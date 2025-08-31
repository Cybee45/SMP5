@php
    try {
        $visiMisi = \App\Models\VisiMisi::where('aktif', true)->first();
    } catch (\Exception $e) {
        $visiMisi = null;
        \Log::error('VisiMisi query error: ' . $e->getMessage());
    }
@endphp

<!-- ===== Section Visi, Misi, & Tujuan Dimulai ===== -->
<section class="relative overflow-hidden py-16 md:py-24">
    <!-- Top gradient blur overlay - diperbesar untuk menyatu lebih baik -->
    <div class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 z-0 
            w-[80%] h-40 bg-gradient-radial from-indigo-200/40 via-white/0 to-transparent 
            blur-3xl rounded-full"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Judul Section -->
        <div class="text-center mb-12 lg:mb-16" data-aos="fade-up">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wider uppercase text-balance">
                {{ $visiMisi->subjudul_section ?? 'Arah & Fokus' }}
            </h2>
            <p class="mt-2 text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight text-balance">
                {{ $visiMisi->judul_section ?? 'Visi, Misi, & Tujuan Sekolah' }}
            </p>
        </div>

        <!-- Grid untuk Kartu -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            <!-- Kartu Visi -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-lg overflow-hidden transform transition-all duration-700 ease-in-out hover:shadow-2xl hover:-translate-y-2" data-aos="fade-right" data-aos-duration="800">
                <div class="flex flex-col items-center text-center mb-5 sm:mb-6">
                    <!-- Ikon Visi -->
                    <div class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-xl p-3 mb-4">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 text-balance">Visi</h3>
                </div>

                <p class="text-gray-700 text-sm sm:text-base leading-relaxed sm:leading-7 text-pretty max-w-[65ch] mx-auto">
                    {{ $visiMisi->visi ?? 'Menjadi lembaga pendidikan terdepan yang menghasilkan generasi unggul, berkarakter, inovatif, dan berwawasan global, serta siap menghadapi tantangan masa depan.' }}
                </p>
            </div>

            <!-- Kartu Misi -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-lg overflow-hidden transform transition-all duration-700 ease-in-out hover:shadow-2xl hover:-translate-y-2" data-aos="fade-left" data-aos-duration="800">
                <div class="flex flex-col items-center text-center mb-5 sm:mb-6">
                    <!-- Ikon Misi -->
                    <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-xl p-3 mb-4">
                       <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                       </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 text-balance">Misi</h3>
                </div>
                
                @if($visiMisi && $visiMisi->misi)
                    <ul class="max-w-[70ch] mx-auto list-disc list-outside pl-5 sm:pl-6 text-gray-700 text-sm sm:text-base leading-relaxed sm:leading-7 space-y-2.5 sm:space-y-3">
                        @foreach($visiMisi->misi as $misiItem)
                            <li class="break-inside-avoid">{{ $misiItem['item'] ?? $misiItem }}</li>
                        @endforeach
                    </ul>
                @else
                    <ul class="max-w-[70ch] mx-auto list-disc list-outside pl-5 sm:pl-6 text-gray-700 text-sm sm:text-base leading-relaxed sm:leading-7 space-y-2.5 sm:space-y-3">
                        <li class="break-inside-avoid">Menyelenggarakan pendidikan berkualitas yang terintegrasi dengan teknologi.</li>
                        <li class="break-inside-avoid">Membentuk karakter siswa yang berlandaskan nilai-nilai luhur dan akhlak mulia.</li>
                        <li class="break-inside-avoid">Mengembangkan potensi siswa secara optimal melalui program ekstrakurikuler yang beragam.</li>
                        <li class="break-inside-avoid">Menciptakan lingkungan belajar yang aman, nyaman, dan inspiratif bagi seluruh warga sekolah.</li>
                    </ul>
                @endif
            </div>
            
            <!-- Kartu Tujuan -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-lg overflow-hidden transform transition-all duration-700 ease-in-out hover:shadow-2xl hover:-translate-y-2" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                <div class="flex flex-col items-center text-center mb-5 sm:mb-6">
                    <!-- Ikon Tujuan -->
                    <div class="flex-shrink-0 bg-purple-100 text-purple-600 rounded-xl p-3 mb-4">
                       <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                       </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 text-balance">Tujuan</h3>
                </div>
                
                @if($visiMisi && $visiMisi->tujuan && count($visiMisi->tujuan) > 0)
                    <ul class="max-w-[75ch] md:max-w-none mx-auto list-disc list-outside pl-5 sm:pl-6 text-gray-700 text-sm sm:text-base leading-relaxed sm:leading-7 space-y-2.5 sm:space-y-3 md:space-y-0 md:columns-2 md:gap-x-10">
                        @foreach($visiMisi->tujuan as $tujuanItem)
                            <li class="break-inside-avoid">{{ $tujuanItem['item'] ?? $tujuanItem }}</li>
                        @endforeach
                    </ul>
                @else
                    <ul class="max-w-[75ch] md:max-w-none mx-auto list-disc list-outside pl-5 sm:pl-6 text-gray-700 text-sm sm:text-base leading-relaxed sm:leading-7 space-y-2.5 sm:space-y-3 md:space-y-0 md:columns-2 md:gap-x-10">
                        <li class="break-inside-avoid">Meningkatkan rata-rata nilai ujian sekolah sebesar 10% dalam dua tahun.</li>
                        <li class="break-inside-avoid">Meraih prestasi di tingkat provinsi dalam bidang olahraga dan seni.</li>
                        <li class="break-inside-avoid">Mengimplementasikan program literasi digital bagi seluruh siswa.</li>
                        <li class="break-inside-avoid">Meningkatkan partisipasi orang tua dalam kegiatan sekolah.</li>
                        <li class="break-inside-avoid">Mengembangkan program kewirausahaan untuk siswa kelas akhir.</li>
                        <li class="break-inside-avoid">Menjalin kemitraan strategis dengan industri dan komunitas lokal.</li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom gradient blur overlay - disesuaikan untuk menyatu dengan bg-slate-50 section prestasi -->
    <div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-20 sm:h-24 lg:h-32 
            bg-gradient-to-t from-slate-50 via-slate-50/85 via-white/60 via-white/30 to-transparent"></div>
</section>
<!-- ===== Section Visi, Misi, & Tujuan Selesai ===== -->
