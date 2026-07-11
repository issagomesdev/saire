@props([
    'width' => null,
    'height' => null,
    'circle' => false,
    'pill' => false,
])

@php
    $style = '';
    if ($width) {
        $style .= 'width:' . $width . ';';
    }
    if ($height) {
        $style .= 'height:' . $height . ';';
    }
@endphp

<span
    {{ $attributes->merge([
        'class' => 'skeleton' . ($circle ? ' skeleton--circle' : '') . ($pill ? ' skeleton--pill' : ''),
        'style' => $style,
    ]) }}
></span>
