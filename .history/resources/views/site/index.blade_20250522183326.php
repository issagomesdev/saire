@include('site.layouts.header')
	<link href="{{ asset('css/site/styles.css') }}" rel="stylesheet" />

<main>
	<div class="fav-gallery-content">
	<section id="fav">
			<div class="features"> </div>
		</section>
		
		<section id="gallery">
			<div class="lab">
				<a href="{{ route('site.gallery') }}"> galeria de fotos <i class="fa-solid fa-link"></i> </a> 
			</div>
			<div class="images"> </div>
			<div class="view-more" id="gallery">
				<a href="{{ route('site.gallery') }}"> ver mais da galeria <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
			</div>
		</section>
	</div>

	<section class="banners">
		<div class="banner"> <a href="https://saire.pe.gov.br/pagina/Precat%C3%B3rio_FUNDEF_2023"> <img src="{{ asset('storage/img/banners/fundef.jpeg') }}" alt=" Precatório FUNDEF 2023"> </a> </div>
		<div class="banner"> <a href="https://saire.pe.gov.br/pagina/Eleição_Conselho_Tutelar"> <img src="{{ asset('storage/img/banners/conselho.png') }}" alt="Processo de Escolha 2023 - Conselho Tutelar"> </a> </div>
		<div class="banner"> <a href="http://www.ebminformatica.com/tributos/index.php"> <img src="{{ asset('storage/img/banners/iptu.png') }}" alt="iptu"> </a> </div>
		<div class="banner"> <a href="https://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=holerite2"> <img src="{{ asset('storage/img/banners/contracheque.png') }}" alt="contracheque"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=lic"> <img src="{{ asset('storage/img/banners/licitacao.png') }}" alt="licitação"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=lic">  <img src="{{ asset('storage/img/banners/aviso-de-licitacao.png') }}" alt="aviso de licitação"> </a> </div>
		<div class="banner"> <a href="http://www.ebminformatica.com/enota25/site/login/login"> <img src="{{ asset('storage/img/banners/nfse.png') }}" alt="nfse"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=serv"> <img src="{{ asset('storage/img/banners/carta.png') }}" alt="carta de serviços"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=dpa"> <img src="{{ asset('storage/img/banners/despesas.png') }}" alt="despesa"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=rec"> <img src="{{ asset('storage/img/banners/receita.png') }}" alt="receita"> </a> </div>
		<div class="banner"> <a href="https://transparencia.saire.pe.gov.br/portal/v81/covid_home/"> <img src="{{ asset('storage/img/banners/covid.png') }}" alt="covid-19"> </a> </div>
	</section>
</main>

	<section id="publications">
		<div class="lab">
			<a href="{{ route('site.publications') }}"> últimas notícias <i class="fa-solid fa-link"> </i> </a> 
		</div>
		<div class="publications"> </div>
		<div class="view-more"  id="publications">
			<a href="{{ route('site.publications') }}"> ver todas as notícias <i class="fa-solid fa-arrow-up-right-from-square"></i> </a>
		</div>
	</section>
		</div> <!-- content close -->

		@include('site.layouts.footer')

	<script>

		const publications = [
			@foreach($publications as $publication)
		{
			"id": "{{$publication->id}}",  
			"title": "{{$publication->title}}",
			"text": "{{$publication->text}}",
			"status": "{{$publication->status}}",         
			"photos": [
			@foreach($publication->photos as $key => $media)
			"{{ $media->getUrl() }}",
			@endforeach
			],
			
		},

            @endforeach
		];

		const featuredPublications = [
			@foreach($features as $feature)
		{ 
			"id": "{{$feature->id}}", 
			"title": "{{$feature->title}}",
			"text": "{{$feature->text}}",
			"status": "{{$feature->status}}",          
			"photos": [
			@foreach($feature->photos as $key => $media)
			"{{ $media->getUrl() }}",
			@endforeach
			],
			
		},
			@endforeach
		];

		var imageDefault = "{{ asset('storage/img/saire.jpeg') }}";

		const galleries = [
			@foreach($galleries as $gallery)
		{ 
			"id": "{{$gallery->id}}", 
			"title": "{{$gallery->title}}",          
			"photos": [
			@foreach($gallery->photos as $key => $media)
			"{{ $media->getUrl() }}",
			@endforeach
			],
			
		},
			@endforeach
		];
		
	</script>
<script src="{{ asset('js/he-master/he.js') }}"> </script>
<script src="{{ asset('js/site/script.js') }}"> </script>

	<style>
	
	span.text-big {
	background-color: rgb(255 255 255 / 0%) !important;
    color: #fff !important;
    }
	
	</style>


</body>
</html>