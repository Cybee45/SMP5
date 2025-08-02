{{-- Hero Section untuk Halaman SPMB --}}
<section id="hero-spmb" class="relative bg-white overflow-hidden">
  
  {{-- Latar belakang dekoratif (lingkaran biru) --}}
  <img src="{{ asset('assets/spmb/hero.png') }}"
       alt="Decorative background"
       class="absolute top-[50%] left-170 transform -translate-y-1/2 w-full lg:w-4/6 max-w-full h-auto object-contain z-10 pointer-events-none" />

  <div class="relative z-20 container mx-auto px-4 sm:px-6 py-16 lg:py-24">
    <div class="flex flex-col lg:flex-row items-center gap-y-12 lg:gap-x-8">

      {{-- Kolom Kiri: Teks --}}
      <div class="w-full lg:w-1/2 text-center lg:text-left lg:pl-16">
        <div data-aos="fade-right" data-aos-delay="100">
          <p class="font-semibold uppercase tracking-wider text-sky-800">
            Sekolah Menengah Unggulan di Sangatta Utara
          </p>
          <h1 class="mt-4 text-4xl md:text-5xl lg:text-6xl font-black leading-tight text-gray-900 font-heading">
            SPMB Dimulai! <br class="hidden md:block"> Saatnya Wujudkan Masa Depan.
          </h1>
          <p class="mt-6 text-base md:text-lg text-slate-600 max-w-xl mx-auto lg:mx-0">
            Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa bersemangat mendalami ilmu. Gerbang sekolah adalah awal dari perjalananmu.
          </p>
        </div>
      </div>

      {{-- Kolom Kanan: Gambar Utama dan Elemen Dekoratif --}}
      <div class="w-full lg:w-1/2 relative flex justify-center items-center h-96 lg:h-auto">
        
        {{-- Gambar utama siswi --}}
        <img src="{{ asset('assets/spmb/SPMB.png') }}"
             alt="Siswa pendaftaran SPMB"
             class="relative z-20 h-full lg:h-[50rem] xl:h-[55rem] w-auto object-contain"/>

        {{-- Dekorasi Tas (kiri atas) --}}
        <img src="{{ asset('assets/spmb/back.png') }}"
             alt="Dekorasi tas sekolah"
             class="hidden md:block absolute z-30 top-10 left-1/2 -translate-x-[150%] lg:left-10 lg:-translate-x-0 w-50 lg:w-50 h-auto animate-float-slow"
             data-aos="zoom-in" data-aos-delay="300" />
    
      </div>
    </div>
  </div>
</section>
