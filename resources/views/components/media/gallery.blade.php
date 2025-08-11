<!-- Media Section -->
    <section id="media" class="relative py-20 lg:py-24 overflow-hidden" 
             x-data="{ 
                modalOpen: false, 
                modalImage: '', 
                modalTitle: '',
                currentPage: 1,
                itemsPerPage: 6,
                items: [
                    { img: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop', title: 'Perkemahan Akbar', desc: 'Pramuka Penggalang' },
                    { img: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop', title: 'Juara 1 LKS Tingkat Kota', desc: 'Kompetensi Siswa 2024' },
                    { img: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop', title: 'Pentas Seni Tahunan', desc: 'Ekspresi Bakat Siswa' },
                    { img: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop', title: 'Final Cerdas Cermat', desc: 'Tingkat Provinsi' },
                    { img: 'https://images.unsplash.com/photo-1531482615713-2c65776cf0ce?q=80&w=2070&auto=format&fit=crop', title: 'Emas Olimpiade', desc: 'Sains Nasional' },
                    { img: 'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?q=80&w=1896&auto=format&fit=crop', title: 'Kegiatan Bakti Sosial', desc: 'Peduli Lingkungan Sekitar' },
                    { img: 'https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?q=80&w=2070&auto=format&fit=crop', title: 'Workshop Kewirausahaan', desc: 'Mencetak Generasi Kreatif' },
                    { img: 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop', title: 'Pelatihan Kepemimpinan OSIS', desc: 'Membangun Jiwa Pemimpin' }
                ],
                get totalPages() {
                    return Math.ceil(this.items.length / this.itemsPerPage);
                },
                get paginatedItems() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.items.slice(start, end);
                }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-12 lg:mb-16"
                 data-aos="fade-up"
                 data-aos-duration="600"
                 data-aos-anchor-placement="top-bottom">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Galeri Aktivitas Sekolah
                </h2>
                <p class="mt-4 max-w-3xl mx-auto text-lg text-gray-600">
                    Momen dan kegiatan berharga yang terekam di lingkungan SMP Negeri 5 Sangatta Utara.
                </p>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                 data-aos="fade-up"
                 data-aos-duration="800"
                 data-aos-delay="200"
                 data-aos-anchor-placement="top-bottom">
                <template x-for="(item, index) in paginatedItems" :key="item.title">
                    <!-- Gallery Card -->
                    <div @click="modalOpen = true; modalImage = item.img; modalTitle = item.title" 
                         class="group bg-white rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 ease-in-out cursor-pointer overflow-hidden flex flex-col"
                         :data-aos="'fade-in'"
                         :data-aos-duration="800"
                         :data-aos-delay="index * 200 + 400"
                         :data-aos-anchor-placement="'top-bottom'"
                         :data-aos-easing="'ease-out-cubic'">
                        <!-- Image Container -->
                        <div class="aspect-w-16 aspect-h-9">
                            <img :src="item.img" :alt="item.title" class="group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <!-- Text Content -->
                        <div class="p-5 flex-grow">
                            <h3 class="text-lg font-bold text-gray-900" x-text="item.title"></h3>
                            <p class="mt-1 text-sm text-gray-600" x-text="item.desc"></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Pagination Controls -->
            <nav class="mt-12 flex items-center justify-center space-x-2" x-show="totalPages > 1">
                <!-- Previous Button -->
                <button @click="currentPage--" :disabled="currentPage === 1" class="p-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Page Numbers -->
                <template x-for="i in totalPages" :key="i">
                    <button @click="currentPage = i" :class="i === currentPage ? 'bg-sky-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-4 py-2 text-sm font-medium rounded-md transition-colors"><span x-text="i"></span></button>
                </template>

                <!-- Next Button -->
                <button @click="currentPage++" :disabled="currentPage === totalPages" class="p-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </nav>

        </div>

        <!-- Image Modal -->    
        <div x-show="modalOpen" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-100" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-100" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm md:backdrop-blur bg-opacity-60" 
             style="display: none;">
            
            <!-- Modal Container -->
            <div class="relative" @click.away="modalOpen = false">
                <!-- Close Button -->
                <button @click="modalOpen = false" class="absolute -top-2 -right-2 z-10 bg-gray-800 text-white h-8 w-8 rounded-full flex items-center justify-center hover:bg-gray-900 transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                
                <!-- Modal Content -->
                <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden">
                    <!-- Image Container -->
                    <div class="flex-grow overflow-hidden flex items-center justify-center h-full w-full">
                        <img :src="modalImage" :alt="modalTitle" class="max-w-full max-h-[60vh] w-auto h-auto object-contain rounded-md" style="object-fit:contain;">
                    </div>
                    
                    <!-- Title Caption -->
                    <div class="p-4 text-center bg-gray-50 rounded-b-lg flex-shrink-0">
                        <h3 class="text-lg font-semibold text-gray-800" x-text="modalTitle"></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom gradient overlay -->
        <div class="absolute bottom-0 left-0 right-0 h-20 sm:h-24 lg:h-32 bg-gradient-to-t from-white via-white/85 via-white/60 via-white/30 to-transparent pointer-events-none z-10"></div>
    </section>
