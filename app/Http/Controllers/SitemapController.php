<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
	public function index()
	{
		// Insert Sub Sitemaps Here.
		$data = [
			'main'
		];
		return response()->view('sitemap.index', ['data' => $data])->header('Content-Type', 'text/xml');
	}

	public function page( Request $request )
	{
		$routes = [
			// 'DATABASE_NAME' => 'ROUTE_NAME'
			'pages'=> 'pages',
			'posts'=> 'posts',
		];

		$page = $request->page;
		if ( !array_key_exists($page, $routes) && $page != 'main' ) return route('sitemap');
		$route = ( $page != 'main' ) ? $routes[$page] : 'main';
		$change_frequency = 'weekly'; // monthly|weekly|daily|hourly
		$view_page = 'sitemap.page';

		switch ( $page ) {
			case 'main':
				$priority = '0.6'; // 0.0|0.1|0.2|0.3|0.4|0.5|0.6|0.7|0.8|0.9|1.0 1.0 being the highest and 0.0 being the lowest
				$data = [
					'home'
				];
				$view_page = 'sitemap.main';
				break;
			
			default:
				$priority = '0.9'; // 0.0|0.1|0.2|0.3|0.4|0.5|0.6|0.7|0.8|0.9|1.0 1.0 being the highest and 0.0 being the lowest
				$data = \DB::table($page)->latest()->get();
				break;
		}

		$return_data = [
			'page' => $page,
			'data' => $data,
			'priority' => $priority,
			'route' => $route,
			'change_frequency' => $change_frequency
		];

		return response()->view($view_page, $return_data)->header('Content-Type', 'text/xml');
	}
}