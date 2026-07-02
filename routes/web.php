<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\JurnalController;
use App\Http\Controllers\Dashboard\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/works', function () {
    return view('works');
});

Route::get('/journal', function () {
    return view('journal');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('index');

    Route::resource('portofolio', PortfolioController::class)->except(['show']);
    Route::resource('jurnal', JurnalController::class)->except(['show']);
});
