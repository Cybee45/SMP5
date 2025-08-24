@php
    // Ambil data hero dari database
    $heroData = $hero ?? null;
    
    // Data fallback jika belum ada di database atau data kosong
    $fallbackData = [
        'subjudul' => 'SEKOLAH MENENGAH UNGGULAN',
        'judul' => 'Prestasi dan Inovasi',
        'deskripsi' => 'Dengan fasilitas modern, tenaga pengajar berkualitas, dan program unggulan, kami membentuk siswa yang siap menghadapi tantangan masa depan dengan percaya diri dan kompeten.',
        'tombol_teks' => 'Selengkapnya',
        'tombol_link' => '#',
        'gambar' => 'assets/hero/hero-prestasi.jpg'
    ];
    
    $displayData = [
        'subjudul' => $heroData->subjudul ?? $fallbackData['subjudul'],
        'judul' => $heroData->judul ?? $fallbackData['judul'],
        'deskripsi' => $heroData->deskripsi ?? $fallbackData['deskripsi'],
        'tombol_teks' => $heroData->tombol_teks ?? $fallbackData['tombol_teks'],
        'tombol_link' => $heroData->tombol_link ?? $fallbackData['tombol_link'],
        'gambar' => $heroData && $heroData->gambar ? asset('storage/' . $heroData->gambar) : asset($fallbackData['gambar'])
    ];
@endphp

<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Latar Belakang -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/home/gedung.jpg') }}" alt="Gedung" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-sky-900/70 via-sky-800/50 to-transparent"></div>
    </div>

    <!-- Konten Hero -->
    <div class="max-w-7xl w-full relative z-10 mx-auto grid grid-cols-2 lg:grid-cols-5 items-center gap-x-6 px-4 sm:px-6 lg:px-8 pt-28 pb-12 lg:pt-24">

        <!-- Kolom Kiri: Text -->
        <div class="space-y-4 md:space-y-6 text-left col-span-2 sm:col-span-1 lg:col-span-2">
            <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs sm:text-sm font-semibold"
                 data-aos="fade-right" data-aos-duration="800" data-aos-delay="100" data-aos-easing="ease-out-cubic">
                {{ $displayData['subjudul'] }}
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black leading-tight text-white drop-shadow-lg"
                data-aos="fade-right" data-aos-duration="900" data-aos-delay="200" data-aos-easing="ease-out-cubic">
                {{ $displayData['judul'] }}
            </h1>

            <p class="text-sm sm:text-base lg:text-lg text-slate-200 max-w-lg"
               data-aos="fade-right" data-aos-duration="800" data-aos-delay="300" data-aos-easing="ease-out-cubic">
                {{ $displayData['deskripsi'] }}
            </p>

            <a href="{{ $displayData['tombol_link'] }}"
               class="inline-block rounded-lg bg-white px-6 py-2 sm:px-8 sm:py-3 text-sm sm:text-base font-bold text-sky-800 shadow-xl hover:bg-slate-100 hover:-translate-y-1 transition-all duration-300 ease-in-out"
               data-aos="fade-right" data-aos-duration="800" data-aos-delay="400" data-aos-easing="ease-out-cubic">
                {{ $displayData['tombol_teks'] }}
            </a>
        </div>

        <!-- Kolom Kanan: Visual -->
        <div class="relative w-full flex justify-center items-end col-span-2 sm:col-span-1 lg:col-span-3 h-[50vh] sm:h-[60vh] lg:h-[80vh]"
             data-aos="fade-left" data-aos-duration="1000" data-aos-delay="600" data-aos-easing="ease-out-cubic">
            <img src="{{ $displayData['gambar'] }}" alt="Hero Image"
                 class="absolute bottom-0 h-[85%] lg:h-[95%] lg:translate-x-9 w-auto object-contain z-10">
        </div>

    </div>

    <!-- Gradasi bawah -->
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-gray-100 to-transparent z-20"></div>
</section>
