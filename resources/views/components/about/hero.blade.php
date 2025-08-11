<section id="hero" class="relative bg-white overflow-hidden" style="--blend:#ffffff;">
  {{-- Wave background --}}
  <img src="{{ asset('assets/about/wave.png') }}"
       alt="Wave background"
       class="absolute top-0 left-0 w-full sm:w-2/4 max-w-full h-auto object-cover z-10 pointer-events-none" />

  <!-- Container with extra bottom spacing to prevent gradient overlap on mobile -->
  <div class="relative z-20 mx-auto max-w-7xl px-4 sm:px-6 md:px-8 pt-20 pb-32 sm:pb-28 lg:pb-24 lg:pt-16 lg:pl-20 xl:pl-32">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-y-12 sm:gap-y-16 lg:gap-x-19">

      {{-- Text Container with adjusted mobile positioning --}}
      <div class="w-full lg:w-5/12 space-y-5 text-left relative -mt-8 sm:-mt-4 lg:-mt-32"
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

      {{-- Kolom Gambar (FIX POSISI & PROPORSI) --}}
      <div class="w-full lg:w-7/12 relative flex justify-center items-center">
        <!-- Wrapper kecil yang menjadi jangkar posisi relatif terhadap ukuran hero -->
  <figure class="relative inline-block isolate"
    style="--decorMin:100px; --decorMax:300px;">
          {{-- Main student image with reduced size --}}
          <img src="{{ asset('assets/about/hero.png') }}"
               alt="Siswa SMP 5 Sangatta Utara"
     class="block h-auto object-contain select-none
       w-[min(68vw,520px)] sm:w-[min(58vw,580px)] lg:w-[540px] xl:w-[580px]" />

          {{-- Decorative globe: kiri-bawah hero (SELALU tampil, skala responsif) --}}
          <img src="{{ asset('assets/about/globe.png') }}"
               alt="Globe decoration" aria-hidden="true"
     class="absolute z-20 pointer-events-none select-none drop-shadow-lg animate-float-slow rotate-[340deg]
       bottom-[10%] right-[63%]
       w-[clamp(var(--decorMin),20vw,var(--decorMax))]" />

          {{-- Decorative light: kanan-tengah hero (SELALU tampil, skala responsif) --}}
          <img src="{{ asset('assets/about/light.png') }}"
               alt="Lightbulb decoration" aria-hidden="true"
     class="absolute z-20 pointer-events-none select-none drop-shadow-lg animate-float-slow
       top-[30%] left-[63%]
       w-[clamp(var(--decorMin),24vw,var(--decorMax))]" />
        </figure>
      </div>

    </div>
  </div>

  {{-- Bottom gradient: stronger, smoother, and color-customizable --}}
  <div class="pointer-events-none absolute inset-x-0 bottom-0 z-20 h-24 sm:h-28 lg:h-32 
              bg-gradient-to-t from-[var(--blend)] via-white/70 to-transparent 
              backdrop-blur-[2px]"></div>
  <div class="pointer-events-none absolute inset-x-0 bottom-0 z-20 h-2 bg-[var(--blend)]"></div>
</section>
