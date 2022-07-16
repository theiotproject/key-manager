<?php

namespace App\Http\Controllers;

use App\Http\Resources\GateResource;
use App\Models\Gate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    /**
     * @OA\Get(
     *     path="/api/gate",
     *     @OA\Response(response="200", description="Display a listing of Gates")
     * )
     */

    public function index()
    {
        if (!auth()->user()->tokenCan('gates-list')) {
            abort(403, 'Unauthorized');
        }
        $gates = Gate::orderBy('id')->get();
        return GateResource::collection($gates);
    }

    /**
     * Show.vue.vue the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
