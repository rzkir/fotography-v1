<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\FeatureController;
use App\Http\Controllers\Dashboard\JurnalCategoryController;
use App\Http\Controllers\Dashboard\JurnalController;
use App\Http\Controllers\Dashboard\PortfolioCategoryController;
use App\Http\Controllers\Dashboard\PortfolioController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\WorkController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware('splash')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/works', [WorkController::class, 'index'])->name('works.index');

    Route::get('/works/{portfolio:slug}', [WorkController::class, 'show'])->name('works.show');

    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');

    Route::get('/journal/{jurnal:slug}', [JournalController::class, 'show'])->name('journal.show');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/privacy-security', function () {
        return view('privacy-security');
    })->name('privacy-security');

    Route::get('/terms-of-service', function () {
        return view('terms-of-service');
    })->name('terms-of-service');

    Route::get('/copyright', function () {
        return view('copyright');
    })->name('copyright');
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
        $portfolios = $user->portfolios()->with('portfolioCategory')->latest()->take(3)->get();
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
    Route::resource('testimonials', TestimonialController::class)->except(['show', 'create', 'edit']);
    Route::resource('features', FeatureController::class)->except(['show', 'create', 'edit']);
    Route::resource('teams', TeamController::class)->except(['show']);

    Route::get('profile', function (Request $request) {
        $user = $request->user();
        $currentSessionId = $request->session()->getId();

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        return view('dashboard.profile.index', [
            'user' => $user,
            'sessions' => $sessions,
            'currentSessionId' => $currentSessionId,
        ]);
    })->name('profile.index');

    Route::post('profile', function (Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Profile updated.');
    })->name('profile.update');

    Route::get('profile/change-password', function () {
        return view('dashboard.profile.change-password');
    })->name('profile.password.edit');

    Route::post('profile/change-password', function (Request $request): RedirectResponse {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard.profile.index')
            ->with('success', 'Password updated.');
    })->name('profile.password.update');
});
