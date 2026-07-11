@props(['count' => 5])

<div {{ $attributes->merge(['class' => 'skeleton-pagination']) }}>
    @for ($i = 0; $i < $count; $i++)
        <x-skeleton.block pill height="2em" width="2em" />
    @endfor
</div>
