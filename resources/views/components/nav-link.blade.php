@props(['href' => '', 'active' => false, 'icon' => 'fa-home'])

@php
    $classes = $active ? 'sidebar-item active' : 'sidebar-item';
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    <a href="{{ $href }}" class="sidebar-link">
        <i class="fa-solid {{ $icon }}"></i>
        <span>{{ $slot }}</span>
    </a>
</li>
