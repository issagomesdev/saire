@props(['lines' => 3])

<div {{ $attributes }}>
    @for ($i = 0; $i < $lines; $i++)
        <span class="skeleton skeleton--text"></span>
    @endfor
</div>
