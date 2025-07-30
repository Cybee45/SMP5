{{-- resources/views/components/nav-link.blade.php --}}
@props([
    'active' => false,
])

@php
    // Base classes: layout, padding, border, transition & focus outline
    $base = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';

    // When active: use brand color for text & border
    $activeClasses   = 'border-[var(--color-carbon)] text-[var(--color-carbon)]';

    // When inactive: text hitam (carbon), transparent border, hover ke brand
    $inactiveClasses = 'border-transparent hover:text-[var(--color-brand)] hover:border-[var(--color-brand)]';

    $classes = $base.' '.(($active ?? false) ? $activeClasses : $inactiveClasses);
@endphp

<a
    {{ $attributes->merge(['class' => $classes]) }}
    style="{{ ! $active ? 'color: var(--color-carbon) !important;' : '' }}"
    @if($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
