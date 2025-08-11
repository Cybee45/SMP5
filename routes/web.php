<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
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
Route::view('/spmb',      'public.spmb')->name('spmb');        // PPDB page
Route::view('/media',     'public.media')->name('media');
Route::view('/kontak',    'public.kontak')->name('kontak');
Route::view('/blog',      'public.blog')->name('blog');

// ────────────────────────────
//  PUBLIC UUID ROUTES
// ────────────────────────────
require __DIR__.'/public-uuid.php';

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
