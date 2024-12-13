<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SleepController;
use App\Http\Controllers\SommeilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/password-forgot', [AuthController::class, 'password_forgot'])->name('password.forgot');
Route::post('/password-forgot', [AuthController::class, 'send_new_password'])->name('password.post');


Route::middleware(['auth'])->group(function () {

    Route::get('dashboard/user/index', [UserController::class, 'index'])->name('users.index');

    Route::get('/dashboard/users/create', [UserController::class, 'create'])->name('users.create');


    Route::post('/dashboard/users/store', [UserController::class, 'store'])->name('users.store');


    Route::get('/dashboard/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/dashboard/users/{id}/edit', [UserController::class, 'update'])->name('users.update');

    Route::post('/dashboard/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('dashboard/menus/index', [MenuController::class, 'index'])->name('menus.index');
    Route::get('dashboard/menus/{id}/content', [MenuController::class, 'content'])->name('menus.content');

    Route::get('/dashboard/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/dashboard/menus', [MenuController::class, 'store'])->name('menus.store');

    Route::get('/dashboard/menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::post('/dashboard/menus/{id}/edit', [MenuController::class, 'update'])->name('menus.update');

    Route::post('/dashboard/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');


    Route::get('dashboard/sleep/index', [SleepController::class, 'index'])->name('sleep.index');
    Route::get('/sleep/{day}/edit', [SleepController::class, 'edit'])->name('sleep.edit');
    Route::post('/sleep/{day}', [SleepController::class, 'update'])->name('sleep.update');

});


