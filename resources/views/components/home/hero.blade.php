<section id="hero" class="relative min-h-screen bg-white flex items-center overflow-x-hidden">
    <!-- 1. Wave shape (background dekoratif) -->
    <img src="{{ asset('assets/home/wave.png') }}"
         alt=""
         class="absolute top-0 right-0 w-5/6 max-w-6xl object-cover z-10 pointer-events-none" />

    <div class="max-w-7xl w-full relative z-20 mx-auto flex flex-col-reverse items-center gap-y-8 px-4 sm:px-6 md:px-8 pt-16 pb-40 lg:flex-row lg:gap-x-16 lg:pl-12 xl:pl-24">
        <!-- Kolom Kiri: Text -->
        <div class="w-full space-y-5 text-left lg:w-5/12 lg:text-left"
             data-aos="fade-right"
             data-aos-delay="300"
             data-aos-duration="900">

            {{-- Baris kecil dengan globe icon --}}
            <div class="flex items-left justify-left lg:justify-start gap-x-2">
                <p class="font-semibold uppercase tracking-wider text-sky-800">
                    {{ $hero->subjudul ?? 'Sekolah Menengah Unggulan di Sangatta Utara' }}
                </p>
            </div>

            <h1 class="text-4xl font-black leading-tight text-gray-900 lg:text-5xl xl:text-6xl font-heading">
                {{ $hero->judul ?? 'Belajar, berprestasi, dan raih ilmu untuk masa depan' }}
            </h1>

            <p class="text-base text-slate-600 md:text-lg">
                {{ $hero->deskripsi ?? 'Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa semangat mendalami ilmu—gerbang sekolah adalah awal perjalananmu.' }}
            </p>

            <a href="{{ $hero->tombol_link ?? '#' }}"
               class="inline-block rounded-full bg-white px-8 py-4 text-base font-bold text-[var(--color-brand-dark)] shadow-xl smooth-hover-lift hover:bg-gray-100"
               data-aos="zoom-in"
               data-aos-delay="400"
               data-aos-duration="800">
                {{ $hero->tombol_teks ?? 'Daftar PPDB' }}
            </a>
        </div>

        <!-- Kolom Kanan: Gambar + floating elements -->
        <div class="w-full relative flex justify-center items-center lg:w-7/12">
            {{-- Gambar utama dari CMS --}}
            @if ($hero?->gambar)
                <img src="{{ asset('storage/' . $hero->gambar) }}"
                     alt="Gambar Hero"
                     class="w-full max-w-xs sm:max-w-md lg:max-w-lg xl:max-w-xl object-cover" />
            @else
                <img src="{{ asset('assets/home/hero.png') }}"
                     alt="Siswa SMP 5 Sangatta Utara"
                     class="w-full max-w-xs sm:max-w-md lg:max-w-lg xl:max-w-xl object-cover" />
            @endif

            {{-- Floating globe --}}
            <img src="{{ asset('assets/home/globe (2).png') }}"
                 alt="Decorative Globe"
                 class="hidden md:block absolute bottom-155 right-125 w-70 h-70 drop-shadow-lg animate-float-slow rotate-[340deg]" />

            {{-- Floating graduation cap --}}
            <img src="{{ asset('assets/home/globe (1).png') }}"
                 alt="Decorative Graduation"
                 class="hidden md:block absolute bottom-60 left-125 w-70 h-60 drop-shadow-lg animate-float-slow rotate-[30deg]" />
        </div>
    </div>

    <!-- Efek Gradasi / Blur di bawah -->
    <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-slate-50 to-transparent pointer-events-none"></div>
</section>
