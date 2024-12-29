<?php

use App\Http\Controllers\BabyController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/babies/{baby}/journals', \App\Http\Controllers\JournalIndexController::class)->name('babies.journals.index');

Route::resource('babies', BabyController::class)
    ->only(['index', 'store', 'show', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/babies/{baby}/journals/search', [JournalController::class, 'search'])->name('babies.journals.search');

Route::resource('babies.journals', JournalController::class)
    ->only(['create','show','update','edit', 'destroy',  'store',])
    ->middleware(['auth', 'verified']);



require __DIR__.'/auth.php';

