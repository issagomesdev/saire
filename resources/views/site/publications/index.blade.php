@include('site.layouts.header')

<link href="{{ asset('css/site/page.css') }}" rel="stylesheet" />
<link href="{{ asset('css/site/publications/styles.css') }}" rel="stylesheet" />

<div class="page-content">
    <div class="publications-content"> </div>
</div> 
<div class="pagination"> </div>

</div> <!-- content close -->

@include('site.layouts.footer') 


<script src="{{ asset('js/he-master/he.js') }}"> </script>
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
<script src="{{ asset('js/site/page.js') }}"> </script>

<script>

    		const publications = [
			@foreach($publications as $publication)
		{
			"id": "{{$publication->id}}",  
			"title": "{{$publication->title}}",
			"text": "{{$publication->text}}",
			"status": "{{$publication->status}}",
            "date": "{{ $publication->created_at }}",
            "categories": [
            @foreach($publication->categories as $key => $category)
			"{{ $category->title }}",
			@endforeach
            ],
			"photos": [
			@foreach($publication->photos as $key => $media)
			"{{ $media->getUrl() }}",
			@endforeach
			],
			
		},

            @endforeach
		];

		var imageDefault = "{{ asset('storage/img/saire.jpeg') }}";
        
</script>
<script src="{{ asset('js/site/publications/script.js') }}"> </script>

</body>
</html>