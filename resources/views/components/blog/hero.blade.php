{{-- resources/views/blog.blade.php --}}
<section id="hero-blog" class="relative bg-white overflow-hidden">
  {{-- 1. Wave background --}}
  <img src="{{ asset('assets/blog/wave.png') }}"
       alt="Wave background"
       class="absolute top-0 right-0
              w-full sm:w-3/4 md:w-2/3 lg:w-1/2
              max-w-none h-auto object-cover z-10 pointer-events-none" />

  {{-- 2. Content wrapper --}}
  <div class="relative z-20 mx-auto max-w-7xl
              px-4 sm:px-6 md:px-8
              pt-14 pb-16
              lg:pt-16 lg:pb-24
              lg:pl-20 xl:pl-32">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-y-9 lg:gap-x-16">
      
      {{-- Left column: text --}}
      <div class="w-full lg:w-5/12 space-y-5 text-left relative
                  mt-6 sm:mt-10 lg:-mt-32"
           data-aos="fade-right" data-aos-delay="300" data-aos-duration="900">
        <p class="text-sm font-semibold uppercase tracking-wide text-sky-800">
          Blog Resmi SMP Negeri 5
        </p>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black leading-tight text-gray-900">
          Selamat datang di Blog Kami
        </h1>
        <p class="text-base md:text-lg text-slate-600">
          Temukan cerita inspiratif, tips belajar, dan kabar terbaru seputar kegiatan sekolah di sini.
        </p>
      </div>

      {{-- Right column: image + decorations --}}
      <div class="w-full lg:w-7/12 relative flex justify-center lg:justify-end
                  mb-6 sm:mb-8 lg:mb-0 overflow-visible">
        {{-- Figure anchor: menjaga komposisi & skala dekorasi --}}
        <figure class="relative inline-block isolate"
                style="--decorMin:90px; --decorMax:260px;">
          
          {{-- Main hero image --}}
          <img src="{{ asset('assets/blog/hero.png') }}"
               alt="Ilustrasi Blog SMP"
               class="block h-auto object-contain select-none relative z-10
                      w-[min(75vw,560px)] sm:w-[min(65vw,640px)] lg:w-[580px] xl:w-[620px]
                      lg:translate-x-4" />

          {{-- Decorative light (tampil di mobile, proporsional via clamp) --}}
          <img src="{{ asset('assets/blog/light.png') }}"
               alt="Decorative Light"
               aria-hidden="true"
               class="absolute z-20 pointer-events-none select-none drop-shadow-lg animate-float-slow rotate-[15deg]
                      top-[22%] right-[68%]
                      w-[clamp(var(--decorMin),24vw,var(--decorMax))]" />
        </figure>
      </div>
    </div>
  </div>

  {{-- 3. Bottom gradient --}}
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full
              bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
</section>
