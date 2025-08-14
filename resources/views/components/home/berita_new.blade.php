<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Berita & Informasi Terbaru
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Ikuti perkembangan terbaru dan informasi penting dari SMP Negeri 5 Sangatta Utara
            </p>
        </div>

        @if(isset($artikels) && $artikels->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                @foreach($artikels->take(4) as $artikel)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Image -->
                        <div class="h-48 bg-blue-100 relative">
                            @if($artikel->gambar)
                                <img src="{{ asset('storage/' . $artikel->gambar) }}" 
                                     alt="{{ $artikel->judul }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                @if($artikel->kategori)
                                    @php
                                        $categoryColorClass = match($artikel->kategori->nama) {
                                            'Prestasi' => 'bg-amber-100 text-amber-800',
                                            'Pengumuman' => 'bg-blue-100 text-blue-800',
                                            'Kegiatan' => 'bg-purple-100 text-purple-800',
                                            'Akademik' => 'bg-green-100 text-green-800',
                                            'Ekstrakurikuler' => 'bg-red-100 text-red-800',
                                            'Beasiswa' => 'bg-indigo-100 text-indigo-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $categoryColorClass }}">
                                        {{ $artikel->kategori->nama }}
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Umum
                                    </span>
                                @endif
                                <span class="text-sm text-gray-500">
                                    {{ $artikel->tanggal_publikasi ? $artikel->tanggal_publikasi->format('d M Y') : $artikel->created_at->format('d M Y') }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                {{ $artikel->judul }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($artikel->konten), 120) }}
                            </p>
                            
                            <a href="{{ route('blog.show', $artikel->slug) }}" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-300">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Link ke Blog -->
            <div class="text-center">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    Lihat Semua Berita
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"></path>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Berita</h3>
                    <p class="text-gray-600">Berita dan informasi akan segera ditambahkan.</p>
                </div>
            </div>
        @endif
    </div>
</section>
