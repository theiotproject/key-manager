<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeamInvitation;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Jetstream\Actions\ValidateTeamDeletion;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Laravel\Jetstream\Jetstream;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use App\Models\VirtualKey;
use App\Models\VirtualTicket;

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
        Auth::user()->switchTeam($invitation->team);
        $invitation->delete();
    }

    public function store(Request $request)
    {
        $creator = app(CreatesTeams::class);
        $team = $creator->create($request->user(), $request->all());
        $team->team_code = random_str();
        $team->save();
        Auth::user()->switchTeam($team);
        return $team;
    }

    public function destroy(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        $teamModel = Team::find($teamId);

        $gates = $teamModel->gates;

        foreach ($gates as $gate) {
            app(ControllersGateController::class)->destroy($gate->id);
        }

        app(ValidateTeamDeletion::class)->validate($request->user(), $team);

        $deleter = app(DeletesTeams::class);

        $deleter->delete($team);

        return $this->redirectPath($deleter);
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

    public function getTeamCodeByTicket(Request $request, $teamId, $virtualTicketId)
    {
        $userEmail = $request->user()->email;
        $userVirtualTickets = VirtualTicket::where("email", $userEmail)->get();

        //check if user has the key in order to get team_code
        foreach ($userVirtualTickets as $userVirtualTicket) {
            if ($virtualTicketId == $userVirtualTicket->id) {
                $team = Team::findOrFail($teamId);
                return $team->team_code;
            }
        }


        abort(403, 'Cannot access Team Code');
    }

    public function getTeamCode(Request $request, $teamId, $virtualKeyId)
    {
        $userId = $request->user()->id;
        $userVirtualKeys = VirtualKey::where("user_id", $userId)->get();

        //check if user has the key in order to get team_code
        foreach ($userVirtualKeys as $userVirtualKey) {
            if ($virtualKeyId == $userVirtualKey->id) {
                $team = Team::findOrFail($teamId);
                return $team->team_code;
            }
        }

        abort(403, 'Cannot access Team Code');
    }

    public function getAdminTeamCode(Request $request, $teamId)
    {
        $userId = $request->user()->id;

        $team = Team::find($teamId);
        $user_role = "";
        if ($team->user_id == $userId) {
            $user_role = "owner";
        } else {
            $user_role = $team->users->where('id', $userId)->first()->membership->role;
        }

        //check if user is the admin in order to get team_code
        if ($user_role == 'owner' || $user_role == 'admin') {
            return $team->team_code;
        }

        abort(403, 'Cannot access Team Code');
    }

    public function getUserRole($teamId, $userId)
    {
        $userId = auth()->user()->id;

        $team = Team::find($teamId);
        $user_role = "";
        if ($team->user_id == $userId) {
            $user_role = "owner";
        } else {
            $user_role = $team->users->where('id', $userId)->first()->membership->role;
        }
        return $user_role;
    }
}

function random_str(
    int $length = 10,
    string $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
