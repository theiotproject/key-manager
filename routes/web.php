<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use PhpParser\Node\Expr\AssignOp\Plus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\VirtualKeyController;

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
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/auth/permission/teamId/{team_id}', [AuthController::class, 'getAuthUserPermissionByTeamId']);
    Route::resource('/virtualKeys', VirtualKeyController::class);
    Route::resource('/gates', GateController::class);
    Route::get('gates/teamId/{team_id}/resource', [GateController::class, 'indexGatesByTeamIdResource']);
    Route::get('virtualKeys/teamId/{team_id}/users/gates', [VirtualKeyController::class, 'indexVirtualKeysByTeamIdWithUsersAndGatesData']);
    Route::get('/auth/users/{team_id}', [AuthController::class, 'indexUsersByTeamId']);
    Route::get('/events/teamId/{teamId}', [EventController::class, 'indexEventsByTeamId']);
});


Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/gates/create', [GateController::class, 'create'])->name('gates.create');
});

Route::middleware([
    'isAdmin'
])->group(function () {
    Route::get('virtualKeys/create', function () {
        return Inertia::render('VirtualKeys/Create');
    })->name('virtualKey.create')->middleware('isAdmin');
});


