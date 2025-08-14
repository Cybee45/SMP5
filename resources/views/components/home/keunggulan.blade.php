@if($keunggulans->count() > 0)
<section class="py-12 sm:py-16 lg:py-24"
         data-aos="fade-up"
         data-aos-duration="800"
         data-aos-easing="ease-out-cubic"
         data-aos-once="true"
         data-aos-anchor-placement="top-bottom">
  <div class="px-4 sm:px-8 lg:px-12">
    
    <!-- Judul Section dari SectionKeunggulan atau fallback -->
    @php
        $sectionKeunggulan = \App\Models\SectionKeunggulan::where('aktif', true)->first();
    @endphp

    <div class="text-center mb-10 sm:mb-16"
         data-aos="fade-up"
         data-aos-delay="50"
         data-aos-duration="800">
      <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
        {{ $sectionKeunggulan->judul_section ?? 'Mengapa Memilih SMP 5 Sangatta Utara?' }}
      </h2>
      <p class="mt-4 max-w-2xl mx-auto text-base leading-relaxed text-gray-600 sm:text-lg">
        {{ $sectionKeunggulan->deskripsi_section ?? 'Kami berkomitmen untuk menyediakan lingkungan belajar yang inspiratif dengan standar kualitas yang terjamin di setiap aspek.' }}
      </p>
    </div>

    <!-- Grid untuk Kartu Keunggulan dari data CMS -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 sm:gap-8"
         data-aos="fade-up"
         data-aos-delay="80"
         data-aos-duration="700">

      @forelse($keunggulans as $index => $item)
      <div class="group bg-white p-8 rounded-3xl shadow-lg transition-all duration-500 ease-in-out hover:shadow-2xl hover:-translate-y-2 flex flex-col items-center text-center will-change-transform transform-gpu"
           data-aos="zoom-in"
           data-aos-delay="{{ 120 + ($index * 60) }}"
           data-aos-duration="650">
        
        <!-- Icon berdasarkan urutan dengan gradient yang berbeda -->
        <div class="flex items-center justify-center h-20 w-20 rounded-full mb-6 ring-4 ring-white
            @switch($index % 4)
                @case(0) bg-gradient-to-br from-blue-200 to-blue-100 @break
                @case(1) bg-gradient-to-br from-indigo-200 to-indigo-100 @break
                @case(2) bg-gradient-to-br from-green-200 to-green-100 @break
                @case(3) bg-gradient-to-br from-red-200 to-red-100 @break
            @endswitch">
          
          @switch($index % 4)
            @case(0)
              <svg class="h-10 w-10 text-blue-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:rotate-[-12deg]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              @break
              
            @case(1)
              <svg class="h-10 w-10 text-indigo-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:rotate-[-12deg]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0l-.07.002z" />
              </svg>
              @break
              
            @case(2)
              <svg class="h-10 w-10 text-green-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:rotate-[-12deg]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
              </svg>
              @break
              
            @case(3)
              <svg class="h-10 w-10 text-red-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:rotate-[-12deg]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
              </svg>
              @break
          @endswitch
        </div>
        
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->judul }}</h3>
          <p class="text-base text-gray-600">{{ $item->deskripsi }}</p>
        </div>
      </div>
      @empty
      <!-- Tidak ada konten yang ditampilkan jika tidak ada keunggulan aktif -->
      @endforelse

    </div>
  </div>
</section>
@endif
