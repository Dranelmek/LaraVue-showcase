<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConvertController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

// Route::inertia('/', 'Home')->name('home');
Route::get('/', [DownloadController::class, 'downloads'])->name('home');
Route::post('/', [ConvertController::class, 'convert']);

Route::delete('/deleteDownload', [DownloadController::class, 'destroy'])->name('download.delete');

Route::get('/download', [FileController::class, 'download'])->name('file.download');
Route::post('/delete', [FileController::class, 'delete'])->name('file.delete');

Route::inertia('/about', 'About')->name('about');

Route::inertia('/login', 'Auth/Login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::inertia('/register', 'Auth/Register')->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');