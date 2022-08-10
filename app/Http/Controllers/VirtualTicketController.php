<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gate;
use App\Models\Team;
use Inertia\Inertia;
use App\Models\VirtualTicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\GateResource;
use App\Models\User;
use App\Http\Resources\VirtualTicketResource;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;
use PhpMqtt\Client\Facades\MQTT;
use VirtualKey;

class VirtualTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('VirtualTickets/Show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('VirtualTickets/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|string
     */
    public function store(Request $request)
    {
        foreach($request->users as $user){
            $valid_from = $request->valid_from;
            $valid_to = $request->valid_to;

            $guid = (string) Str::uuid();
            $virtualTicket = new VirtualTicket();
            $virtualTicket->GUID = $guid;
            $virtualTicket->label = $user['label'];
            $virtualTicket->email = $user['email'];
            $virtualTicket->valid_from = $valid_from;
            $virtualTicket->valid_to = $valid_to;
            $virtualTicket->save();

            $gateSerialNumbers = "";
            $gatesData=array();

            foreach($request->gates as $gateId){
                $gate = Gate::find($gateId);
                $virtualTicket->gates()->attach($gate);
                array_push($gatesData, $gate->serial_number);
            }

            $gateSerialNumbers = implode (",", $gatesData);

            $qrcode = "OPEN:ID:" . $guid . ";VF:" . $valid_from . ";VT:" . $valid_to . ";L:" . $gateSerialNumbers . ";;";

            $mailContent = new Request( [
                'team_name' => 'Biuro',
                'email' => $user['email'],
                'code' => $qrcode,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'label' => $user['label']
            ]);

            app(SendEmailController::class)->sendQrCode($mailContent);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function destroy($id)
    {


        // try {

            $virtualTicket = VirtualTicket::findOrFail($id);
            $gates = $virtualTicket->gates;

            if($gates!=null) {
                foreach ($gates as $gate) {
                    $virtualTicket->gates()->detach($gate->id);
                }
            }

            $virtualTicket->delete();
            $oldVirtualTickets = VirtualTicket::whereDate("valid_to","<=", date("Y-m-d H:i:s"))->withTrashed()->get();

            foreach($oldVirtualTickets as $oldTicket) {

                $gates = $oldTicket->gates;

                if($gates!=null) {
                    foreach ($gates as $gate) {
                        $oldTicket->gates()->detach($gate->id);
                    }
                }
                    $oldTicket->forceDelete();
                }

            $tickets = VirtualTicket::onlyTrashed()->get();

            $ticketsGUID=array();
            foreach($tickets as $ticket) {
                array_push($ticketsGUID, $ticket->GUID);
            }

            $ticketsGUIDMessage = implode(";", $ticketsGUID);
             MQTT::publish('blacklist/9238420983', $ticketsGUIDMessage);

        // } catch (\Exception $e) {
        //      return response()->json([
        //         'message' => $e->getMessage()
        //     ], 404);
        // }
        // return Redirect::render('');
         return redirect()->route('virtualTickets.index');
        //   return Inertia::render('VirtualTickets/Show');

    }

    // public function indexVirtualKeysByTeamId($teamId)
    // {
    //     $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
    //         $query->where('team_id', $teamId);
    //     })->get();

    //     return $virtualKeys;
    // }

    public function indexVirtualTicketsByTeamIdWithUsersAndGatesData($teamId)
    {
        $virtualTickets = VirtualTicket::whereHas('gates', function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
            $query->whereDate("valid_to",">", date("Y-m-d H:i:s"));
            $query->where("deleted_at", null);
        })->get();

        $virtualTicketsData = array();

        foreach ($virtualTickets as $virtualTicket) {
            $user = User::where('email', $virtualTicket->email)->get();

            //check if user with this email exists, if not create temporary user
            if ($user->isEmpty()) {
                $user = array(new User(['name'=>'unregistered', 'profile_photo_url'=>'https://ui-avatars.com/api/?name=s&color=7F9CF5&background=EBF4FF']));
                $virtualTicket->gates;
                $merge = array_merge($virtualTicket->toArray(), $user);
                array_push($virtualTicketsData, new VirtualTicketResource($merge));
             }
             else {
                $virtualTicket->gates;
                $merge = array_merge($virtualTicket->toArray(), $user->toArray());
                array_push($virtualTicketsData, new VirtualTicketResource($merge));
             }
        }

        return $virtualTicketsData;
    }

    public function indexByTeamIdForLoggedUser(Request $request, $teamId)
    {
        try {
            $virtualTickets = VirtualTicket::whereHas('gates', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
                $query->whereDate("valid_to",">", date("Y-m-d H:i:s"));
            })->get();

            return $virtualTickets->where('email', $request->user()->email)->values();

          } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
