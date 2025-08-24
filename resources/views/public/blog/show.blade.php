<x-app-layout :title="$artikel->judul . ' - SMP Negeri 5'">

<div class="bg-gray-50 min-h-screen">
    <section class="relative bg-gray-900 pt-20 pb-16 overflow-hidden">
        <!-- Latar Belakang Gambar (BARU) -->
        <div class="absolute inset-0 z-0">
            <!-- GANTI SRC INI DENGAN GAMBAR ANDA -->
            <img src="{{ asset('assets/hero/hero-prestasi.jpg') }}" 
                alt="Latar Belakang Artikel" 
                class="w-full h-full object-cover object-center">
        </div>

        <!-- Overlay Gradasi dan Gelap (Opacity dikurangi) -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 opacity-40"></div>
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Breadcrumb -->
            <nav class="text-white/80 text-sm mb-8 ml-3 sm:ml-8 md:ml-16 lg:ml-24 xl:ml-32 2xl:ml-40">
                <a href="/" class="hover:text-white transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <a href="/blog" class="hover:text-white transition-colors">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-yellow-400">{{ $artikel->judul }}</span>
            </nav>

            <!-- Konten Utama (digeser ke kiri) -->
            <div class="max-w-4xl text-white ml-3 sm:ml-8 md:ml-16 lg:ml-24 xl:ml-32 2xl:ml-40">
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
    <section class="py-12 sm:py-16">
  <div class="container mx-auto px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        {{-- Featured Image + Category Badge --}}
        @if($artikel->gambar)
          @php
            // Ambil nama & warna kategori (opsional)
            $katNama  = optional($artikel->kategori)->nama ?? null;
            $katWarna = optional($artikel->kategori)->warna ?? 'blue';

            // Map warna sederhana -> kelas Tailwind
            $badgeColor = match($katWarna) {
              default  => 'bg-blue-600',
            };
          @endphp

          <div class="w-full">
            <div class="relative aspect-[16/9] sm:aspect-[21/9] md:aspect-[16/9] overflow-hidden">
              {{-- Badge kategori (muncul kalau ada nama kategori) --}}
              @if($katNama)
                <div class="absolute top-3 left-3 z-10">
                  <span
                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold text-white shadow-md ring-1 ring-black/5 {{ $badgeColor }}">
                    {{ $katNama }}
                  </span>
                </div>
              @endif

              <img
                src="{{ asset('storage/' . $artikel->gambar) }}"
                alt="{{ $artikel->judul }}"
                class="absolute inset-0 w-full h-full object-cover"
                loading="lazy">
            </div>
          </div>
        @endif

        {{-- Article Body --}}
        <div class="p-6 sm:p-8 md:p-12">
          <div class="prose prose-slate max-w-none prose-img:rounded-lg prose-a:text-sky-600 hover:prose-a:text-sky-700 prose-headings:scroll-mt-24">
            {!! $artikel->konten !!}
          </div>

          {{-- Tags --}}
          @if($artikel->meta_keywords)
            <div class="mt-8 pt-6 border-t border-gray-200">
              <h4 class="text-xs sm:text-sm font-semibold text-gray-600 mb-3">Tags</h4>
              <div class="flex flex-wrap gap-2">
                @foreach(explode(',', $artikel->meta_keywords) as $tag)
                  <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs sm:text-sm">
                    {{ trim($tag) }}
                  </span>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Share (icons only) --}}
          @php
            $shareUrl   = urlencode(route('blog.show', $artikel->slug));
            $shareTitle = urlencode($artikel->judul);
          @endphp

          <div class="mt-8 pt-6 border-t border-gray-200">
            <h4 class="text-xs sm:text-sm font-semibold text-gray-600 mb-3">Bagikan artikel ini</h4>

            <div class="flex items-center gap-3 sm:gap-4">
              {{-- Facebook --}}
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                 target="_blank" rel="noopener noreferrer"
                 class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-blue-600 text-white hover:bg-blue-700 transition"
                 aria-label="Bagikan ke Facebook" title="Facebook">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.62h3.129V8.41c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.504 0-1.794.715-1.794 1.763v2.313h3.586l-.467 3.62h-3.119V24h6.116C23.407 24 24 23.407 24 22.676V1.325C24 .593 23.407 0 22.675 0z"/>
                </svg>
                <span class="sr-only">Facebook</span>
              </a>

              {{-- Instagram (no official sharer) --}}
              <a href="https://www.instagram.com/?url={{ $shareUrl }}"
                 target="_blank" rel="noopener noreferrer"
                 class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-tr from-fuchsia-600 via-rose-500 to-amber-400 text-white hover:opacity-90 transition"
                 aria-label="Bagikan ke Instagram" title="Instagram">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.35 3.608 1.325.975.975 1.263 2.242 1.325 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.35 2.633-1.325 3.608-.975.975-2.242 1.263-3.608 1.325-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.35-3.608-1.325-.975-.975-1.263-2.242-1.325-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.35-2.633 1.325-3.608C4.533 1.567 5.8 1.279 7.166 1.217 8.432 1.159 8.812 1.147 12 1.147m0-1.147C8.741 0 8.332.013 7.053.072 5.773.13 4.602.39 3.6 1.392 2.598 2.394 2.338 3.565 2.28 4.845 2.222 6.124 2.21 6.533 2.21 9.79v4.42c0 3.257.012 3.666.07 4.946.058 1.279.318 2.45 1.32 3.452 1.002 1.002 2.173 1.262 3.452 1.32 1.279.058 1.688.07 4.946.07s3.666-.012 4.946-.07c1.279-.058 2.45-.318 3.452-1.32 1.002-1.002 1.262-2.173 1.32-3.452.058-1.279.07-1.689.07-4.946V9.79c0-3.257-.012-3.666-.07-4.946-.058-1.28-.318-2.451-1.32-3.453C19.398.39 18.227.13 16.947.072 15.668.013 15.259 0 12 0Z"/>
                  <path d="M12 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324Zm0 10.176a4.014 4.014 0 1 1 0-8.028 4.014 4.014 0 0 1 0 8.028Zm6.406-10.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88Z"/>
                </svg>
                <span class="sr-only">Instagram</span>
              </a>

              {{-- WhatsApp --}}
              <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . route('blog.show', $artikel->slug)) }}"
                 target="_blank" rel="noopener noreferrer"
                 class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-green-600 text-white hover:bg-green-700 transition"
                 aria-label="Bagikan ke WhatsApp" title="WhatsApp">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.051 22.666h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884Z"/>
                </svg>
                <span class="sr-only">WhatsApp</span>
              </a>
            </div>
          </div>
        </div> {{-- /paddings --}}
      </div>
    </div>
  </div>
</section>



    <!-- Related Articles -->
    @if($relatedArtikels->count() > 0)
        <section class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Artikel Lainnya</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedArtikels as $related)
                            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
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
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium text-white"
                                              style="background-color: {{ $related->kategori->warna ?? '#3B82F6' }};">
                                            {{ $related->kategori->nama }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="text-sm text-gray-500 mb-3">
                                        {{ $related->tanggal_publikasi->format('d F Y') }}
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                                        {{ $related->judul }}
                                    </h3>
                                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($related->konten), 100) }}
                                    </p>
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

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertic
</style>

@endpush
</x-app-layout>