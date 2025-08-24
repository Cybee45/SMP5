@props([
    'artikels' => collect(),
    'title' => 'Berita & Informasi Terbaru',
    'subtitle' => 'Ikuti terus perkembangan, pengumuman, dan cerita inspiratif dari lingkungan sekolah kami.',
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $items    = collect($artikels)->take(3)->values();
    $featured = $items->get(0);
    $others   = $items->slice(1)->values();

    $img = function ($a) {
        $cands = [data_get($a,'gambar_utama'), data_get($a,'gambar'), data_get($a,'thumbnail'), data_get($a,'cover_image')];
        foreach ($cands as $c) {
            if (!$c) continue;
            if (Str::startsWith($c, ['http://','https://'])) return $c;
            if (Storage::disk('public')->exists($c)) return Storage::url($c);
            if (Str::startsWith($c, 'storage/')) return asset($c);
        }
        return null;
    };

    $tgl = fn($a) => optional(data_get($a,'tanggal_publikasi') ?: data_get($a,'created_at'))->format('d M Y');
    $badge = function ($a) {
        $nama = data_get($a,'kategori.nama') ?? data_get($a,'kategori') ?? 'Umum';
        $cls = match ($nama) {
            'Prestasi'        => 'bg-amber-100 text-amber-800 ring-1 ring-inset ring-amber-200',
            'Pengumuman'      => 'bg-blue-100 text-blue-800 ring-1 ring-inset ring-blue-200',
            'Kegiatan'        => 'bg-purple-100 text-purple-800 ring-1 ring-inset ring-purple-200',
            'Akademik'        => 'bg-green-100 text-green-800 ring-1 ring-inset ring-green-200',
            'Ekstrakurikuler' => 'bg-red-100 text-red-800 ring-1 ring-inset ring-red-200',
            'Beasiswa'        => 'bg-indigo-100 text-indigo-800 ring-1 ring-inset ring-indigo-200',
            default           => 'bg-gray-100 text-gray-800 ring-1 ring-inset ring-gray-200',
        };
        return [$nama, $cls];
    };
@endphp

<section class="bg-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-12 lg:mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900" 
            data-aos="fade-up" data-aos-duration="800" data-aos-delay="100" data-aos-easing="ease-out-cubic">{{ $title }}</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto text-base md:text-lg"
            data-aos="fade-up" data-aos-duration="800" data-aos-delay="100" data-aos-easing="ease-out-cubic">{{ $subtitle }}</p>
        </div>

        @if($featured)
        {{-- [REDESIGNED] Grid Layout --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- [REDESIGNED] FEATURED CARD (Kiri) --}}
            @php
                $fImg   = $img($featured);
                [$fCat, $fCls] = $badge($featured);
                $fJudul = data_get($featured,'judul','Tanpa Judul');
                $fSlug  = data_get($featured,'slug');
                $fRing  = data_get($featured,'excerpt') ?? Str::limit(strip_tags((string)data_get($featured,'konten')), 130);
            @endphp
            <article
                class="group relative lg:col-span-2 bg-gray-900 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl"
                data-aos="fade-right" data-aos-duration="700">
                
                {{-- Background Image --}}
                <div class="absolute inset-0">
                    @if($fImg)
                        <img src="{{ $fImg }}" alt="{{ $fJudul }}"
                            class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-105"
                            loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-sky-500 to-indigo-600"></div>
                    @endif
                </div>

                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>

                {{-- Content --}}
                <div class="relative h-full flex flex-col justify-end p-6 sm:p-8 min-h-[400px] md:min-h-[450px]">
                    <div class="flex items-center gap-x-4 text-xs mb-2">
                        <time datetime="{{ (data_get($featured,'tanggal_publikasi') ?: data_get($featured,'created_at'))->toIso8601String() }}" class="text-gray-300">{{ $tgl($featured) }}</time>
                        <span class="relative z-10 rounded-full px-3 py-1 font-medium text-white bg-white/10 ring-1 ring-white/20">{{ $fCat }}</span>
                    </div>
                    <h3 class="text-2xl lg:text-3xl font-bold leading-tight text-white mb-3 line-clamp-3">
                        @if($fSlug)
                            <a href="{{ route('blog.show', $fSlug) }}">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $fJudul }}
                            </a>
                        @else
                            {{ $fJudul }}
                        @endif
                    </h3>
                    <p class="text-gray-300 text-sm md:text-base line-clamp-2">{{ $fRing }}</p>
                    
                    {{-- [ADDED] Tombol Baca Selengkapnya --}}
                    <div class="mt-4 inline-flex items-center font-semibold text-white group-hover:text-indigo-300 transition-colors duration-300">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1.5 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </article>

            {{-- [REDESIGNED] Kolom untuk 2 kartu di kanan --}}
            <div class="flex flex-col gap-8">
                @foreach($others as $i => $a)
                    @php
                        $aImg   = $img($a);
                        [$aCat, $aCls] = $badge($a);
                        $aJudul = data_get($a,'judul','Tanpa Judul');
                        $aSlug  = data_get($a,'slug');
                    @endphp
                    <article
                        class="group relative flex flex-col bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1"
                        data-aos="fade-left" data-aos-duration="700" data-aos-delay="{{ 100 + ($i*100) }}">
                        
                        {{-- Image container --}}
                        <div class="relative h-48 overflow-hidden">
                             @if($aImg)
                                <img src="{{ $aImg }}" alt="{{ $aJudul }}"
                                    class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-105"
                                    loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-sky-400 to-indigo-500"></div>
                            @endif
                        </div>
                        
                        {{-- Content --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex items-center gap-x-3 text-xs mb-2">
                                <time datetime="{{ (data_get($a,'tanggal_publikasi') ?: data_get($a,'created_at'))->toIso8601String() }}" class="text-gray-500">{{ $tgl($a) }}</time>
                                <span class="relative z-10 rounded-full px-3 py-1 font-medium {{ $aCls }}">{{ $aCat }}</span>
                            </div>
                            <h4 class="text-base font-bold text-gray-900 flex-grow line-clamp-2">
                                @if($aSlug)
                                    <a href="{{ route('blog.show', $aSlug) }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $aJudul }}
                                    </a>
                                @else
                                    {{ $aJudul }}
                                @endif
                            </h4>
                            {{-- [ADDED] Tombol Baca Selengkapnya --}}
                            <div class="mt-auto pt-2 inline-flex items-center text-sm font-semibold text-indigo-600 group-hover:text-indigo-700 transition-colors duration-300">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1.5 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>

        {{-- [ADDED] Tombol "Selengkapnya" --}}
        <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="200">
            {{-- Pastikan route 'blog.index' ada di web.php Anda --}}
            <a href="{{ route('blog.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-lg hover:shadow-indigo-500/40 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Lihat Semua Berita
                <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>