<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\VirtualKeyController;
use Illuminate\Foundation\Application;
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
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/auth/permission/teamId/{team_id}', [AuthController::class, 'getAuthUserPermissionByTeamId']);
    Route::resource('/virtualKeys', VirtualKeyController::class);
    Route::resource('/gates', GateController::class);
    Route::get('gates/teamId/{team_id}/resource', [GateController::class, 'indexGatesByTeamIdResource']);
    Route::get('virtualKeys/teamId/{team_id}/resource', [VirtualKeyController::class, 'indexVirtualKeysByTeamIdResource']);
});

Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/gates/create', [GateController::class, 'create'])->name('gates.create');
});

Route::resource('projects', ProjectsController::class);
