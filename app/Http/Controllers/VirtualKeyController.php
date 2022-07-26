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

class VirtualKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
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
        foreach($users as $user){
            $virtualKey = new VirtualKey();
            $virtualKey->label = $user['label'];
            $virtualKey->user_id = $user['id'];
            $virtualKey->valid_days = $request->validDays;
            $virtualKey->save();
            array_push($virtualKeys, $virtualKey);
        }

        foreach($virtualKeys as $virtualKey){
            foreach($request->gates as $gateId){
                $gate = Gate::find($gateId);
                $virtualKey->gates()->attach($gate);
            }
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
    public function destroy($id)
    {
        $virtualKey = VirtualKey::find($id);
        $gates = $virtualKey->gates;
        if($gates!=null) {
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

    public function generateCode(Request $request, $teamId)
    {
        // $mytime = Carbon::now();
        // $mytime->toDateTimeString();
        $randomString = strtoupper(Str::random(10));
        // return $mytime . '/' . $randomString;
        return $randomString;
    }
}
