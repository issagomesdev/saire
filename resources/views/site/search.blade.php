@include('site.layouts.header')
<link href="{{ asset('css/site/page.css') }}" rel="stylesheet" />
<link href="{{ asset('css/site/search/styles.css') }}" rel="stylesheet" />
<link href="{{ asset('css/site/galleries/styles.css') }}" rel="stylesheet" />

<div class="search-content">
	
	<!-- display imagen -->
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
				<div class="categories-items"> </div>
			</div>
		</div>
	</div>

	<div class="close"> <i class="fa-solid fa-xmark"></i> </div>
	<div class="change-image" id="previous"> <i class="fa-solid fa-circle-chevron-left"></i> </div>
	<img>
	<div class="change-image" id="next"> <i class="fa-solid fa-circle-chevron-right"></i> </div>
</div>

	<!-- publications -->
	<div class="items-conteiner" id="publications">
	<div class="search-lab"> Notícias  <div class="lab-color"> </div> </div>
		<div class="spinner-conteiner">
			<div id="publications" class="spinner"></div>
		</div>
		<div class="items-content" id="publications"> </div>
		<div class="pagination" id="publications">  </div>
	</div>

	<!-- page -->
	<div class="items-conteiner" id="page">
	<div class="search-lab"> Páginas <div class="lab-color"> </div> </div>
		<div class="spinner-conteiner">
			<div id="page" class="spinner"></div>
		</div>
		<div class="items-content" id="page"> </div>
		<div class="pagination" id="page">  </div>
	</div>
</div>

<!-- galleries -->

<div class="items-conteiner" id="galleries">
	<div class="search-lab"> Galeria <div class="lab-color"> </div> </div>
		<div class="spinner-conteiner">
			<div id="galleries" class="spinner"></div>
		</div>
	<div class="items-content" id="galleries"> </div>
	<div class="pagination" id="galleries">  </div>
</div>

<div class="spinner-conteiner">
	<div id="galleries" class="spinner"></div>
</div>

</div> <!-- content close -->

<style>
	.display-imagen[visible="true"] {
    height: 95%;
    width: 95%;
    z-index: 999;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
}

	.display-imagen img {
    border-radius: 0;
}

.card-container p, .card-container span {
    font: normal normal 300 1em/1.55em 'Outfit', sans-serif !important;
    color: hsl(215, 51%, 70%) !important;
    margin: 0 !important;
    background-color: transparent !important;
}

.card-tags p {
    background-color: #3b3b50 !important;
    margin: 2px !important;
}
</style>

@include('site.layouts.footer')
<script src="{{ asset('js/site/search/script.js') }}"> </script>
<script src="{{ asset('js/he-master/he.js') }}"> </script>
<script>
	// showSpinner('publications')
	// showSpinner('page')
	// showSpinner('galleries')
loadPublications(1, "{{ $search }}",  "{{ asset('storage/img/saire.jpeg') }}");
loadPages(1, "{{ $search }}",  "{{ asset('storage/img/saire.jpeg') }}");
loadGalleries(1, "{{ $search }}");
</script>
