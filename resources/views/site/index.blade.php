@include('site.layouts.header')
	<link href="{{ asset('css/site/styles.css') }}" rel="stylesheet" />

<main>
	<div class="fav-gallery-content">
	<section id="fav">
			<div class="features"><x-skeleton.card variant="home-publication" /></div>
		</section>

		<section id="gallery">
			<div class="lab">
				<a href="{{ route('site.gallery') }}"> galeria de fotos <i class="fa-solid fa-link"></i> </a>
			</div>
			<div class="images">
				@for ($i = 0; $i < 6; $i++)
					<x-skeleton.image width="20em" height="20em" />
				@endfor
			</div>
			<div class="view-more" id="gallery">
				<a href="{{ route('site.gallery') }}"> ver mais da galeria <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
			</div>
		</section>
	</div>

	<section class="banners">
		<div class="banner"> <a href="https://saire.pe.gov.br/pagina/Precat%C3%B3rio_FUNDEF_2023"> <img class="skeleton-image-loading" src="/media/img/banners/fundef.png" alt=" Precatório FUNDEF 2023"> </a> </div>
		<div class="banner"> <a href="https://saire.pe.gov.br/pagina/Eleição_Conselho_Tutelar"> <img class="skeleton-image-loading" src="/media/img/banners/conselho.png" alt="Processo de Escolha 2023 - Conselho Tutelar"> </a> </div>
		<div class="banner"> <a href="http://www.ebminformatica.com/tributos/index.php"> <img class="skeleton-image-loading" src="/media/img/banners/iptu.png" alt="iptu"> </a> </div>
		<div class="banner"> <a href="https://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=holerite2"> <img class="skeleton-image-loading" src="/media/img/banners/contracheque.png" alt="contracheque"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=lic"> <img class="skeleton-image-loading" src="/media/img/banners/licitacao.png" alt="licitação"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=lic">  <img class="skeleton-image-loading" src="/media/img/banners/aviso-de-licitacao.png" alt="aviso de licitação"> </a> </div>
		<div class="banner"> <a href="http://www.ebminformatica.com/enota25/site/login/login"> <img class="skeleton-image-loading" src="/media/img/banners/nfse.png" alt="nfse"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=serv"> <img class="skeleton-image-loading" src="/media/img/banners/carta.png" alt="carta de serviços"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=dpa"> <img class="skeleton-image-loading" src="/media/img/banners/despesas.png" alt="despesa"> </a> </div>
		<div class="banner"> <a href="http://transparencia.saire.pe.gov.br/portal/v81/indexent/indexent.php?entidade=215&idoc=rec"> <img class="skeleton-image-loading" src="/media/img/banners/receita.png" alt="receita"> </a> </div>
		<div class="banner"> <a href="https://transparencia.saire.pe.gov.br/portal/v81/covid_home/"> <img class="skeleton-image-loading" src="/media/img/banners/covid.png" alt="covid-19"> </a> </div>
	</section>
</main>

	<section id="publications">
		<div class="lab">
			<a href="{{ route('site.publications') }}"> últimas notícias <i class="fa-solid fa-link"> </i> </a> 
		</div>
		<div class="publications">
			@for ($i = 0; $i < 6; $i++)
				<x-skeleton.card variant="home-publication" />
			@endfor
		</div>
		<div class="view-more"  id="publications">
			<a href="{{ route('site.publications') }}"> ver todas as notícias <i class="fa-solid fa-arrow-up-right-from-square"></i> </a>
		</div>
	</section>
		</div> <!-- content close -->

		@include('site.layouts.footer')

	<script>
		@php
			// @json() escapa aspas, barras invertidas e quebras de linha
			// corretamente para contexto JS/HTML. O foreach manual antigo
			// interpolava $publication->text (que pode ter quebras de linha
			// reais dentro de um literal de string de uma linha só) direto
			// no JS, o que gerava um erro de sintaxe e quebrava o script
			// inteiro — por isso nada era renderizado na home.
			$publicationsJs = $publications->map(fn ($item) => [
				'id' => $item->id,
				'title' => $item->title,
				'text' => $item->text,
				'status' => $item->status,
				'photos' => $item->photos->map(fn ($media) => $media->getUrl())->values(),
			])->values();

			$featuredPublicationsJs = $features->map(fn ($item) => [
				'id' => $item->id,
				'title' => $item->title,
				'text' => $item->text,
				'status' => $item->status,
				'photos' => $item->photos->map(fn ($media) => $media->getUrl())->values(),
			])->values();

			$galleriesJs = $galleries->map(fn ($item) => [
				'id' => $item->id,
				'title' => $item->title,
				'photos' => $item->photos->map(fn ($media) => $media->getUrl())->values(),
			])->values();
		@endphp

		const publications = @json($publicationsJs);
		const featuredPublications = @json($featuredPublicationsJs);

		var imageDefault = "/media/img/default.png";

		const galleries = @json($galleriesJs);
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