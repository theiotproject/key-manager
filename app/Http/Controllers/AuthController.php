<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\VirtualKey;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Fortify\Actions\ConfirmPassword;
use Laravel\Jetstream\Actions\ValidateTeamDeletion;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Laravel\Jetstream\Jetstream;


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

    public function destroyUser(Request $request, StatefulGuard $guard)
    {
        $confirmed = app(ConfirmPassword::class)(
            $guard, $request->user(), $request->password
        );

        if (! $confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        $virtualKeys = VirtualKey::where('user_id', $request->user()->id)->get();
        foreach($virtualKeys as $virtualKey) {
            app(VirtualKeyController::class)->destroy($virtualKey->id);
        }

        $user = $request->user()->fresh();
        DB::transaction(function () use ($user) {
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });

        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(url('/'));
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
        $ownerId = Team::find($teamId)->user_id;
        $owner = User::find($ownerId);
        $users->add($owner);
        $owner->setAttribute('membership', ['role'=>'owner']);
        return $users;
    }

    public function getAuthUserRoleByTeamId($teamId)
    {
        $user = Auth::user();
        $team = Team::find($teamId);
        if($team->user_id == $user->id){
            return "owner";
        }
        return $team->users->where('id', $user->id)->first()->membership->role;
    }

}
