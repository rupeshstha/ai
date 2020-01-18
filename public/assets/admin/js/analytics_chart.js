var generate_chart = {
	thisWeekVsLastWeek : function(data)
	{
		var ctx = $("#thisWeekVsLastWeek");
		var thisWeekVsLastWeek = new Chart(ctx, {
			type: 'line',
			data: {
				labels: data.day,
				datasets: [{
					label: 'This Week',
					data: data.this_week_session,
					fillColor: "#000",
					backgroundColor: 'rgba(52, 152, 219, 0.4)',
					borderColor: 'rgba(52, 152, 219, 1.0)',
					borderWidth: 1,
					datalabels: {
						align: 'end',
						anchor: 'end'
					}
				},{
					label: 'Last Week',
					data: data.last_week_session,
					backgroundColor: 'rgba(189, 195, 199, 0.4)',
					borderColor: 'rgba(189, 195, 199, 1.0)',
					borderWidth: 1,
					datalabels: {
						align: 'end',
						anchor: 'end'
					}
				}]
			},
			options: {
				plugins: {
					datalabels: {
						backgroundColor: function(context) {
							return context.dataset.borderColor;
						},
						borderRadius: 5,
						font: {
							weight: 'bold'
						},
						color: function(context) {
							colorString = context.dataset.borderColor,
							colorsOnly = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/),
							red = colorsOnly[0],
							green = colorsOnly[1],
							blue = colorsOnly[2],
							opacity = colorsOnly[3];
							if ((red*0.299 + green*0.587 + blue*0.114) > 186)
							{
								return '#000';
							}
							return '#fff';
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
		$("#chart_loader_thisWeekVsLastWeek").fadeOut();
	},
	topBrowsers : function(data)
	{
		var ctx = document.getElementById("topBrowsers");
		var topBrowsers = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: data.browser,
				datasets: [{
					data: data.session,
					backgroundColor: [
						'rgba(52, 152, 219,1.0)',
						'rgba(231, 76, 60,1.0)',
						'rgba(230, 126, 34,1.0)',
						'rgba(46, 204, 113,1.0)',
						'rgba(189, 195, 199,1.0)'
					]
				}]
			},
			options: {
				legend: {
					position: 'right'
				},
				plugins: {
					datalabels: {
						font: {
							weight: 'bold'
						},
						color: '#fff'
					}
				}
			}
		});
		$("#chart_loader_topBrowsers").fadeOut();
	},
	topCountries : function(data)
	{
		var ctx = document.getElementById("topCountries");
		var topCountries = new Chart(ctx, {
			type: 'doughnut',
			data: {
				labels: data.country,
				datasets: [{
					data: data.session,
					backgroundColor: [
						'rgba(52, 152, 219,1.0)',
						'rgba(231, 76, 60,1.0)',
						'rgba(230, 126, 34,1.0)',
						'rgba(46, 204, 113,1.0)',
						'rgba(189, 195, 199,1.0)'
					]
				}]
			},
			options: {
				legend: {
					position: 'right'
				},
				plugins: {
					datalabels: {
						font: {
							weight: 'bold'
						},
						color: '#fff'
					}
				}
			}
		});
		$("#chart_loader_topCountries").fadeOut();
	},
	topSources : function(data)
	{
		var ctx = document.getElementById("topSources");
		var topSources = new Chart(ctx, {
			type: 'doughnut',
			data: {
				labels: data.source,
				datasets: [{
					data: data.session,
					backgroundColor: [
						'rgba(52, 152, 219,1.0)',
						'rgba(231, 76, 60,1.0)',
						'rgba(230, 126, 34,1.0)',
						'rgba(46, 204, 113,1.0)',
						'rgba(189, 195, 199,1.0)'
					]
				}]
			},
			options: {
				legend: {
					position: 'right'
				},
				plugins: {
					datalabels: {
						font: {
							weight: 'bold'
						},
						color: '#fff'
					}
				}
			}
		});
		$("#chart_loader_topSources").fadeOut();
	},
	activeUsers : function(data)
	{
		var ctx = document.getElementById("activeUsers");
		var activeUsers = new Chart(ctx, {
			type: 'line',
			data: {
				labels: data.day,
				datasets: [{
					label: 'Active Users',
					data: data.session,
					fillColor: "#000",
					backgroundColor: 'rgba(52, 152, 219, 0.4)',
					borderColor: 'rgba(52, 152, 219, 1.0)',
					borderWidth: 1,
					datalabels: {
						align: 'end',
						anchor: 'end'
					}
				}]
			},
			options: {
				plugins: {
					datalabels: {
						backgroundColor: function(context) {
							return context.dataset.borderColor;
						},
						borderRadius: 5,
						font: {
							weight: 'bold'
						},
						color: function(context) {
							colorString = context.dataset.borderColor,
							colorsOnly = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/),
							red = colorsOnly[0],
							green = colorsOnly[1],
							blue = colorsOnly[2],
							opacity = colorsOnly[3];
							if ((red*0.299 + green*0.587 + blue*0.114) > 186)
							{
								return '#000';
							}
							return '#fff';
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
		$("#chart_loader_activeUsers").fadeOut();
	},
	newUsersVsReturningUsers : function(data)
	{
		var ctx = document.getElementById("newUsersVsReturningUsers");
		var newUsersVsReturningUsers = new Chart(ctx, {
			type: 'line',
			data: {
				labels: data.day,
				datasets: [{
					label: 'New Users',
					data: data.newUsersSession,
					fillColor: "#000",
					backgroundColor: 'rgba(52, 152, 219, 0.4)',
					borderColor: 'rgba(52, 152, 219, 1.0)',
					borderWidth: 1,
					datalabels: {
						align: 'end',
						anchor: 'end'
					}
				},{
					label: 'Returning Users',
					data: data.returningUsers,
					backgroundColor: 'rgba(192, 57, 43, 0.4)',
					borderColor: 'rgba(192, 57, 43, 1.0)',
					borderWidth: 1,
					datalabels: {
						align: 'end',
						anchor: 'end'
					}
				}]
			},
			options: {
				plugins: {
					datalabels: {
						backgroundColor: function(context) {
							return context.dataset.borderColor;
						},
						borderRadius: 5,
						font: {
							weight: 'bold'
						},
						color: function(context) {
							colorString = context.dataset.borderColor,
							colorsOnly = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/),
							red = colorsOnly[0],
							green = colorsOnly[1],
							blue = colorsOnly[2],
							opacity = colorsOnly[3];
							if ((red*0.299 + green*0.587 + blue*0.114) > 186)
							{
								return '#000';
							}
							return '#fff';
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
		$("#chart_loader_newUsersVsReturningUsers").fadeOut();
	},
	last30Days : function(data)
	{
		var ctx = document.getElementById("last30Days");
		var last30Days = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: data.day,
				datasets: [{
					label: 'Last 30 days',
					data: data.session,
					fillColor: "#000",
					backgroundColor: 'rgba(52, 152, 219, 1)',
					datalabels: {
						align: 'end',
						anchor: 'end'
					}
				}]
			},
			options: {
				plugins: {
					datalabels: {
						color: function (context) {
							return context.dataset.backgroundColor;
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
		$("#chart_loader_last30Days").fadeOut();
	}
};