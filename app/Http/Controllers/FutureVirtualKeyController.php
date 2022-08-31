<?php

namespace App\Http\Controllers;

use App\Models\FutureVirtualKey;
use App\Models\Gate;
use App\Models\VirtualKey;
use Cassandra\Future;
use Illuminate\Http\Request;

class FutureVirtualKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $futureVirtualKey = new FutureVirtualKey();
            $futureVirtualKey->label = $request->label;
            $futureVirtualKey->user_email = $request->email;
            $futureVirtualKey->valid_days = $request->validDays;
            $futureVirtualKey->save();

            $gateIds = array();
            foreach ($request->gates as $gateId) {
                $gate = Gate::find($gateId);
                array_push($gateIds, $gate->id);
            }
            $futureVirtualKey->gates()->sync($gateIds);
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

    }
}
