<section class="relative bg-white overflow-hidden min-h-screen">
  <div class="container mx-auto max-w-7xl px-4 md:px-8 pt-16 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-10 lg:gap-16">

      {{-- Teks --}}
      <div class="order-2 lg:order-1 lg:col-span-6 2xl:col-span-7">
        <div class="max-w-[48rem]">
          <p class="font-semibold uppercase tracking-wider text-sky-800 mb-3"
             data-aos="fade-right" 
             data-aos-duration="800" 
             data-aos-delay="100"
             data-aos-easing="ease-out-cubic">
            SEKOLAH MENENGAH UNGGULAN DI SANGATTA UTARA
          </p>
          <h1 class="text-4xl md:text-5xl xl:text-7xl font-black leading-tight text-gray-900 font-heading"
              data-aos="fade-right" 
              data-aos-duration="900" 
              data-aos-delay="200"
              data-aos-easing="ease-out-cubic">
            Belajar, berprestasi,<br>dan raih ilmu untuk masa depan
          </h1>
          <p class="mt-5 text-lg md:text-xl text-slate-600"
             data-aos="fade-right" 
             data-aos-duration="800" 
             data-aos-delay="300"
             data-aos-easing="ease-out-cubic">
            Kita ciptakan lingkungan belajar yang patut diacungi jempol.
            Siswa semangat mendalami ilmu—gerbang sekolah adalah awal dari perjalananmu.
          </p>
        </div>
      </div>

      {{-- Visual --}}
      <div class="order-1 lg:order-2 lg:col-span-6 2xl:col-span-5 relative flex justify-center lg:justify-end items-center">

        {{-- Ornamen lingkaran --}}
        <img
          src="{{ asset('assets/spmb/hero.png') }}"
          alt="Ornamen Lingkaran"
          class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[420px] md:w-[560px] lg:w-[760px] xl:w-[880px] max-w-[94vw] h-auto z-10 pointer-events-none" />

        {{-- Back to School --}}
        <img
          src="{{ asset('assets/spmb/back.png') }}"
          alt="Back to School"
          class="absolute z-20 left-1/2 -translate-x-[150%] top-[8%] md:top-[6%] lg:top-[7%] w-[76px] md:w-[98px] lg:w-[116px] xl:w-[132px] transition-all duration-300" />

        {{-- Karakter --}}
        <img
      src="{{ asset('assets/spmb/SPMB.png') }}"
      alt="Karakter"
      class="relative z-30 w-[350px] md:w-[500px] lg:w-[700px] xl:w-[800px] h-auto object-contain" />

          </div>
        </div>
      </div>
  {{-- Gradasi ke bawah --}}
  <div class="absolute bottom-0 left-0 w-full h-24 md:h-32 lg:h-40 
              bg-gradient-to-b from-white/0 via-white/60 to-white 
              pointer-events-none">
  </div>
</section>
