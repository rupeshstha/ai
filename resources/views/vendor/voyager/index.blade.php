@extends('voyager::master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/chart.css') }}">
@stop

@section('content')
<div class="page-content">
@include('voyager::alerts')
@if ( env('ANALYTICS_VIEW_ID') != null )
	<div class="analytics-container">
		<div class="row" id="analytics_charts">{{-- Charts Divs will be added dynamically wtih javascript --}}
		</div>
	</div>
@endif
</div>
@stop

@section('javascript')
<script src="{{ asset('assets/admin/chart.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/chart_plugin.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/analytics_chart.js') }}" type="text/javascript"></script>
<script>
$(function()
{
	var data, request, cache_minute, chart_ids, chart_divs, analytics_charts;
	var app = {
		// Initialize
		init : function()
		{
			cache_minute = 30; // Set the cache time for analytics to be stored
			expire_threshold = cache_minute * 1000 * 60;

			chart_ids = [
				'thisWeekVsLastWeek', // This Week Vs Last Week
				'topBrowsers', // Top Browsers
				'topCountries', // Top Countries
				'topSources', // Top Sources
				'activeUsers', // Active Users
				'newUsersVsReturningUsers', // New Vs Returning users
				'last30Days' // Last 30 days Analytics
			];
			chart_divs = {
				'thisWeekVsLastWeek' : {
					'title' : 'This Week Vs. Last Week',
					'sub_title' : 'Sessions',
					'column' : '6'
				},
				'topBrowsers' : {
					'title' : 'Top Browsers',
					'sub_title' : 'Last 7 Days',
					'column' : '6'
				},
				'topCountries' : {
					'title' : 'Top Countries',
					'sub_title' : 'Last 7 Days',
					'column' : '6'
				},
				'topSources' : {
					'title' : 'Top Sources',
					'sub_title' : 'Last 7 Days',
					'column' : '6'
				},
				'activeUsers' : {
					'title' : 'Active Users',
					'sub_title' : 'This Week',
					'column' : '6'
				},
				'newUsersVsReturningUsers' : {
					'title' : 'New Vs. Returning Users',
					'sub_title' : 'This Week',
					'column' : '6'
				},
				'last30Days' : {
					'title' : 'Last 30 days',
					'sub_title' : 'session',
					'column' : '12'
				}
			};
			analytics_charts = $('#analytics_charts');

			// Loop through all the chart_ids and generate chart
			$.each( chart_ids, function(index, id)
			{
				app.generate_div(id);
				app.analytics(id);
			});
		},
		// Check if the cache time has been completed
		is_expired : function( check_date )
		{
			current_date = new Date;
			recorded_date = new Date( check_date );
			time_diff = Math.abs( current_date.getTime() - recorded_date.getTime() );
			return ( time_diff > expire_threshold ) ? true : false;
		},
		// Generate an analytics chart Div.
		generate_div : function(self_id)
		{
			div_template = `
			<div class="col-md-${chart_divs[self_id].column}">
				<div class="panel panel-bordered">
					<div class="panel-body">
						<div class="panel-heading analytics-panel">
							<h3>
								${chart_divs[self_id].title} <small>( ${chart_divs[self_id].sub_title} )</small>
							</h3>
						</div>
						<span class="chart_loader" id="chart_loader_${self_id}">
							<i class="voyager-helm"></i>
						</span>
						<div>
							<canvas id="${self_id}"></canvas>
						</div>
					</div>
				</div>
			</div>
			`;

			analytics_charts.append(div_template);
		},
		// Check Analytics local
		analytics : function(self_id)
		{
			if ( !localStorage[self_id] || app.is_expired( localStorage[self_id+'_created_at'] ) )
			{
				app.analytics_remote(self_id);
				return false;
			}

			data = JSON.parse(localStorage[self_id]);
			generate_chart[self_id](data );
		},
		// Analytics remote
		analytics_remote : function(self_id)
		{
			request = $.ajax({
				url : "{{ route('admin.chart_data') }}/"+self_id
			});

			request.done( function(remote_data)
			{
				localStorage.setItem(self_id, JSON.stringify(remote_data));
				localStorage.setItem(self_id+'_created_at', new Date);
				generate_chart[self_id](remote_data );
			});
		}
	}
	app.init();
});
</script>
@stop