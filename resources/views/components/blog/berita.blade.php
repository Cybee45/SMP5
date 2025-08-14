@php
    // Gunakan data dari controller atau fallback
    $fallbackData = [
        ['id' => 1, 'slug' => 'jadwal-dan-alur-pendaftaran-peserta-didik-baru-ppdb-2025', 'img' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'category' => 'Pengumuman', 'categoryColor' => 'blue', 'date' => '22 Juli 2025', 'title' => 'Jadwal dan Alur Pendaftaran Peserta Didik Baru (PPDB) 2025', 'content' => 'Berikut adalah jadwal lengkap dan alur pendaftaran untuk calon peserta didik baru tahun ajaran 2025/2026. Pastikan untuk membaca semua detail dengan saksama agar tidak ada informasi yang terlewat.'],
        ['id' => 2, 'slug' => 'kegiatan-studi-tur-edukatif-ke-museum-nasional', 'img' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2232&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'category' => 'Kegiatan', 'categoryColor' => 'purple', 'date' => '18 Juli 2025', 'title' => 'Kegiatan Studi Tur Edukatif ke Museum Nasional', 'content' => 'Siswa-siswi kelas VIII telah berhasil melaksanakan studi tur yang sangat bermanfaat ke Museum Nasional. Mereka belajar banyak tentang sejarah dan warisan budaya bangsa.'],
        ['id' => 3, 'slug' => 'siswa-raih-medali-emas-di-olimpiade-sains-tingkat-nasional', 'img' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop', 'category' => 'Prestasi', 'categoryColor' => 'amber', 'date' => '15 Juli 2025', 'title' => 'Siswa Raih Medali Emas di Olimpiade Sains Tingkat Nasional', 'content' => 'Selamat kepada ananda Budi Hartono dari kelas IX-A yang berhasil membawa pulang medali emas dalam ajang Olimpiade Sains Nasional (OSN) bidang Fisika.']
    ];

    // Transformasi data artikel dari controller jika ada
    if (isset($artikels) && $artikels->count() > 0) {
        $postsData = $artikels->map(function($artikel) {
            return [
                'id' => $artikel->id,
                'slug' => $artikel->slug ?? \Str::slug($artikel->judul),
                'img' => $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'category' => $artikel->kategori ? $artikel->kategori->nama : 'Umum',
                'categoryColor' => $artikel->kategori ? $artikel->kategori->warna : 'blue',
                'date' => $artikel->created_at->format('d M Y'),
                'title' => $artikel->judul,
                'content' => \Str::limit(strip_tags($artikel->konten), 150)
            ];
        })->toArray();
    } else {
        $postsData = $fallbackData;
    }
@endphp

<!-- ===== Section Berita & Pengumuman Dimulai ===== -->
    <section class="py-16 md:py-24 relative" 
             x-data="{
                posts: {{ json_encode($postsData) }},
                currentPage: 1,
                itemsPerPage: 4,
                get totalPages() {
                    return Math.ceil(this.posts.length / this.itemsPerPage);
                },
                get paginatedPosts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.posts.slice(start, end);
                }
             }">
       
        <!-- Gradasi blur di atas agar transisi ke section hero lebih halus -->
        <div class="absolute top-0 left-0 w-full h-24 md:h-32 z-10 bg-gradient-to-b from-white/90 via-white/60 to-transparent pointer-events-none"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-12 lg:mb-16"
                 data-aos="fade-up"
                 data-aos-duration="800"
                 data-aos-delay="100"
                 data-aos-anchor-placement="top-bottom">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Berita & Pengumuman Terkini
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Ikuti informasi terbaru seputar kegiatan, prestasi, dan pengumuman dari sekolah kami.
                </p>
            </div>

            <!-- Blog Posts Container -->
            <div class="space-y-6">
                <template x-for="(post, index) in paginatedPosts" :key="post.id">
                    <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 ease-in-out overflow-hidden flex flex-col sm:flex-row sm:h-44"
                         :data-aos="index % 2 === 0 ? 'fade-right' : 'fade-left'"
                         :data-aos-duration="800"
                         :data-aos-delay="200 + (index * 150)"
                         data-aos-easing="ease-out-cubic"
                         data-aos-anchor-placement="top-bottom">
                        <!-- Image -->
                        <div class="h-48 sm:h-full sm:w-2/5 flex-shrink-0">
                            <img :src="post.img" :alt="post.title" class="w-full h-full object-cover">
                        </div>
                        <!-- Content -->
                        <div class="p-5 flex flex-col justify-between flex-grow sm:w-3/5">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full"
                                          :class="{
                                            'bg-blue-100 text-blue-800': post.categoryColor === 'blue',
                                            'bg-purple-100 text-purple-800': post.categoryColor === 'purple',
                                            'bg-amber-100 text-amber-800': post.categoryColor === 'amber'
                                          }"
                                          x-text="post.category"></span>
                                    <span class="text-xs text-gray-500" x-text="post.date"></span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-2" x-text="post.title"></h3>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-2" x-text="post.content"></p>
                            </div>
                            <div class="mt-3 text-right">
                                <!-- TOMBOL DIUBAH MENJADI LINK (tag <a>) -->
                                <a :href="'/blog/' + post.slug" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                    Baca Selengkapnya <span class="group-hover:ml-1 transition-all inline-block">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Pagination Controls -->
            <nav class="mt-12 flex items-center justify-center space-x-2" 
                 x-show="totalPages > 1">
                <!-- Previous Button -->
                <button @click="currentPage--" :disabled="currentPage === 1" class="p-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Page Numbers -->
                <template x-for="i in totalPages" :key="i">
                    <button @click="currentPage = i" :class="i === currentPage ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'" class="px-4 py-2 text-sm font-medium rounded-md transition-colors" x-text="i"></button>
                </template>

                <!-- Next Button -->
                <button @click="currentPage++" :disabled="currentPage === totalPages" class="p-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </nav>
        </div>
        <!-- Gradasi blur di bawah agar transisi ke footer lebih halus -->
        <div class="absolute bottom-0 left-0 w-full h-24 md:h-32 z-10 bg-gradient-to-t from-white/90 via-white/60 to-transparent pointer-events-none"></div>
    </section>