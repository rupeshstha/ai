@extends('voyager::master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/chart.css') }}">
@stop

@section('content')
<div class="page-content">
@include('voyager::alerts')
	<div class="analytics-container">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-bordered realtime-panel">
					<div class="panel-heading analytics-panel">
						<h3>
							Active Users right now
						</h3>
					</div>
					<div class="panel-body realtime-body">
						<span class="chart_loader" id="chart_loader_realtime_visitors">
							<i class="voyager-helm"></i>
						</span>
						<div class="text-center">
							<h1 id="realtime_visitors"></h1>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-bordered realtime-panel">
					<div class="panel-heading analytics-panel">
						<h3>
							Traffic Sources right now
						</h3>
					</div>
					<div class="panel-body realtime-body">
						<span class="chart_loader" id="chart_loader_realtime_sources">
							<i class="voyager-helm"></i>
						</span>
						<div class="realtime_sources realtime-list">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-bordered realtime-panel">
					<div class="panel-heading analytics-panel">
						<h3>
							Active Pages right now
						</h3>
					</div>
					<div class="panel-body realtime-body">
						<span class="chart_loader" id="chart_loader_realtime_pages">
							<i class="voyager-helm"></i>
						</span>
						<div class="realtime_pages realtime-list">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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

	var realtime_app = {
		init : function()
		{
			request = $.ajax({
				url : "{{ route('admin.realtime_data') }}"
			});

			request.done( function(remote_data)
			{
				realtime_app.stats = remote_data;
				realtime_app.load_visitor();
				realtime_app.load_source();
				realtime_app.load_page();
			});
		},
		load_visitor : function()
		{
			$('#chart_loader_realtime_visitors').fadeOut( function() {
				$('#realtime_visitors').fadeOut( function() {
					$(this).html(realtime_app.stats.realtime_visitors);
					$(this).fadeIn();
				});
			});
		},
		load_source : function()
		{
			$('#chart_loader_realtime_sources').fadeOut( function() {
				$('.realtime_sources').fadeOut( function() {
					if ( realtime_app.stats.realtime_sources.length > 0 )
					{
						template = `<ul>`;
						$.each(realtime_app.stats.realtime_sources, function( index, value ) {
							template += `<li><i class="voyager-paperclip"></i> ${value}</li>`;
						});
						template += `</ul>`;
					}
					else
					{
						template = `<div class="text-center"><h3>Not Available</h3></div>`;
					}
					$(this).html(template);
					$(this).fadeIn();
				});
			});
		},
		load_page : function()
		{
			$('#chart_loader_realtime_pages').fadeOut( function() {
				$('.realtime_pages').fadeOut( function() {
					if ( realtime_app.stats.realtime_pages.length > 0 )
					{
						template = `<ul>`;
						$.each(realtime_app.stats.realtime_pages, function( index, value ) {
							template += `<li><a href="${value['link']}" title="${value['title']}" target="_blank"><i class="voyager-external"></i> ${value['title']}</a></li>`;
						});
						template += `</ul>`;
					}
					else
					{
						template = `<div class="text-center"><h3>Not Available</h3></div>`;
					}
					$(this).html(template);
					$(this).fadeIn();
				});
			});
		}
	}
	realtime_app.init();
	window.setInterval(realtime_app.init, 15000);
	app.init();
});
</script>
@stop