@include('site.layouts.header')

<link href="{{ asset('css/site/publications/show.css') }}" rel="stylesheet" />

<div class="page-content">

    <div class="publication-content">

        <div class="publication-imagen">
        <a> </a>
        <div class="publication-imagens"> </div>
        </div>

        <div class="publication-title">
            <p>{{ $publication->title }}</p>
        </div>

        <div class="publication-text">
            <p>{!! $publication->text !!}</p>
        </div>

        <div class="publication-categories">
        @foreach($publication->categories as $categories)
        <p>{{ $categories->title }}</p>
        @endforeach
        </div>

        <div class="publication-date">
        <p>Publicado em {{ $publication->created_at }}</p>
        </div>

    </div>

    <div class="navigation-pages">
        
        @if($previus)
        <div class="navigate">
        <a href="{{ route('site.publications.show', str_replace(" ", "_", $previus->title))}}" class="fa-solid fa-angles-left"></a>
        <div class="navigate-page">
        <div class="navigate-page-lab"> Anterior: </div>
        <a> {{$previus->title}} </a> 
        </div>
        </div>
        @endif
        
        @if($next)
        <div class="navigate">
        <div class="navigate-page"> 
        <div class="navigate-page-lab"> Próximo: </div>
        <a> {{$next->title}} </a> 
        </div>
        <a href="{{ route('site.publications.show', str_replace(" ", "_", $next->title))}}" class="fa-solid fa-angles-right"></a>
        </div>
        @endif

    </div>
    

</div>

</div> <!-- content close -->

@include('site.layouts.footer')

<script>

const publication_imagens = [
			@foreach($publication->photos as $key => $media)
			"{{ $media->getUrl() }}",
			@endforeach
			]
</script>

<script src="{{ asset('js/site/publications/show.js') }}"> </script>

</body>
</html>