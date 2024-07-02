<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');

Route::get('/', function () {
    return view('welcome');
});

// Routing ke halaman Home Page
// Route::get('/', function () {
//     return view('Homepage');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
