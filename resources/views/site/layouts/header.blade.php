<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Prefeitura Municipal de Sairé</title>
	<link href="{{ asset('css/site/header.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/site/footer.css') }}" rel="stylesheet" />
	<meta charset="UTF-8" content="width=device-width, initial-scale=1" name="viewport">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>

<div class="top_access">
		<div class="widget-container-social">
			<a href="https://www.instagram.com/governodesaire/" class="fa-brands fa-square-instagram"></a>
			<a href="https://www.facebook.com/governosaire/?locale=pt_BR" class="fa-brands fa-facebook"></a>
		</div>
</div>
	
	<div class="content">
	<header>
	<a href="/"> <img src="{{ asset('storage/img/logo1.png') }}" alt="logo"> </a>
	</header>
	
	<header>
			
		<div class="drop-menu"> 
		<p> menu <i class="fa-solid fa-caret-up"></i>	</p>
		</div>

		<div class="nav" active="true">
			
		@foreach($menus as $menu)
		@if($menu->link_type == 0)
		<div class="parent-menu"> 
		<a> {{ $menu->title }} </a>
		<i class="fa-solid fa-caret-down"></i>
		<div class="child-menu" active="false">
		@foreach($menu->submenuses as $menuchild)
		@if($menuchild->link_type == 0)
		<a href="{{ route('site.page', str_replace(" ", "_", $menuchild->page->title)) }}" class="{{ collect([$menuchild])->contains(function($menuchild) { return str_replace(" ", "_", $menuchild->page->title) == last(explode('/', request()->path())); }) ? 'active' : '' }}"> {{ $menuchild->title }} </a> 
		@elseif($menuchild->link_type == 1)
		<a href="{{ $menuchild->url }}"> {{ $menuchild->title }} </a>
		@endif
		@endforeach
		</div>
		</div>
		@elseif($menu->link_type == 1)
		<div class="{{ urldecode(request()->getRequestUri()) == ("/pagina/" . str_replace(" ", "_", $menu->page->title)) ? 'active' : '' }}">
		<a href="{{ route('site.page', str_replace(" ", "_", $menu->page->title)) }}"> {{ $menu->title }} </a> 
		</div>
		@elseif($menu->link_type == 2)
		<div class="{{ urldecode(request()->getRequestUri()) == $menu->url ? 'active' : '' }}"> <a href="{{ $menu->url }}"> {{ $menu->title }} </a> </div>
		@endif
		@endforeach

		</div>
	</header>


	<script src="{{ asset('js/site/parentMenu.js') }}"> </script>