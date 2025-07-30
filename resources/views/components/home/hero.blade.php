<section id="hero" class="relative h-screen bg-white">
    <!-- 
      Konten Hero
      - z-index dinaikkan menjadi z-30 agar berada di atas gradasi.
    -->
    <div class="container relative z-30 mx-auto flex h-full flex-col-reverse items-center gap-y-8 px-6 pt-16 md:px-8 lg:flex-row lg:gap-x-16 lg:pl-12 xl:pl-50">

        <div class="w-full space-y-5 text-center lg:w-5/12 lg:text-left"
             data-aos="fade-right"
             data-aos-delay="300"
             data-aos-duration="900">
            <p class="font-semibold uppercase tracking-wider text-sky-800">
                Sekolah Menengah Unggulan di Sangatta Utara
            </p>
            <h1 class="text-4xl font-black leading-tight text-gray-900 lg:text-5xl xl:text-6xl font-heading">
                Belajar, berprestasi, dan raih ilmu untuk masa depan
            </h1>
            <p class="text-base text-slate-600 md:text-lg">
                Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa semangat mendalami ilmu—gerbang sekolah adalah awal perjalananmu.
            </p>
            <a href="#"
               class="inline-block rounded-full bg-white px-8 py-4 text-base font-bold text-[var(--color-brand-dark)] shadow-xl transition-transform duration-300 hover:scale-105 hover:bg-gray-100"
               data-aos="zoom-in"
               data-aos-delay="400"
               data-aos-duration="800"
            >
                Daftar PPDB
            </a>
        </div>

        <div class="w-full lg:w-7/12 flex justify-center">
            <img src="{{ asset('assets/home/hero.png') }}"
                 alt="Siswa SMP 5 Sangatta Utara"
                 class="w-full max-w-md object-cover" />
        </div>
    </div>

    <!-- 
      PERBAIKAN: Efek Gradasi / Blur
      - Ditempatkan di bagian bawah section dengan z-20.
      - `from-slate-50` adalah warna latar dari section berikutnya (Keunggulan).
    -->
    <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-slate-50 to-transparent"></div>
</section>
