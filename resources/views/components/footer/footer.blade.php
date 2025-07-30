  {{-- resources/views/components/footer/footer.blade.php --}}
  <footer class="bg-white py-5">
    <div class="container mx-auto px-6 md:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Menu --}}
        <div>
          <h3 class="text-lg font-semibold text-[var(--color-brand-dark)] mb-4">Menu</h3>
          <ul class="space-y-2">
            <li>
              <a href="{{ route('about') }}"
                class="text-slate-700 hover:text-[var(--color-brand)] transition">
                Tentang Sekolah
              </a>
            </li>
            <li>
              <a href="{{ route('prestasi') ?? '#' }}"
                class="text-slate-700 hover:text-[var(--color-brand)] transition">
                Program & Prestasi
              </a>
            </li>
            <li>
              <a href="{{ route('spmb') }}"
                class="text-slate-700 hover:text-[var(--color-brand)] transition">
                SPMB Online
              </a>
            </li>
            <li>
              <a href="{{ route('contact') }}"
                class="text-slate-700 hover:text-[var(--color-brand)] transition">
                Hubungi Kami
              </a>
            </li>
          </ul>
        </div>

        {{-- Kontak --}}
        <div>
          <h3 class="text-lg font-semibold text-[var(--color-brand-dark)] mb-4">Kontak</h3>
          <ul class="space-y-3 text-slate-700">
            <li class="flex items-start">
              <span class="mr-2 text-[var(--color-brand)]">📍</span>
              <span>
                Jalan Pendidikan No. 15, Sangatta Utara, Kutai Timur, Kalimantan Timur
              </span>
            </li>
            <li class="flex items-center">
              <span class="mr-2 text-[var(--color-brand)]">📞</span>
              <span>(+62) 812-3456-7890</span>
            </li>
            <li class="flex items-center">
              <span class="mr-2 text-[var(--color-brand)]">✉️</span>
              <a href="mailto:info@smpn5sanggatta.sch.id"
                class="hover:text-[var(--color-brand)] transition">
                info@smpn5sanggatta.sch.id
              </a>
            </li>
          </ul>
        </div>

        {{-- Social --}}
        <div>
          <h3 class="text-lg font-semibold text-[var(--color-brand-dark)] mb-4">Follow Us</h3>
          <div class="flex items-center space-x-4">
          {{--  <a href="#" class="p-2 bg-[var(--color-card-bg)] rounded-full hover:bg-[var(--color-card-secondary)] transition">
              <img src="{{ Vite::asset('resources/images/icons/facebook.svg') }}"
                  alt="Facebook" class="h-6 w-6" />
            </a>
            <a href="#" class="p-2 bg-[var(--color-card-bg)] rounded-full hover:bg-[var(--color-card-secondary)] transition">
              <img src="{{ Vite::asset('resources/images/icons/instagram.svg') }}"
                  alt="Instagram" class="h-6 w-6" />
            </a>
            <a href="#" class="p-2 bg-[var(--color-card-bg)] rounded-full hover:bg-[var(--color-card-secondary)] transition">
              <img src="{{ Vite::asset('resources/images/icons/youtube.svg') }}"
                  alt="YouTube" class="h-6 w-6" />
            </a>
            <a href="#" class="p-2 bg-[var(--color-card-bg)] rounded-full hover:bg-[var(--color-card-secondary)] transition">
              <img src="{{ Vite::asset('resources/images/icons/tiktok.svg') }}"
                  alt="TikTok" class="h-6 w-6" />
            </a> --}}
          </div>
        </div>

      </div>

      {{-- Copyright --}}
      <div class="mt-8 text-center text-sm text-slate-500">
        © {{ date('Y') }} SMP 5 Sangatta Utara. All Rights Reserved.
      </div>
    </div>
  </footer>
