<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class ArtikelController extends Controller
{
    public function index()
    {
        // Terbaru duluan + hanya yang publish
        $artikels = Artikel::published()->newest()->paginate(12);

        return view('public.artikel.index', compact('artikels'));
    }
}
