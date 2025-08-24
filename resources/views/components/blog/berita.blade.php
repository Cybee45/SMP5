@php
    use Illuminate\Support\Str;

    // --- Fallback data (kalau $artikels kosong) ---
    $fallbackData = [
        ['id' => 1, 'slug' => 'jadwal-dan-alur-pendaftaran-peserta-didik-baru-ppdb-2025', 'img' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'category' => 'Pengumuman', 'category_slug' => 'pengumuman', 'categoryColor' => 'blue', 'date' => '22 Juli 2025', 'title' => 'Jadwal dan Alur Pendaftaran Peserta Didik Baru (PPDB) 2025', 'content' => 'Berikut adalah jadwal lengkap dan alur pendaftaran untuk calon peserta didik baru tahun ajaran 2025/2026. Pastikan untuk membaca semua detail dengan saksama agar tidak ada informasi yang terlewat.'],
        ['id' => 2, 'slug' => 'kegiatan-studi-tur-edukatif-ke-museum-nasional', 'img' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2232&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'category' => 'Kegiatan', 'category_slug' => 'kegiatan', 'categoryColor' => 'purple', 'date' => '18 Juli 2025', 'title' => 'Kegiatan Studi Tur Edukatif ke Museum Nasional', 'content' => 'Siswa-siswi kelas VIII telah berhasil melaksanakan studi tur yang sangat bermanfaat ke Museum Nasional. Mereka belajar banyak tentang sejarah dan warisan budaya bangsa.'],
        ['id' => 3, 'slug' => 'siswa-raih-medali-emas-di-olimpiade-sains-tingkat-nasional', 'img' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop', 'category' => 'Prestasi', 'category_slug' => 'prestasi', 'categoryColor' => 'amber', 'date' => '15 Juli 2025', 'title' => 'Siswa Raih Medali Emas di Olimpiade Sains Tingkat Nasional', 'content' => 'Selamat kepada ananda Budi Hartono dari kelas IX-A yang berhasil membawa pulang medali emas dalam ajang Olimpiade Sains Nasional (OSN) bidang Fisika.']
    ];

    // --- Transformasi data dari controller (kalau ada) ---
    if (isset($artikels) && $artikels->count() > 0) {
        $postsData = $artikels->map(function($artikel) {
            $kategoriNama = $artikel->kategori ? $artikel->kategori->nama : 'Umum';

            // Normalisasi gambar: izinkan URL penuh, atau storage
            $raw = $artikel->gambar;
            if ($raw && (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://'))) {
                $img = $raw;
            } elseif ($raw) {
                $clean = ltrim(preg_replace('#^(public/|storage/)+#', '', trim($raw)), '/');
                $img = asset('storage/' . $clean);
            } else {
                $img = 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop';
            }

            return [
                'id'            => $artikel->id,
                'slug'          => $artikel->slug ?? Str::slug($artikel->judul),
                'img'           => $img,
                'category'      => $kategoriNama,
                'category_slug' => Str::slug($kategoriNama),
                'categoryColor' => $artikel->kategori->warna ?? 'blue',
                'date'          => $artikel->created_at?->format('d M Y') ?? now()->format('d M Y'),
                'title'         => $artikel->judul,
                'content'       => Str::limit(strip_tags($artikel->konten), 150),
            ];
        })->toArray();
    } else {
        $postsData = $fallbackData;
    }

    // Daftar kategori dinamis
    $kategoriList = collect($postsData)
        ->map(fn($p) => ['label' => $p['category'], 'slug' => $p['category_slug']])
        ->unique('slug')
        ->values()
        ->all();
@endphp

<!-- ===== Section Berita & Pengumuman (desain baru + fitur lengkap) ===== -->
<section class="bg-slate-50 py-16 md:py-24 relative"
    x-data="{
        allPosts: {{ json_encode($postsData) }},
        kategoriList: {{ json_encode($kategoriList) }},
        activeCategory: 'all',
        dropdownOpen: false,
        currentPage: 1,
        itemsPerPage: 6,

        get activeCategoryLabel() {
            if (this.activeCategory === 'all') return 'Semua Kategori';
            const c = this.kategoriList.find(k => k.slug === this.activeCategory);
            return c ? c.label : 'Semua Kategori';
        },
        get filteredPosts() {
            if (this.activeCategory === 'all') return this.allPosts;
            return this.allPosts.filter(post => post.category_slug === this.activeCategory);
        },
        get totalPages() {
            return Math.ceil(this.filteredPosts.length / this.itemsPerPage) || 1;
        },
        get paginatedPosts() {
            if (this.currentPage > this.totalPages) this.currentPage = 1;
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredPosts.slice(start, start + this.itemsPerPage);
        },
        changeCategory(slug) {
            this.activeCategory = slug;
            this.currentPage = 1;
            this.dropdownOpen = false;
        }
    }"
>
    <!-- Gradasi halus di atas (opsional) -->
    <div class="absolute top-0 left-0 w-full h-20 md:h-24 bg-gradient-to-b from-white/95 via-white/70 to-transparent backdrop-blur-sm pointer-events-none z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        <!-- Header -->
        <div class="text-center mb-12 lg:mb-16" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold font-heading text-gray-900 tracking-tight">
                Berita & Pengumuman Terkini
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-600">
                Ikuti informasi terbaru seputar kegiatan, prestasi, dan pengumuman dari sekolah kami.
            </p>
        </div>

        <!-- Filter: dropdown mobile + pills desktop -->
        <div class="mb-10 relative z-40" data-aos="fade-up" data-aos-delay="100">
            <!-- Mobile: Dropdown -->
            <div class="md:hidden">
                <div class="relative w-full max-w-xs mx-auto" @click.outside="dropdownOpen = false">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg bg-white text-slate-700 font-semibold shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span x-text="activeCategoryLabel"></span>
                        <svg class="h-5 w-5 text-slate-400 transition-transform duration-300"
                             :class="{'rotate-180': dropdownOpen}" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition
                         class="absolute z-50 mt-1 w-full bg-white shadow-lg rounded-md p-1"
                         style="display:none;">
                        <a @click="changeCategory('all')"
                           class="block w-full text-left px-3 py-2 rounded-md text-sm font-medium cursor-pointer"
                           :class="activeCategory === 'all' ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-indigo-50 hover:text-indigo-600'">
                           Semua Kategori
                        </a>
                        <template x-for="kat in kategoriList" :key="kat.slug">
                            <a @click="changeCategory(kat.slug)"
                               class="block w-full text-left px-3 py-2 rounded-md text-sm font-medium cursor-pointer"
                               :class="activeCategory === kat.slug ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-indigo-50 hover:text-indigo-600'">
                               <span x-text="kat.label"></span>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Desktop: Pills -->
            <div class="hidden md:flex items-center justify-center flex-wrap gap-3 mt-4 md:mt-0">
                <button @click="changeCategory('all')"
                        :class="activeCategory === 'all' ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-indigo-50'"
                        class="px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                    Semua
                </button>
                <template x-for="kat in kategoriList" :key="kat.slug">
                    <button @click="changeCategory(kat.slug)"
                            :class="activeCategory === kat.slug ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-indigo-50'"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                        <span x-text="kat.label"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Grid Post (DESAIN BARU: card vertikal, gambar 16:9) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="(post, index) in paginatedPosts" :key="post.id">
                <article class="group flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out overflow-hidden"
                         data-aos="fade-up" :data-aos-delay="100 + (index * 100)">
                    <!-- Image -->
                    <div class="relative overflow-hidden">
                        <a :href="'/blog/' + post.slug" class="block aspect-w-16 aspect-h-9">
                            <img :src="post.img"
                                 :alt="post.title"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2232&auto=format&fit=crop';"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </a>
                    </div>
                    <!-- Content -->
                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full" x-text="post.category"></span>
                                <span class="text-xs text-gray-500" x-text="post.date"></span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 line-clamp-2 mb-2">
                                <a :href="'/blog/' + post.slug" class="hover:text-indigo-600 transition-colors" x-text="post.title"></a>
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-3" x-text="post.content"></p>
                        </div>
                        <div class="mt-4">
                            <a :href="'/blog/' + post.slug" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors group-hover:underline">
                                Baca Selengkapnya <span class="inline-block transition-transform group-hover:translate-x-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </article>
            </template>

            <!-- Tidak ada hasil -->
            <template x-if="paginatedPosts.length === 0">
                <div class="text-center py-12 md:col-span-2 lg:col-span-3">
                    <p class="text-gray-500">Tidak ada berita yang ditemukan untuk kategori ini.</p>
                </div>
            </template>
        </div>

        <!-- Pagination -->
        <nav class="mt-12 flex items-center justify-center gap-2" x-show="totalPages > 1">
            <button @click="currentPage--" :disabled="currentPage === 1"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
            </button>
            <template x-for="p in totalPages" :key="p">
                <button @click="currentPage = p"
                        :class="p === currentPage ? 'bg-indigo-600 text-white' : 'border bg-white text-gray-700 hover:bg-gray-100'"
                        class="w-10 h-10 rounded-lg text-sm font-medium transition">
                    <span x-text="p"></span>
                </button>
            </template>
            <button @click="currentPage++" :disabled="currentPage === totalPages"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
            </button>
        </nav>
    </div>

    <!-- Gradasi halus di bawah (opsional) -->
    <div class="absolute bottom-0 left-0 w-full h-20 md:h-24 bg-gradient-to-t from-white/90 via-white/60 to-transparent pointer-events-none z-10"></div>
</section>
