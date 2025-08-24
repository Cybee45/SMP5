@php
    // Ambil data galeri dari database CMS
    $mediaGaleris = \App\Models\MediaGaleri::active()->ordered()->take(6)->get();
    
    // Convert ke format yang dibutuhkan untuk tampilan
    $galleryItems = $mediaGaleris->map(function($galeri) {
        return [
            'img' => $galeri->gambar_url,
            'title' => $galeri->judul,
            'desc' => $galeri->deskripsi ?? ucfirst($galeri->kategori),
        ];
    });

    // Data fallback jika database kosong
    if ($galleryItems->isEmpty()) {
        $galleryItems = collect([
            ['img' => asset('assets/galery/smp_5-11.jpg'), 'title' => 'Juara 1 LKS Tingkat Kota', 'desc' => 'Kompetensi Siswa 2024'],
            ['img' => asset('assets/galery/smp_5-12.jpg'), 'title' => 'Pentas Seni Tahunan', 'desc' => 'Ekspresi Bakat Siswa'],
            ['img' => asset('assets/galery/smp_5-15.jpg'), 'title' => 'Studi Banding ke Jakarta', 'desc' => 'Wawasan Industri 4.0'],
            ['img' => asset('assets/galery/smp_5-40.jpg'), 'title' => 'Medali Emas Olimpiade', 'desc' => 'Olimpiade Sains Nasional'],
            ['img' => asset('assets/galery/smp_5-10.jpg'), 'title' => 'Perkemahan Akbar', 'desc' => 'Pramuka Penggalang'],
            ['img' => asset('assets/galery/smp_5-38.jpg'), 'title' => 'Final Cerdas Cermat', 'desc' => 'Tingkat Provinsi'],
        ]);
    }
    
    // Duplikasi data untuk efek marquee
    $galleryItems = $galleryItems->merge($galleryItems);
    
    // Variabel untuk tracking source data
    $isFromCMS = $mediaGaleris->count() > 0;
    $totalCMSItems = $mediaGaleris->count();

    // Lebar & Tinggi card fix (ubah kalau perlu: w-80=320px, h-96=384px)
    $cardW = 'w-80'; // <--- setel lebar di sini
    $cardH = 'h-96'; // <--- setel tinggi di sini
@endphp

{{-- [MODIFIED] Tambahkan x-data untuk state modal --}}
<section 
    x-data="{ 
        modalOpen: false, 
        modalImage: '', 
        modalTitle: '',
        modalDescription: '' 
    }" 
    @keydown.escape.window="modalOpen = false"
    class="relative py-20 lg:py-24 bg-slate-50 overflow-hidden">
  
  <!-- Gradasi Atas -->
  <div class="absolute top-0 left-0 z-20 h-32 w-full bg-gradient-to-b from-slate-50 to-transparent pointer-events-none"></div>

  <div class="container relative z-10 mx-auto px-6 md:px-8">
    
    <!-- Judul Section -->
    <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900"
            data-aos="fade-up" data-aos-duration="800" data-aos-delay="100" data-aos-easing="ease-out-cubic">
            Galeri Sekolah & Prestasi
        </h2>
        <p class="mt-4 text-base md:text-lg text-slate-600"
           data-aos="fade-up" data-aos-duration="800" data-aos-delay="200" data-aos-easing="ease-out-cubic">
            Momen-momen berharga dan pencapaian gemilang yang menjadi bagian dari perjalanan kami.
        </p>
    </div>

    <!-- Kontainer marquee -->
    <div class="scroller" data-speed="slow" 
         data-aos="fade-up" data-aos-duration="900" data-aos-delay="300" data-aos-easing="ease-out-cubic"
         style="
            -webkit-mask-image: 
                linear-gradient(to right, transparent, black 15%, black 85%, transparent),
                linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
            mask-image: 
                linear-gradient(to right, transparent, black 15%, black 85%, transparent),
                linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
            -webkit-mask-composite: source-in;
            mask-composite: intersect;
         ">
      <div class="scroller__inner">
          
          @forelse($galleryItems as $item)
              <!-- Card Galeri -->
              <div 
                  @click="
                    modalOpen = true; 
                    modalImage = '{{ $item['img'] }}'; 
                    modalTitle = '{{ addslashes($item['title']) }}';
                    modalDescription = '{{ addslashes($item['desc']) }}';
                  "
                  class="flex-shrink-0 {{ $cardW }} {{ $cardH }} bg-gray-200 rounded-xl shadow-lg overflow-hidden group cursor-pointer
                          transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
                  data-aos="zoom-in" data-aos-duration="800" data-aos-delay="400" data-aos-easing="ease-out-cubic">
                  
                  <img src="{{ $item['img'] }}"
                       alt="{{ $item['title'] }}"
                       onerror="this.onerror=null;this.src='{{ asset('assets/galery/smp_5-32.jpg') }}';"
                       class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110"
                       loading="lazy" decoding="async" draggable="false" />
              </div>
          @empty
              <div class="flex-shrink-0 {{ $cardW }} {{ $cardH }} bg-white rounded-xl shadow-lg overflow-hidden flex flex-col"
                   data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                  <div class="relative w-full h-2/3 bg-gradient-to-r from-sky-400 to-blue-500 flex items-center justify-center">
                      <div class="text-center text-white">
                          <i class="fas fa-camera text-3xl mb-2"></i>
                          <p class="text-sm">Belum ada galeri</p>
                      </div>
                  </div>
                  <div class="p-5 flex-grow">
                      <p class="font-bold text-gray-900 text-lg">Upload Foto</p>
                      <span class="text-sm text-slate-500">Melalui admin CMS</span>
                  </div>
              </div>
          @endforelse

      </div>
    </div>
  </div>

  <!-- Gradasi Bawah -->
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-slate-50 to-transparent pointer-events-none"></div>

  <!-- Modal -->
  <div x-show="modalOpen" 
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display: none;">

      <div @click="modalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

      <div x-show="modalOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 scale-90"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-90"
           class="relative bg-white w-full max-w-3xl rounded-xl shadow-2xl overflow-hidden flex flex-col">
          
          <button @click="modalOpen = false" class="absolute top-3 right-3 text-white bg-black/40 rounded-full p-1.5 hover:bg-black/60 transition-colors z-10">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>

          <div class="w-full bg-gray-900 flex-shrink-0 flex items-center justify-center">
            <img :src="modalImage" :alt="modalTitle" class="w-full max-h-[70vh] object-contain">
          </div>

          <div class="p-6 text-center">
              <h3 x-text="modalTitle" class="text-xl font-bold text-gray-900 mb-1"></h3>
              <p x-text="modalDescription" class="text-gray-600"></p>
          </div>
      </div>
  </div>
</section>
