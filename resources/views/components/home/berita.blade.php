<section class="bg-white py-20 lg:py-24 overflow-x-hidden">
  <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Judul Section -->
    <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">
            Berita & Informasi Terbaru
        </h2>
        <p class="mt-4 text-base md:text-lg text-slate-600">
            Ikuti terus perkembangan, pengumuman, dan cerita inspiratif dari lingkungan sekolah kami.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
      
      @php
          $beritaItems = [
              [
                  'img' => asset('assets/berita/smp_5-12.jpg'),
                  'kategori' => 'Prestasi',
                  'tanggal' => '26 Juli 2025',
                  'judul' => 'Siswa SMPN 5 Raih Medali Emas di Olimpiade Sains Nasional',
                  'kutipan' => 'Sebuah pencapaian luar biasa yang mengharumkan nama sekolah di tingkat nasional, membuktikan kualitas pendidikan yang kami berikan.'
              ],
              [
                  'img' => asset('assets/berita/smp_5-20.jpg')  ,
                  'kategori' => 'Pengumuman',
                  'tanggal' => '22 Juli 2025',
                  'judul' => 'Jadwal dan Alur Pendaftaran Peserta Didik Baru (PPDB) 2025',
                  'kutipan' => 'Simak informasi lengkap mengenai jadwal, syarat, dan tata cara pendaftaran.'
              ],
              [
                  'img' => asset('assets/berita/smp_5-15.jpg'),
                  'kategori' => 'Kegiatan',
                  'tanggal' => '18 Juli 2025',
                  'judul' => 'Kegiatan Studi Tur Edukatif ke Museum Nasional',
                  'kutipan' => 'Para siswa mendapatkan pengalaman belajar yang menyenangkan di luar kelas.'
              ],
          ];
      @endphp

      <!-- Kolom Kiri: Berita Utama (Featured) -->
      <article
        class="group flex flex-col overflow-hidden rounded-xl bg-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
        data-aos="fade-right"
        data-aos-delay="100"
        data-aos-duration="900"
      >
        @php $featured = $beritaItems[0]; @endphp
        <div class="h-56 sm:h-64 overflow-hidden">
          <img src="{{ $featured['img'] }}" alt="{{ $featured['judul'] }}" class="h-full w-full max-w-full object-cover transition-transform duration-500 group-hover:scale-110" />
        </div>
        <div class="flex flex-1 flex-col p-6 lg:p-8">
          <div class="flex-1">
            <div class="mb-3 flex items-center justify-between text-sm">
              <span class="rounded-full bg-sky-100 px-3 py-1 font-medium text-sky-700">{{ $featured['kategori'] }}</span>
              <span class="text-slate-500">{{ $featured['tanggal'] }}</span>
            </div>
            <h3 class="mb-3 text-2xl font-bold text-gray-900 transition-colors duration-300 group-hover:text-[var(--color-brand)]">
              <a href="#">{{ $featured['judul'] }}</a>
            </h3>
            <p class="text-slate-600 leading-relaxed">{{ $featured['kutipan'] }}</p>
          </div>
          <a href="#" class="mt-6 inline-flex items-center gap-x-2 font-semibold text-[var(--color-brand)]">
            Baca Selengkapnya
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </article>

      <!-- Kolom Kanan: Dua Berita Sekunder -->
      <div class="flex flex-col gap-8">
        @foreach(array_slice($beritaItems, 1) as $i => $item)
          <article
            class="group flex flex-1 flex-col sm:flex-row overflow-hidden rounded-xl bg-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1"
            data-aos="fade-left"
            data-aos-delay="{{ 200 + ($i * 150) }}"
            data-aos-duration="900"
          >
            <div class="w-full sm:w-2/5 h-48 sm:h-full overflow-hidden">
              <img src="{{ $item['img'] }}" alt="{{ $item['judul'] }}" class="h-full w-full max-w-full object-cover transition-transform duration-500 group-hover:scale-110" />
            </div>
            <div class="flex flex-1 flex-col p-5">
              <div class="flex-1">
                <div class="mb-2 flex items-center justify-between text-xs">
                  <span class="rounded-full bg-indigo-100 px-2.5 py-1 font-medium text-indigo-700">{{ $item['kategori'] }}</span>
                  <span class="text-slate-500">{{ $item['tanggal'] }}</span>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 transition-colors duration-300 group-hover:text-[var(--color-brand)]">
                  <a href="#">{{ $item['judul'] }}</a>
                </h3>
              </div>
              <a href="#" class="mt-4 inline-flex items-center gap-x-1 text-sm font-semibold text-[var(--color-brand)]">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
              </a>
            </div>
          </article>
        @endforeach
      </div>

    </div>

    <!-- Tombol Lihat Semua Berita -->
    <div class="mt-16 text-center"
        data-aos="zoom-in"
        data-aos-delay="300"
        data-aos-duration="2000">
        <a href="/blog" class="inline-block rounded-lg bg-slate-200 px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-300">
            Lihat Semua Berita
        </a>
    </div>
  </div>
</section>
