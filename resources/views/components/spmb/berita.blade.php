<!-- SPMB Section -->
    <section id="spmb" class="py-20 lg:py-24" x-data="{ modalPersyaratan: false, modalTataCara: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Penerimaan Siswa Baru
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Ikuti langkah-langkah pendaftaran siswa baru di SMP Negeri 5 Sangatta Utara.
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">

                <!-- Card 1: Persyaratan -->
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="flex justify-center mb-6">
                            <div class="bg-sky-100 text-sky-600 rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-center text-xl font-bold text-gray-900 mb-3">Persyaratan Pendaftaran</h3>
                        <p class="text-center text-gray-600 text-sm leading-relaxed">
                            Pastikan semua dokumen yang diperlukan sudah lengkap sebelum mendaftar.
                        </p>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-b-xl mt-auto">
                        <button @click="modalPersyaratan = true" class="w-full bg-sky-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-all duration-300">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Card 2: Tata Cara -->
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="flex justify-center mb-6">
                            <div class="bg-emerald-100 text-emerald-600 rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-center text-xl font-bold text-gray-900 mb-3">Tata Cara Pendaftaran</h3>
                        <p class="text-center text-gray-600 text-sm leading-relaxed">
                            Ikuti alur pendaftaran dengan benar untuk memperlancar proses seleksi.
                        </p>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-b-xl mt-auto">
                        <button @click="modalTataCara = true" class="w-full bg-emerald-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Card 3: Formulir -->
                <div class="group bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-in-out flex flex-col">
                    <div class="p-8 flex-grow">
                         <div class="flex justify-center mb-6">
                            <div class="bg-white/20 text-white rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-center text-xl font-bold mb-3">Unduh Formulir</h3>
                        <p class="text-center text-indigo-100 text-sm leading-relaxed">
                            Silakan unduh, cetak, dan isi formulir pendaftaran secara lengkap.
                        </p>
                    </div>
                    <div class="p-6 mt-auto">
                        <a href="#" class="w-full block text-center bg-white text-indigo-600 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-indigo-500 transition-all duration-300">
                            Download Formulir (.pdf)
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal for Persyaratan -->
        <div x-show="modalPersyaratan" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <!-- Overlay -->
            <div @click="modalPersyaratan = false" class="fixed inset-0 bg-black/50"></div>
            <!-- Modal Panel -->
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6 md:p-8" @click.stop>
                <button @click="modalPersyaratan = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Detail Persyaratan</h3>
                <div class="space-y-4 text-gray-600">
                    <p>Harap mempersiapkan dokumen-dokumen berikut dalam bentuk fisik dan digital:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Fotokopi Akta Kelahiran (2 lembar).</li>
                        <li>Fotokopi Kartu Keluarga (KK) terbaru (2 lembar).</li>
                        <li>Pas foto berwarna ukuran 3x4 (4 lembar) dengan latar belakang biru.</li>
                        <li>Fotokopi Ijazah SD/MI yang telah dilegalisir.</li>
                        <li>Surat Keterangan Lulus (SKL) Asli dari sekolah asal.</li>
                        <li>Fotokopi KTP kedua orang tua/wali.</li>
                    </ul>
                    <p>Semua berkas dimasukkan ke dalam map berwarna biru untuk laki-laki dan merah untuk perempuan.</p>
                </div>
                 <button @click="modalPersyaratan = false" class="mt-6 w-full bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                    Tutup
                </button>
            </div>
        </div>

        <!-- Modal for Tata Cara -->
        <div x-show="modalTataCara" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <!-- Overlay -->
            <div @click="modalTataCara = false" class="fixed inset-0 bg-black/50"></div>
            <!-- Modal Panel -->
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6 md:p-8" @click.stop>
                <button @click="modalTataCara = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Detail Tata Cara</h3>
                <div class="space-y-4 text-gray-600">
                    <p>Berikut adalah alur pendaftaran siswa baru secara online dan offline:</p>
                    <ol class="list-decimal list-inside space-y-2">
                        <li><strong>Unduh Formulir:</strong> Calon siswa mengunduh formulir dari website ini.</li>
                        <li><strong>Isi Formulir:</strong> Cetak dan isi formulir dengan data yang benar dan lengkap.</li>
                        <li><strong>Siapkan Berkas:</strong> Kumpulkan semua dokumen persyaratan yang telah ditentukan.</li>
                        <li><strong>Datang ke Sekolah:</strong> Kunjungi sekretariat pendaftaran di SMPN 5 Sangatta Utara pada jam kerja (08:00 - 14:00 WITA).</li>
                        <li><strong>Verifikasi Berkas:</strong> Panitia akan memverifikasi kelengkapan dan keabsahan berkas.</li>
                        <li><strong>Pengumuman:</strong> Hasil seleksi akan diumumkan di papan pengumuman sekolah dan website resmi.</li>
                    </ol>
                </div>
                 <button @click="modalTataCara = false" class="mt-6 w-full bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </section>