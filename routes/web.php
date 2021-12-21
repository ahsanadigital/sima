<?php

/**
 * Route Main
 * Mendefinisikan semua rute yang akan digunakan
 *
 * @package collage-life
 * @since 1.0.0
 * @author Unknown
 */

use Illuminate\Support\Facades\Route;

# Guest Section =======================================================================
Route::prefix('/login')->group(function () {
  Route::get('/', [\App\Http\Controllers\HomeController::class, 'main'])->name('login.main');
  Route::post('/', [\App\Http\Controllers\HomeController::class, 'process'])->name('login.process');
});

Route::prefix('/forgot-password')->group(function () {
  Route::get('/', [\App\Http\Controllers\ForgotPassword::class, 'main'])->name('forgot-password.main');
  Route::post('/', [\App\Http\Controllers\ForgotPassword::class, 'process'])->name('forgot-password.process');
});

Route::prefix('/register')->group(function () {
  Route::get('/', [\App\Http\Controllers\RegisterController::class, 'main'])->name('register.main');
  Route::post('/', [\App\Http\Controllers\RegisterController::class, 'process'])->name('register.process');
});

# Panel Section =======================================================================
Route::prefix('/')->group(function () {
  Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('panel.home');
});

Route::prefix('my-profile')->group(function () {
  Route::get('/', [\App\Http\Controllers\UpdateUser::class, 'index'])->name('user-edit.home');
  Route::post('/', [\App\Http\Controllers\UpdateUser::class, 'update'])->name('user-edit.update');

  Route::get('/password', [\App\Http\Controllers\UpdatePassword::class, 'index'])->name('user-password.home');
  Route::post('/password', [\App\Http\Controllers\UpdatePassword::class, 'update'])->name('user-password.update');
});

# User Section
Route::prefix('event')->group(function () {
  Route::get('/', [\App\Http\Controllers\User\EventController::class, 'index'])->name('event.index');
  Route::get('/{id}/register', [\App\Http\Controllers\User\EventController::class, 'register'])->name('event.register');
  Route::post('/{id}/process', [\App\Http\Controllers\User\EventController::class, 'process'])->name('event.process');

  Route::get('/seminar', [\App\Http\Controllers\User\EventController::class, 'seminar'])->name('event.seminar');
  Route::get('/volunteer', [\App\Http\Controllers\User\EventController::class, 'volunteer'])->name('event.volunteer');
  Route::get('/competition', [\App\Http\Controllers\User\EventController::class, 'competition'])->name('event.competition');
  Route::get('/scholarship', [\App\Http\Controllers\User\EventController::class, 'scholarship'])->name('event.scholarship');
});
Route::resource('agenda', \App\Http\Controllers\User\AgendaController::class);

# Admin Section
Route::prefix('admin')->group(function () {
  Route::resource('events', \App\Http\Controllers\Admin\EventsController::class);
});

# For Logout ===========================================================================
Route::any('logout', function() {
  if(auth()->guard('admin')->user() OR auth()->guard('user')->user()) {
    auth()->guard('admin')->logout();
    auth()->guard('user')->logout();
    return redirect()->route('login.main')->with('success', 'Successfuly logging out from the system!');
  } else {
    return redirect()->route('login.main')->with('error', 'You\'re not loggedin!');
  }
})->name('logout');
