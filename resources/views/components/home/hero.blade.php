<section id="hero"
         class="relative min-h-screen bg-white flex items-center overflow-x-hidden">
  <!-- 1. Wave shape (background dekoratif) -->
  <img src="{{ asset('assets/home/wave.png') }}"
       alt=""
       class="absolute top-0 right-0 w-5/6 max-w-6xl object-cover z-10 pointer-events-none" />

  <!-- PENYESUAIAN: Menambahkan padding-bottom (pb-40) untuk memberi ruang di bawah pada tampilan mobile -->
  <div class="max-w-7xl w-full relative z-20 mx-auto
              flex flex-col-reverse items-center gap-y-8
              px-4 sm:px-6 md:px-8 pt-16 pb-40
              lg:flex-row lg:gap-x-16 lg:pl-12 xl:pl-24">

    <!-- Kolom Kiri: Text -->
    <div class="w-full space-y-5 text-left lg:w-5/12"
         data-aos="fade-right"
         data-aos-delay="300"
         data-aos-duration="900">

      {{-- Baris kecil dengan globe icon --}}
      <div class="flex items-start justify-start lg:justify-start gap-x-2">
        <p class="font-semibold uppercase tracking-wider text-sky-800">
          Sekolah Menengah Unggulan di Sangatta Utara
        </p>
      </div>

      <h1 class="text-4xl font-black leading-tight text-gray-900
                 lg:text-5xl xl:text-6xl font-heading">
        Belajar, berprestasi, dan raih ilmu untuk masa depan
      </h1>
      <p class="text-base text-slate-600 md:text-lg">
        Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa semangat mendalami ilmu—gerbang sekolah adalah awal perjalananmu.
      </p>

      <!-- PENYESUAIAN: Menerapkan kelas smooth hover lift -->
      <a href="#"
         class="inline-block rounded-full bg-white px-8 py-4 text-base font-bold text-[var(--color-brand-dark)]
                shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-500 ease-in-out">
        Daftar PPDB
      </a>
    </div>

    <!-- Kolom Kanan: Gambar + floating elements -->
    <div class="w-full relative flex justify-center items-center lg:w-7/12">
      {{-- Gambar utama --}}
      <img src="{{ asset('assets/home/hero.png') }}"
           alt="Siswa SMP 5 Sangatta Utara"
           class="w-full max-w-xs sm:max-w-md lg:max-w-lg xl:max-w-xl object-cover" />

      {{-- Floating globe --}}
      <img src="{{ asset('assets/home/globe (2).png') }}"
           alt="Decorative Globe"
           class="hidden md:block absolute bottom-[155px] right-[125px]
                  w-[70px] h-[70px] drop-shadow-lg animate-float-slow rotate-[340deg]" />

      {{-- Floating graduation cap ilustration --}}
      <img src="{{ asset('assets/home/globe (1).png') }}"
           alt="Decorative Graduation"
           class="hidden md:block absolute bottom-[60px] left-[125px]
                  w-[70px] h-[60px] drop-shadow-lg animate-float-slow rotate-[30deg]" />
    </div>
  </div>

  <!-- Efek Gradasi / Blur di bawah -->
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full
              bg-gradient-to-t from-slate-100 to-transparent pointer-events-none">
  </div>
</section>
