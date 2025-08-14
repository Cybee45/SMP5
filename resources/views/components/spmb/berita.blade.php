@php
    // Ambil data dari CMS
    $persyaratan = \App\Models\SpmhContent::where('jenis', 'persyaratan')->where('aktif', true)->first();
    $tataCara = \App\Models\SpmhContent::where('jenis', 'tata_cara')->where('aktif', true)->first();
    $formulir = \App\Models\SpmhContent::where('jenis', 'formulir')->where('aktif', true)->first();
@endphp

<!-- SPMB Section (Tailwind v4.1 ready) -->
<section id="spmb"
  class="relative overflow-hidden py-20 lg:py-24"
  x-data="{ modalPersyaratan: false, modalTataCara: false }">
  <!-- Top gradient overlay -->
  <div class="pointer-events-none absolute inset-x-0 top-0 z-10 h-20 sm:h-24 lg:h-32
              bg-gradient-to-b from-white via-white/85 via-white/60 via-white/30 to-transparent"></div>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
       data-aos="fade-up"
       data-aos-duration="800"
       data-aos-easing="ease-out-cubic"
       data-aos-once="true"
       data-aos-anchor-placement="top-bottom">
    <!-- Section Header -->
    <div class="text-center mb-12 lg:mb-16"
         data-aos="fade-up"
         data-aos-delay="60">
      <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">
        Penerimaan Siswa Baru
      </h2>
      <p class="mt-4 mx-auto max-w-2xl text-lg text-gray-600">
        Ikuti langkah-langkah pendaftaran siswa baru di SMP Negeri 5 Sangatta Utara.
      </p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 gap-8 sm:gap-10 md:grid-cols-2 lg:grid-cols-3"
         data-aos="fade-up"
         data-aos-delay="80"
         data-aos-duration="700">
      <!-- Card 1 -->
      <div class="group bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-2 flex flex-col
                  will-change-transform motion-reduce:transform-none"
           data-aos="zoom-in-up" data-aos-delay="120" data-aos-duration="650">
        <div class="p-8 flex-grow">
          <div class="flex justify-center mb-6" data-aos="fade-up" data-aos-delay="140">
            <div class="rounded-full p-4 bg-sky-100 text-sky-600 ring-4 ring-white">
              <svg class="size-10 text-sky-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3"
                   xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
          </div>
          <h3 class="mb-3 text-center text-xl font-bold text-gray-900"
              data-aos="fade-up" data-aos-delay="160">
              {{ $persyaratan->judul ?? 'Persyaratan Pendaftaran' }}
          </h3>
          <p class="text-center text-sm leading-relaxed text-gray-600"
             data-aos="fade-up" data-aos-delay="180">
            {{ $persyaratan->deskripsi ?? 'Pastikan semua dokumen yang diperlukan sudah lengkap sebelum mendaftar.' }}
          </p>
        </div>
        <div class="mt-auto p-6 bg-gray-50 rounded-b-xl">
          <button @click="modalPersyaratan = true"
                  class="w-full rounded-lg bg-sky-500 py-3 px-6 font-semibold text-white transition-all duration-300 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
            Lihat Detail
          </button>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="group bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-2 flex flex-col
                  will-change-transform motion-reduce:transform-none"
           data-aos="zoom-in-up" data-aos-delay="180" data-aos-duration="650">
        <div class="p-8 flex-grow">
          <div class="flex justify-center mb-6" data-aos="fade-up" data-aos-delay="200">
            <div class="rounded-full p-4 bg-emerald-100 text-emerald-600 ring-4 ring-white">
              <svg class="size-10 text-emerald-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3"
                   xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
              </svg>
            </div>
          </div>
          <h3 class="mb-3 text-center text-xl font-bold text-gray-900"
              data-aos="fade-up" data-aos-delay="220">
              {{ $tataCara->judul ?? 'Tata Cara Pendaftaran' }}
          </h3>
          <p class="text-center text-sm leading-relaxed text-gray-600"
             data-aos="fade-up" data-aos-delay="240">
            {{ $tataCara->deskripsi ?? 'Ikuti alur pendaftaran dengan benar untuk memperlancar proses seleksi.' }}
          </p>
        </div>
        <div class="mt-auto p-6 bg-gray-50 rounded-b-xl">
          <button @click="modalTataCara = true"
                  class="w-full rounded-lg bg-emerald-500 py-3 px-6 font-semibold text-white transition-all duration-300 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            Lihat Detail
          </button>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="group rounded-xl shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-2 flex flex-col
                  bg-gradient-to-br from-indigo-500 to-purple-600 text-white
                  will-change-transform motion-reduce:transform-none"
           data-aos="zoom-in-up" data-aos-delay="240" data-aos-duration="650">
        <div class="p-8 flex-grow">
          <div class="flex justify-center mb-6" data-aos="fade-up" data-aos-delay="260">
            <div class="rounded-full p-4 bg-white/20 text-white">
              <svg class="size-10 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3"
                   xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
            </div>
          </div>
          <h3 class="mb-3 text-center text-xl font-bold" data-aos="fade-up" data-aos-delay="280">
            {{ $formulir->judul ?? 'Unduh Formulir' }}
          </h3>
          <p class="text-center text-sm leading-relaxed text-indigo-100"
             data-aos="fade-up" data-aos-delay="300">
            {{ $formulir->deskripsi ?? 'Silakan unduh, cetak, dan isi formulir pendaftaran secara lengkap.' }}
          </p>
        </div>
        <div class="p-6 mt-auto">
          @if($formulir && $formulir->file_pdf)
            <a href="{{ asset('storage/' . $formulir->file_pdf) }}"
               download="{{ $formulir->nama_file ?? 'Formulir-Pendaftaran.pdf' }}"
               class="block w-full rounded-lg bg-white py-3 px-6 text-center font-semibold text-indigo-600 transition-all duration-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-500">
              Download Formulir (.pdf)
            </a>
          @else
            <a href="#"
               class="block w-full rounded-lg bg-white py-3 px-6 text-center font-semibold text-indigo-600 transition-all duration-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-500">
              Download Formulir (.pdf)
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Persyaratan (dengan scrollbar) -->
  <div x-show="modalPersyaratan"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display:none;">
    <div @click="modalPersyaratan = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative w-full max-w-2xl max-h-[85vh] rounded-xl bg-white shadow-2xl flex flex-col overflow-hidden" @click.stop>
      <!-- Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
        <h3 class="text-2xl font-bold text-gray-900">Detail Persyaratan Pendaftaran</h3>
        <button @click="modalPersyaratan = false" class="text-gray-400 hover:text-gray-600 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      
      <!-- Content dengan Scrollbar -->
      <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <div class="text-gray-700">
          @if($persyaratan && $persyaratan->deskripsi_pembuka)
            <p class="mb-4 text-base leading-relaxed">{!! $persyaratan->deskripsi_pembuka !!}</p>
          @else
            <p class="mb-4 text-base leading-relaxed">Harap mempersiapkan dokumen-dokumen berikut dalam bentuk fisik dan digital untuk keperluan pendaftaran siswa baru tahun ajaran 2025/2026:</p>
          @endif
          
          <h4 class="font-semibold text-lg text-gray-900 mb-3">A. Dokumen Wajib:</h4>
          <ul class="list-disc list-inside space-y-2 mb-6">
            @if($persyaratan && $persyaratan->dokumen_wajib)
              @foreach($persyaratan->dokumen_wajib as $dokumen)
                <li>{{ $dokumen['item'] ?? $dokumen }}</li>
              @endforeach
            @else
              <li>Fotokopi Akta Kelahiran yang telah dilegalisir (2 lembar)</li>
              <li>Fotokopi Kartu Keluarga (KK) terbaru yang telah dilegalisir (2 lembar)</li>
              <li>Pas foto berwarna ukuran 3x4 dengan latar belakang biru (4 lembar)</li>
              <li>Fotokopi Ijazah SD/MI yang telah dilegalisir oleh sekolah asal (2 lembar)</li>
              <li>Surat Keterangan Lulus (SKL) asli dari sekolah asal</li>
              <li>Fotokopi KTP kedua orang tua/wali yang masih berlaku (masing-masing 2 lembar)</li>
              <li>Surat pernyataan orang tua/wali bermaterai 10.000</li>
            @endif
          </ul>

          <h4 class="font-semibold text-lg text-gray-900 mb-3">B. Dokumen Pendukung:</h4>
          <ul class="list-disc list-inside space-y-2 mb-6">
            @if($persyaratan && $persyaratan->dokumen_pendukung)
              @foreach($persyaratan->dokumen_pendukung as $dokumen)
                <li>{{ $dokumen['item'] ?? $dokumen }}</li>
              @endforeach
            @else
              <li>Fotokopi SHUN/Nilai UN SD/MI (jika ada)</li>
              <li>Sertifikat prestasi akademik atau non-akademik (jika ada)</li>
              <li>Surat keterangan tidak mampu dari kelurahan (untuk jalur khusus)</li>
              <li>Surat keterangan sehat dari dokter</li>
              <li>Surat keterangan kelakuan baik dari sekolah asal</li>
            @endif
          </ul>

          <h4 class="font-semibold text-lg text-gray-900 mb-3">C. Ketentuan Berkas:</h4>
          <ul class="list-disc list-inside space-y-2 mb-6">
            @if($persyaratan && $persyaratan->ketentuan_berkas)
              @foreach($persyaratan->ketentuan_berkas as $ketentuan)
                <li>{{ $ketentuan['item'] ?? $ketentuan }}</li>
              @endforeach
            @else
              <li>Semua berkas dimasukkan ke dalam map plastik berwarna biru untuk laki-laki dan merah muda untuk perempuan</li>
              <li>Berkas yang sudah diserahkan tidak dapat dikembalikan</li>
              <li>Pastikan semua fotokopi jelas dan dapat dibaca dengan baik</li>
              <li>Berkas yang tidak lengkap akan dikembalikan</li>
            @endif
          </ul>

          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-800">
                  @if($persyaratan && $persyaratan->catatan_penting)
                    {!! $persyaratan->catatan_penting !!}
                  @else
                    <strong>Penting:</strong> Harap cek kembali kelengkapan berkas sebelum diserahkan ke panitia pendaftaran. Berkas yang tidak lengkap akan memperlambat proses verifikasi.
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <div class="p-6 border-t border-gray-200 flex-shrink-0">
        <button @click="modalPersyaratan = false" 
                class="w-full rounded-lg bg-sky-500 hover:bg-sky-600 py-3 px-4 font-semibold text-white transition-colors">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- Modal Tata Cara (dengan scrollbar) -->
  <div x-show="modalTataCara"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display:none;">
    <div @click="modalTataCara = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative w-full max-w-2xl max-h-[85vh] rounded-xl bg-white shadow-2xl flex flex-col overflow-hidden" @click.stop>
      <!-- Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
        <h3 class="text-2xl font-bold text-gray-900">Tata Cara Pendaftaran</h3>
        <button @click="modalTataCara = false" class="text-gray-400 hover:text-gray-600 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      
      <!-- Content dengan Scrollbar -->
      <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <div class="text-gray-700">
          @if($tataCara && $tataCara->deskripsi_pembuka)
            <p class="mb-6 text-base leading-relaxed">{!! $tataCara->deskripsi_pembuka !!}</p>
          @else
            <p class="mb-6 text-base leading-relaxed">Berikut adalah alur lengkap pendaftaran siswa baru SMPN 5 Sangatta Utara tahun ajaran 2025/2026 secara online dan offline:</p>
          @endif
          
          <h4 class="font-semibold text-lg text-gray-900 mb-4">Tahap Persiapan:</h4>
          <ol class="list-decimal list-inside space-y-3 mb-6">
            @if($tataCara && $tataCara->tahap_persiapan)
              @foreach($tataCara->tahap_persiapan as $tahap)
                <li>{!! $tahap['item'] ?? $tahap !!}</li>
              @endforeach
            @else
              <li><strong>Unduh Formulir Pendaftaran:</strong> Calon siswa atau orang tua dapat mengunduh formulir dari website resmi sekolah atau mengambil langsung di sekretariat sekolah.</li>
              <li><strong>Baca Ketentuan:</strong> Pahami dengan seksama semua ketentuan dan persyaratan yang telah ditetapkan.</li>
              <li><strong>Siapkan Dokumen:</strong> Kumpulkan dan lengkapi semua dokumen persyaratan sesuai dengan checklist yang telah disediakan.</li>
            @endif
          </ol>

          <h4 class="font-semibold text-lg text-gray-900 mb-4">Tahap Pendaftaran:</h4>
          <ol class="list-decimal list-inside space-y-3 mb-6" start="4">
            @if($tataCara && $tataCara->tahap_pendaftaran)
              @foreach($tataCara->tahap_pendaftaran as $tahap)
                <li>{!! $tahap['item'] ?? $tahap !!}</li>
              @endforeach
            @else
              <li><strong>Isi Formulir:</strong> Cetak dan isi formulir pendaftaran dengan data yang benar, lengkap, dan menggunakan tinta hitam atau biru.</li>
              <li><strong>Verifikasi Data:</strong> Pastikan semua data yang diisi sudah sesuai dengan dokumen asli dan tidak ada kesalahan penulisan.</li>
              <li><strong>Kunjungi Sekolah:</strong> Datang ke sekretariat pendaftaran SMPN 5 Sangatta Utara pada hari kerja (Senin-Jumat) pukul 08:00 - 14:00 WITA.</li>
              <li><strong>Serahkan Berkas:</strong> Serahkan formulir dan semua dokumen persyaratan kepada panitia pendaftaran.</li>
            @endif
          </ol>

          <h4 class="font-semibold text-lg text-gray-900 mb-4">Tahap Seleksi:</h4>
          <ol class="list-decimal list-inside space-y-3 mb-6" start="8">
            @if($tataCara && $tataCara->tahap_seleksi)
              @foreach($tataCara->tahap_seleksi as $tahap)
                <li>{!! $tahap['item'] ?? $tahap !!}</li>
              @endforeach
            @else
              <li><strong>Verifikasi Berkas:</strong> Panitia akan memverifikasi kelengkapan dan keabsahan semua dokumen yang diserahkan.</li>
              <li><strong>Tes Seleksi:</strong> Calon siswa akan mengikuti tes seleksi sesuai dengan jadwal yang telah ditentukan (tes tulis dan wawancara).</li>
              <li><strong>Penilaian:</strong> Tim seleksi akan melakukan penilaian berdasarkan nilai akademik, tes seleksi, dan prestasi.</li>
            @endif
          </ol>

          <h4 class="font-semibold text-lg text-gray-900 mb-4">Tahap Pengumuman:</h4>
          <ol class="list-decimal list-inside space-y-3 mb-6" start="11">
            @if($tataCara && $tataCara->tahap_pengumuman)
              @foreach($tataCara->tahap_pengumuman as $tahap)
                <li>{!! $tahap['item'] ?? $tahap !!}</li>
              @endforeach
            @else
              <li><strong>Pengumuman Hasil:</strong> Hasil seleksi akan diumumkan di papan pengumuman sekolah dan website resmi sekolah.</li>
              <li><strong>Daftar Ulang:</strong> Calon siswa yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang ditentukan.</li>
              <li><strong>Orientasi:</strong> Mengikuti program orientasi siswa baru dan persiapan pembelajaran.</li>
            @endif
          </ol>

          <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-6">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">Informasi Penting</h4>
                <div class="mt-2 text-sm text-blue-700">
                  <ul class="list-disc list-inside space-y-1">
                    @if($tataCara && $tataCara->jadwal_penting)
                      @foreach($tataCara->jadwal_penting as $jadwal)
                        <li>{{ $jadwal['item'] ?? $jadwal }}</li>
                      @endforeach
                    @else
                      <li>Pendaftaran dibuka mulai tanggal 1 Agustus 2025</li>
                      <li>Batas akhir pendaftaran: 31 Agustus 2025</li>
                      <li>Pengumuman hasil seleksi: 15 September 2025</li>
                      <li>Daftar ulang: 16-20 September 2025</li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="ml-3">
                <h4 class="text-sm font-medium text-green-800">Tips Sukses</h4>
                <div class="mt-2 text-sm text-green-700">
                  <ul class="list-disc list-inside space-y-1">
                    @if($tataCara && $tataCara->tips_sukses)
                      @foreach($tataCara->tips_sukses as $tips)
                        <li>{{ $tips['item'] ?? $tips }}</li>
                      @endforeach
                    @else
                      <li>Siapkan berkas jauh-jauh hari untuk menghindari keterlambatan</li>
                      <li>Datang tepat waktu saat pengumpulan berkas dan tes seleksi</li>
                      <li>Hubungi panitia jika ada pertanyaan atau kesulitan</li>
                      <li>Ikuti perkembangan informasi melalui website resmi sekolah</li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <div class="p-6 border-t border-gray-200 flex-shrink-0">
        <button @click="modalTataCara = false" 
                class="w-full rounded-lg bg-emerald-500 hover:bg-emerald-600 py-3 px-4 font-semibold text-white transition-colors">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- Bottom gradient overlay -->
  <div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-20 sm:h-24 lg:h-32
              bg-gradient-to-t from-white via-white/85 via-white/60 via-white/30 to-transparent"></div>
</section>
