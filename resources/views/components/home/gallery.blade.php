<section class="relative py-20 lg:py-24 bg-slate-50 overflow-hidden">
  
  <!-- Efek Gradasi / Blur di Bagian Atas -->
  <!-- Transisi dari section 'Profil' (bg-white) -->
  <div class="absolute top-0 left-0 z-20 h-32 w-full bg-gradient-to-b from-white to-transparent"></div>

  <div class="container relative z-10 mx-auto px-6 md:px-8">
    
    <!-- Judul Section -->
    <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">
            Galeri Sekolah & Prestasi
        </h2>
        <p class="mt-4 text-base md:text-lg text-slate-600">
            Momen-momen berharga dan pencapaian gemilang yang menjadi bagian dari perjalanan kami.
        </p>
    </div>

    <!-- Kontainer untuk marquee -->
    <div class="scroller" data-speed="slow">
      <div class="scroller__inner">
          
          @php
              // Data galeri
              $galleryItems = [
                  // Contoh gambar lokal (letakkan file di public/assets/home/namafile.jpg)
                  ['img' => asset('assets/galery/smp_5-11.jpg'), 'title' => 'Juara 1 LKS Tingkat Kota', 'desc' => 'Kompetensi Siswa 2024'],
                  ['img' => asset('assets/galery/smp_5-12.jpg'), 'title' => 'Pentas Seni Tahunan', 'desc' => 'Ekspresi Bakat Siswa'],
                  ['img' => asset('assets/galery/smp_5-15.jpg'), 'title' => 'Studi Banding ke Jakarta', 'desc' => 'Wawasan Industri 4.0'],
                  ['img' => asset('assets/galery/smp_5-40.jpg'), 'title' => 'Medali Emas Olimpiade', 'desc' => 'Olimpiade Sains Nasional'],
                  ['img' => asset('assets/galery/smp_5-10.jpg'), 'title' => 'Perkemahan Akbar', 'desc' => 'Pramuka Penggalang'],
                  ['img' => asset('assets/galery/smp_5-38.jpg'), 'title' => 'Final Cerdas Cermat', 'desc' => 'Tingkat Provinsi'],
              ];
              // Duplikasi data
              $galleryItems = array_merge($galleryItems, $galleryItems);
          @endphp

          {{-- Loop galeri --}}
          @foreach($galleryItems as $item)
              <div class="flex-shrink-0 w-80a bg-white rounded-xl shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                  <div class="h-48 overflow-hidden">
                      <img src="{{ $item['img'] }}"
                           alt="{{ $item['title'] }}"
                           class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
                  </div>
                  <div class="p-5">
                      <p class="font-bold text-gray-900 text-lg truncate">{{ $item['title'] }}</p>
                      <span class="text-sm text-slate-500">{{ $item['desc'] }}</span>
                  </div>
              </div>
          @endforeach

      </div>
    </div>
  </div>

  <!-- 
    PERBAIKAN: Efek Gradasi / Blur di Bagian Bawah
    - Transisi ke section 'Berita' (asumsi bg-white).
  -->
  <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-white to-transparent"></div>
</section>