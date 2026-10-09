{{-- Renders an ESG icon: inline SVG (so theme CSS can recolor it) for .svg files, else <img loading="lazy" decoding="async">. --}}
@php
    $__abs = $file ? public_path('esg-uploads/'.$file) : null;
    $__isSvg = $file && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'svg' && is_file($__abs);
@endphp
@if($__isSvg)
    {!! file_get_contents($__abs) !!}
@elseif($file)
    <img loading="lazy" decoding="async" src="{{ asset('esg-uploads/'.$file) }}" alt="{{ $alt ?? '' }}">
@endif
