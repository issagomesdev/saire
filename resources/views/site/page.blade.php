@include('site.layouts.header')

<div class="page-content" style="margin: 2em 0em 5em 0em; word-wrap: break-word;">

{!! $page->content !!}

</div>

</div> <!-- content close -->

@include('site.layouts.footer')

<script>
    Skeleton.watchImages(document.querySelector('.page-content'));
</script>