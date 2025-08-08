<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman akan dinamis sesuai judul berita --}}
    <title>{{ $berita->title }}</title>
    <!-- Memuat Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Memuat Plugin Tailwind Typography untuk styling artikel -->
    <script src="https://cdn.tailwindcss.com/3.3.5?plugins=typography"></script>
    <!-- Memuat Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
        }
    </style>
</head>
<body>
    <!-- ===== Contoh Header Sederhana ===== -->
    <header class="bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <a href="/" class="text-xl font-bold text-gray-800">SMPN 5 SANGATTA UTARA</a>
        </nav>
    </header>

    <!-- ===== Konten Utama Artikel Dimulai ===== -->
    <main class="py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article>
                <!-- Header Artikel -->
                <header class="mb-8">
                    <!-- Kategori Berita -->
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800 mb-4">
                        {{ $berita->kategori->nama }}
                    </span>
                    <!-- Judul Artikel -->
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight">
                        {{ $berita->title }}
                    </h1>
                    <!-- Meta Info: Penulis dan Tanggal -->
                    <div class="mt-6 flex items-center space-x-4 text-sm text-gray-500">
                        <span>Oleh <span class="font-semibold text-gray-700">{{ $berita->author->name }}</span></span>
                        <span class="text-gray-300">|</span>
                        <span>Diterbitkan pada <span class="font-semibold text-gray-700">{{ $berita->created_at->format('d F Y') }}</span></span>
                    </div>
                </header>

                <!-- Gambar Utama Artikel -->
                <figure class="mb-8">
                    <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="w-full h-auto rounded-2xl shadow-lg">
                </figure>

                <!-- Isi Artikel -->
                <div class="prose prose-lg max-w-none prose-blue">
                    {!! $berita->body !!}
                </div>

                <!-- Tombol Kembali -->
                <div class="mt-12 pt-8 border-t">
                    <a href="/berita" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke Daftar Berita
                    </a>
                </div>
            </article>
        </div>
    </main>

    <!-- ===== Section Berita Lainnya ===== -->
    <aside class="bg-white py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Baca Juga Berita Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Loop untuk menampilkan berita lainnya --}}
                @foreach($berita_lainnya as $item)
                <a href="{{ url('/berita/' . $item->slug) }}" class="group block bg-white rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-in-out overflow-hidden">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-40 w-full object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-500 mt-2">{{ $item->created_at->format('d F Y') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </aside>

    <!-- ===== Contoh Footer Sederhana ===== -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 SMPN 5 Sangatta Utara. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
        