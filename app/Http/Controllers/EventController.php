<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gate;
use App\Models\Team;
use Inertia\Inertia;
use App\Models\Event;
use function Psy\debug;
use App\Models\KeyUsage;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\Facades\DB;
use App\Models\VirtualKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventResource;

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

    public function indexEventsByTeamId($teamId, $limit, $pagination)
    {
        $user = Auth::user();
        $role = app('App\Http\Controllers\AuthController')->getAuthUserRoleByTeamId($teamId);

        if ($role == 'owner' || $role == 'admin') {
            $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            })->get();
        } else {
            $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            })->where('user_id', $user->id)->get();
        }

        $virtualKeyIds = array();
        foreach ($virtualKeys as $virtualKey) {
            array_push($virtualKeyIds, $virtualKey->id);
        }

        $keyUsages = KeyUsage::all()->whereIn('virtual_key_id', $virtualKeyIds)->where('access_granted', 1);

        $keyUsageIds = array();
        foreach ($keyUsages as $keyUsage) {
            array_push($keyUsageIds, $keyUsage->id);
        }

        $pagination == 1 ? $events = Event::all()->whereIn('GUID', $keyUsageIds)->sortByDesc('scan_time')->take(1000)->values() : $events = Event::all()->whereIn('GUID', $keyUsageIds)->sortByDesc('scan_time')->take($limit)->values();


        $result = array();
        foreach ($events as $event) {
            $virtualKeyId = $event->keyUsage->virtual_key_id;
            $virtualKey = VirtualKey::find($virtualKeyId);
            $user = $virtualKey->user;
            $gate = Gate::where('serial_number', $event->serial_number)->get();
            $merge = array_merge($event->toArray(), $user->toArray(), $gate->toArray());
            array_push($result, new EventResource($merge));
        }
        if ($pagination == 1) return paginate($result, $limit);
        return $result;
    }

    public function indexRejectedEventsByTeamId($teamId, $limit)
    {

        $events = Event::whereHas('gate', function ($q) use ($teamId) {
            $q->where('team_id', $teamId);
        })->orderBy('scan_time', 'DESC')->get();

        $result = array();
        foreach ($events as $event) {
            $gate = Gate::where('serial_number', $event->serial_number)->get();
            $merge = array_merge($event->toArray(), $gate->toArray());
            array_push($result, $merge);
        }
        return $result;
    }

    public function indexEventsByGate($teamId, $gateId, $limit)
    {
        $user = Auth::user();
        $role = app('App\Http\Controllers\AuthController')->getAuthUserRoleByTeamId($teamId);

        if ($role == 'owner' || $role == 'admin') {
            $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            })->get();
        } else {
            $virtualKeys = VirtualKey::whereHas('gates', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            })->where('user_id', $user->id)->get();
        }

        $virtualKeyIds = array();
        foreach ($virtualKeys as $virtualKey) {
            array_push($virtualKeyIds, $virtualKey->id);
        }

        $keyUsages = KeyUsage::all()->whereIn('virtual_key_id', $virtualKeyIds)->where('access_granted', 1);

        $keyUsageIds = array();
        foreach ($keyUsages as $keyUsage) {
            array_push($keyUsageIds, $keyUsage->id);
        }

        $gateSerialNumber = Gate::findOrFail($gateId)->serial_number;

        $events = Event::where('serial_number', $gateSerialNumber)->whereIn('GUID', $keyUsageIds)->orderBy('scan_time', 'desc')->limit($limit)->get();

        $result = array();
        foreach ($events as $event) {
            $virtualKeyId = $event->keyUsage->virtual_key_id;
            $virtualKey = VirtualKey::find($virtualKeyId);
            $user = $virtualKey->user;
            $gate = Gate::where('serial_number', $event->serial_number)->get();
            $merge = array_merge($event->toArray(), $user->toArray(), $gate->toArray());
            array_push($result, new EventResource($merge));
        }
        return $result;
    }

    public function countAccessForGateLast7Days($gateSerialNumber)
    {
        $last7Days = getLastNDays(7, 'Y-m-d');

        $labels = [$last7Days[0], $last7Days[1], $last7Days[2], $last7Days[3], $last7Days[4], $last7Days[5], $last7Days[6]];

        $last7DaysAccessGranted = array();

        $last7DaysAccessDenied = array();

        foreach ($last7Days as $day) {
            array_push($last7DaysAccessGranted, Event::whereDate('scan_time', $day)->where('serial_number', $gateSerialNumber)->where('status', 1)->count());
            array_push($last7DaysAccessDenied, Event::whereDate('scan_time', $day)->where('serial_number', $gateSerialNumber)->where('status', 0)->count());
        }

        $last7DaysData = [
            'labels' => $labels,
            'accessGranted' => $last7DaysAccessGranted,
            'accessDenied' => $last7DaysAccessDenied
        ];
        return $last7DaysData;
    }
}

function getLastNDays($days, $format)
{
    $m = date("m");
    $de = date("d");
    $y = date("Y");
    $dateArray = array();
    for ($i = 0; $i <= $days - 1; $i++) {
        $dateArray[] = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
    }
    return array_reverse($dateArray);
}


function paginate($items, $perPage, $page = null, $options = [])
{
    $page = $page ?: (PaginationPaginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}
