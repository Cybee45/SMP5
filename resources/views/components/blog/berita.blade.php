<section id="blog" class="py-20 lg:py-24" 
             x-data="{
                posts: [
                    { img: 'http://googleusercontent.com/file_content/1', category: 'Pengumuman', categoryColor: 'sky', date: '22 Juli 2025', title: 'Jadwal dan Alur Pendaftaran Peserta Didik Baru (PPDB) 2025', content: 'Berikut adalah jadwal lengkap dan alur pendaftaran untuk calon peserta didik baru tahun ajaran 2025/2026. Pastikan untuk membaca semua detail dengan saksama agar tidak ada informasi yang terlewat. Pendaftaran dibuka mulai tanggal 1 Agustus 2025.' },
                    { img: 'http://googleusercontent.com/file_content/2', category: 'Kegiatan', categoryColor: 'purple', date: '18 Juli 2025', title: 'Kegiatan Studi Tur Edukatif ke Museum Nasional', content: 'Siswa-siswi kelas VIII telah berhasil melaksanakan studi tur yang sangat bermanfaat ke Museum Nasional. Mereka belajar banyak tentang sejarah dan warisan budaya bangsa. Kegiatan ini bertujuan untuk meningkatkan wawasan kebangsaan para siswa.' },
                    { img: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop', category: 'Prestasi', categoryColor: 'amber', date: '15 Juli 2025', title: 'Siswa Raih Medali Emas di Olimpiade Sains Tingkat Nasional', content: 'Selamat kepada ananda Budi Hartono dari kelas IX-A yang berhasil membawa pulang medali emas dalam ajang Olimpiade Sains Nasional (OSN) bidang Fisika. Prestasi ini membanggakan nama sekolah di kancah nasional.' },
                    { img: 'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?q=80&w=1896&auto=format&fit=crop', category: 'Kegiatan', categoryColor: 'purple', date: '10 Juli 2025', title: 'Bakti Sosial dan Penanaman Pohon di Lingkungan Sekolah', content: 'Dalam rangka memperingati Hari Lingkungan Hidup, OSIS SMPN 5 Sangatta Utara mengadakan kegiatan bakti sosial dan penanaman 100 pohon di sekitar area sekolah untuk menciptakan lingkungan yang lebih hijau dan asri.' },
                    { img: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop', category: 'Pengumuman', categoryColor: 'sky', date: '05 Juli 2025', title: 'Informasi Pembagian Rapor Semester Genap', content: 'Diberitahukan kepada seluruh orang tua/wali murid bahwa pembagian rapor semester genap akan dilaksanakan pada hari Sabtu, 12 Juli 2025. Kehadiran orang tua/wali sangat diharapkan untuk berdiskusi mengenai perkembangan siswa.' },
                    { img: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop', category: 'Prestasi', categoryColor: 'amber', date: '01 Juli 2025', title: 'Tim Robotik Sekolah Juarai Kompetisi Tingkat Regional', content: 'Tim robotik kebanggaan kita, \'Robo-5\', berhasil meraih Juara Umum dalam kompetisi robotik tingkat regional yang diadakan di Balikpapan. Mereka akan mewakili Kalimantan Timur di tingkat nasional.' },
                    { img: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop', category: 'Kegiatan', categoryColor: 'purple', date: '28 Juni 2025', title: 'Seminar Motivasi Menghadapi Ujian Akhir Sekolah', content: 'Sekolah mengadakan seminar motivasi dengan menghadirkan motivator ternama untuk memberikan semangat dan strategi belajar kepada siswa-siswi kelas IX dalam menghadapi Ujian Akhir Sekolah (UAS).' },
                    { img: 'https://images.unsplash.com/photo-1531482615713-2c65776cf0ce?q=80&w=2070&auto=format&fit=crop', category: 'Pengumuman', categoryColor: 'sky', date: '25 Juni 2025', title: 'Jadwal Ujian Akhir Sekolah (UAS) Telah Dirilis', content: 'Berikut adalah jadwal resmi Ujian Akhir Sekolah (UAS) untuk kelas IX. Para siswa diharapkan untuk mempersiapkan diri dengan baik dan menjaga kesehatan selama periode ujian berlangsung.' }
                ],
                currentPage: 1,
                itemsPerPage: 4,
                modalOpen: false,
                modalData: {},
                get totalPages() {
                    return Math.ceil(this.posts.length / this.itemsPerPage);
                },
                get paginatedPosts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.posts.slice(start, end);
                },
                openModal(post) {
                    this.modalData = post;
                    this.modalOpen = true;
                }
             }">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
                <!-- Section Header -->
                <div class="text-center mb-12 lg:mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                        Berita & Pengumuman Terkini
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                        Ikuti informasi terbaru seputar kegiatan, prestasi, dan pengumuman dari sekolah kami.
                    </p>
                </div>

                <!-- Blog Posts Container -->
                <div class="space-y-6">
                    <template x-for="post in paginatedPosts" :key="post.title">
                        <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 ease-in-out overflow-hidden flex flex-col sm:flex-row sm:h-44">
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
                                                'bg-sky-100 text-sky-800': post.categoryColor === 'sky',
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
                                    <button @click="openModal(post)" class="text-sm font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                                        Baca Selengkapnya <span class="group-hover:ml-1 transition-all inline-block">&rarr;</span>
                                    </button>
                                </div>
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

            <!-- Detail Modal -->
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75" style="display: none;">
                <div @click.away="modalOpen = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                    <button @click="modalOpen = false" class="absolute -top-3 -right-3 z-20 bg-white rounded-full p-1 text-gray-600 hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    <div class="overflow-y-auto">
                        <img :src="modalData.img" :alt="modalData.title" class="w-full h-64 object-cover rounded-t-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full"
                                      :class="{
                                        'bg-sky-100 text-sky-800': modalData.categoryColor === 'sky',
                                        'bg-purple-100 text-purple-800': modalData.categoryColor === 'purple',
                                        'bg-amber-100 text-amber-800': modalData.categoryColor === 'amber'
                                      }"
                                      x-text="modalData.category"></span>
                                <span class="text-xs text-gray-500" x-text="modalData.date"></span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4" x-text="modalData.title"></h3>
                            <p class="text-gray-700 leading-relaxed" x-text="modalData.content"></p>
                        </div>
                    </div>
                </div>
            </div>

        </section>
