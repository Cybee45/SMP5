@php
    $kepalaSekolah = \App\Models\TimBirokrasi::kepalaSekolah()->active()->ordered()->first();
    $wakilKepala = \App\Models\TimBirokrasi::wakilKepala()->active()->ordered()->get();
    $guru = \App\Models\TimBirokrasi::byKategori('guru')->active()->ordered()->get();
    $staff = \App\Models\TimBirokrasi::byKategori('staff')->active()->ordered()->get();
@endphp

<!-- ===== Bagian Birokrasi Dimulai ===== -->
<section class="relative overflow-hidden py-16 md:py-24">
    <!-- Top gradient overlay untuk blending dengan section atas -->
    <div class="pointer-events-none absolute inset-x-0 top-0 z-10 h-20 sm:h-24 lg:h-32 
                bg-gradient-to-b from-white via-white/85 via-white/60 via-white/30 to-transparent"></div>
                
    <!-- Bagian Konten Tengah (Judul & Pimpinan) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Judul Section -->
        <div class="text-center mb-12">
            <h2 class="text-base font-semibold text-blue-600 tracking-wider uppercase">Struktur Organisasi</h2>
            <p class="mt-2 text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Tim Pendidik & Tenaga Kependidikan
            </p>
        </div>

        <!-- Bagian Pimpinan Inti -->
        <div class="mb-16">
            @if($kepalaSekolah)
            <!-- Kepala Sekolah -->
            <div class="flex justify-center mb-10">
                <!-- KARTU KEPALA SEKOLAH -->
                <div class="group w-full max-w-xs bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-2xl hover:-translate-y-2"
                     data-aos="fade-up" 
                     data-aos-duration="800" 
                     data-aos-delay="100">
                    <div class="relative h-96 overflow-hidden">
                        <x-ui.image-loader 
                            :src="$kepalaSekolah->foto ? asset('storage/' . $kepalaSekolah->foto) : 'https://placehold.co/300x400/1A202C/FFFFFF?text=Kepala+Sekolah'"
                            :alt="'Foto ' . $kepalaSekolah->nama"
                            class="w-full h-full object-cover object-top"
                            error-placeholder="https://placehold.co/300x400/1A202C/FFFFFF?text=Kepala+Sekolah"
                        />
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900">{{ $kepalaSekolah->nama }}</h3>
                        <p class="mt-1 text-blue-600 font-semibold">{{ $kepalaSekolah->jabatan }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($wakilKepala->count() > 0)
            <!-- Wakil Kepala Sekolah -->
            <!-- PENYESUAIAN: Grid dibuat justify-items-center agar kartu terpusat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
                @foreach($wakilKepala as $index => $wakil)
                <!-- Wakil {{ $index + 1 }} -->
                <!-- KARTU DISESUAIKAN: Ukuran kartu dan gambar disamakan dengan Kepala Sekolah -->
                <div class="group w-full max-w-xs bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-2xl hover:-translate-y-2"
                     data-aos="fade-right" 
                     data-aos-duration="800" 
                     data-aos-delay="{{ 200 + ($index * 100) }}">
                    <div class="relative h-96 overflow-hidden">
                        <x-ui.image-loader 
                            :src="$wakil->foto ? asset('storage/' . $wakil->foto) : 'https://placehold.co/300x400/63B3ED/FFFFFF?text=Wakil+' . ($index + 1)"
                            :alt="'Foto ' . $wakil->nama"
                            class="w-full h-full object-cover"
                            :error-placeholder="'https://placehold.co/300x400/63B3ED/FFFFFF?text=Wakil+' . ($index + 1)"
                        />
                    </div>
                    <div class="p-5 text-center">
                        <h3 class="text-lg font-bold text-gray-900">{{ $wakil->nama }}</h3>
                        <p class="mt-1 text-gray-500">{{ $wakil->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Bagian Staff & Guru (Bergerak - Full Width) -->
    @if($guru->count() > 0 || $staff->count() > 0)
    <div class="mt-8 space-y-8">
        @if($guru->count() > 0)
        <!-- Baris 1: Guru - Bergerak ke Kiri -->
        <div class="scroller" data-direction="left">
            <div class="scroller__inner">
                @php
                    // Pastikan minimal 12 kartu untuk scroll smooth
                    $guruCards = $guru->count() >= 6 ? $guru : $guru->concat($guru)->concat($guru);
                    $displayGuru = $guruCards->take(12);
                @endphp
                @foreach($displayGuru as $member)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <div class="relative h-72 overflow-hidden">
                        <x-ui.image-loader 
                            :src="$member->foto ? asset('storage/' . $member->foto) : 'https://placehold.co/300x400/CBD5E0/FFFFFF?text=Guru'"
                            :alt="'Foto ' . $member->nama"
                            class="w-full h-full object-cover"
                            error-placeholder="https://placehold.co/300x400/CBD5E0/FFFFFF?text=Guru"
                        />
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">{{ $member->nama }}</h3>
                        <p class="text-sm text-gray-500">{{ $member->jabatan }}</p>
                    </div>
                </div>
                @endforeach
                <!-- Duplikasi penuh untuk smooth infinite scroll -->
                @foreach($displayGuru as $member)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <div class="relative h-72 overflow-hidden">
                        <x-ui.image-loader 
                            :src="$member->foto ? asset('storage/' . $member->foto) : 'https://placehold.co/300x400/CBD5E0/FFFFFF?text=Guru'"
                            :alt="'Foto ' . $member->nama"
                            class="w-full h-full object-cover"
                            error-placeholder="https://placehold.co/300x400/CBD5E0/FFFFFF?text=Guru"
                        />
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">{{ $member->nama }}</h3>
                        <p class="text-sm text-gray-500">{{ $member->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($staff->count() > 0)
        <!-- Baris 2: Staff - Bergerak ke Kanan -->
        <div class="scroller" data-direction="right">
            <div class="scroller__inner">
                @php
                    // Pastikan minimal 12 kartu untuk scroll smooth
                    $staffCards = $staff->count() >= 6 ? $staff : $staff->concat($staff)->concat($staff);
                    $displayStaff = $staffCards->take(12);
                @endphp
                @foreach($displayStaff as $member)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <div class="relative h-72 overflow-hidden">
                        <x-ui.image-loader 
                            :src="$member->foto ? asset('storage/' . $member->foto) : 'https://placehold.co/300x400/C6F6D5/FFFFFF?text=Staff'"
                            :alt="'Foto ' . $member->nama"
                            class="w-full h-full object-cover"
                            error-placeholder="https://placehold.co/300x400/C6F6D5/FFFFFF?text=Staff"
                        />
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">{{ $member->nama }}</h3>
                        <p class="text-sm text-gray-500">{{ $member->jabatan }}</p>
                    </div>
                </div>
                @endforeach
                <!-- Duplikasi penuh untuk smooth infinite scroll -->
                @foreach($displayStaff as $member)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <div class="relative h-72 overflow-hidden">
                        <x-ui.image-loader 
                            :src="$member->foto ? asset('storage/' . $member->foto) : 'https://placehold.co/300x400/C6F6D5/FFFFFF?text=Staff'"
                            :alt="'Foto ' . $member->nama"
                            class="w-full h-full object-cover"
                            error-placeholder="https://placehold.co/300x400/C6F6D5/FFFFFF?text=Staff"
                        />
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">{{ $member->nama }}</h3>
                        <p class="text-sm text-gray-500">{{ $member->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- Fallback dengan data demo jika tidak ada data guru atau staff -->
    <div class="mt-8 space-y-8">
        <!-- Baris 1: Demo Guru - Bergerak ke Kiri -->
        <div class="scroller" data-direction="left">
            <div class="scroller__inner">
                @for($i = 1; $i <= 12; $i++)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <img class="w-full h-72 object-cover" src="https://placehold.co/300x400/CBD5E0/FFFFFF?text=Guru+{{ $i }}" alt="Foto Guru">
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">Nama Guru {{ $i }}</h3>
                        <p class="text-sm text-gray-500">Guru Mata Pelajaran</p>
                    </div>
                </div>
                @endfor
                <!-- Duplikasi untuk smooth scroll -->
                @for($i = 1; $i <= 12; $i++)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <img class="w-full h-72 object-cover" src="https://placehold.co/300x400/CBD5E0/FFFFFF?text=Guru+{{ $i }}" alt="Foto Guru">
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">Nama Guru {{ $i }}</h3>
                        <p class="text-sm text-gray-500">Guru Mata Pelajaran</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Baris 2: Demo Staff - Bergerak ke Kanan -->
        <div class="scroller" data-direction="right">
            <div class="scroller__inner">
                @for($i = 1; $i <= 12; $i++)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <img class="w-full h-72 object-cover" src="https://placehold.co/300x400/C6F6D5/FFFFFF?text=Staff+{{ $i }}" alt="Foto Staff">
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">Nama Staff {{ $i }}</h3>
                        <p class="text-sm text-gray-500">Tenaga Kependidikan</p>
                    </div>
                </div>
                @endfor
                <!-- Duplikasi untuk smooth scroll -->
                @for($i = 1; $i <= 12; $i++)
                <div class="group w-56 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-500 ease-in-out hover:shadow-xl hover:scale-105">
                    <img class="w-full h-72 object-cover" src="https://placehold.co/300x400/C6F6D5/FFFFFF?text=Staff+{{ $i }}" alt="Foto Staff">
                    <div class="p-4 text-center">
                        <h3 class="font-semibold">Nama Staff {{ $i }}</h3>
                        <p class="text-sm text-gray-500">Tenaga Kependidikan</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
    @endif
<div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-32 sm:h-40 lg:h-48 
            bg-gradient-to-t from-slate-50 via-slate-50/90 via-slate-50/70 via-white/50 via-white/25 to-transparent"></div> 
</section>
