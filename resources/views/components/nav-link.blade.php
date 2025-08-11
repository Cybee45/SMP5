{{-- resources/views/components/nav-link.blade.php --}}
@props([
    'active' => false,
    'mobile' => false,
])

@php
    if ($mobile) {
        // Mobile classes: block display untuk susunan vertikal, padding, underline on hover
        $base = 'block w-full text-left px-4 py-3 text-sm font-medium transition-all duration-200 focus:outline-none';
        
        // When active on mobile: underline dengan brand color
        $activeClasses   = 'underline decoration-[var(--color-carbon)] decoration-2 underline-offset-4 text-[var(--color-carbon)]';
        
        // When inactive on mobile: no underline, hover shows underline
        $inactiveClasses = 'no-underline text-[var(--color-black, #000)] hover:underline hover:decoration-[var(--color-carbon)] hover:decoration-2 hover:underline-offset-4 hover:text-[var(--color-carbon)]';
    } else {
        // Desktop classes: inline-flex, border-bottom indicator
        $base = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';

        // When active: use brand color for text & border
        $activeClasses   = 'border-[var(--color-carbon)] text-[var(--color-carbon)]';

        // When inactive: text hitam (carbon), transparent border, hover ke brand
        $inactiveClasses = 'border-transparent hover:text-[var(--color-carbon)] hover:border-[var(--color-carbon)]';
    }

    $classes = $base.' '.(($active ?? false) ? $activeClasses : $inactiveClasses);
@endphp

<a
    {{ $attributes->merge(['class' => $classes]) }}
    @if(!$mobile && !$active) style="color: var(--color-carbon) !important;" @endif
    @if($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
