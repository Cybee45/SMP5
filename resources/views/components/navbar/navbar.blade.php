{{-- resources/views/components/navbar/navbar.blade.php --}}
<nav x-data="{ open: false }" class="fixed inset-x-0 top-0 z-50 bg-transparent backdrop-blur-md">
  <div class="mx-auto max-w-7xl px-6 md:px-8">
    <div class="flex h-16 items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center gap-3">
        {{-- -<img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="h-10" /> --}}
        <span class="hidden sm:inline-block font-heading text-base font-semibold tracking-wide text-[var(--color-black, #000)]">
          SMP 5 SANGATTA UTARA
        </span>
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-8 text-[var(--color-button-blue)]">
        <x-nav-link href="{{ route('home') }}"
                    :active="request()->routeIs('home')">
          HOME
        </x-nav-link>
        <x-nav-link href="{{ route('about') }}"
                    :active="request()->routeIs('about')">
          ABOUT
        </x-nav-link>
        <x-nav-link href="{{ route('spmb') }}"
                    :active="request()->routeIs('spmb')">
          SPMB
        </x-nav-link>
        <x-nav-link href="{{ route('media') }}"
                    :active="request()->routeIs('media')">
          MEDIA
        </x-nav-link>
        <x-nav-link href="{{ route('contact') }}"
                    :active="request()->routeIs('contact')">
          KONTAK
        </x-nav-link>
      </div>

      <!-- Mobile Toggle -->
      <button @click="open = !open"
              class="md:hidden p-2 rounded-md text-[var(--color-black, #000)] hover:text-[var(--color-brand)]">
        <svg x-show="!open" …>…</svg>
        <svg x-show="open" …>…</svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" x-transition class="md:hidden bg-white/90 backdrop-blur-md text-[var(--color-button-blue)]">
    <div class="space-y-2 px-6 py-4">
      <x-nav-link href="{{ route('home') }}"
                  mobile
                  :active="request()->routeIs('home')">
        HOME
      </x-nav-link>
      <x-nav-link href="{{ route('about') }}"
                  mobile
                  :active="request()->routeIs('about')">
        ABOUT
      </x-nav-link>
      <x-nav-link href="{{ route('spmb') }}"
                  mobile
                  :active="request()->routeIs('spmb')">
        SPMB
      </x-nav-link>
      <x-nav-link href="{{ route('media') }}"
                  mobile
                  :active="request()->routeIs('media')">
        MEDIA
      </x-nav-link>
      <x-nav-link href="{{ route('contact') }}"
                  mobile
                  :active="request()->routeIs('contact')">
        KONTAK
      </x-nav-link>
    </div>
  </div>
</nav>
