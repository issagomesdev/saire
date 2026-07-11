@include('site.layouts.header')

<link href="{{ asset_v('css/site/page.css') }}" rel="stylesheet" />
<link href="{{ asset_v('css/site/publications/styles.css') }}" rel="stylesheet" />

<div class="page-content">
    <div class="publications-content">
        @for ($i = 0; $i < 6; $i++)
            <x-skeleton.card variant="list-publication" />
        @endfor
    </div>
</div>
<div class="pagination"><x-skeleton.pagination /></div>

</div> <!-- content close -->

@include('site.layouts.footer') 


<script src="{{ asset_v('js/he-master/he.js') }}"> </script>
<script>

	const url = "{{Request::url()}}"
	const next = {{ $publications->currentPage() }} == {{ $publications->lastPage() }}? 0 :
	({{ $publications->lastPage() }} - {{ $publications->currentPage() }}) >= 3? 3 : 
	({{ $publications->lastPage() }} - {{ $publications->currentPage() }});


	const previus = {{ $publications->currentPage() }} == 1? 0 :
	({{ $publications->currentPage() }} - 1) >= 3? 3 : 
	({{ $publications->currentPage() }} - 1);

	const currentPage = "{{ $publications->currentPage() }}"
	const lastPage = "{{ $publications->lastPage() }}"
	const nextPages = []
	const previusPages = []

	for(let i = ({{ $publications->currentPage() }} + 1); i <= ({{ $publications->currentPage() }} + next); i++) {
		nextPages.push([i]);
	}

	for(let i = ({{ $publications->currentPage() }} - 1); i >= ({{ $publications->currentPage() }} - previus); i--) {
		previusPages.push([i]);
	}

</script>
<script src="{{ asset_v('js/site/page.js') }}"> </script>

<script>

    		@php
			// @json() evita que quebras de linha/aspas dentro de $publication->text
			// quebrem a sintaxe do <script> (mesmo bug corrigido em site/index.blade.php).
			$publicationsJs = $publications->map(fn ($publication) => [
				'id' => $publication->id,
				'title' => $publication->title,
				'text' => $publication->text,
				'status' => $publication->status,
				'date' => (string) $publication->created_at,
				'categories' => $publication->categories->pluck('title')->values(),
				'photos' => $publication->photos->map(fn ($media) => $media->getUrl())->values(),
			])->values();
		@endphp
    		const publications = @json($publicationsJs);

		var imageDefault = "/media/img/default.png";
        
</script>
<script src="{{ asset_v('js/site/publications/script.js') }}"> </script>

</body>
</html>