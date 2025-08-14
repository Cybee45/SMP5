@extends('layouts.app')

@section('title', $artikel->judul . ' - SMP Negeri 5')

@section('meta')
<meta name="description" content="{{ $artikel->meta_description ?? Str::limit(strip_tags($artikel->konten), 160) }}">
<meta name="keywords" content="{{ $artikel->meta_keywords ?? $artikel->kategori->nama }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $artikel->judul }}">
<meta property="og:description" content="{{ $artikel->meta_description ?? Str::limit(strip_tags($artikel->konten), 160) }}">
<meta property="og:image" content="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/default-og.jpg') }}">
<meta property="og:url" content="{{ route('blog.show', $artikel->slug) }}">
<meta property="og:type" content="article">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $artikel->judul }}">
<meta name="twitter:description" content="{{ $artikel->meta_description ?? Str::limit(strip_tags($artikel->konten), 160) }}">
<meta name="twitter:image" content="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/default-og.jpg') }}">
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 pt-20 pb-16">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="container mx-auto px-4 relative z-10">
            <!-- Breadcrumb -->
            <nav class="text-white/80 text-sm mb-8">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-yellow-400">{{ $artikel->judul }}</span>
            </nav>

            <div class="max-w-4xl mx-auto text-white">
                <!-- Category Badge -->
                <div class="mb-4">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-medium text-white"
                          style="background-color: {{ $artikel->kategori->warna ?? '#3B82F6' }};">
                        {{ $artikel->kategori->nama }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-5xl font-bold mb-6 leading-tight">
                    {{ $artikel->judul }}
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 text-white/80">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $artikel->tanggal_publikasi->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $artikel->user->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Featured Image -->
                    @if($artikel->gambar)
                        <div class="w-full h-64 md:h-96 relative overflow-hidden">
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" 
                                 alt="{{ $artikel->judul }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Article Body -->
                    <div class="p-8 md:p-12">
                        <div class="prose prose-lg max-w-none">
                            {!! $artikel->konten !!}
                        </div>

                        <!-- Tags -->
                        @if($artikel->meta_keywords)
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-600 mb-3">Tags:</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $artikel->meta_keywords) as $tag)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Share Buttons -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-600 mb-3">Bagikan artikel ini:</h4>
                            <div class="flex gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $artikel->slug)) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $artikel->slug)) }}&text={{ urlencode($artikel->judul) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . route('blog.show', $artikel->slug)) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                                    </svg>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Articles -->
    @if($relatedArtikels->count() > 0)
        <section class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Artikel Terkait</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedArtikels as $related)
                            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                                <!-- Article Image -->
                                <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-600 relative overflow-hidden">
                                    @if($related->gambar)
                                        <img src="{{ asset('storage/' . $related->gambar) }}" 
                                             alt="{{ $related->judul }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium text-white"
                                              style="background-color: {{ $related->kategori->warna ?? '#3B82F6' }};">
                                            {{ $related->kategori->nama }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Article Content -->
                                <div class="p-6">
                                    <!-- Date -->
                                    <div class="text-sm text-gray-500 mb-3">
                                        {{ $related->tanggal_publikasi->format('d F Y') }}
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                                        {{ $related->judul }}
                                    </h3>

                                    <!-- Content Preview -->
                                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($related->konten), 100) }}
                                    </p>

                                    <!-- Read More Button -->
                                    <a href="{{ route('blog.show', $related->slug) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors duration-300">
                                        Baca Selengkapnya
                                        <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Back to Blog Button -->
                    <div class="text-center mt-12">
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali ke Blog
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prose {
        color: #374151;
        line-height: 1.75;
    }

    .prose h1,
    .prose h2,
    .prose h3,
    .prose h4,
    .prose h5,
    .prose h6 {
        color: #111827;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .prose h1 { font-size: 2.25rem; }
    .prose h2 { font-size: 1.875rem; }
    .prose h3 { font-size: 1.5rem; }
    .prose h4 { font-size: 1.25rem; }

    .prose p {
        margin-bottom: 1.25rem;
    }

    .prose ul,
    .prose ol {
        margin-bottom: 1.25rem;
        padding-left: 1.625rem;
    }

    .prose li {
        margin-bottom: 0.5rem;
    }

    .prose blockquote {
        border-left: 4px solid #3B82F6;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #6B7280;
    }

    .prose img {
        border-radius: 0.5rem;
        margin: 1.5rem 0;
        width: 100%;
        height: auto;
    }

    .prose a {
        color: #3B82F6;
        text-decoration: underline;
    }

    .prose a:hover {
        color: #1D4ED8;
    }
</style>
@endpush
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
        