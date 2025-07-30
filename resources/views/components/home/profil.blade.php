<section class="relative bg-white py-20 lg:py-24 overflow-hidden">
    <!-- Efek Gradasi / Blur di Bagian Atas -->
    <div class="absolute top-0 left-0 z-20 h-32 w-full bg-gradient-to-b from-slate-50 to-transparent"></div>

    <div class="container relative z-10 mx-auto px-6 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          
            <!-- Kolom Gambar -->
            <div class="relative h-80 lg:h-[480px] w-full"
                 data-aos="zoom-in"
                 data-aos-delay="100"
                 data-aos-duration="900">
                <div class="absolute -top-4 -left-4 w-full h-full bg-sky-100 rounded-2xl transform -rotate-3"></div>
                <div class="relative w-full h-full rounded-2xl shadow-2xl overflow-hidden">
                    <img src="{{ asset('assets/home/smp_5-32.jpg') }}"
                         alt="Foto Gedung SMP 5 Sangatta Utara"
                         onerror="this.onerror=null;this.src='https://placehold.co/800x600/e0f2fe/333?text=Gambar+Tidak+Tersedia';"
                         class="w-full h-full object-cover">
                </div>
            </div>
            <!-- Kolom Teks -->
            <div>
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-5 text-gray-900">
                    Profil Singkat Sekolah
                </h2>
                <div class="space-y-4 text-slate-600 text-base md:text-lg leading-relaxed">
                    <p>
                        SMP 5 Sangatta Utara adalah sekolah menengah unggulan yang berdedikasi untuk menciptakan lingkungan belajar yang inklusif, didukung oleh kurikulum inovatif dan fasilitas modern.
                    </p>
                    <p>
                        Kami berkomitmen penuh untuk mencetak generasi berprestasi yang tidak hanya unggul secara akademis, tetapi juga siap dan tangguh dalam menghadapi tantangan masa depan.
                    </p>
                </div>
                <a href="#"
                   class="mt-8 inline-flex items-center gap-x-3 bg-[var(--color-brand)] text-white font-semibold rounded-lg px-6 py-3 shadow-lg hover:bg-[var(--color-brand-dark)] transition-all duration-300 transform hover:scale-105"
                   data-aos="zoom-in"
                   data-aos-delay="400"
                   data-aos-duration="700">
                    Selengkapnya Tentang Kami
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Efek Gradasi / Blur di Bagian Bawah -->
    <div class="absolute bottom-0 left-0 z-20 h-32 w-full bg-gradient-to-t from-slate-50 to-transparent"></div>
</section>
