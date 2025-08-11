<section class="py-20 lg:py-24 bg-slate-50">
    <div class="container mx-auto px-6 md:px-8">
        
        <!-- Judul Section dari SectionKeunggulan -->
        @php
            $sectionKeunggulan = \App\Models\SectionKeunggulan::where('aktif', true)->first();
        @endphp

        @if($sectionKeunggulan)
        <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16"
            data-aos="fade-up"
            data-aos-duration="900"
            data-aos-delay="100">
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">
                {{ $sectionKeunggulan->judul_section }}
            </h2>
            <p class="mt-4 text-base md:text-lg text-slate-600">
                {{ $sectionKeunggulan->deskripsi_section }}
            </p>
        </div>
        @endif

        
        <!-- Grid untuk Kartu Keunggulan dari data individual -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($keunggulans as $index => $item)
            <div 
                class="bg-white rounded-xl shadow-lg p-6 lg:p-8 text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                data-aos="zoom-in"
                data-aos-delay="{{ 100 + ($index * 150) }}"
                data-aos-duration="700"
            >
                {{-- Icon statis berdasarkan urutan untuk konsistensi tampilan client --}}
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full 
                    @switch($index)
                        @case(0) bg-sky-100 @break
                        @case(1) bg-indigo-100 @break
                        @case(2) bg-emerald-100 @break
                        @case(3) bg-rose-100 @break
                        @default bg-gray-100
                    @endswitch">
                    @switch($index)
                        @case(0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @break
                        @case(1)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                            @break
                        @case(2)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            @break
                        @case(3)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            @break
                        @default
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                    @endswitch
                </div>

                <h3 class="font-bold text-lg mb-2 text-gray-900">{{ $item->judul }}</h3>
                <p class="text-sm text-slate-600">{{ $item->deskripsi }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
