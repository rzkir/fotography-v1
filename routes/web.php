<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\JurnalCategoryController;
use App\Http\Controllers\Dashboard\JurnalController;
use App\Http\Controllers\Dashboard\PortfolioCategoryController;
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
        $user = auth()->user();
        $portfolios = $user->portfolios()->latest()->take(3)->get();
        $projectCount = $user->portfolios()->count();
        $publishedCount = $user->portfolios()->where('is_published', true)->count();

        $stats = [
            'views' => 142800,
            'projects' => $projectCount,
            'published' => $publishedCount,
            'appreciations' => 12500,
            'earnings' => 8200,
        ];

        $shoots = [
            [
                'month' => 'Jul',
                'day' => '12',
                'title' => 'Street Life Series',
                'meta' => 'Berlin, Germany • 14:00',
                'accent' => 'orange',
            ],
            [
                'month' => 'Jul',
                'day' => '15',
                'title' => 'Vogue Editorial',
                'meta' => 'Paris, Studio 4 • 09:00',
                'accent' => 'coral',
            ],
            [
                'month' => 'Jul',
                'day' => '18',
                'title' => 'Architectural Bio',
                'meta' => 'London, HQ • 11:30',
                'dimmed' => true,
            ],
        ];

        return view('dashboard.index', compact('portfolios', 'stats', 'shoots'));
    })->name('index');

    Route::get('portofolio/category', [PortfolioCategoryController::class, 'index'])->name('portofolio.category.index');
    Route::post('portofolio/category', [PortfolioCategoryController::class, 'store'])->name('portofolio.category.store');
    Route::put('portofolio/category/{portfolioCategory}', [PortfolioCategoryController::class, 'update'])->name('portofolio.category.update');
    Route::delete('portofolio/category/{portfolioCategory}', [PortfolioCategoryController::class, 'destroy'])->name('portofolio.category.destroy');
    Route::resource('portofolio', PortfolioController::class)->except(['show']);

    Route::get('jurnal/category', [JurnalCategoryController::class, 'index'])->name('jurnal.category.index');
    Route::post('jurnal/category', [JurnalCategoryController::class, 'store'])->name('jurnal.category.store');
    Route::put('jurnal/category/{jurnalCategory}', [JurnalCategoryController::class, 'update'])->name('jurnal.category.update');
    Route::delete('jurnal/category/{jurnalCategory}', [JurnalCategoryController::class, 'destroy'])->name('jurnal.category.destroy');
    Route::resource('jurnal', JurnalController::class)->except(['show']);
});
