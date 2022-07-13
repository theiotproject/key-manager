<?php

use App\Http\Controllers\GateController;
use App\Http\Resources\GateResource;
use App\Models\Gate;
use App\Models\Team;
use App\Models\User;
use App\Http\Controllers\EventController;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Protected Routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('/permission/{team_id}', function($team_id){
        $user = Auth::user();
        $team = Team::find($team_id);
        return $user->hasTeamPermission($team, 'everything');
    });

    Route::resource('/gate', GateController::class);

    Route::get('/team/{id}/gates', function($id) {
        $gates = Team::find($id)->gates;
        return GateResource::collection($gates);
    });

    Route::get('/user/{id}/teams', function($id){
        $userTeams= Team::where('user_id', $id)->get();
        $teams = User::find($id)->teams->merge($userTeams);
        return $teams;
    });

    Route::get('/user/{id}/teams/gates', function($id) {
        $userTeams= Team::where('user_id', $id)->get();
        $teams = User::find($id)->teams->merge($userTeams);
        $result = array();
        foreach($teams as $team){
            $gates = Gate::where('team_id', $team->id)->get();
            array_push($result, $gates);
        }
        return $result;
    });
});

//Public routes
Route::resource('/event', EventController::class);

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return ['message'=> "The provided credentials are incorrect."];
    }

    return $user->createToken($request->device_name)->plainTextToken;
});


