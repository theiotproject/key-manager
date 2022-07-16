<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use App\Models\Team;
use Inertia\Inertia;
use App\Models\VirtualKey;
use Illuminate\Http\Request;
use App\Http\Resources\GateResource;
use App\Http\Resources\VirtualKeyResource;

class VirtualKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // if (!auth()->user()->tokenCan('virtualKeys-list')) {
        //     ab   ort(403, 'Unauthorized');
        // }
        // $virtualKeys = VirtualKey::orderBy('id')->get();
        // return VirtualKeyResource::collection($virtualKeys);
        return "dziala";
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $virtualKey = VirtualKey::create([
            'user_id' => $request->userId,
            'active_from' => $request->activeFrom,
            'active_to' => $request->activeTo
        ]);
        $gate = Gate::find($request->gateId);
        $virtualKey->gates()->attach($gate);
        return 'success';
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function indexVirtualKeysByTeamId($teamId)
    // {
    //     return Team::find($teamId)->virtualKeys;
    // }

    // public function indexVirtualKeysByTeamIdResource($teamId)
    // {
    //     return GateResource::collection(Team::find($teamId)->virtualKeys);
    // }
}
