<?php

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
