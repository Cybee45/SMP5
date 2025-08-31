@if($keunggulans->count() > 0)
<section
  x-data="{
    modalOpen: false,
    modalTitle: '',
    modalDesc: '',
    modalIconHtml: '',
  }"
  x-effect="document.body.style.overflow = modalOpen ? 'hidden' : ''"
  class="relative py-12 sm:py-16 lg:py-24 scroll-mt-24 md:scroll-mt-28"
  data-aos="fade-up"
  data-aos-duration="800"
  data-aos-easing="ease-out-cubic"
  data-aos-once="true"
  data-aos-anchor-placement="top-bottom">

  <div class="absolute top-0 left-0 z-20 h-20 md:h-24 w-full 
              bg-gradient-to-b from-white/90 via-white/60 to-transparent 
              backdrop-blur-sm pointer-events-none"></div>

  {{-- Tambah padding-top untuk mobile/tablet + padding-bottom KHUSUS mobile --}}
  <div class="px-4 sm:px-8 lg:px-12 pt-20 sm:pt-24 md:pt-28 lg:pt-0 pb-16 sm:pb-0">
    @php
      $sectionKeunggulan = \App\Models\SectionKeunggulan::where('aktif', true)->first();
    @endphp

    <!-- Header -->
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

    <!-- Grid Kartu (lebih rapat & 2 kolom di mobile supaya tidak jumbo) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8"
         data-aos="fade-up"
         data-aos-delay="80"
         data-aos-duration="700">

      @forelse($keunggulans as $index => $item)
        @php
          $bg = match($index % 4) {
            0 => 'from-blue-200 to-blue-100',
            1 => 'from-indigo-200 to-indigo-100',
            2 => 'from-green-200 to-green-100',
            default => 'from-red-200 to-red-100',
          };

          $icon = match($index % 4) {
            0 => '<svg class=&quot;h-10 w-10 text-blue-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot; fill=&quot;none&quot; viewBox=&quot;0 0 24 24&quot; stroke-width=&quot;1.5&quot; stroke=&quot;currentColor&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z&quot;/></svg>',
            1 => '<svg class=&quot;h-10 w-10 text-indigo-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot; fill=&quot;none&quot; viewBox=&quot;0 0 24 24&quot; stroke-width=&quot;1.5&quot; stroke=&quot;currentColor&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0l-.07.002z&quot;/></svg>',
            2 => '<svg class=&quot;h-10 w-10 text-green-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot; fill=&quot;none&quot; viewBox=&quot;0 0 24 24&quot; stroke-width=&quot;1.5&quot; stroke=&quot;currentColor&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21&quot;/></svg>',
            default => '<svg class=&quot;h-10 w-10 text-red-700 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:-rotate-3&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot; fill=&quot;none&quot; viewBox=&quot;0 0 24 24&quot; stroke-width=&quot;1.5&quot; stroke=&quot;currentColor&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z&quot;/></svg>',
          };
        @endphp

        <button
          type="button"
          @click="
            modalTitle = @js($item->judul);
            modalDesc  = @js($item->deskripsi);
            modalIconHtml = `<div class=&quot;flex items-center justify-center h-20 w-20 rounded-full ring-4 ring-white bg-gradient-to-br {{ $bg }} mx-auto mb-6&quot;>{!! $icon !!}</div>`;
            modalOpen = true;
          "
          class="group bg-white p-5 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl shadow-lg transition-all duration-500 ease-in-out
                 hover:shadow-2xl hover:-translate-y-2 flex flex-col items-center text-center cursor-pointer
                 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2">

          <div class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 lg:h-20 lg:w-20 mb-4 sm:mb-5
                      ring-4 ring-white rounded-full bg-gradient-to-br {{ $bg }}">
            {!! html_entity_decode($icon) !!}
          </div>

          <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900">{{ $item->judul }}</h3>
        </button>
      @empty
        <!-- kosong -->
      @endforelse

    </div>
  </div>

  <!-- Modal di-teleport ke <body> supaya backdrop benar2 full layar -->
  <template x-teleport="body">
    <div
      x-cloak
      x-show="modalOpen"
      @keydown.escape.window="modalOpen=false"
      @click.self="modalOpen=false"
      class="fixed inset-0 z-[9999] flex items-center justify-center p-4
             bg-white/10 backdrop-blur-md md:backdrop-blur-lg
             transition-opacity duration-200">

      <div
        x-show="modalOpen"
        x-transition.opacity
        x-transition.scale.origin.center
        class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl p-6 sm:p-8 text-center">

        <button
          @click="modalOpen=false"
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-800 transition-colors focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          <span class="sr-only">Tutup</span>
        </button>

        <div x-html="modalIconHtml"></div>

        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4" x-text="modalTitle"></h3>
        <p class="text-sm sm:text-base text-gray-600 leading-relaxed" x-text="modalDesc"></p>
      </div>
    </div>
  </template>

  <div class="absolute bottom-0 left-0 w-full h-20 md:h-24 bg-gradient-to-t from-slate-50/95 via-slate-50/70 to-transparent backdrop-blur-sm pointer-events-none z-20"></div>
</section>
@endif
