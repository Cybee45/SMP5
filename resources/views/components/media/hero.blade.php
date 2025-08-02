{{-- resources/views/media.blade.php --}}
<section id="hero" class="relative bg-white overflow-hidden">
  {{-- 1. Wave background: diperbesar dan dipindah ke pojok kanan atas --}}
  <img src="{{ asset('assets/media/wave.png') }}"
       alt="Wave background"
       class="absolute top-0 right-0
              w-[180%] sm:w-[120%] md:w-[110%] lg:w-[90%]
              max-w-none h-auto object-cover z-10 pointer-events-none" />

  {{-- 2. Content wrapper --}}
  <div class="relative z-20 mx-auto max-w-7xl
              px-4 sm:px-6 md:px-8
              pt-8 pb-16
              lg:pt-16 lg:pb-24
              lg:pl-20 xl:pl-32">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-y-9 lg:gap-x-16">

      {{-- Text Container --}}
      <div class="w-full lg:w-5/12 space-y-5 text-left relative
                  -mt-16 sm:-mt-20 lg:-mt-32"
           data-aos="fade-right"
           data-aos-delay="300"
           data-aos-duration="900">
        <p class="text-sm font-semibold uppercase tracking-wide text-sky-800">
          Sekolah Menengah Unggulan di Sangatta Utara
        </p>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black leading-tight text-gray-900">
          Kami hadirkan aktivitas dan momen kampus dalam foto, video, dan tulisan.
        </h1>
        <p class="text-base md:text-lg text-slate-600">
          Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa bersemangat mendalami ilmu. Gerbang sekolah adalah awal perjalananmu.
        </p>
      </div>

      {{-- Image Container --}}
      <div class="w-full lg:w-7/12 relative flex justify-center lg:justify-end">
        {{-- Main hero image --}}
        <img src="{{ asset('assets/media/hero.png') }}"
             alt="Siswa SMP 5 Sangatta Utara"
             class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl h-auto object-contain transform lg:translate-x-4" />

        {{-- Decorative tas --}}
        <img src="{{ asset('assets/media/tas.png') }}"
             alt="Tas decoration"
             class="hidden lg:block absolute top-[20%] left-120
                    w-50 h-50 sm:w-65 sm:h-65 drop-shadow-lg animate-float" />

        {{-- Decorative globe --}}
        <img src="{{ asset('assets/media/globe.png') }}"
             alt="Globe decoration"
             class="hidden lg:block absolute bottom-10 right-70
                    w-50 h-50 sm:w-100 sm:h-100 drop-shadow-lg animate-float-slow rotate-[330deg]" />
      </div>
    </div>
  </div>

  {{-- Bottom gradient --}}
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
</section>
