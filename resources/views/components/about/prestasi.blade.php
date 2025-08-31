@php
    use App\Models\SectionAkreditasi;
    use App\Models\PrestasiAbout;

    $akreditasi = SectionAkreditasi::where('aktif', true)->orderBy('urutan')->first();

    $judulSection = $akreditasi->judul_section ?? 'Prestasi & Akreditasi';
    $deskripsiAkreditasi = $akreditasi->deskripsi_akreditasi
        ?? 'SMP Negeri 5 Sangatta Utara telah meraih berbagai prestasi dan memiliki akreditasi yang menandakan kualitas pendidikan yang baik.';
    $gambarAkreditasi = $akreditasi && $akreditasi->gambar_akreditasi
        ? asset('storage/' . $akreditasi->gambar_akreditasi)
        : asset('assets/about/akreditas.png');

    $prestasiList = PrestasiAbout::query()
        ->active()
        ->ordered()
        ->when($akreditasi, function ($q) use ($akreditasi) {
            $q->where(function ($q) use ($akreditasi) {
                $q->where('section_akreditasi_id', $akreditasi->id)
                  ->orWhereNull('section_akreditasi_id');
            });
        })
        ->get();
@endphp

{{-- Alpine state modal (tetap) --}}
<section 
    x-data="{ 
        modalOpen: false, 
        modalImage: '', 
        modalTitle: '',
        modalDescription: '' 
    }" 
    @keydown.escape.window="modalOpen = false"
    class="relative overflow-hidden bg-slate-50 py-16 md:py-24">

    <div class="container mx-auto px-6 md:px-8">

        {{-- Header --}}
        <div class="max-w-3xl mx-auto text-center px-4 sm:px-6 mb-10 lg:mb-14">
            <img src="{{ $gambarAkreditasi }}" alt="Akreditasi" class="mx-auto h-auto w-40 sm:w-48 mb-5 sm:mb-6" data-aos="zoom-in"/>
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900 text-balance" data-aos="fade-up" data-aos-delay="50">
                {{ $judulSection }}
            </h2>
            <p class="mt-3 sm:mt-4 text-slate-700 text-sm sm:text-base leading-relaxed sm:leading-7 text-pretty max-w-[70ch] mx-auto" data-aos="fade-up" data-aos-delay="100">
                {{ $deskripsiAkreditasi }}
            </p>
        </div>

        {{-- Grid --}}
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 lg:gap-10">
                @forelse($prestasiList as $index => $prestasi)
                    {{-- Kartu Prestasi --}}
                    <div 
                        role="button" tabindex="0"
                        @click="
                            modalOpen = true; 
                            modalImage = '{{ asset('storage/' . $prestasi->gambar) }}'; 
                            modalTitle = '{{ addslashes($prestasi->judul) }}';
                            modalDescription = '{{ addslashes($prestasi->deskripsi) }}';
                        "
                        @keydown.enter.prevent="$el.click()"
                        @keydown.space.prevent="$el.click()"
                        class="bg-white rounded-2xl shadow-lg overflow-hidden group cursor-pointer transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="{{ 250 + ($index * 100) }}">
                        
                        <div class="relative overflow-hidden h-56 sm:h-60 md:h-64">
                            <img
                                src="{{ asset('storage/' . $prestasi->gambar) }}"
                                alt="{{ $prestasi->judul }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/about/smp_5-36.jpg') }}';"
                                loading="lazy" decoding="async"
                                class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent"></div>
                            <h3 class="absolute bottom-0 left-0 p-4 sm:p-5 text-lg sm:text-xl font-bold text-white leading-tight text-pretty line-clamp-2 w-full">
                                {{ $prestasi->judul }}
                            </h3>
                        </div>
                    </div>
                @empty
                    {{-- Fallback contoh bila kosong --}}
                    @for ($i = 0; $i < 2; $i++)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ 300 + ($i * 100) }}">
                            <div class="relative overflow-hidden h-56 sm:h-60 md:h-64">
                                <img src="{{ asset('assets/about/smp_5-3' . (6 + $i*3) . '.jpg') }}"
                                     class="w-full h-full object-cover" alt="Contoh Prestasi" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent"></div>
                                <h3 class="absolute bottom-0 left-0 p-4 sm:p-5 text-lg sm:text-xl font-bold text-white leading-tight text-pretty line-clamp-2 w-full">
                                    {{ $i == 0 ? 'Prestasi Akademik Siswa' : 'Juara Lomba Futsal' }}
                                </h3>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal --}}
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
            class="relative bg-white w-full max-w-3xl max-h-[90vh] rounded-xl shadow-2xl overflow-y-auto flex flex-col">

            <button @click="modalOpen = false" class="absolute top-3 right-3 text-white bg-black/40 rounded-full p-1.5 hover:bg-black/60 transition-colors z-10" aria-label="Tutup dialog">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <img :src="modalImage" :alt="modalTitle" class="w-full h-auto max-h-[70vh] object-contain flex-shrink-0">

            <div class="p-5 sm:p-6 text-center">
                <h3 x-text="modalTitle" class="text-lg sm:text-xl font-bold text-gray-900 mb-2 text-pretty"></h3>
                <p x-text="modalDescription" class="text-gray-700 text-sm sm:text-base leading-relaxed sm:leading-7 text-pretty max-w-[70ch] mx-auto"></p>
            </div>
        </div>
    </div>
</section>
