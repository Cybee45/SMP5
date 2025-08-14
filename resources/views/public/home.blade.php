{{-- resources/views/pages/home.blade.php --}}
<x-app-layout title="Beranda - SMP Negeri 5 Sangatta Utara">
    @include('components.home.hero', ['hero' => $hero])
    @include('components.home.keunggulan', ['keunggulan' => $keunggulans])
    @include('components.home.stats', ['statistik' => $statistiks])
    @include('components.home.profil')
    @include('components.home.gallery')
    @include('components.home.berita')
</x-app-layout>
