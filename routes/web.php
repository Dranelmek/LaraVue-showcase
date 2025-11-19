<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConvertController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
use Illuminate\Http\Kernel;

Route::get('/debug-url', function (Request $request) {
    dd(app()->make(Kernel::class)->getMiddleware());
    return [
        'is_secure' => $request->isSecure(),
        'scheme' => $request->getScheme(),
        'full_url' => $request->fullUrl(),
        'app_url' => config('app.url'),
        'forwarded_proto' => $request->header('X-Forwarded-Proto'),
    ];
});

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

Route::get('/update', [ConvertController::class, 'update'])->name('update');