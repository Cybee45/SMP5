<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog articles.
     */
    public function index(Request $request)
    {
        \Log::info('BlogController@index dipanggil');
        
        $query = Artikel::with('kategori', 'user')
            ->where('aktif', true)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        // Filter by category if provided
        if ($request->has('kategori') && $request->kategori) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }

        $artikels = $query->paginate(9);
        $kategoris = Kategori::where('aktif', true)->get();

        \Log::info('Jumlah artikel: ' . $artikels->count());
        \Log::info('Jumlah kategori: ' . $kategoris->count());
        \Log::info('Tentang to render view: public.blog.index');

        return view('public.blog.index', compact('artikels', 'kategoris'));
    }

    /**
     * Display the specified blog article.
     */
    public function show(string $slug)
    {
        $artikel = Artikel::with('kategori', 'user')
            ->where('slug', $slug)
            ->where('aktif', true)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related articles from the same category
        $relatedArtikels = Artikel::with('kategori')
            ->where('kategori_id', $artikel->kategori_id)
            ->where('id', '!=', $artikel->id)
            ->where('aktif', true)
            ->where('status', 'published')
            ->orderBy('tanggal_publikasi', 'desc')
            ->take(3)
            ->get();

        // If no related articles in same category, get latest articles
        if ($relatedArtikels->count() < 3) {
            $additionalArtikels = Artikel::with('kategori')
                ->where('id', '!=', $artikel->id)
                ->where('aktif', true)
                ->where('status', 'published')
                ->orderBy('tanggal_publikasi', 'desc')
                ->take(3 - $relatedArtikels->count())
                ->get();

            $relatedArtikels = $relatedArtikels->merge($additionalArtikels);
        }

        return view('public.blog.show', compact('artikel', 'relatedArtikels'));
    }
}
