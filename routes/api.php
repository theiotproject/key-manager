<?php

use App\Http\Controllers\GateController;
use App\Models\Gate;
use App\Models\Team;
use App\Models\User;
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

//Route::get('/team/{id}/gates', function($id) {
//    $gates = Team::find($id)->gates;
//    foreach($gates as $gate){
//        echo $gate . " ";
//    }
//});
//
//Route::get('/user/{id}/gates', function($id){
//    $user= User::find($id);
//    foreach($user->gates as $gate){
//        echo $gate . " ";
//    }
//});
//
//Route::get('/gate/{id}/users', function($id){
//    $gate = Gate::find($id);
//    foreach($gate->users as $user){
//        echo $user . " ";
//    }
//});

Route::resource('/gate', GateController::class);

//Route::get('/user/{id}/gates', [GateController::class, 'show']);
