<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function indexTeamsByUser($userId)
    {
        $userTeams = Team::where('user_id', $userId)->get();
        $teams = User::find($userId)->teams->merge($userTeams);
        return $teams;
    }
}
