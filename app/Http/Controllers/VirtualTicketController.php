<?php

namespace App\Http\Controllers;

use App\Models\VirtualTicket;
use App\Models\Gate;
use Illuminate\Http\Request;

class VirtualTicketController extends Controller
{
    public function store(Request $request)
    {
        $users = $request->users;
        $virtualTickets = array();
        foreach($users as $user){
            $virtualTicket = new VirtualTicket();
            $virtualTicket->label = $user['label'];
            $virtualTicket->user_id = $user['id'];
            $virtualTicket->valid_days = $request->validDays;
            $virtualTicket->save();
            array_push($virtualTickets, $virtualTicket);
        }

        foreach($virtualTickets as $virtualTicket){
            foreach($request->gates as $gateId){
                $gate = Gate::find($gateId);
                $virtualTicket->gates()->attach($gate);
            }
        }
    }
}
