{{--
    Skeleton de card com variantes que espelham os tamanhos reais do CSS
    do site (evita layout shift quando o card de verdade substitui o
    skeleton):
      - home-publication: .card-publications (styles.css) — 100% x 30em
      - list-publication: .publication-item (publications/styles.css) — 20em
      - gallery-item:     .item-in-gallery (galleries/styles.css) — 20em
      - search-result:    .card-container (search/styles.css) — 100% da grade
--}}
@props(['variant' => 'list-publication'])

@if ($variant === 'home-publication')
    <div {{ $attributes->merge(['class' => 'skeleton-card']) }} style="width:100%;height:30em;position:relative;">
        <x-skeleton.block width="100%" height="100%" />
        <div style="position:absolute;bottom:0;left:0;right:0;padding:12px;">
            <div style="margin-bottom:8px;">
                <x-skeleton.block width="60%" height="1.4em" />
            </div>
            <x-skeleton.block width="90%" height="0.9em" />
        </div>
    </div>
@elseif ($variant === 'gallery-item')
    <x-skeleton.image {{ $attributes }} width="20em" height="15em" />
@elseif ($variant === 'search-result')
    <div {{ $attributes->merge(['class' => 'skeleton-card']) }} style="width:100%;display:flex;flex-direction:row;gap:1em;padding:1em;">
        <x-skeleton.block width="40%" height="10em" />
        <div style="flex:1;display:flex;flex-direction:column;gap:0.5em;">
            <x-skeleton.title />
            <x-skeleton.text :lines="2" />
            <div style="display:flex;gap:6px;margin-top:auto;">
                <x-skeleton.block pill width="4em" height="1.4em" />
                <x-skeleton.block pill width="3em" height="1.4em" />
            </div>
        </div>
    </div>
@else
    {{-- list-publication (default) --}}
    <div {{ $attributes->merge(['class' => 'skeleton-card']) }} style="width:20em;">
        <x-skeleton.image width="100%" height="20em" />
        <div class="skeleton-card__body">
            <x-skeleton.title />
            <x-skeleton.text :lines="2" />
            <div style="display:flex;gap:6px;margin:6px 0;">
                <x-skeleton.block pill width="4em" height="1.4em" />
                <x-skeleton.block pill width="3em" height="1.4em" />
            </div>
            <x-skeleton.block width="8em" height="0.75em" />
        </div>
    </div>
@endif
