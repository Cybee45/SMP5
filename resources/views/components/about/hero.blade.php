<section id="hero" class="relative bg-white overflow-hidden">
  {{-- Wave background --}}
  <img src="{{ asset('assets/about/wave.png') }}"
       alt="Wave background"
       class="absolute top-0 left-0 w-full sm:w-2/4 max-w-full h-auto object-cover z-10 pointer-events-none" />

  <!-- PENYESUAIAN: Menambahkan padding kiri (lg:pl-*) untuk menggeser konten ke kanan -->
  <div class="relative z-20 mx-auto max-w-7xl px-4 sm:px-6 md:px-8 pt-8 pb-16 lg:pt-16 lg:pb-24 lg:pl-20 xl:pl-32">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-y-9 lg:gap-x-19">

      {{-- Text Container (naik sedikit) --}}
      <div class="w-full lg:w-5/12 space-y-5 text-left relative
                   -mt-16 sm:-mt-20 lg:-mt-32"
           data-aos="fade-right"
           data-aos-delay="300"
           data-aos-duration="900">
        <p class="text-sm font-semibold uppercase tracking-wide text-sky-800">
          Sekolah Menengah Unggulan di Sangatta Utara
        </p>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black leading-tight text-gray-900">
          Gali ilmu, ukir prestasi, sambut masa depan gemilang.
        </h1>
        <p class="text-base md:text-lg text-slate-600">
          Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa bersemangat mendalami ilmu. Gerbang sekolah adalah awal perjalananmu.
        </p>
      </div>

      <div class="w-full lg:w-7/12 relative flex justify-center items-center">
        {{-- Main student image --}}
        <img src="{{ asset('assets/about/hero.png') }}"
             alt="Siswa SMP 5 Sangatta Utara"
             class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl h-auto object-contain" />

        {{-- Decorative lightbulb (desktop only) --}}
        <img src="{{ asset('assets/about/light.png') }}"
             alt="Lightbulb decoration"
             class="hidden lg:block absolute top-2/6 right-100 transform -translate-y-1/2
                     w-28 h-28 sm:w-32 sm:h-80 md:w-80 md:h-80
                     drop-shadow-lg animate-float-slow" />

        {{-- Decorative globe (desktop only) --}}
        <img src="{{ asset('assets/about/globe.png') }}"
             alt="Globe decoration"
             class="hidden lg:block absolute bottom-25 left-88
                     w-32 h-32 sm:w-36 sm:h-100 md:w-100 md:h-100
                     drop-shadow-lg animate-float-slow rotate-[15deg]" />
      </div>
    </div>
  </div>

  {{-- Bottom gradient --}}
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-white to-transparent"></div>
</section>