<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Gate;
use App\Models\KeyUsage;
use App\Models\VirtualKey;
use Illuminate\Http\Request;

use Inertia\Inertia;
use function Psy\debug;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */



    public function index()
    {
        return Inertia::render('Events/Show');
    }

    /**
     * Show.vue.vue the form for creating a new resource.
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
        $data = $request->all();

        // $event = new Event;
        // $event->message = $data>message;
        // $post->save();
        // return redirect('/posts');

       $event = Event::create($data);

        return $event;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        return $event;
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

    public function indexEventsByTeamId($teamId, $limit) {

        $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
        })->get();

        $virtualKeyIds = array();
        foreach($virtualKeys as $virtualKey){
            array_push($virtualKeyIds, $virtualKey->id);
        }

        $keyUsages = KeyUsage::all()->whereIn('virtual_key_id', $virtualKeyIds)->where('access_granted', 1);

        $keyUsageIds = array();
        foreach($keyUsages as $keyUsage){
            array_push($keyUsageIds, $keyUsage->id);
        }

        $events = Event::all()->whereIn('GUID', $keyUsageIds)->sortByDesc('scan_time')->take($limit)->values();

        $result = array();
        foreach ($events as $event){
            $virtualKeyId = $event->keyUsage->virtual_key_id;
            $virtualKey = VirtualKey::find($virtualKeyId);
            $user = $virtualKey->user;
            $gate = Gate::where('serial_number', $event->serial_number)->get();
            $merge = array_merge($event->toArray(), $user->toArray(), $gate->toArray());
            array_push($result, new EventResource($merge));
        }
        return $result;
    }
}
