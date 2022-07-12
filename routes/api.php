<?php

use App\Http\Controllers\GateController;
use App\Http\Resources\GateResource;
use App\Models\Gate;
use App\Models\Team;
use App\Models\User;
use App\Http\Controllers\EventController;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/team/{id}/gates', function($id) {
    $gates = Team::find($id)->gates;
    return GateResource::collection($gates);
});

Route::get('/team', function() {
    $gates = Team::all();
    return $gates;
});

Route::get('/user/{id}/gates', function($id){
    $gates= User::find($id)->gates;
    return GateResource::collection($gates);
});
//
//Route::get('/gate/{id}/users', function($id){
//    $gate = Gate::find($id);
//    foreach($gate->users as $user){
//        echo $user . " ";
//    }
//});

Route::resource('/gate', GateController::class);

//Route::get('/user/{id}/gates', [GateController::class, 'show']);


Route::post('/events', [EventController::class, 'store']);

Route::get('/events/{id}', function($id) {
    $event = Event::find($id);
    return $event;
});

Route::post('/events', [EventController::class, 'store']);

Route::get('/events/{id}', function($id) {
    $event = Event::find($id);
    return $event;
});
