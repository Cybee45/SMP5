@php
    $aboutHero = \App\Models\AboutHero::where('aktif', true)->first();
@endphp

<section id="hero-about" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Latar Belakang Gambar Sekolah -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/about/gedung.jpg') }}" alt="Latar Belakang Gedung Sekolah" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-sky-900/70 via-sky-800/50 to-transparent"></div>
    </div>

    <!-- Konten Hero (Padding bawah ditambahkan) -->
    <div class="max-w-7xl w-full relative z-10 mx-auto grid grid-cols-2 lg:grid-cols-5 items-center gap-x-4 lg:gap-x-8 px-4 sm:px-6 lg:px-8 pt-28 pb-24 lg:pt-24 lg:pb-24">
        
        <!-- Kolom Kiri: Teks -->
        <div class="space-y-4 md:space-y-6 text-left col-span-2 sm:col-span-1 lg:col-span-2">
            <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs sm:text-sm font-semibold"
                 data-aos="fade-right" data-aos-duration="800" data-aos-delay="100" data-aos-easing="ease-out-cubic">
                {{ $aboutHero->subjudul ?? 'Sekolah Menengah Unggulan' }}
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black leading-tight text-white drop-shadow-lg"
                data-aos="fade-right" data-aos-duration="900" data-aos-delay="200" data-aos-easing="ease-out-cubic">
                {{ $aboutHero->judul ?? 'Gali ilmu, ukir prestasi.' }}
            </h1>

            <p class="text-sm sm:text-base lg:text-lg text-slate-200 max-w-lg"
               data-aos="fade-right" data-aos-duration="800" data-aos-delay="300" data-aos-easing="ease-out-cubic">
                {{ $aboutHero->deskripsi ?? 'Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa bersemangat mendalami ilmu.' }}
            </p>
        </div>

        <!-- Kolom Kanan: Visual -->
        <div class="relative w-full flex justify-center items-end col-span-2 sm:col-span-1 lg:col-span-3 h-[50vh] sm:h-[60vh] lg:h-[80vh]"
             data-aos="fade-left" data-aos-duration="1000" data-aos-delay="450" data-aos-easing="ease-out-cubic">
            @if($aboutHero?->gambar)
                <img src="{{ asset('storage/' . $aboutHero->gambar) }}"
                     alt="Hero About Image"
                     class="absolute bottom-0 h-[90%] lg:h-[105%] w-auto object-contain z-10" />
            @else
                <img src="{{ asset('assets/about/hero.png') }}"
                     alt="Siswa SMP 5 Sangatta Utara"
                     class="absolute bottom-0 h-[90%] lg:h-[105%] w-auto object-contain z-10" />
            @endif
        </div>

    </div>

    <!-- Gradasi Bawah untuk Transisi Mulus -->
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-slate-100 to-transparent z-20"></div>
</section>
