<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CMSGuideWidget extends Widget
{
    protected static string $view = 'filament.widgets.cms-guide-widget';
    protected static ?int $sort = 99;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $guides = [
            'Konten' => [
                'Menambah Artikel' => 'Gunakan menu Artikel untuk membuat berita sekolah dan isi kolom yang diperlukan.',
                'Upload Gambar' => 'Gunakan fitur upload pada Gambar Utama untuk menambahkan foto yang tampil di artikel.'
            ],
            'SPMB' => [
                'Upload Formulir' => 'Tambahkan file PDF pada menu SPMB Content agar dapat diunduh publik.',
            ],
            'Media' => [
                'Galeri' => 'Tambah foto di Media Galeri untuk ditampilkan di halaman Galeri dan Home.',
            ],
        ];

        return [
            'guides' => $guides,
        ];
    }
}
