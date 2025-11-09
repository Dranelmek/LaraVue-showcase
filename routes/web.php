<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Home');

Route::get('/about', function () {
    return Inertia::render('About', ['user' => 'John Doe']);
});

