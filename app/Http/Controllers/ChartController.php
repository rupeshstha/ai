<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard; 
use Spatie\Analytics\Period;
use Carbon\Carbon;
use Auth, Analytics, Helper;

class ChartController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function chart_data(Request $request)
	{
		// Check if today is Sunday or Saturday
		$f_sunday = ( date('N') == 7 ) ? 'this sunday' : 'last sunday';
		$f_saturday = ( date('N') == 6 ) ? 'this saturday' : 'next saturday';

		// Set Latest Sunday, Saturday and Today
		$thisSunday = new Carbon( $f_sunday );
		$thisSaturday = new Carbon( $f_saturday );
		$thisDay = Carbon::today();

		// Set A week ago Sunday and Saturday
		$lastSunday = new Carbon( $f_sunday );
		$lastSaturday = new Carbon( $f_saturday );
		$lastSunday->subDays(7);
		$lastSaturday->subDays(7);

		switch ( $request->chart )
		{
			case 'thisWeekVsLastWeek':
				$day = [];
				$this_week_session = [];
				$last_week_session = [];

				$thisWeek = Helper::getChartData( ['from' => $thisSunday, 'to' => $thisSaturday] );
				$lastWeek = Helper::getChartData( ['from' => $lastSunday, 'to' => $lastSaturday] );

				foreach ($thisWeek as $data) $this_week_session[] = $data[1];
				foreach ($lastWeek as $data)
				{
					$day[] = date('D', Helper::format_ga_date($data[0]));
					$last_week_session[] = $data[1];
				}

				$response = [
					'day' => $day,
					'this_week_session' => $this_week_session,
					'last_week_session' => $last_week_session
				];
			break;

			case 'topBrowsers':
				$browser = [];
				$session = [];

				$topBrowsers = Helper::getChartData( ['days' => 7, 'max' => 5, 'sort' => true, 'dimension' => 'browser'] );

				foreach ($topBrowsers as $data)
				{
					$browser[] = $data[0];
					$session[] = $data[1];
				}

				$response = [
					'browser' => $browser,
					'session' => $session,
				];
			break;

			case 'topCountries':
				$country = [];
				$session = [];

				$topCountries = Helper::getChartData( ['days' => 7, 'max' => 5, 'sort' => true, 'dimension' => 'country'] );

				foreach ($topCountries as $data)
				{
					$country[] = $data[0];
					$session[] = $data[1];
				}

				$response = [
					'country' => $country,
					'session' => $session,
				];
			break;

			case 'topSources':
				$source = [];
				$session = [];

				$topSources = Helper::getChartData( ['days' => 7, 'max' => 5, 'sort' => true, 'dimension' => 'sourceMedium'] );

				foreach ($topSources as $data)
				{
					$source[] = $data[0];
					$session[] = $data[1];
				}

				$response = [
					'source' => $source,
					'session' => $session,
				];
			break;

			case 'activeUsers':
				$day = [];
				$session = [];

				$activeUsers = Helper::getChartData( ['from' => $thisSunday, 'to' => $thisSaturday, 'metrics' => 'ga:1dayUsers'] );

				foreach ($activeUsers as $data)
				{
					$day[] = date('D', Helper::format_ga_date($data[0]));
					$session[] = $data[1];
				}

				$response = [
					'day' => $day,
					'session' => $session,
				];
			break;

			case 'newUsersVsReturningUsers':
				$newUsersSession = [];
				$returningUsers = [];
				$this_week_session = [];

				$thisWeek = Helper::getChartData( ['from' => $thisSunday, 'to' => $thisSaturday] );
				$newUsers = Helper::getChartData( ['from' => $thisSunday, 'to' => $thisDay, 'metrics' => 'ga:percentNewSessions'] );

				foreach ($thisWeek as $data)
				{
					$day[] = date('D', Helper::format_ga_date($data[0]));
					$this_week_session[] = $data[1];
				}
				foreach ($newUsers as $key => $data) $newUsersSession[] = ceil(( $this_week_session[$key] * $data[1] ) / 100);
				foreach ($newUsersSession as $key => $data) $returningUsers[] = $this_week_session[$key] - $data;

				$response = [
					'day' => $day,
					'newUsersSession' => $newUsersSession,
					'returningUsers' => $returningUsers,
				];
			break;

			case 'last30Days':
				$day = [];
				$session = [];

				$last30Days = Helper::getChartData( ['days' => 30] );

				foreach ($last30Days as $data)
				{
					$day[] = date('M-d', Helper::format_ga_date($data[0]));
					$session[] = $data[1];
				}

				$response = [
					'day' => $day,
					'session' => $session,
				];
			break;
			
			default:
				$response = [
					'status' => 'error',
					'message' => 'No parameters detected',
				];
			break;
		}

		return response()->json($response);
	}

	public function realtime_data()
	{
		// cache()->flush(); // This clears the cache
		$add_fifteen = Carbon::now()->addSeconds(15);
		$visitors = cache()->remember('realtime_visitors', $add_fifteen, function() {
			$realtime_data = Analytics::getAnalyticsService()->data_realtime->get(
				'ga:'.env('ANALYTICS_VIEW_ID'),
				'rt:activeVisitors'
			)->totalsForAllResults['rt:activeVisitors'];
			return number_format($realtime_data, 0);
		});

		$sources = cache()->remember('realtime_sources', $add_fifteen, function() {
			$realtime_sources = Analytics::getAnalyticsService()->data_realtime->get(
				'ga:'.env('ANALYTICS_VIEW_ID'),
				'rt:activeVisitors',
				[
					'dimensions' => 'rt:source',
					'sort' => '-rt:activeVisitors',
					'max-results' => '5'
				]
			)->rows;
			$realtime_data = [];
			if ( count($realtime_sources) > 0 )
			{
				foreach ( $realtime_sources as $source ) $realtime_data[] = $source[0];
			}
			return $realtime_data;
		});

		$pages = cache()->remember('realtime_pages', $add_fifteen, function() {
			$realtime_pages = Analytics::getAnalyticsService()->data_realtime->get(
				'ga:'.env('ANALYTICS_VIEW_ID'),
				'rt:activeVisitors',
				[
					'dimensions' => 'rt:pageTitle, rt:pagePath',
					'sort' => '-rt:activeVisitors',
					'max-results' => '5'
				]
			)->rows;
			$realtime_data = [];
			if ( count($realtime_pages) > 0 )
			{
				foreach ( $realtime_pages as $page )
				{
					$realtime_data[] = [
						'title' => $page[0],
						'link' => asset('').substr($page[1], 1)
					];
				}
			}
			return $realtime_data;
		});

		$return_data = [
			'realtime_visitors' => $visitors,
			'realtime_sources' => $sources,
			'realtime_pages' => $pages,
		];

		return response()->json($return_data);
	}
}