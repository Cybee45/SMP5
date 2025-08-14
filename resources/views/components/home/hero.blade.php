@php
    $hero = \App\Models\Hero::where('aktif', true)->first();
@endphp

<section id="hero" class="relative min-h-screen bg-white flex items-center overflow-hidden pt-20 sm:pt-24 md:pt-0">
  <!-- Wave (dekoratif background) -->
  <img src="{{ asset('assets/home/wave.png') }}" alt="" class="absolute top-0 right-0 w-[85%] max-w-[1200px] object-cover z-10 pointer-events-none" />

  <div class="max-w-[88rem] w-full relative z-20 mx-auto flex flex-col-reverse items-center gap-y-4 sm:gap-y-6 md:gap-y-8 px-4 sm:px-6 md:px-8 pt-24 lg:pt-28 pb-24 lg:flex-row lg:gap-x-16 lg:pl-12 xl:pl-24">
    <!-- Kolom kiri: teks -->
    <div class="w-full space-y-5 text-left lg:w-5/12 mt-4 lg:mt-0" data-aos="fade-right" data-aos-delay="300" data-aos-duration="900">
      <div class="flex items-start gap-x-2">
        <p class="font-semibold uppercase tracking-wider text-sky-800">Sekolah Menengah Unggulan di Sangatta Utara</p>
      </div>
      <h1 class="text-4xl lg:text-5xl xl:text-6xl font-black leading-tight text-gray-900 font-heading">
        {{ $hero->judul ?? 'Belajar, berprestasi, dan raih ilmu untuk masa depan' }}
      </h1>
      <p class="text-base md:text-lg text-slate-600 max-w-[48rem]">
        {{ $hero->deskripsi ?? 'Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa semangat mendalami ilmu—gerbang sekolah adalah awal perjalananmu.' }}
      </p>
      <a href="{{ $hero->tombol_link ?? '/spmb' }}" class="inline-block rounded-full bg-white px-8 py-4 text-base font-bold text-[var(--color-brand-dark)] shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-500 ease-in-out">
        {{ $hero->tombol_teks ?? 'Cek SPMB' }}
      </a>
    </div>

    <!-- Kolom kanan: KANVAS visual -->
    <div class="w-full lg:w-7/12 flex justify-center lg:justify-end">
      <div class="relative isolate w-full max-w-[420px] sm:max-w-[520px] md:max-w-[720px] lg:max-w-[960px] xl:max-w-[1080px] aspect-[1/1]">
        <!-- Parent komposisi: semua elemen di-scale bersama -->
        <div class="absolute inset-0">
          <!-- Karakter utama -->
          @if ($hero?->gambar)
            <img src="{{ asset('storage/' . $hero->gambar) }}" alt="Hero Image" class="absolute z-30 left-1/2 -translate-x-1/2 bottom-0 w-[72%] h-auto object-contain" />
          @else
            <img src="{{ asset('assets/home/hero.png') }}" alt="Siswa SMP 5 Sangatta Utara" class="absolute z-30 left-1/2 -translate-x-1/2 bottom-0 w-[72%] h-auto object-contain" />
          @endif

          <!-- Globe kiri-atas -->
          <img src="{{ asset('assets/home/globe (1).png') }}" alt="Decorative Graduation" class="block absolute z-20 left-[-8%] bottom-[65%] w-[32%] sm:left-[-12%] sm:bottom-[62%] sm:w-[38%] md:left-[-22%] md:bottom-[59%] md:w-[56%] h-auto drop-shadow-xl animate-float-slow rotate-[350deg]" />

          <!-- Globe kanan-bawah -->
          <img src="{{ asset('assets/home/globe (2).png') }}" alt="Decorative Globe" class="block absolute z-20 right-[-8%] bottom-[12%] w-[30%] sm:right-[-12%] sm:bottom-[15%] sm:w-[36%] md:right-[-15%] md:bottom-[15%] md:w-[50%] h-auto drop-shadow-xl animate-float-slow rotate-[20deg]" />
        </div>
      </div>
    </div>
  </div>

  <!-- Fade/gradien bawah -->
  <div class="absolute bottom-0 left-0 z-20 h-28 md:h-36 lg:h-40 w-full bg-gradient-to-t from-slate-100 to-transparent pointer-events-none"></div>
</section>
