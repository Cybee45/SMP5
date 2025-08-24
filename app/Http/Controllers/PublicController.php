<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Keunggulan;
use App\Models\Statistik;
use App\Models\Artikel;
use App\Models\SectionAkreditasi;
use App\Models\PrestasiAbout;

class PublicController extends Controller
{
    public function home()
    {
        $hero = Hero::where('tipe', 'home')->where('aktif', true)->first();
        $keunggulans = Keunggulan::where('aktif', true)->orderBy('urutan')->get();
        $statistiks  = Statistik::where('aktif', true)->orderBy('urutan')->get();

        $artikels = Artikel::with('kategori')
            ->where('aktif', true)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // (opsional) kalau mau tampilkan di home
        $prestasis = PrestasiAbout::query()
            ->where('aktif', 1)
            ->orderBy('urutan')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('public.home', compact('hero','keunggulans','statistiks','artikels','prestasis'));
    }

    public function about()
    {
        $akreditasi = SectionAkreditasi::where('aktif', true)
            ->with(['prestasi' => fn($q) => $q->where('aktif', 1)->orderBy('urutan')->orderByDesc('created_at')])
            ->orderBy('urutan')
            ->first();

        // Jika ada section aktif gunakan relasinya; jika tidak, fallback ke semua prestasi aktif
        $prestasiList = $akreditasi
            ? $akreditasi->prestasi
            : PrestasiAbout::where('aktif', 1)->orderBy('urutan')->orderByDesc('created_at')->get();

        $judulSection        = $akreditasi->judul_section ?? 'Prestasi & Akreditasi';
        $deskripsiAkreditasi = $akreditasi->deskripsi_akreditasi
            ?? 'SMP Negeri 5 Sangatta Utara terakreditasi C, menandakan sekolah ini memiliki kualitas pendidikan yang baik...';
        $gambarAkreditasi    = $akreditasi && $akreditasi->gambar_akreditasi
            ? asset('storage/' . $akreditasi->gambar_akreditasi)
            : asset('assets/about/akreditas.png');

        return view('public.about', compact(
            'prestasiList',
            'judulSection',
            'deskripsiAkreditasi',
            'gambarAkreditasi'
        ));
    }

    public function downloadSpmb($id)
    {
        $spmhContent = \App\Models\SpmhContent::findOrFail($id);

        if (!$spmhContent->file_pdf) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $spmhContent->file_pdf);
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $fileName = $spmhContent->nama_file ?: basename($spmhContent->file_pdf);
        return response()->download($filePath, $fileName);
    }
}
