<?php

namespace App\Http\Controllers;

use App\Http\Resources\GateResource;
use App\Models\Gate;
use App\Models\Team;
use App\Models\VirtualKey;
use App\Models\VirtualTicket;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Controllers\TeamController;
use App\Models\KeyUsage;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Str;

class GateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */


    public function index()
    {
        return Inertia::render('Gates/Show');
    }

    /**
     * Show.vue.vue the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Gates/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return GateResource
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $gate = Gate::create($data);

        return new GateResource($gate);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return GateResource
     */
    public function show(Gate $gate)
    {
        return new GateResource($gate);
    }

    /**
     * Show.vue.vue the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $gate = Gate::find($id);
        return Inertia::render('Gates/Edit', ["gate"=>$gate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function update(Request $request, $id)
    {
        $gate = Gate::find($id);
        $gate->name = $request->input('name');
        $gate->serial_number = $request->input('serial_number');
        $gate->magic_code = $request->input('magic_code');
        $gate->save();
        $virtualKeys = $gate->virtualKeys;
        if($virtualKeys!=null) {
            foreach ($virtualKeys as $virtualKey) {
                $gates = $virtualKey->gates;
                $gatesArray = array();
                foreach($gates as $gate2){
                    array_push($gatesArray, $gate2->name);
                }
                $virtualKey->label = 'Key opens ' . implode(', ', $gatesArray );
                $virtualKey->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function destroy($id)
    {
        $gate = Gate::find($id);
        $virtualKeys = $gate->virtualKeys;
        $virtualTickets = $gate->virtualTickets;

        if($virtualKeys!=null) {
            foreach ($virtualKeys as $virtualKey) {
                $gate->virtualKeys()->detach($virtualKey->id);
            }
            foreach ($virtualKeys as $virtualKey) {
                $gates = $virtualKey->gates;
                $gatesArray = array();
                foreach($gates as $gate2){
                    array_push($gatesArray, $gate2->name);
                }
                $virtualKey->label = 'Key opens ' . implode(', ', $gatesArray );
                $virtualKey->save();
            }
        }

         if($virtualTickets!=null) {
            foreach ($virtualTickets as $virtualTicket) {
                $gate->virtualTickets()->detach($virtualTicket->id);
            }
            foreach ($virtualTickets as $virtualTicket) {
                $gates = $virtualTicket->gates;
                $gatesArray = array();
                foreach($gates as $gate2){
                    array_push($gatesArray, $gate2->name);
                }
                $virtualTicket->label = 'Key opens ' . implode(', ', $gatesArray );
                $virtualTicket->save();
            }
        }

        $gate->delete();
        return Inertia::render('Dashboard');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */

    public function indexGatesByTeamId($teamId)
    {
            return Team::find($teamId)->gates;


    }

    public function indexGatesByTeamIdResource($teamId)
    {
         // check user permission
        $userAuth = auth()->user();
        $user_role = app(TeamController::class)->getUserRole($teamId, $userAuth->id);

        if ($user_role == 'owner' || $user_role == 'admin') {
            return GateResource::collection(Team::find($teamId)->gates);
        } else {

            $gates = Gate::whereHas('virtualKeys', function($query) use ($userAuth,$teamId){
                $query->where("team_id", $teamId);
                $query->where('user_id', $userAuth->id);
            })->get();

            $gatesTickets = Gate::whereHas("virtualTickets", function($query) use ($userAuth, $teamId) {
                $query->where("team_id", $teamId);
                $query->where("email", $userAuth->email);
            })->get();
            $gatesMerge = array_merge($gates->toArray(), $gatesTickets->toArray());

            $result = array_unique($gatesMerge, SORT_REGULAR);
            return GateResource::collection($result);
        }
    }

    public function indexGatesByUserTeam($userId)
    {
        $userTeams = Team::where('user_id', $userId)->get();
        $teams = User::find($userId)->teams->merge($userTeams);
        $result = array();
        foreach ($teams as $team) {
            $gates = Gate::where('team_id', $team->id)->get();
            array_push($result, $gates);
        }
        return $result;
    }

    public function indexGatesByVirtualKey($virtualKeyId){
        $gates = Gate::whereHas('virtualKeys', function($q) use ($virtualKeyId){
            $q->where('virtual_key_id', $virtualKeyId);
        })->get();
        return $gates;
    }

     public function openGateRemotely(Request $request)
    {
        $userId = $request->user()->id;
        $guid = $request->id;
        $validFrom = $request->valid_from;
        $validTo= $request->valid_to;
        $gateSerialNumber = $request->gate;
        $teamId = $request->team_id;

        //check if user has access to key, then give team code
        try {
            $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId,$gateSerialNumber,$userId) {
                $query->where('team_id', $teamId);
                $query->where("serial_number", $gateSerialNumber);
                $query->where('user_id', $userId);
            })->firstOrFail();

            $team = Team::findOrFail($teamId);
            $teamCode = $team->team_code;
            $qrcode = "OPEN:ID:{$guid};VF:{$validFrom};VT:{$validTo};L:{$gateSerialNumber};;";
            $hashQrcode = hash('sha256', $qrcode . $teamCode);
            $finalQrcode = $qrcode . "S:" . $hashQrcode;

            MQTT::publish("iotlock/v1/{$teamCode}/control/{$gateSerialNumber}", $finalQrcode);
             return response()
                ->json(['message' => 'Sent request to open the Gate'])
                ->setStatusCode(200);
        } catch (\Exception $e) {
             abort(404, $e->getMessage());
        }
    }

    public function openGateRemotelyByWebsite(Request $request)
    {
        $user = $request->user();
        $gateSerialNumber = $request->gate['serial_number'];
        $teamId = $request->gate['team_id'];
        $guid = "";
        $validFrom = "";
        $validFrom = "";
        //check validity of all user's Virtual Keys & Tickets that can open {Gate}
        try {
            $virtualKey = VirtualKey::whereHas('gates', function ($query) use ($teamId,$gateSerialNumber,$user) {
                $query->where('team_id', $teamId);
                $query->where("serial_number", $gateSerialNumber);
                $query->where('user_id', $user->id);
            })->first();
            if(!empty($virtualKey))
            {
                //assign values from key
                $guid = (string) Str::uuid();
                //check if day is valid
                $validDays = $virtualKey->valid_days;
                $validFrom = $request->valid_from;
                $validTo = $request->valid_to;

                //create KeyUsage instance
                $data = [
                    'id'=>$guid,
                    'virtual_key_id'=> $virtualKey->id,
                    'access_granted'=> "1",
                    'message'=>"Access Granted"
                ];
                $req = new Request($data);
                $keyUsage = app(KeyUsageController::class)->store($req);
            }
            else {
                 $virtualTicket = VirtualTicket::whereHas('gates', function ($query) use ($teamId,$gateSerialNumber,$user) {
                $query->where('team_id', $teamId);
                $query->where("serial_number", $gateSerialNumber);
                $query->where('email', $user->email);
                })->first();
                if(!empty($virtualTicket)) {
                    $guid = $virtualTicket->GUID;
                    $validFrom = $virtualTicket->valid_from;
                    $validTo = $virtualTicket->valid_to;
                } else {
                    $user_role = app(TeamController::class)->getUserRole($teamId, $user->id);

                    //check if user is the admin\owner in order to get all data, else get data of user only
                    if($user_role == 'owner' || $user_role == 'admin') {
                        $gateMagic = Gate::findOrFail($request->gate['id'])->magic_code;

                    $team = Team::findOrFail($teamId);
                    $teamCode = $team->team_code;
                    MQTT::publish("iotlock/v1/{$teamCode}/control/{$gateSerialNumber}", "MAGIC:{$gateMagic};");
                    return back(303);
                    // MQTT::publish('iotlock/v1/V7JWQE92BS/control/9238420983',"MAGIC:ab406815-9311-457c-8878-cb4c2e491017;");
                    } else {
                        abort(404, "Cannot access Gate");
                    }
                }
            }

            $team = Team::findOrFail($teamId);
            $teamCode = $team->team_code;
            $qrcode = "OPEN:ID:{$guid};VF:{$validFrom};VT:{$validTo};L:{$gateSerialNumber};;";
            $hashQrcode = hash('sha256', $qrcode . $teamCode);
            $finalQrcode = $qrcode . "S:" . $hashQrcode;

            MQTT::publish("iotlock/v1/{$teamCode}/control/{$gateSerialNumber}", $finalQrcode);
            return back(303);
        } catch (\Exception $e) {
             abort(404, $e->getMessage());
        }
    }
}

