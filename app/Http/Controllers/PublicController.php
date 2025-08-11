<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\Keunggulan;
use App\Models\Statistik;

class PublicController extends Controller
{
    public function home()
    {
        $hero = Hero::where('tipe', 'home')->where('aktif', true)->first();
        $keunggulans = Keunggulan::where('aktif', true)->orderBy('urutan')->get();
        $statistiks = Statistik::where('aktif', true)->orderBy('urutan')->get();
        return view('public.home', compact('hero', 'keunggulans', 'statistiks'));
    }

    // Kamu bisa tambahkan about(), spmb(), dst. di sini juga nanti
}
