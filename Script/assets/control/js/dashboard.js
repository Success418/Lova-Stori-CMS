$(function() {

	// WORDMAP
	$('#world-map').vectorMap({
        map: 'world_en',
        backgroundColor: "#fff",
        enableZoom: false,
        showTooltip: false,
        series: {
            regions: [{
              values: worldMapData,
              scale: ['#75B4BE', '#007688'],
              normalizeFunction: 'polynomial'
            }]
        },
        onRegionTipShow: (e, el, code)=> {
          el.html(el.html() + ':' +  worldMapData[code] + ' visits');
        }
    });



	// TRAFFIC CHART
	var ctx1 = document.getElementById("lineChart").getContext('2d');
	
	window.lineChart = new Chart(ctx1, {
		type: 'bar',
		responsive: false,
		data: {
			labels: traffic_chart_days,
			datasets: [{
					label: chart_labels.unique_visits,
					backgroundColor: '#E0E3E7',
					data: unique_visits
				}, {
					label: chart_labels.non_unique_visits,
					backgroundColor: '#EA4444',
					data: non_unique_visits
				}]
		},
		options: {
			tooltips: {
				mode: 'index',
				intersect: false,
				backgroundColor: '#fff',
				cornerRadius: 0,
				bodyFontColor: '#000',
				titleFontColor: '#000',
				legendColorBackground: '#000'
			},
			responsive: false,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					stacked: true,
				}],
				yAxes: [{
					stacked: false
				}]
			}
		}
	});



	$('#items-count .sync.icon').on('click', function() {
		var table_name 	= $(this).data('table');
		var thisEl 		= $(this);

		$.post(window.origin + '/control/dashboard/refresh_items_count', {table_name: table_name})
		.done(function(data) {
			thisEl.closest('.card')
				  .css('opacity', 0)
				  .animate({
				  	opacity: 1
				  }, 200)
				  .find('.count h3').text(data.count);
		})
	})



	$('.lineChart .sync.icon').on('click', function() {
		var selectedMonth = parseInt($('select[name="month"]').val());
		var currentMonth  = new Date().getMonth()+1;

		if(selectedMonth === currentMonth)
		{
			$.post(window.origin + '/control/dashboard/refresh_traffic_data')
			.done(function(trafficData) {
				lineChart.data.datasets[0]['data'] = trafficData.unique_visits;
				lineChart.data.datasets[1]['data'] = trafficData.non_unique_visits;

				$('.lineChart .count span').text(trafficData.non_unique_traffic);

				lineChart.update();

				$('#lineChart')
				.css('opacity', 0)
				.animate({
					opacity: 1
				}, 200);
			})
		}
		else
		{
			$('select[name="month"]')
			.dropdown('set selected', new Date().getMonth()+1);
		}
	})



	$('select[name="month"]')
	.dropdown('set selected', new Date().getMonth()+1)
	.change(function(e) {
		if(/^([1-9]|1[0-2])$/.test($(e.target).val()))
		{
			var month 		= {'month': $(e.target).val()};
			var requestUrl  = window.origin + '/control/dashboard/traffic_by_month';

			$.post(requestUrl, month)
			.done(function(trafficData) {
				lineChart.data.datasets[0]['data'] = trafficData.unique_visits;
				lineChart.data.datasets[1]['data'] = trafficData.non_unique_visits;

				lineChart.data.labels = trafficData.traffic_chart_days;

				$('.lineChart .count span').text(trafficData.non_unique_traffic);

				lineChart.update();

				$('#lineChart')
				.css('opacity', 0)
				.animate({
					opacity: 1
				}, 200);
			})
		}
	})



	$('#popular-posts .sync.icon').on('click', function() {
		var thisEl = $(this);

		$.post(window.origin + '/control/dashboard/popular_posts')
		.done(function(posts) {
			var newBody = '';
			var baseUrl = location.origin;

			if(posts)
			{
				for(var k in posts)
				{
					newBody += '\
					<tr>\
						<td class="fixed wide">\
							<a href="'+ baseUrl +'/post/'+ posts[k]['post_slug'] +'" \
							   title="'+ posts[k]['post_title'] +'">\
								'+ posts[k]['post_title'] + '\
							</a>\
						</td>\
						<td class="right aligned">'+ posts[k]['post_views'] +'</td>\
					</tr>';
				}
			}

			$('#popular-posts tbody').html(newBody)
			.css('opacity', 0)
			.animate({
				opacity: 1
			}, 200);
		})
	})



	$('._users i.sync, ._subscribers i.sync').on('click', function() {
		var table = $(this).data('table');

		if(/^(users|subscribers)$/.test(table))
		{
			var requestUrl  = window.origin + '/control/dashboard/recent_users_subscribers';

			$.post(requestUrl, {'table': table})
			.done(function(items) {
				var newBody = '';

				if(table === 'users')
				{
					for(var k in items)
					{
						var country = (items[k]['user_country_EN'] != null)
									  ? items[k]['user_country_EN']
									  : '-';
						newBody += '\
						<tr>\
							<td>' + items[k]['user_name'] + '</td>\
							<td>' + items[k]['user_email'] + '</td>\
							<td>' + country + '</td>\
							<td>' + items[k]['user_created_at'] + '</td>\
						</tr>';
					}
				}
				else
				{
					for(var k in items)
					{
						var country = (items[k]['country_EN'] != null)
									  ? items[k]['country_EN']
									  : '-';
						newBody += '\
						<tr>\
							<td>' + items[k]['email'] + '</td>\
							<td>' + country + '</td>\
							<td>' + items[k]['created_at'] + '</td>\
						</tr>';
					}
				}


				$('._' + table + ' tbody').html(newBody)
				.css('opacity', 0)
				.animate({
					opacity: 1
				}, 200);
			})	
		}
	})

})