<!-- Media Section -->
    <section id="media" class="py-20 lg:py-24" x-data="{ modalOpen: false, modalImage: '', modalTitle: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Galeri Aktivitas Sekolah
                </h2>
                <p class="mt-4 max-w-3xl mx-auto text-lg text-gray-600">
                    Momen dan kegiatan berharga yang terekam di lingkungan SMP Negeri 5 Sangatta Utara.
                </p>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Data untuk setiap kartu -->
                <template x-for="item in [
                    { img: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop', title: 'Perkemahan Akbar', desc: 'Pramuka Penggalang' },
                    { img: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop', title: 'Juara 1 LKS Tingkat Kota', desc: 'Kompetensi Siswa 2024' },
                    { img: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop', title: 'Pentas Seni Tahunan', desc: 'Ekspresi Bakat Siswa' },
                    { img: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop', title: 'Final Cerdas Cermat', desc: 'Tingkat Provinsi' },
                    { img: 'https://images.unsplash.com/photo-1531482615713-2c65776cf0ce?q=80&w=2070&auto=format&fit=crop', title: 'Emas Olimpiade', desc: 'Sains Nasional' },
                    { img: 'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?q=80&w=1896&auto=format&fit=crop', title: 'Kegiatan Bakti Sosial', desc: 'Peduli Lingkungan Sekitar' }
                ]">
                    <!-- Gallery Card -->
                    <div @click="modalOpen = true; modalImage = item.img; modalTitle = item.title" 
                         class="group bg-white rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 ease-in-out cursor-pointer overflow-hidden flex flex-col">
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
        </div>

        <!-- Image Modal -->
        <div x-show="modalOpen" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-15" 
             style="display: none;">
            
            <!-- Modal Content -->
            <div @click.away="modalOpen = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col">
                <!-- Close Button -->
                <button @click="modalOpen = false" class="absolute -top-3 -right-3 z-10 bg-white rounded-full p-1 text-gray-600 hover:text-gray-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                
                <!-- Image -->
                <div class="p-4 flex-grow">
                    <img :src="modalImage" :alt="modalTitle" class="w-full h-full object-contain rounded-md">
                </div>
                
                <!-- Title Caption -->
                <div class="p-4 text-center bg-gray-50 rounded-b-lg">
                    <h3 class="text-lg font-semibold text-gray-800" x-text="modalTitle"></h3>
                </div>
            </div>
        </div>

    </section>