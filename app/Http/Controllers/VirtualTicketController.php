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
        $guid = (string) Str::uuid();
        foreach($request->users as $user){
            $virtualTicket = new VirtualTicket();
            $virtualTicket->GUID = $guid;
            $virtualTicket->label = $user['label'];
            $virtualTicket->email = $user['email'];
            $virtualTicket->valid_from = $request->valid_from;
            $virtualTicket->valid_to = $request->valid_to;
            $virtualTicket->save();

            foreach($request->gates as $gateId){
                $gate = Gate::find($gateId);
                $virtualTicket->gates()->attach($gate);
            }

                $mailContent = new Request( [
                'team_name' => 'Biuro',
                'email' => "slawek@qware.pl",
                'code' => '821381209382',
                'valid_from' => '2022-07-26 10:35:09',
                'valid_to' => '2022"gates": [8-20 23:35:09',
                'label' => 'Key opens Biuro'
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
    // public function destroy($id)
    // {
    //     $virtualKey = VirtualKey::find($id);
    //     $gates = $virtualKey->gates;
    //     if($gates!=null) {
    //         foreach ($gates as $gate) {
    //             $virtualKey->gates()->detach($gate->id);
    //         }
    //     }
    //     $virtualKey->delete();
    //     return Inertia::render('Dashboard');
    // }

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

    // public function indexByTeamIdForLoggedUser(Request $request, $teamId)
    // {
    //     $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
    //         $query->where('team_id', $teamId);
    //     })->get();

    //     return $virtualKeys->where('user_id', $request->user()->id)->values();
    // }
}
