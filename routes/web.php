<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConvertController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::post('/', [ConvertController::class, 'convert']);

Route::inertia('/about', 'About', ['user' => 'John Doe'])->name('about');

Route::inertia('/login', 'Auth/Login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::inertia('/register', 'Auth/Register')->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');