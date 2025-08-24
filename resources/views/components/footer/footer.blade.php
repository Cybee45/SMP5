@php
    use Illuminate\Support\Facades\Storage;

    // Ambil 1 record FooterSetting yang aktif (atau yang pertama kalau kolom 'aktif' tidak ada)
    $footer = \App\Models\FooterSetting::query()
        ->when(\Schema::hasColumn('footer_settings','aktif'), fn($q) => $q->where('aktif', true))
        ->orderBy('urutan')
        ->first();

    // Fallback default
    $namaSekolah   = $footer->nama_sekolah      ?? 'SMP Negeri 5 Sangatta Utara';
    $deskripsi     = $footer->deskripsi_sekolah ?? 'Menjadi Sekolah Unggulan yang Berkualitas dan Berwawasan Lingkungan untuk Membentuk Generasi Pemimpin Berkarakter, wwww 1234, Indonesia';
    $telepon1      = $footer->telepon_1         ?? '123456789123';
    $telepon2      = $footer->telepon_2         ?? '123456789123';
    $alamat        = $footer->alamat            ?? null;

    // Logo: kalau pakai FileUpload (path di storage), gunakan Storage::url, kalau kosong pakai asset default
    $logoUrl = isset($footer->logo_sekolah) && $footer->logo_sekolah
        ? Storage::url($footer->logo_sekolah)
        : asset('assets/logo/logo.png');

    // Sosial/Link: biarkan apa adanya dari CMS; kalau kosong arahkan ke '#'
    $ig   = $footer->instagram_url ?? '#';
    $wa   = $footer->whatsapp_url  ?? '#';
    $fb   = $footer->facebook_url  ?? '#';
    $yt   = $footer->youtube_url   ?? '#';

    $copyright = $footer->copyright_text ?? '© 2024 Afaja Company. All Rights Reserved.';

    // Menu Footer dari CMS atau fallback ke default
    $menuItems = $footer->menu_items ?? [
        ['nama_menu' => 'HOME', 'url' => '/', 'aktif' => true, 'urutan' => 1],
        ['nama_menu' => 'ABOUT US', 'url' => '/about', 'aktif' => true, 'urutan' => 2],
        ['nama_menu' => 'SPMB', 'url' => '/spmb', 'aktif' => true, 'urutan' => 3],
        ['nama_menu' => 'MEDIA', 'url' => '/media', 'aktif' => true, 'urutan' => 4],
        ['nama_menu' => 'BLOG', 'url' => '/blog', 'aktif' => true, 'urutan' => 5],
        ['nama_menu' => 'KONTAK', 'url' => '/contact', 'aktif' => true, 'urutan' => 6],
    ];

    // Filter menu yang aktif dan urutkan
    $activeMenus = collect($menuItems)->where('aktif', true)->sortBy('urutan');
@endphp

