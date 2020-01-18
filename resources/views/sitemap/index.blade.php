@extends('sitemap.app')

@section('content')
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($data as $page)
	<sitemap>
		<loc>{{ route('sitemaps.dynamic', $page) }}</loc>
	</sitemap>
@endforeach
</sitemapindex>
@stop