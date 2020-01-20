<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
	private $routes;
	private $pages;
	private $mainStaticRoutes;

	public function __construct()
	{
		// Insert Page associations
		$this->routes = (!empty(config('sitemap.routes'))) ? config('sitemap.routes') : [];
		// Insert Main Static Routes.
		$this->mainStaticRoutes = (!empty(config('sitemap.mainStaticRoutes'))) ? config('sitemap.routes') : [];

		// Main Sitemap Initiatior
		$this->pages = ['main'];
		foreach ($this->routes as $route => $database) $this->pages[] = $route;
	}

	public function index()
	{
		return response()
			->view('voyager::sitemap.index', ['data' => $this->pages])
			->header('Content-Type', 'text/xml');
	}

	public function page( Request $request )
	{
		$page = $request->page;
		if ( !in_array($page, $this->pages) ) return redirect()->route('sitemaps.index');
		$view = ($page == 'main') ? 'main' : 'page';

		$data = ( $page == 'main' ) ? $this->mainStaticRoutes : \DB::table($page)->latest()->get();
		$priority = ( $page == 'main' ) ? '0.6' : '0.9'; // 0.0|0.1|0.2|0.3|0.4|0.5|0.6|0.7|0.8|0.9|1.0 1.0 being the highest and 0.0 being the lowest
		$route = ( $page != 'main' ) ? $this->routes[$page] : 'main';
		$change_frequency = ( $page == 'main' ) ? 'weekly' : 'daily'; // monthly|weekly|daily|hourly

		return response()
			->view('voyager::sitemap.'.$view, compact('page', 'data', 'priority', 'route', 'change_frequency'))
			->header('Content-Type', 'text/xml');
	}
}