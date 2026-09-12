<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SceneController;
use Illuminate\Support\Facades\Route;

// Landing & Welcome (Screen 1i)
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/welcome', [HomeController::class, 'welcome']);
Route::get('/how-it-works', [HomeController::class, 'welcome'])->name('how-it-works');

// Browse & Catalog (Screen 1a, 1b, 1c)
Route::get('/browse', [HomeController::class, 'index'])->name('home');
Route::get('/films', [HomeController::class, 'index'])->name('films.index');

// Locale Switcher
Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');

// Film Details & Community Actions
Route::get('/film/{film}', [FilmController::class, 'show'])->name('films.show');
Route::post('/film/{film}/clean-vote', [FilmController::class, 'cleanVote'])->name('films.clean-vote');
Route::post('/film/{film}/watched', [FilmController::class, 'toggleWatched'])->name('films.watched');
Route::post('/film/{film}/scenes', [SceneController::class, 'store'])->name('scenes.store');
Route::post('/scenes/{scene}/vote', [SceneController::class, 'vote'])->name('scenes.vote');

// Reports
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Public Profile
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Onboarding
Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
Route::post('/onboarding', [OnboardingController::class, 'update'])->name('onboarding.update');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Editor Moderation Dashboard
Route::prefix('editor')->middleware(['auth', 'editor'])->name('editor.')->group(function () {
    Route::get('/', [EditorController::class, 'index'])->name('dashboard');
    Route::post('/scenes/{scene}/approve', [EditorController::class, 'approveScene'])->name('scenes.approve');
    Route::post('/scenes/{scene}/reject', [EditorController::class, 'rejectScene'])->name('scenes.reject');
    Route::put('/scenes/{scene}', [EditorController::class, 'updateScene'])->name('scenes.update');
    Route::post('/reports/{report}/resolve', [EditorController::class, 'resolveReport'])->name('reports.resolve');
    Route::post('/films/{film}/delist', [EditorController::class, 'confirmDelist'])->name('films.delist');
    Route::post('/films/{film}/reject-delist', [EditorController::class, 'rejectDelist'])->name('films.reject-delist');
});
