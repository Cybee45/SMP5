<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── PUBLIC ───────────────────────────────────────────────────────────────
Route::get('/',        [PublicController::class, 'home'])->name('home');
Route::get('/about',   [PublicController::class, 'about'])->name('about');
Route::view('/spmb',   'public.spmb')->name('spmb');
Route::view('/media',  'public.media')->name('media');
Route::view('/kontak', 'public.kontak')->name('kontak');

// Blog
Route::get('/blog',        [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Download
Route::get('/download/spmb/{id}', [PublicController::class, 'downloadSpmb'])->name('download.spmb');

// ── AUTH ────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard');
});

require __DIR__.'/auth.php';
