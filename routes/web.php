<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BlogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| • “/”  → Home (landing) – blade: resources/views/home.blade.php
| • Public pages: About, SPMB, Media, Contact
| • Auth middleware: Profile + (optional) Dashboard
|--------------------------------------------------------------------------*/

// ────────────────────────────
//  PUBLIC ROUTES (no auth)
// ────────────────────────────
Route::view('/',          'public.home')->name('home');
Route::view('/about',     'public.about')->name('about');
Route::view('/spmb',      'public.spmb')->name('spmb');
Route::view('/media',     'public.media')->name('media');
Route::view('/kontak',    'public.kontak')->name('kontak');

// Blog routes
Route::get('/blog',       [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ────────────────────────────
//  AUTH-PROTECTED ROUTES
// ────────────────────────────
Route::middleware('auth')->group(function () {

    // ‣ Profil pengguna (Breeze)
    Route::get   ('/profile',  [ProfileController::class, 'edit' ])->name('profile.edit');
    Route::patch ('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',  [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ‣ (Opsional) Dashboard internal – akses setelah login
    Route::get('/dashboard', fn () => view('dashboard.index'))
         ->name('dashboard');
});


Route::get('/', [PublicController::class, 'home'])->name('home');

// ────────────────────────────
//  AUTH SCAFFOLDING (Breeze)
// ────────────────────────────
require __DIR__.'/auth.php';
