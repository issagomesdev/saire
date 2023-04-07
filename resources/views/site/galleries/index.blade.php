@include('site.layouts.header')

<link href="{{ asset('css/site/page.css') }}" rel="stylesheet" />
<link href="{{ asset('css/site/galleries/styles.css') }}" rel="stylesheet" />

<div class="gallery-content">
<div class="display-imagen" visible="false">

<div class="details">
<div class="open-details"> <i class="fa-solid fa-ellipsis-vertical"> </i> </div>
</div>

  <div class="details-item" visible="false">

  <div class="items-data">
  <div id="title" class="item-data">
    <i class="fa-solid fa-file-signature"></i>
    <p> </p>
    </div>

    <div id="description" class="item-data">
    <i class="fa-solid fa-align-center"></i>
    <p> </p>
    </div>

    <div id="date" class="item-data">
    <i class="fa-solid fa-calendar-days"></i>
    <p> </p>
    </div>

    <div id="categories" class="item-data">
    <i class="fa-solid fa-tags"></i>
    <div class="categories-items">

    </div>
    </div>
  </div>

  </div>


  <div class="close"> <i class="fa-solid fa-xmark"></i> </div>
  <div class="change-image" id="previous"> <i class="fa-solid fa-circle-chevron-left"></i> </div>
  <img>
  <div class="change-image" id="next"> <i class="fa-solid fa-circle-chevron-right"></i> </div>
</div>

<div class="galleries"> </div>
<div class="pagination"> </div>

</div>
</div> <!-- content close -->

@include('site.layouts.footer')

<script>

const url = "{{Request::url()}}"
const next = {{ $galleries->currentPage() }} == {{ $galleries->lastPage() }}? 0 :
({{ $galleries->lastPage() }} - {{ $galleries->currentPage() }}) >= 3? 3 : 
({{ $galleries->lastPage() }} - {{ $galleries->currentPage() }});


const previus = {{ $galleries->currentPage() }} == 1? 0 :
({{ $galleries->currentPage() }} - 1) >= 3? 3 : 
({{ $galleries->currentPage() }} - 1);

const currentPage = "{{ $galleries->currentPage() }}"
const lastPage = "{{ $galleries->lastPage() }}"
const nextPages = []
const previusPages = []

for(let i = ({{ $galleries->currentPage() }} + 1); i <= ({{ $galleries->currentPage() }} + next); i++) {
    nextPages.push([i]);
  }

  for(let i = ({{ $galleries->currentPage() }} - 1); i >= ({{ $galleries->currentPage() }} - previus); i--) {
    previusPages.push([i]);
  }

</script>
<script src="{{ asset('js/site/page.js') }}"> </script>
<script>

const galleries = [
			@foreach($galleries as $gallery)
		{
			"id": "{{$gallery->id}}",  
			"title": "{{$gallery->title}}",
			"description": "{{$gallery->description}}",
      "date": "{{ $gallery->created_at }}",
      "categories": [
            @foreach($gallery->categories as $key => $category)
			"{{ $category->title }}",
			@endforeach
            ],
			"photos": [
			@foreach($gallery->photos as $key => $media)
			"{{ $media->getUrl() }}",
			@endforeach
			],
			
		},

            @endforeach
		];

</script>
<script src="{{ asset('js/site/galleries/script.js') }}"> </script>
</body>
</html>