{{-- resources/views/components/navbar/navbar.blade.php --}}
<nav x-data="{ open: false }" 
     @click.away="open = false"
     class="fixed inset-x-0 top-0 z-50 bg-transparent backdrop-blur-md">
  <div class="mx-auto max-w-7xl px-6 md:px-8">
    <div class="flex h-16 items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center gap-3">
        <img src="{{ asset('assets/logo/logo.png') }}" alt="Logo SMP 5 Sangatta Utara" class="h-8 w-8 sm:h-10 sm:w-10 object-contain" />
        <span class="font-heading text-sm sm:text-base font-semibold tracking-wide text-[var(--color-black, #000)]">
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
        <x-nav-link href="{{ route('blog.index') }}"
                    :active="request()->routeIs('blog.*')">
          BLOG
        </x-nav-link>
        <x-nav-link href="{{ route('kontak') }}"
                    :active="request()->routeIs('kontak')">
          KONTAK
        </x-nav-link>
      </div>

      <!-- Mobile Toggle -->
      <button @click="open = !open"
              class="md:hidden relative p-2 rounded-lg text-[var(--color-black, #000)] hover:bg-gray-100/80 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all duration-200">
        <!-- Hamburger Icon -->
        <div class="w-6 h-6 flex flex-col justify-center items-center transform transition-transform duration-300 ease-in-out"
             :class="{ 'rotate-90': open }">
          <span class="block w-5 h-0.5 bg-current mb-1"></span>
          <span class="block w-5 h-0.5 bg-current mb-1"></span>
          <span class="block w-5 h-0.5 bg-current"></span>
        </div>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" 
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 -translate-y-2"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-2"
       class="md:hidden bg-transparent backdrop-blur-md border-t border-white/20 shadow-sm">
    <div class="px-6 py-4 space-y-1" @click="open = false">
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
      <x-nav-link href="{{ route('blog.index') }}"
                  mobile
                  :active="request()->routeIs('blog.*')">
        BLOG
      </x-nav-link>
      <x-nav-link href="{{ route('kontak') }}"
                  mobile
                  :active="request()->routeIs('kontak')">
        KONTAK
      </x-nav-link>
    </div>
  </div>
</nav>
