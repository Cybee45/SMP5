@php
    use Illuminate\Support\Str;

    $mediaGaleris = \App\Models\Galeri::query()
        ->when(function ($q) { return $q->where('aktif', true); })
        ->with('kategoriRef')
        ->orderBy('urutan')->orderByDesc('created_at')
        ->get();

    $galeriData = $mediaGaleris->map(function ($g) {
        $label = optional($g->kategoriRef)->nama ?: ($g->kategori ?: 'Umum');
        $slug  = Str::slug(Str::lower(trim($label)));

        // Normalisasi URL gambar (boleh URL penuh atau path storage)
        $raw = $g->gambar;
        if ($raw && (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://'))) {
            $url = $raw;
        } elseif ($raw) {
            $clean = ltrim(preg_replace('#^(public/|storage/)+#', '', trim($raw)), '/');
            $url = asset('storage/' . $clean);
        } else {
            $url = null;
        }

        return [
            'img'            => $url,
            'title'          => $g->judul ?? 'Tanpa Judul',
            'desc'           => $g->deskripsi ?? ucfirst($label),
            'kategori_label' => $label,
            'kategori_slug'  => $slug ?: 'umum',
        ];
    });

    $fallbackData = [
        ['img'=>asset('assets/galery/smp_5-11.jpg'),'title'=>'Perkemahan Akbar','desc'=>'Pramuka Penggalang','kategori_label'=>'Pramuka','kategori_slug'=>'pramuka'],
        ['img'=>asset('assets/galery/smp_5-12.jpg'),'title'=>'Pentas Seni Tahunan','desc'=>'Ekspresi Bakat Siswa','kategori_label'=>'Seni','kategori_slug'=>'seni'],
        ['img'=>asset('assets/galery/smp_5-15.jpg'),'title'=>'Studi Banding ke Jakarta','desc'=>'Wawasan Industri 4.0','kategori_label'=>'Kunjungan','kategori_slug'=>'kunjungan'],
        ['img'=>asset('assets/galery/smp_5-40.jpg'),'title'=>'Medali Emas Olimpiade','desc'=>'Olimpiade Sains Nasional','kategori_label'=>'Prestasi','kategori_slug'=>'prestasi'],
        ['img'=>asset('assets/galery/smp_5-10.jpg'),'title'=>'Juara 1 Lomba Paskibra','desc'=>'Tingkat Kabupaten','kategori_label'=>'Prestasi','kategori_slug'=>'prestasi'],
        ['img'=>asset('assets/galery/smp_5-38.jpg'),'title'=>'Final Cerdas Cermat','desc'=>'Tingkat Provinsi','kategori_label'=>'Akademik','kategori_slug'=>'akademik'],
    ];

    $items = $galeriData->count() ? $galeriData->toArray() : $fallbackData;

    $kategoriList = collect($items)
        ->map(fn($i) => ['label' => $i['kategori_label'], 'slug' => $i['kategori_slug']])
        ->unique('slug')
        ->values()
        ->all();
@endphp

<section id="media" class="relative py-20 lg:py-24 bg-slate-50 overflow-visible"
    x-data="{
        allItems: {{ json_encode($items) }},
        kategoriList: {{ json_encode($kategoriList) }},
        activeCategory: 'all',
        currentPage: 1,
        itemsPerPage: 9,

        // Modal
        modalOpen: false,
        modalImage: '',
        modalTitle: '',
        modalDescription: '',

        // Dropdown (mobile)
        dropdownOpen: false,

        // Label kategori aktif (biar sama kayak section berita)
        get activeCategoryLabel() {
            if (this.activeCategory === 'all') return 'Semua Kategori';
            const c = this.kategoriList.find(k => k.slug === this.activeCategory);
            return c ? c.label : 'Semua Kategori';
        },

        get filteredItems() {
            if (this.activeCategory === 'all') return this.allItems;
            return this.allItems.filter(item => item.kategori_slug === this.activeCategory);
        },
        get totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage) || 1;
        },
        get paginatedItems() {
            if (this.currentPage > this.totalPages) this.currentPage = 1;
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredItems.slice(start, start + this.itemsPerPage);
        },
        changeCategory(slug) {
            this.activeCategory = slug;
            this.currentPage = 1;
            this.dropdownOpen = false; // tutup dropdown setelah pilih
        },
        openModal(item) {
            this.modalImage = item.img || '{{ asset('assets/galery/smp_5-12.jpg') }}';
            this.modalTitle = item.title;
            this.modalDescription = item.desc;
            this.modalOpen = true;
        }
    }"
    @keydown.escape.window="modalOpen = false">

    <!-- Gradasi Blur Atas -->
    <div class="absolute top-0 left-0 w-full h-20 md:h-24 
                bg-gradient-to-b from-white/95 via-white/70 to-transparent 
                backdrop-blur-sm pointer-events-none z-20"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold font-heading text-gray-900 tracking-tight">Galeri Aktivitas Sekolah</h2>
            <p class="mt-4 max-w-3xl mx-auto text-lg text-slate-600">
                Momen dan kegiatan berharga yang terekam di lingkungan SMP Negeri 5 Sangatta Utara.
            </p>
        </div>

        <!-- FILTER (Desktop pills + Mobile dropdown dengan efek sama seperti section berita) -->
        <div class="mb-10 flex flex-col items-center gap-4 relative z-40" data-aos="fade-up" data-aos-delay="100">
            <!-- Desktop: pills -->
            <div class="hidden sm:flex items-center justify-center flex-wrap gap-3">
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

            <!-- Mobile: dropdown (efek & gaya disamakan) -->
            <div class="sm:hidden relative w-full max-w-xs z-50" @click.outside="dropdownOpen = false">
                <button @click="dropdownOpen = !dropdownOpen"
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg bg-white text-slate-700 font-semibold shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span x-text="activeCategoryLabel"></span>
                    <svg class="h-5 w-5 text-slate-400 transition-transform duration-300"
                         :class="{'rotate-180': dropdownOpen}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="dropdownOpen"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute mt-1 w-full bg-white shadow-lg rounded-md p-1 z-[9999]"
                     style="display: none;">
                    <div class="max-h-60 overflow-y-auto">
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
        </div>

        <!-- Grid Galeri -->
        <div id="gallery-grid" class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="(item, index) in paginatedItems" :key="(item.img || 'fallback') + index">
                <div
                    @click="openModal(item)"
                    class="relative z-0 aspect-[4/5] bg-gray-200 rounded-2xl shadow-lg overflow-hidden group cursor-pointer transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
                    data-aos="fade-up"
                    :data-aos-delay="100 + (index * 50)">

                    <img :src="item.img || '{{ asset('assets/galery/smp_5-12.jpg') }}'"
                         :alt="item.title"
                         onerror="this.onerror=null;this.src='{{ asset('assets/galery/smp_5-12.jpg') }}';"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110"
                         loading="lazy">

                    <!-- Overlay hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                        <h3 class="text-white font-bold text-lg leading-tight line-clamp-2" x-text="item.title"></h3>
                    </div>
                </div>
            </template>

            <template x-if="paginatedItems.length === 0">
                <div class="text-center py-12 sm:col-span-2 lg:col-span-3">
                    <p class="text-gray-500">Tidak ada galeri yang ditemukan untuk kategori ini.</p>
                </div>
            </template>
        </div>

        <!-- Paginasi -->
        <nav x-show="totalPages > 1" class="mt-12 flex items-center justify-center gap-2" aria-label="Pagination">
            <button @click="currentPage--" :disabled="currentPage === 1"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition">
                ‹
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
                ›
            </button>
        </nav>
    </div>

    <!-- Modal -->
    <div x-show="modalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">

        <div @click="modalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div x-show="modalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="relative bg-white w-auto max-w-3xl max-h-[90vh] rounded-xl shadow-2xl overflow-y-auto flex flex-col">

            <button @click="modalOpen = false" class="absolute top-3 right-3 text-white bg-black/40 rounded-full p-1.5 hover:bg-black/60 transition-colors z-10">✕</button>

            <img :src="modalImage" :alt="modalTitle" class="w-full h-auto max-h-[75vh] object-contain flex-shrink-0">

            <div class="p-6 text-center">
                <h3 x-text="modalTitle" class="text-xl font-bold text-gray-900 mb-2"></h3>
                <p x-text="modalDescription" class="text-gray-600"></p>
            </div>
        </div>
    </div>

    <!-- Gradasi Blur Bawah -->
    <div class="absolute bottom-0 left-0 w-full h-20 md:h-24 
                bg-gradient-to-t from-white/95 via-white/70 to-transparent 
                backdrop-blur-sm pointer-events-none z-20"></div>
</section>
