<?php

namespace App\Http\Controllers;

use App\Http\Resources\GateResource;
use App\Models\Gate;
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
    public function index()
    {
        if(!auth()->user()->tokenCan('gates-list')){
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
    public function redirect(){
        return Inertia::render('VirtualKeys/Show');
    }
}
