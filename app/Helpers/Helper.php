<?php
namespace App\Helpers;
use File, Analytics, Auth, Hash;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class Helper
{
	// Format Google Analytics Date
	public static function format_ga_date($date)
	{
		return strtotime( substr($date, 0, 4) . '-'. substr($date, 4, 2) . '-'. substr($date, 6, 2));
	}

	// Generate Analytics according to Days
	public static function analytics_days( $days, $analytics_parameter )
	{
		return Analytics::performQuery(
			Period::days($days), // Using days(...) for Days option
			'ga:sessions',
			$analytics_parameter
		);
	}

	// Generate Analytics according to Start Date and End Date
	public static function analytics_create( $from, $to, $analytics_parameter )
	{
		return Analytics::performQuery(
			Period::create($from, $to), // Using create(...) for Periodic option
			'ga:sessions',
			$analytics_parameter
		);
	}

	// Function to get Chartdata (Parameters sent via an array)
	public static function getChartData( $parameters )
	{
		$analytics_parameter = [
			'metrics' => 'ga:sessions',
			'dimensions' => 'ga:date'
		];

		if ( isset( $parameters['days'], $parameters['max'], $parameters['sort'], $parameters['dimension'] ) )
		{
			$analytics_parameter['dimensions'] = 'ga:'.$parameters['dimension'];
			$analytics_parameter['max-results'] = $parameters['max'];
			$analytics_parameter['sort'] = '-ga:sessions';
			$data = self::analytics_days($parameters['days'], $analytics_parameter);
		}
		elseif ( isset( $parameters['days'] ) )
		{
			$data = self::analytics_days($parameters['days'], $analytics_parameter);
		}
		elseif ( isset( $parameters['metrics'] ) )
		{
			$analytics_parameter['metrics'] = $parameters['metrics'];
			$data = self::analytics_create($parameters['from'], $parameters['to'], $analytics_parameter);
		}
		else
		{
			$data = self::analytics_create($parameters['from'], $parameters['to'], $analytics_parameter);
		}

		return $data;
	}
}