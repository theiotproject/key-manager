<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VirtualKeyController;
use App\Http\Controllers\SendEmailController;
use App\Mail\SendMail;


//Protected Routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/auth/permission/teamId/{team_id}/request', [AuthController::class, 'getRequestUserPermissionByTeamId']);
    Route::get('gates/teamId/{team_id}', [GateController::class, 'indexGatesByTeamId']);
    Route::get('gates/userId/{user_id}/teams', [GateController::class, 'indexGatesByUserTeam']);
    Route::get('/virtualKeys/teamId/{team_id}', [VirtualKeyController::class, 'indexVirtualKeysByTeamId']);
    Route::get('/teams/userId/{user_id}', [TeamController::class, 'indexTeamsByUser']);
    Route::get('/virtualKeys/teamId/{team_id}/token', [VirtualKeyController::class, 'indexByTeamIdForLoggedUser']);
    Route::get('/virtualKeys/code/{team_id}', [VirtualKeyController::class, 'generateCode']); // do zmienienia na key_id
    Route::resource('/virtualKeys', VirtualKeyController::class);
});

//Public routes
Route::resource('/events', EventController::class);
Route::post('/auth/token', [AuthController::class, 'getToken']);


//Route::get('/role/userId/{userId}/teamId/{teamId}', function($userId, $teamId) {
//    $user = User::find($userId);
//    foreach($user->teams as $team) {
//        if ($team->id == $teamId) {
//            return $team->pivot->role;
//        }
//    }
//});

Route::post('/sendemail/send', [SendEmailController::class, 'send']);
// Route::post('/sendemail2/send', [SendMail::class, 'send']);
