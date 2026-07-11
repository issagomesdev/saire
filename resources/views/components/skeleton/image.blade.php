@props([
    'width' => '100%',
    'height' => '12em',
])

<span
    {{ $attributes->merge([
        'class' => 'skeleton',
        'style' => 'display:block;width:' . $width . ';height:' . $height . ';',
    ]) }}
></span>
