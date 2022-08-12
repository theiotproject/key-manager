<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gate;
use App\Models\Team;
use Inertia\Inertia;
use App\Models\VirtualKey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\GateResource;
use App\Http\Resources\VirtualKeyResource;
use PhpMqtt\Client\Facades\MQTT;


class VirtualKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return Inertia::render('VirtualKeys/Show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $users = $request->users;
        $virtualKeys = array();
        foreach ($users as $user) {
            $virtualKey = new VirtualKey();
            $virtualKey->label = $user['label'];
            $virtualKey->user_id = $user['id'];
            $virtualKey->valid_days = $request->validDays;
            $virtualKey->save();
            array_push($virtualKeys, $virtualKey);
        }

        foreach ($virtualKeys as $virtualKey) {
            $gateIds = array();
            foreach ($request->gates as $gateId) {
                $gate = Gate::find($gateId);
                array_push($gateIds, $gate->id);
            }
            $virtualKey->gates()->sync($gateIds);
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
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $virtualKey = VirtualKey::find($id);
        return Inertia::render('VirtualKeys/Edit', ["virtualKey" => $virtualKey]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        $virtualKey = VirtualKey::find($id);
        $virtualKey->label = $request->label;
        $virtualKey->valid_days = $request->validDays;
        $gateIds = array();
        $gateNames = array();
        foreach ($request->gates as $gate) {
            array_push($gateIds, $gate['id']);
            array_push($gateNames, $gate['name']);
        }
        $virtualKey->gates()->sync($gateIds);
        $virtualKey->label = 'Key opens ' . implode(', ', $gateNames);
        $virtualKey->save();
        return Inertia::render('VirtualKeys/Show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function destroy($id)
    {
        $virtualKey = VirtualKey::find($id);
        $gates = $virtualKey->gates;
        if ($gates != null) {
            foreach ($gates as $gate) {
                $virtualKey->gates()->detach($gate->id);
            }
        }
        $virtualKey->delete();
        return Inertia::render('Dashboard');
    }

    public function indexVirtualKeysByTeamId($teamId)
    {
        $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
        })->get();

        return $virtualKeys;
    }

    public function indexVirtualKeysByTeamIdWithUsersAndGatesData($teamId)
    {
        $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
        })->get();

        foreach ($virtualKeys as $virtualKey) {
            $virtualKey->user;
            $virtualKey->gates;
        }

        return $virtualKeys;
    }

    public function indexByTeamIdForLoggedUser(Request $request, $teamId)
    {
        $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
        })->get();

        return $virtualKeys->where('user_id', $request->user()->id)->values();
    }

    public function getTeamCode(Request $request, $teamId, $virtualKeyId)
    {
        $userId = $request->user()->id;
        $userVirtualKey = VirtualKey::where("user_id", $userId)->firstOrFail();

        //check if user has the key in order to get team_code
        if($virtualKeyId == $userVirtualKey->id)
        {
            $team = Team::findOrFail($teamId);
            return ($team->team_code)
                ->response()
                ->setStatusCode(201);
        }

        abort(403, 'Cannot access Team Code' );
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
}
