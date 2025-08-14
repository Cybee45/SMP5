<x-app-layout title="Blog - SMP Negeri 5 Sangatta Utara">
    @include('components.blog.hero')
    @include('components.blog.berita', ['artikels' => $artikels, 'kategoris' => $kategoris])
</x-app-layout>
