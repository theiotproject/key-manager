<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeamInvitation;
use Laravel\Jetstream\Jetstream;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Team;

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

    public function store(Request $request)
    {
        $creator = app(CreatesTeams::class);

        $team = $creator->create($request->user(), $request->all());
        Auth::user()->switchTeam($team);
        return $team;
    }

    public function getRoles()
    {
        return array_values(Jetstream::$roles);
    }

    public function getTeamInvitations($teamId)
    {
        $teamInvitations = TeamInvitation::where('team_id', $teamId)->get();
        return $teamInvitations;
    }
}
