<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::apiResource('mahasiswas', MahasiswaController::class);

