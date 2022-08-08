<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeamInvitation;
use Laravel\Jetstream\Contracts\AddsTeamMembers;

class TeamController extends Controller
{
    public function indexTeamsByUser($userId)
    {
        $userTeams = Team::where('user_id', $userId)->get();
        $teams = User::find($userId)->teams->merge($userTeams);
        return $teams;
    }

    public function getUserInvitations($userId)
    {
        $user = User::find($userId);
        $userInvitations = TeamInvitation::where('email', $user->email)->get();
        foreach ($userInvitations as $userInvitation) {
            $userInvitation->team;
        }
        return $userInvitations;
    }

    public function joinTeam(Request $request)
    {
        $invitation = TeamInvitation::find($request->invitationId);

        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $invitation->delete();
    }
}
