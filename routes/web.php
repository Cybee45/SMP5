<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
Route::view('/about',     'about')->name('about');
Route::view('/spmb',      'spmb')->name('spmb');        // PPDB page
Route::view('/media',     'media')->name('media');
Route::view('/contact',   'contact')->name('contact');
Route::view('/prestasi', 'prestasi')->name('prestasi');

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

// ────────────────────────────
//  AUTH SCAFFOLDING (Breeze)
// ────────────────────────────
require __DIR__.'/auth.php';
