<?php

namespace App\Http\Controllers;

use App\Http\Resources\GateResource;
use Inertia\Inertia;
use App\Models\VirtualKey;
use Illuminate\Http\Request;
use App\Http\Resources\VirtualKeyResource;
use App\Models\Team;

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
        //     abort(403, 'Unauthorized');
        // }
        // $virtualKeys = VirtualKey::orderBy('id')->get();
        // return VirtualKeyResource::collection($virtualKeys);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
