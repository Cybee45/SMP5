<section class="relative bg-white py-20 lg:py-24 overflow-hidden">
    <!-- Efek Gradasi / Blur di Bagian Atas -->
    <div class="absolute top-0 left-0 z-20 h-32 w-full bg-gradient-to-b from-slate-50 to-transparent"></div>

    @php
        $profil = \App\Models\Profil::where('aktif', true)->first();
    @endphp

    @if($profil)
    <div class="container relative z-10 mx-auto px-6 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          
            <!-- Kolom Gambar -->
            <div class="relative h-80 lg:h-[480px] w-full"
                 data-aos="fade-right"
                 data-aos-delay="100"
                 data-aos-duration="900">
                <div class="absolute -top-4 -left-4 w-full h-full bg-sky-100 rounded-2xl transform -rotate-3"></div>
                <div class="relative w-full h-full rounded-2xl shadow-2xl overflow-hidden">
                    <img src="{{ $profil->gambar ? asset($profil->gambar) : asset('assets/home/smp_5-32.jpg') }}"
                         alt="Foto Gedung SMP 5 Sangatta Utara"
                         onerror="this.onerror=null;this.src='https://placehold.co/800x600/e0f2fe/333?text=Gambar+Tidak+Tersedia';"
                         class="w-full h-full object-cover">
                </div>
            </div>
            <!-- Kolom Teks -->
            <div>
              <div class="max-w-2xl space-y-6"
                   data-aos="fade-left"
                   data-aos-delay="400"
                   data-aos-duration="700">
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-5 text-gray-900">
                    {{ $profil->judul }}
                </h2>
                <div class="space-y-4 text-slate-600 text-base md:text-lg leading-relaxed">
                    <p>
                        {{ $profil->deskripsi_1 }}
                    </p>
                    @if($profil->deskripsi_2)
                    <p>
                        {{ $profil->deskripsi_2 }}
                    </p>
                    @endif
                </div>
              </div>
              
                @if($profil->link_selengkapnya)
                <a href="{{ $profil->link_selengkapnya }}"
                   class="mt-8 inline-flex items-center gap-x-3 bg-[var(--color-brand)] text-white font-semibold rounded-lg px-6 py-3 shadow-lg hover:bg-[var(--color-brand-dark)] transition-all duration-300 transform hover:scale-105"
                   data-aos="fade-left"
                   data-aos-delay="300"
                   data-aos-duration="650">
                    Selengkapnya Tentang Kami
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                <a href="/about"
                   class="mt-8 inline-flex items-center gap-x-3 bg-[var(--color-brand)] text-white font-semibold rounded-lg px-6 py-3 shadow-lg hover:bg-[var(--color-brand-dark)] transition-all duration-300 transform hover:scale-105"
                   data-aos="fade-left"
                   data-aos-delay="300"
                   data-aos-duration="650">
                    Selengkapnya Tentang Kami
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Efek Gradasi / Blur di Bagian Bawah -->
    <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-slate-50 to-transparent"></div>
</section>