<footer class="bg-white pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Mengubah grid utama menjadi 2 kolom besar -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 items-start">
      <!-- Kiri: Info Sekolah (tetap sama strukturnya) -->
      <div>
        <div class="flex items-center mb-4">
          <img src="{{ $logoUrl }}" alt="Logo Sekolah" class="h-12 mr-3 rounded" />
          <span class="text-xl font-bold">{{ $namaSekolah }}</span>
        </div>

        <div class="text-slate-700 mb-3">
          {{ $deskripsi }}
          @if($alamat)
            <br>{{ $alamat }}
          @endif
        </div>

        @if($telepon1)<div class="font-semibold text-slate-900 mb-1">{{ $telepon1 }}</div>@endif
        @if($telepon2)<div class="font-semibold text-slate-900">{{ $telepon2 }}</div>@endif
      </div>

      <!-- Kanan: Grup Akses Cepat & Media Sosial -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-8">
        <!-- Kolom Akses Cepat (dari CMS) -->
        <div>
          <h3 class="text-lg font-semibold mb-4">AKSES CEPAT</h3>
          <ul class="space-y-1">
            @foreach($activeMenus as $menu)
              <li>
                <a href="{{ !empty($menu['route_name']) ? route($menu['route_name']) : ($menu['url'] ?? '#') }}" 
                   class="hover:text-sky-700 transition-colors">
                  {{ $menu['nama_menu'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

        <!-- Kolom Media Sosial -->
        <div>
          <h3 class="text-lg font-semibold mb-4">HUBUNGI KAMI</h3>
          <div class="flex items-center space-x-4">
            <!-- Instagram -->
            <a href="{{ $ig }}" title="Instagram" target="_blank" rel="noopener"
               class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-200 text-slate-600 hover:text-white hover:bg-instagram-gradient transition-all duration-300 transform hover:-translate-y-1 shadow hover:shadow-lg">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919C8.416 2.175 8.796 2.163 12 2.163zm0 1.441c-3.161 0-3.523.012-4.752.068-2.73.123-3.962 1.359-4.085 4.085-.056 1.229-.067 1.591-.067 4.751s.011 3.522.067 4.752c.123 2.726 1.355 3.962 4.085 4.085 1.229.056 1.591.067 4.752.067s3.523-.011 4.752-.067c2.73-.123 3.962-1.359 4.085-4.085.056-1.229.067-1.591.067-4.752s-.011-3.523-.067-4.752c-.123-2.726-1.355-3.962-4.085-4.085-1.229-.056-1.591-.067-4.752-.067z"></path>
                <path d="M12 6.865c-2.833 0-5.135 2.302-5.135 5.135s2.302 5.135 5.135 5.135 5.135-2.302 5.135-5.135-2.302-5.135-5.135-5.135zm0 8.832c-2.04 0-3.697-1.657-3.697-3.697s1.657-3.697 3.697-3.697 3.697 1.657 3.697 3.697-1.657 3.697-3.697 3.697z"></path>
                <path d="M16.949 6.885c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5 1.5-.672 1.5-1.5-.672-1.5-1.5-1.5z"></path>
              </svg>
            </a>

            <!-- WhatsApp -->
            <a href="{{ $wa }}" title="WhatsApp" target="_blank" rel="noopener"
               class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-200 text-slate-600 hover:text-white hover:bg-[#25D366] transition-all duration-300 transform hover:-translate-y-1 shadow hover:shadow-lg">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.42 1.29 4.88L2 22l5.25-1.38c1.41.78 3.02 1.22 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91s-4.45-9.91-9.91-9.91zM17.2 15.3c-.28-.14-1.65-.81-1.91-.91-.26-.09-.45-.14-.64.14-.19.28-.72.91-.88 1.1-.16.19-.32.22-.59.07-.28-.15-1.17-.43-2.23-1.38-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.19-.28.28-.47.1-.19.05-.36-.02-.5-.07-.14-.64-1.53-.87-2.1-.23-.57-.47-.49-.64-.5-.17-.01-.36-.01-.54-.01-.18 0-.47.07-.72.35-.25.28-.96.93-.96 2.27 0 1.34.99 2.64 1.13 2.82.14.18 1.96 3.01 4.75 4.22 2.79 1.2 2.79.8 3.3.78.5-.03 1.65-.68 1.88-1.33.24-.65.24-1.21.17-1.33-.07-.13-.26-.21-.54-.35z"></path>
              </svg>
            </a>
            
            <!-- Facebook (BARU) -->
            <a href="{{ $fb }}" title="Facebook" target="_blank" rel="noopener"
               class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-200 text-slate-600 hover:text-white hover:bg-[#1877F2] transition-all duration-300 transform hover:-translate-y-1 shadow hover:shadow-lg">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.02 22V12.33H16.21L16.68 8.82H13.02V6.63C13.02 5.62 13.3 4.92 14.54 4.92H16.8V1.89C16.42 1.85 15.31 1.75 14.02 1.75C11.32 1.75 9.53 3.39 9.53 6.32V8.82H6.33V12.33H9.53V22H13.02Z"></path>
              </svg>
            </a>

            <!-- YouTube (BARU) -->
            <a href="{{ $yt }}" title="YouTube" target="_blank" rel="noopener"
               class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-200 text-slate-600 hover:text-white hover:bg-[#FF0000] transition-all duration-300 transform hover:-translate-y-1 shadow hover:shadow-lg">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M21.58 7.19c-.23-.86-.9-1.52-1.76-1.76C18.25 5 12 5 12 5s-6.25 0-7.82.43c-.86.23-1.52.9-1.76 1.76C2 8.75 2 12 2 12s0 3.25.43 4.81c.23.86.9 1.52 1.76 1.76C5.75 19 12 19 12 19s6.25 0 7.82-.43c.86-.23 1.52-.9 1.76-1.76C22 15.25 22 12 22 12s0-3.25-.42-4.81zM9.75 15.5V8.5l6.5 3.5-6.5 3.5z"></path>
              </svg>
            </a>

          </div>
        </div>
      </div>
    </div>

    <div class="mt-8 border-t border-slate-300 pt-4 flex flex-col sm:flex-row items-center justify-between">
      <p class="text-sm text-slate-600">{{ $copyright }}</p>
    </div>
  </div>
</footer>
