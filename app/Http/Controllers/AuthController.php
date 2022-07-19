<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['message' => "The provided credentials are incorrect."];
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function getAuthUserPermissionByTeamId($teamId)
    {
        $user = Auth::user();
        $team = Team::find($teamId);
        return $user->hasTeamPermission($team, 'everything');
    }

    public function getRequestUserPermissionByTeamId(Request $request, $teamId)
    {
        $user = $request->user();
        $team = Team::find($teamId);
        return $user->hasTeamPermission($team, 'everything');
    }

    public function indexUsersByTeamId($teamId)
    {
        $users = Team::find($teamId)->users;
        return $users;
    }
}
