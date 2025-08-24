<section class="relative bg-slate-50 py-20 lg:py-24 overflow-hidden">
  <div class="absolute top-0 left-0 w-full h-20 md:h-24 bg-gradient-to-b from-slate-50/95 via-slate-50/70 to-transparent backdrop-blur-sm pointer-events-none z-20"></div>
  <div class="container mx-auto px-6 md:px-8 relative z-10">
    <div class="grid grid-cols-1 items-left gap-y-12 lg:grid-cols-12 lg:gap-x-12">
      <!-- Kolom Kiri -->
      <div class="text-left lg:text-left lg:col-span-5 lg:col-start-2">
        <div class="mb-6 flex h-24 w-24 items-center justify-center rounded-2xl bg-white shadow-md">
            <img src="https://placehold.co/100x100/0D63C6/FFFFFF?text=SMPN5" alt="Logo SMPN 5 Sangatta Utara" class="rounded-2xl">
        </div>
        <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">
          Komunitas Kami dalam Angka
        </h2>
        <p class="mt-4 text-base md:text-lg text-slate-600">
          Sebuah rekam jejak yang membanggakan, didukung oleh siswa, guru, dan alumni yang berdedikasi tinggi.
        </p>
      </div>

      <!-- Kolom Statistik -->
      <div class="grid grid-cols-2 gap-x-8 gap-y-10 lg:col-span-5">
        @php
            $icons = [
                ['color' => 'text-sky-600', 'svg' => '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />'],
                ['color' => 'text-indigo-600', 'svg' => '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />'],
                ['color' => 'text-emerald-600', 'svg' => '<path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />'],
                ['color' => 'text-rose-600', 'svg' => '<path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />'],
            ];
        @endphp

        @foreach($statistiks as $index => $stat)
          @php
              $icon = $icons[$index] ?? null;
          @endphp
          @if($icon)
          <div class="flex items-center gap-x-4"
               data-aos="zoom-in"
               data-aos-delay="{{ 150 * $loop->iteration }}"
               data-aos-duration="{{ 1000 + (200 * $loop->iteration) }}">
            <div class="flex-shrink-0 {{ $icon['color'] }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                {!! $icon['svg'] !!}
              </svg>
            </div>
            <div>
              <p class="text-4xl font-extrabold tracking-tight text-gray-900">{{ $stat->jumlah }}</p>
              <p class="mt-1 text-sm font-medium text-slate-500">{{ $stat->judul }}</p>
            </div>
          </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>

  <!-- Gradasi Blur Bawah -->
  <div class="absolute bottom-0 left-0 w-full h-20 md:h-24 bg-gradient-to-t from-slate-50/95 via-slate-50/70 to-transparent backdrop-blur-sm pointer-events-none z-20"></div>
</section>
