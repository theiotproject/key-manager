<?php

namespace App\Http\Controllers;

use App\Http\Resources\GateResource;
use App\Models\Gate;
use App\Models\Team;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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
        return GateResource::collection(Team::find($teamId)->gates);
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
}

