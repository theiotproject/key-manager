<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VirtualKeyController;

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
    Route::get('/virtualKeys/code/{team_id}', [VirtualKeyController::class, 'generateCode']);
});

//Public routes
Route::resource('/events', EventController::class);
Route::post('/auth/token', [AuthController::class, 'getToken']);
