<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConvertController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;

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

// Debug Routs
Route::get('/debug-dirs', function () {
    return [
        'temp_exists' => is_dir(storage_path('app/temp')),
        'output_exists' => is_dir(storage_path('app/output')),
        'temp_writable' => is_writable(storage_path('app/temp')),
        'output_writable' => is_writable(storage_path('app/output')),
        'cookies_exists' => is_dir(storage_path('cookies')),
    ];
});

Route::get('/debug-ytdlp-run', function () {
    $cmd = 'yt-dlp -v -o "/var/www/html/storage/app/temp/%(title)s.%(ext)s" https://www.youtube.com/watch?v=6wyaN_vPkXM 2>&1';
    return shell_exec($cmd);
});

Route::get('/debug-node', function () {
    return [
        'which_node' => trim(shell_exec('which node')),
        'node_v' => shell_exec('node -v 2>&1'),
        'npm_v' => shell_exec('npm -v 2>&1'),
        'PATH' => getenv('PATH'),
    ];
});

Route::get('/debug-node-ytdlp', function () {
    return [
        "node" => trim(shell_exec("node -v 2>&1")),
        "which_node" => trim(shell_exec("which node 2>&1")),
        "yt_dlp_js" => trim(shell_exec("yt-dlp --dump-single-json https://www.youtube.com/watch?v=UnIhRpIT7nc 2>&1")),
    ];
});

Route::get('/debug-cookies-file', function () {
    $path = '/etc/secrets/cookies.txt';
    return [
        'exists' => file_exists($path),
        'size' => file_exists($path) ? filesize($path) : 0,
        'first_lines' => file_exists($path)
            ? implode("\n", array_slice(file($path), 0, 5))
            : null,
        'absolute_path' => $path,
    ];
});