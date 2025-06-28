<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route login (tanpa middleware auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Route yang dilindungi auth
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/mahasiswa', function () {
        return view('mahasiswa');
    })->name('mahasiswa');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
