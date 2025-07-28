<section class="py-20 lg:py-24 bg-slate-50 overflow-hidden">
  <div class="container mx-auto px-6 md:px-8">
    
    <!-- Judul Section -->
    <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">
            Galeri Sekolah & Prestasi
        </h2>
        <p class="mt-4 text-base md:text-lg text-slate-600">
            Momen-momen berharga dan pencapaian gemilang yang menjadi bagian dari perjalanan kami.
        </p>
    </div>

    <!--
      Kontainer untuk marquee
      - Dipindahkan ke dalam .container agar lebarnya terbatas dan tidak menyebabkan scroll.
    -->
    <div class="scroller" data-speed="slow">
      <div class="scroller__inner">
          
          @php
              // Definisikan data galeri di sini untuk kemudahan duplikasi
              $galleryItems = [
                  ['img' => 'https://placehold.co/400x300/0ea5e9/ffffff?text=Juara+1+LKS', 'title' => 'Juara 1 LKS Tingkat Kota', 'desc' => 'Kompetensi Siswa 2024'],
                  ['img' => 'https://placehold.co/400x300/8b5cf6/ffffff?text=Pentas+Seni', 'title' => 'Pentas Seni Tahunan', 'desc' => 'Ekspresi Bakat Siswa'],
                  ['img' => 'https://placehold.co/400x300/10b981/ffffff?text=Studi+Banding', 'title' => 'Studi Banding ke Jakarta', 'desc' => 'Wawasan Industri 4.0'],
                  ['img' => 'https://placehold.co/400x300/f97316/ffffff?text=Olimpiade+Sains', 'title' => 'Medali Emas Olimpiade', 'desc' => 'Olimpiade Sains Nasional'],
                  
              ];
              // Duplikasi data untuk loop yang mulus
              $galleryItems = array_merge($galleryItems, $galleryItems);
          @endphp

          {{-- Loop melalui item galeri yang sudah diduplikasi --}}
          @foreach($galleryItems as $item)
              <div class="flex-shrink-0 w-80 bg-white rounded-xl shadow-lg overflow-hidden group">
                  <div class="h-48 overflow-hidden">
                      <img src="{{ $item['img'] }}"
                           alt="{{ $item['title'] }}"
                           class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
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
</section>