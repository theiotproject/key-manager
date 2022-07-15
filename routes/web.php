<?php

use App\Http\Controllers\GateController;
use App\Http\Controllers\VirtualKeyController;
use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // return Inertia::render('Dashboard');
        return redirect('/gates');
    })->name('dashboard');

    Route::resource('virtualKey', VirtualKeyController::class);
    Route::resource('gate', GateController::class);
    Route::get('/gates', function() {
        return Inertia::render('Gates/Show');
    })->name('gates');
});

Route::middleware([
    'isAdmin'
])->group(function () {
    Route::get('gates/create', function() {
        return Inertia::render('Gates/Create');
    })->name('gates.create')->middleware('isAdmin');
});

Route::resource('projects', ProjectsController::class);
