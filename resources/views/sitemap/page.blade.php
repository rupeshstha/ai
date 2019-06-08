@extends('sitemap.app')

@section('content')
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($data as $url)
	<url>
		<loc>{{ route($route, $url->slug) }}</loc>
		<lastmod>{{ date('c', strtotime($url->updated_at)) }}</lastmod>
		<changefreq>{{ $change_frequency }}</changefreq>
		<priority>{{ $priority }}</priority>
	</url>
@endforeach
</urlset>
@stop