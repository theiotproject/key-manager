<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TenantsController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/admin/', [AdminController::class, 'index'])->name('admin.updatePermission');

Route::resource('/tenants', 'App\Http\Controllers\TenantsController');

Route::get('/tenants', [TenantsController::class, 'index'])->name('tenants');

Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);
//Route::get('/admin/user/roles', ['middleware'=>'IsAdmin', function() {
//    return "something";
//}]);

//Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
//
//Route::get('/auth/check', function(){
//    $user = Auth::user();
//    if(Auth::check()){
//        if($user->isAdmin()){
//            echo "this user is administrator";
//        } else {
//            echo "this user is not administrator";
//        }
//    } else{
//        echo "you are not logged in";
//    }
//});
