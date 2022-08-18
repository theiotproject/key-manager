<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use PhpParser\Node\Expr\AssignOp\Plus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\VirtualKeyController;
use App\Http\Controllers\VirtualTicketController;
use App\Models\VirtualTicket;

// Main page
Route::get('/', function () {
    if (Auth::user()) {
        if (Auth::user()->current_team_id === null) {
            return redirect()->route('onboarding.landing');
        } else {
            return redirect()->route('dashboard');
        }
    } else {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
});

// Routes with verified/logged users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->current_team_id === null) {
            return redirect()->route('onboarding.landing');
        } else {
            return Inertia::render('Dashboard');
        }
    })->name('dashboard');
    Route::get('/onboarding/landing', function () {
        return Inertia::render('Onboarding/Landing');
    })->name('onboarding.landing');
    Route::get('/setup/teamName', function () {
        return Inertia::render('Onboarding/Setup/TeamName');
    });
    Route::get('/auth/permission/teamId/{team_id}', [AuthController::class, 'getAuthUserPermissionByTeamId']);
    Route::get('/auth/role/teamId/{team_id}', [AuthController::class, 'getAuthUserRoleByTeamId']);
    Route::resource('/virtualKeys', VirtualKeyController::class);
    Route::resource('/virtualTickets', VirtualTicketController::class);
    Route::get("/virtualTickets", [VirtualTicketController::class, 'index'])->name('virtualTickets.index');
    Route::resource('/gates', GateController::class);
    Route::resource('/events', EventController::class);
    Route::get('gates/teamId/{team_id}/resource', [GateController::class, 'indexGatesByTeamIdResource']);
    Route::get('virtualKeys/teamId/{team_id}/users/gates', [VirtualKeyController::class, 'indexVirtualKeysByTeamIdWithUsersAndGatesData']);
    Route::get('virtualTickets/teamId/{team_id}/users/gates', [VirtualTicketController::class, 'indexVirtualTicketsByTeamIdWithUsersAndGatesData']);
    Route::get('/auth/users/{team_id}', [AuthController::class, 'indexUsersByTeamId']);
    Route::get('/events/teamId/{teamId}/limit/{limit}', [EventController::class, 'indexEventsByTeamId']);
    Route::get('/events/teamId/{teamId}/limit/{limit}/rejected', [EventController::class, 'indexRejectedEventsByTeamId']);
    Route::get('/events/teamId/{teamId}/gateId/{gateId}/limit/{limit}', [EventController::class, 'indexEventsByGate']);
    Route::get('/events/gateSN/{gateSerialNumber}/count', [EventController::class, 'countAccessForGateLast7Days']);
    Route::delete('/gates/{gate}', [GateController::class, 'destroy'])->name('gates.destroy');
    Route::get('/gates/{gate}/edit', [GateController::class, 'edit'])->name('gates.edit');
    Route::put('/gates/{gate}', [GateController::class, 'update']);
    Route::put('/virtualKeys/{virtualKey}', [VirtualKeyController::class, 'update']);
    Route::get('/virtualKeys/gate/{gateId}', [VirtualKeyController::class, 'indexVirtualKeysByGate']);
    Route::put('/tours', [ToursController::class, 'update']);
});


Route::get('/teams/invitations/{userId}', [TeamController::class, 'getUserInvitations']);


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
