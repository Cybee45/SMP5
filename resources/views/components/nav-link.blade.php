{{-- resources/views/components/nav-link.blade.php --}}
@props([
    'active' => false,
    ])

@php
    // Base classes: layout, padding, border, transition & focus outline
    $base = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';

    // When active: use brand color for text & border
    $activeClasses   = 'border-[var(--color-brand)] text-[var(--color-brand)]';

    // When inactive: dark text, transparent border, hover to brand
    $inactiveClasses = 'border-transparent text-[var(--color-brand-dark)] hover:text-[var(--color-brand)] hover:border-[var(--color-brand)]';

    $classes = $base.' '.(($active ?? false) ? $activeClasses : $inactiveClasses);
@endphp

<a
    {{ $attributes->merge(['class' => $classes]) }}
    @if($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
