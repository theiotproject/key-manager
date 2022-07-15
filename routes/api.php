<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VirtualKeyController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/permission/teamId/{team_id}', [AuthController::class, 'getAuthUserPermissionByTeamId']);
    Route::get('/auth/permission/teamId/{team_id}/request', [AuthController::class, 'getRequestUserPermissionByTeamId']);

    Route::resource('/gate', GateController::class);
    Route::get('/gate/teamId/{team_id}', [GateController::class, 'indexGatesByTeamId']);
    Route::get('/gate/teamId/{team_id}/resource', [GateController::class, 'indexGatesByTeamIdResource']);
    Route::get('/gate/userId/{user_id}/teams', [GateController::class, 'indexGatesByUserTeam']);

    Route::resource('/virtualKey', VirtualKeyController::class);
    Route::get('/gate/virtualKey/{team_id}', [GateController::class, 'indexVirtualKeysByTeamId']);
    Route::get('/gate/virtualKey/{team_id}/resource', [GateController::class, 'indexVirtualKeysByTeamIdResource']);

    Route::get('/team/userId/{user_id}', [TeamController::class, 'indexTeamsByUser']);
});

//Public routes
Route::resource('/event', EventController::class);
Route::post('/auth/token', [AuthController::class, 'getToken']);
