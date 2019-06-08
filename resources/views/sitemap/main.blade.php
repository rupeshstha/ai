@extends('sitemap.app')

@section('content')
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($data as $route)
	<url>
		<loc>{{ route($route) }}</loc>
		<priority>{{ $priority }}</priority>
	</url>
@endforeach
</urlset>
@stop