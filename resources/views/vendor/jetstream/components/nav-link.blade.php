@props(['active'])

@php
    $classes = 'nav-link';
@endphp

<li class="nav-item {{ ($active ?? false) ? 'active' : '' }}">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
