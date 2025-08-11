<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hero;
use App\Models\Artikel;
use App\Models\Galeri;

/*
|--------------------------------------------------------------------------
| Public Web Routes dengan UUID
|--------------------------------------------------------------------------
| Routes ini menggunakan UUID untuk keamanan dan anti-enumeration
|
*/

// Public Hero route with UUID
Route::get('/hero/{hero:uuid}', function (Hero $hero) {
    return response()->json([
        'success' => true,
        'data' => [
            'id' => $hero->id,
            'uuid' => $hero->uuid,
            'judul' => $hero->judul,
            'subjudul' => $hero->subjudul,
            'deskripsi' => $hero->deskripsi,
            'created_at' => $hero->created_at,
        ]
    ]);
})->name('public.hero.show');

// Public Artikel route with UUID  
Route::get('/artikel/{artikel:uuid}', function (\App\Models\Artikel $artikel) {
    return response()->json([
        'success' => true,
        'data' => [
            'id' => $artikel->id,
            'uuid' => $artikel->uuid,
            'judul' => $artikel->judul ?? 'Tidak ada judul',
            'konten' => $artikel->konten ?? 'Tidak ada konten',
            'created_at' => $artikel->created_at,
        ]
    ]);
})->name('public.artikel.show');

// Public Galeri route with UUID
Route::get('/galeri/{galeri:uuid}', function (\App\Models\Galeri $galeri) {
    return response()->json([
        'success' => true,
        'data' => [
            'id' => $galeri->id,
            'uuid' => $galeri->uuid,
            'judul' => $galeri->judul ?? 'Tidak ada judul',
            'deskripsi' => $galeri->deskripsi ?? 'Tidak ada deskripsi',
            'created_at' => $galeri->created_at,
        ]
    ]);
})->name('public.galeri.show');

// Demo route untuk menunjukkan perbedaan
Route::get('/uuid-demo', function () {
    $hero = Hero::first();
    
    if (!$hero) {
        return response()->json(['error' => 'No hero found']);
    }
    
    return response()->json([
        'uuid_implementation' => [
            'admin_url' => url("/admin/heroes/{$hero->id}/edit"),
            'public_url' => url("/hero/{$hero->uuid}"),
            'api_url' => url("/api/heroes/{$hero->uuid}"),
        ],
        'security_comparison' => [
            'admin_id' => $hero->id,  // Predictable: 1, 2, 3, 4...
            'public_uuid' => $hero->uuid,  // Unpredictable: 265f7152-2bb2-4605-8331-2cfa11a2c8b6
        ],
        'benefits' => [
            'admin' => 'Fast database queries, easy debugging, Filament compatible',
            'public' => 'Security against enumeration, unique global identifiers, API standard'
        ]
    ]);
});
