@php
    // Ambil data hero dari database
    $mediaHero = \App\Models\MediaHero::active()->first();
    
    // Data fallback jika belum ada di database
    $heroData = $mediaHero ? [
        'subjudul' => $mediaHero->subjudul ?? 'Sekolah Menengah Unggulan di Sangatta Utara',
        'judul_utama' => $mediaHero->judul_utama,
        'deskripsi' => $mediaHero->deskripsi,
        'gambar_hero' => $mediaHero->gambar_hero_url,
        'gambar_globe' => $mediaHero->gambar_globe_url,
        'gambar_wave' => $mediaHero->gambar_wave_url,
    ] : [
        'subjudul' => 'Sekolah Menengah Unggulan di Sangatta Utara',
        'judul_utama' => 'Kami hadirkan aktivitas dan momen kampus dalam foto, video, dan tulisan.',
        'deskripsi' => 'Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa bersemangat mendalami ilmu. Gerbang sekolah adalah awal perjalananmu.',
        'gambar_hero' => asset('assets/media/hero.png'),
        'gambar_globe' => asset('assets/media/globe.png'),
        'gambar_wave' => asset('assets/media/wave.png'),
    ];
@endphp

{{-- resources/views/media.blade.php --}}
<section id="hero" class="relative bg-white overflow-hidden">
  {{-- 1) Wave background --}}
  <img src="{{ $heroData['gambar_wave'] }}"
       alt="Wave background"
       class="absolute top-0 right-0
              w-[180%] sm:w-[120%] md:w-[110%] lg:w-[90%]
              max-w-none h-auto object-cover z-10 pointer-events-none" />

  {{-- 2) Content wrapper --}}
  <div class="relative z-20 mx-auto max-w-7xl
              px-4 sm:px-6 md:px-8
              pt-14 pb-16
              lg:pt-16 lg:pb-24
              lg:pl-20 xl:pl-32">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-y-9 lg:gap-x-16">

      {{-- Text Container (tetap) --}}
      <div class="w-full lg:w-5/12 space-y-5 text-left relative
                  mt-6 sm:mt-10 lg:-mt-32"
           data-aos="fade-right" data-aos-delay="300" data-aos-duration="900">
        <p class="text-sm font-semibold uppercase tracking-wide text-sky-800">
          {{ $heroData['subjudul'] }}
        </p>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black leading-tight text-gray-900">
          {{ $heroData['judul_utama'] }}
        </h1>
        <p class="text-base md:text-lg text-slate-600">
          {{ $heroData['deskripsi'] }}
        </p>
      </div>

      {{-- Image Container (figure + clamp, komposisi stabil) --}}
      <div class="w-full lg:w-7/12 relative flex justify-center lg:justify-end mb-6 sm:mb-8 lg:mb-0 overflow-visible">
        <!-- Kanvas komposisi. Variabel untuk skala dekorasi -->
        <figure class="relative inline-block isolate max-w-full"
                style="--decorMinG:135px; --decorMaxG:340px; --decorMinT:110px; --decorMaxT:280px;">

          {{-- Hero (anchor ukuran) --}}
          <img src="{{ $heroData['gambar_hero'] }}"
               alt="Siswa SMP 5 Sangatta Utara"
               class="block h-auto object-contain select-none relative z-10
                      w-[min(82vw,620px)] sm:w-[min(68vw,640px)] lg:w-[580px] xl:w-[620px]
                      lg:translate-x-4" />

          {{-- Globe (kiri–bawah) | dibuat lebih besar & responsif --}}
    <img src="{{ $heroData['gambar_globe'] }}"
      alt="Globe decoration" aria-hidden="true"
      class="absolute z-20 pointer-events-none select-none drop-shadow-lg animate-float-slow rotate-[330deg]
          bottom-[14%] right-[52%]
          sm:bottom-[13%] sm:right-[50%]
          md:bottom-[12%] md:right-[48%]
          lg:bottom-[11%] lg:right-[46%]
          w-[clamp(var(--decorMinG),28vw,var(--decorMaxG))] lg:w-[min(56vw,680px)]" />
        </figure>
      </div>
    </div>
  </div>

  {{-- Bottom gradient --}}
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
</section>
