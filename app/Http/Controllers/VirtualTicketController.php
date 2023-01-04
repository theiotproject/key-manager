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
            $valid_from_unix = strtotime($valid_from);
            $valid_to = $request->valid_to;
            $valid_to_unix = strtotime($valid_to);

            $guid = (string) Str::uuid();
            $virtualTicket = new VirtualTicket();
            $virtualTicket->GUID = $guid;
            $virtualTicket->label = $user['label'];
            $virtualTicket->email = $user['email'];
            $virtualTicket->valid_from = $valid_from_unix;
            $virtualTicket->valid_to = $valid_to_unix;
            $virtualTicket->save();

            $gateSerialNumbers = "";
            $gatesData=array();
            $teamId=0;

            foreach($request->gates as $gateId){
                $gate = Gate::find($gateId);
                $teamId = $gate->team_id;
                $virtualTicket->gates()->attach($gate);
                array_push($gatesData, $gate->serial_number);
            }
            $gateSerialNumbers = implode (",", $gatesData);

            $team = Team::findOrFail($teamId);
            $teamCode = $team->team_code;

            $qrcode = "OPEN:ID:{$guid};VF:{$valid_from_unix};VT:{$valid_to_unix};L:{$gateSerialNumbers};;";
            $hashQrcode = hash('sha256', $qrcode . $teamCode);
            $finalQrcode = $qrcode . "S:" . $hashQrcode . ";";

            $mailContent = new Request( [
                'guid'=>$guid,
                'team_name' => $request->team_name,
                'email' => $user['email'],
                'code' => $finalQrcode,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'label' => $user['label']
            ]);

            app(SendEmailController::class)->sendQrCode($mailContent);
        }
        return response()->json(['message' => 'Virtual Ticket created successfully'],201);
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


        try {

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
             MQTT::publish('iotlock/v1/V7JWQE92BS/blacklist', $ticketsGUIDMessage);

        } catch (\Exception $e) {
             abort(400, $e->getMessage());
        }
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
        try {
            $userAuth = auth()->user();

            $user_role = app(TeamController::class)->getUserRole($teamId, $userAuth->id);

            //check if user is the admin\owner in order to get all data, else get data of user only
            if ($user_role == 'owner' || $user_role == 'admin')
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
            } else {
                $virtualTickets = VirtualTicket::whereHas('gates', function ($query) use ($teamId,$userAuth) {
                    $query->where('team_id', $teamId);
                    $query->whereDate("valid_to",">", date("Y-m-d H:i:s"));
                    $query->where("deleted_at", null);
                    $query->where("email", $userAuth->email);
                })->get();

                $virtualTicketsData = array();

                foreach ($virtualTickets as $virtualTicket) {
                    $user = User::where('email', $userAuth->email)->get();
                    $virtualTicket->gates;
                    $merge = array_merge($virtualTicket->toArray(), $user->toArray());
                    array_push($virtualTicketsData, new VirtualTicketResource($merge));
                }
            }
                return $virtualTicketsData;

        } catch (\Exception $e) {
            throw new HttpException(400, $e->getMessage());
        }
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
