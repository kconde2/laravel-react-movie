<?php

use App\Http\Controllers\Movies\DeleteMovieController;
use App\Http\Controllers\Movies\EditMovieController;
use App\Http\Controllers\Movies\GetTrendingMoviesController;
use App\Http\Controllers\Movies\MoviesDashboardController;
use App\Http\Controllers\Movies\ShowMovieDetailController;
use App\Http\Controllers\Movies\UpdateMovieController;
use App\Http\Controllers\ProfileController;
use Domain\Movies\Enums\MovieTimeWindow;
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

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', MoviesDashboardController::class)->name('dashboard');

    Route::prefix('movies/trending')->group(function () {
        Route::get('/{timeWindow}', GetTrendingMoviesController::class)
            ->where('timeWindow', implode('|', array_column(MovieTimeWindow::cases(), 'value')))
            ->name('movies.trending');
        Route::get('/detail/{movieId}', ShowMovieDetailController::class)
            ->where('movieId', '[0-9]+')
            ->name('movies.detail');
        Route::delete('/delete/{movieId}', DeleteMovieController::class)
            ->where('movieId', '[0-9]+')
            ->name('movies.delete');

        Route::get('/movies/{movieId}/edit', EditMovieController::class)->name('movies.edit');
        Route::put('/movies/{movieId}', UpdateMovieController::class)->name('movies.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
