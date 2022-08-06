<?php

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use PhpParser\Node\Expr\AssignOp\Plus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\VirtualKeyController;
use App\Http\Controllers\VirtualTicketController;

// Main page
Route::get('/', function () {
    if(Auth::user()->current_team_id === null){
        return Inertia::render('Onboarding/Landing');
    }
    if (Auth::user()) {
        return redirect()->route('dashboard');
//        return Inertia::render('Dashboard', [
//            'canLogin' => Route::has('login'),
//            'canRegister' => Route::has('register'),
//            'laravelVersion' => Application::VERSION,
//            'phpVersion' => PHP_VERSION,
//        ])->middleware('auth:sanctum',
//            config('jetstream.auth_session'),
//            'verified',
//            'team');
    } else {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
});



Route::get('/landing', function () {
    return Inertia::render('Onboarding/Landing');
});

Route::get('/setup/teamName', function () {
    return Inertia::render('Onboarding/Setup/TeamName');
});


// Routes with verified/logged users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'team'
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/auth/permission/teamId/{team_id}', [AuthController::class, 'getAuthUserPermissionByTeamId']);
    Route::get('/auth/role/teamId/{team_id}', [AuthController::class, 'getAuthUserRoleByTeamId']);
    Route::resource('/virtualKeys', VirtualKeyController::class);
    Route::resource('/virtualTickets', VirtualTicketController::class);
    Route::resource('/gates', GateController::class);
    Route::resource('/events', EventController::class);
    Route::get('gates/teamId/{team_id}/resource', [GateController::class, 'indexGatesByTeamIdResource']);
    Route::get('virtualKeys/teamId/{team_id}/users/gates', [VirtualKeyController::class, 'indexVirtualKeysByTeamIdWithUsersAndGatesData']);
    Route::get('virtualTickets/teamId/{team_id}/users/gates', [VirtualTicketController::class, 'indexVirtualTicketsByTeamIdWithUsersAndGatesData']);
    Route::get('/auth/users/{team_id}', [AuthController::class, 'indexUsersByTeamId']);
    Route::get('/events/teamId/{teamId}/limit/{limit}', [EventController::class, 'indexEventsByTeamId']);
    Route::get('/events/teamId/{teamId}/limit/{limit}/rejected', [EventController::class, 'indexRejectedEventsByTeamId']);
    Route::delete('/gates/{gate}', [GateController::class, 'destroy'])->name('gates.destroy');
    Route::get('/gates/{gate}/edit', [GateController::class, 'edit'])->name('gates.edit');
    Route::put('/gates/{gate}', [GateController::class, 'update']);
    Route::put('/virtualKeys/{virtualKey}', [VirtualKeyController::class, 'update']);
});

// Routes with administrator permission
Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/gates/create', [GateController::class, 'create'])->name('gates.create');
    Route::get('virtualTickets/create', [VirtualTicketController::class, 'create'])->name('virtualTicket.create');
});

Route::middleware([
    'isAdmin'
])->group(function () {
    Route::get('virtualKeys/create', function () {
        return Inertia::render('VirtualKeys/Create');
    })->name('virtualKey.create')->middleware('isAdmin');
});
