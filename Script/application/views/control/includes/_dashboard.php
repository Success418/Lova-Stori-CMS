<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui four doubling cards" id="items-count">
	<div class="card card-1">
		<div class="content title">
			<i class="right floated sync icon _posts" data-table="posts"></i>
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/article.png') ?>">
			<div class="header">
				<?= lang('ui_posts') ?>
			</div>
			<div class="meta">
				<span>Total <?= lang('ui_posts') ?></span>
			</div>
		</div>
		<div class="content count p-0">
			<div class="ui m-0 horizontal segments">
				<div class="ui attached segment center aligned" style="align-self:center">
					<h3><?= round_int($posts_count) ?></h3>
				</div>
				<div class="ui attached segment center aligned xs-hidden">
					<h1><i class="file outline icon m-0"></i></h1>
				</div>
			</div>
		</div>
		<a href="<?= base_url('control/posts') ?>" class="ui bottom attached button">
			<i class="ellipsis horizontal big icon mx-0"></i>
		</a>
	</div>
	<div class="card card-2">
		<div class="content title">
			<i class="right floated sync icon _users" data-table="users"></i>
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/users.png') ?>">
			<div class="header">
				<?= lang('ui_users') ?>
			</div>
			<div class="meta">
				<span>Total <?= lang('ui_users') ?></span>
			</div>
		</div>
		<div class="content count p-0">
			<div class="ui m-0 horizontal segments">
				<div class="ui attached segment center aligned" style="align-self:center">
					<h3><?= round_int($users_count) ?></h3>
				</div>
				<div class="ui attached segment center aligned xs-hidden">
					<h1><i class="users icon m-0"></i></h1>
				</div>
			</div>
		</div>
		<a href="<?= base_url('control/users/members') ?>" class="ui bottom attached button">
			<i class="ellipsis horizontal big icon mx-0"></i>
		</a>
	</div>
	<div class="card card-3">
		<div class="content title">
			<i class="right floated sync icon _subscribers" data-table="subscribers"></i>
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/subscribers.png') ?>">
			<div class="header">
				<?= lang('ui_subscribers') ?>
			</div>
			<div class="meta">
				<span>Total <?= lang('ui_subscribers') ?></span>
			</div>
		</div>
		<div class="content count p-0">
			<div class="ui m-0 horizontal segments">
				<div class="ui attached segment center aligned" style="align-self:center">
					<h3><?= round_int($subscribers_count) ?></h3>
				</div>
				<div class="ui attached segment center aligned xs-hidden">
					<h1><i class="envelope outline icon m-0"></i></h1>
				</div>
			</div>
		</div>
		<a href="<?= base_url('control/newsletter/subscribers') ?>" class="ui bottom attached button">
			<i class="ellipsis horizontal big icon mx-0"></i>
		</a>
	</div>
	<div class="card card-4">
		<div class="content title">
			<i class="right floated sync icon _comments" data-table="comments"></i>
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/comments.png') ?>">
			<div class="header">
				<?= lang('ui_comments') ?>
			</div>
			<div class="meta">
				<span>Total <?= lang('ui_comments') ?></span>
			</div>
		</div>
		<div class="content count p-0">
			<div class="ui m-0 horizontal segments">
				<div class="ui attached segment center aligned" style="align-self:center">
					<h3><?= round_int($comments_count) ?></h3>
				</div>
				<div class="ui attached segment center aligned xs-hidden">
					<h1><i class="comments outline icon m-0"></i></h1>
				</div>
			</div>
		</div>
		<a href="<?= base_url('control/comments') ?>" class="ui bottom attached button">
			<i class="ellipsis horizontal big icon mx-0"></i>
		</a>
	</div>
</div>
<div class="ui hidden divider"></div>
<div class="ui stackable two column grid" id="visits-count">
	<div class="eleven wide column">
		<div class="ui fluid card lineChart">
			<div class="content title">
				<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/chart.png') ?>">
				<i class="right floated sync icon"></i>
				<div class="header"><?= lang('ui_daily_visits') ?></div>
				<div class="meta">
					<span class="date"><?= lang('ui_daily_vists_label') ?></span>
				</div>
			</div>
			<div class="content">
				<select class="ui dropdown" name="month">
					<?php foreach(lang('ui_months') as $k => $month): ?>
					<option value="<?= $k+1 ?>"><?= $month ?></option>	
					<?php endforeach ?>
				</select>
			</div>
			<div class="content scroll horizontally px-0">
				<canvas id="lineChart" style="height:320px; min-width:100%"></canvas>
			</div>
			<div class="content title">
				<div class="meta count">
					<div>Total <?= lang('ui_visits') ?> : <span><?= round_int($non_unique_traffic_count) ?></span></div>
				</div>
			</div>
		</div>		
	</div>
	<div class="five wide column">
		<div class="ui fluid card" id="popular-posts">
			<div class="content title">
				<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/article.png') ?>">
				<i class="right floated sync icon"></i>
				<div class="header"><?= lang('ui_most_visited_pages') ?></div>
				<div class="meta">
					<span class="date"><?= lang('ui_most_visited_pages_label') ?></span>
				</div>
			</div>
			<div class="content scroll vertically horizontally px-0" style="height: 388px;">
				<table class="ui basic celled single line unstackable table">
					<thead>
						<tr>
							<th><?= lang('ui_page') ?></th>
							<th class="right aligned"><?= lang('ui_views') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($popular_posts as $post): ?>
							<tr>
								<td class="fixed wide">
									<a href="<?= base_url("post/{$post->post_slug}") ?>" title="<?= $post->post_title ?>">
										<?= $post->post_title ?>
									</a>		
								</td>
								<td class="right aligned"><?= $post->post_views ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>	
			</div>
			<div class="content title">
				<div class="meta count">
					&nbsp;
				</div>
			</div>
		</div>
	</div>
</div>
<div class="ui hidden divider"></div>
<div class="ui two stackable cards" id="recent-entries">
	<div class="card _users">
		<div class="content title">
			<i class="right floated sync icon" data-table="users"></i>
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/users.png') ?>">
			<div class="header">
				<?= lang('ui_users') ?>
			</div>
			<div class="meta">
				<span><?= lang('ui_latest_registered_users') ?></span>
			</div>
		</div>
		<div class="content scroll horizontally p-0">
			<table class="ui basic celled single line unstackable table">
				<thead>
					<tr>
						<th><?= lang('ui_username') ?></th>
						<th>Email</th>
						<th><?= lang('ui_country') ?></th>
						<th><?= lang('ui_date') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($latest_users as $user): ?>
						<tr>
							<td><?= $user->user_name ?></td>
							<td><?= $user->user_email ?></td>
							<td><?= $user->user_country_EN ?></td>
							<td><?= $user->user_created_at ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card _subscribers">
		<div class="content title">
			<i class="right floated sync icon" data-table="subscribers"></i>
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/subscribers.png') ?>">
			<div class="header">
				<?= lang('ui_subscribers') ?>
			</div>
			<div class="meta">
				<span><?= lang('ui_latest_subscribers') ?></span>
			</div>
		</div>
		<div class="content scroll horizontally p-0">
			<table class="ui basic celled single line unstackable table">
				<thead>
					<tr>
						<th>Email</th>
						<th><?= lang('ui_country') ?></th>
						<th><?= lang('ui_date') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($latest_subscribers as $subscriber): ?>
						<tr>
							<td><?= $subscriber->email ?></td>
							<td><?= $subscriber->country_EN ?></td>
							<td><?= $subscriber->created_at ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="ui hidden divider"></div>
<div class="ui stackable two column grid" id="visits-origins">
	<div class="eleven wide column">
		<div class="ui fluid card">
			<div class="content title">
				<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/globe.png') ?>">
				<div class="header">
					<?= lang('ui_traffic_origin') ?>
				</div>
				<div class="meta">
					<span><?= lang('ui_traffic_origin_label') ?></span>
				</div>
			</div>
			<div class="content px-0">
				<div id="world-map"></div>
			</div>
			<div class="content title">
				<div class="meta">
					<div class="ui labels">
					<?= lang('ui_top_locations') ?>
					<span class="p-1"></span>
					<?php foreach($top_traffic_locations as $location => $traffic): ?>
						<span class="ui blue basic label"><?= "$location : $traffic" ?></span>
					<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="five wide column">
		<div class="ui fluid card">
			<div class="content title">
				<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/square-dashed.png') ?>">
				<div class="header">
					<?= lang('ui_web_rebots_scraper') ?>
				</div>
				<div class="meta">
					<span><?= lang('ui_web_rebots_scraper_label') ?></span>
				</div>
			</div>
			<div class="content scroll vertically horizontally px-0" style="height: 329px">
				<table class="ui basic celled single line unstackable table">
					<thead>
						<tr>
							<th>Robot</th>
							<th class="right aligned">%</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($robots as $robot => $percentage): ?>
							<tr>
								<td class="fixed wide"><?= ucfirst($robot) ?>	</td>
								<td class="right aligned"><?= $percentage ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="content title" style="height: 63px">
				<div class="meta">
					&nbsp;
				</div>
			</div>
		</div>
	</div>
</div>
<div class="ui hidden divider"></div>
<div class="ui three stackable cards" id="user-agent-stats">
	<div class="card">
		<div class="content title">
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/browsers.png') ?>">
			<div class="header">
				<?= lang('ui_browsers') ?>
			</div>
			<div class="meta">
				<span><?= lang('ui_browsers_label') ?></span>
			</div>
		</div>
		<div class="content scroll vertically horizontally px-0">
			<table class="ui basic celled single line unstackable table">
				<thead>
					<tr>
						<th><?= lang('ui_browser') ?></th>
						<th class="right aligned">%</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($browsers as $browser => $percentage): ?>
						<tr>
							<td class="fixed wide"><?= ucfirst($browser) ?></td>
							<td class="right aligned"><?= $percentage ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card">
		<div class="content title">
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/screen_sizes.png') ?>">
			<div class="header">
				<?= lang('ui_screen_sizes') ?>
			</div>
			<div class="meta">
				<span><?= lang('ui_screen_sizes_list') ?></span>
			</div>
		</div>
		<div class="content scroll vertically horizontally px-0">
			<table class="ui basic celled single line unstackable table">
				<thead>
					<tr>
						<th><?= lang('ui_screen_size') ?></th>
						<th class="right aligned">%</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($screen_sizes as $ss => $percentage): ?>
						<tr>
							<td class="fixed wide"><?= ucfirst($ss) ?></td>
							<td class="right aligned"><?= $percentage ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card">
		<div class="content title">
			<img class="left floated mini ui image mb-0" src="<?= base_url('assets/control/images/os.png') ?>">
			<div class="header">
				<?= lang('ui_operating_systems') ?>
			</div>
			<div class="meta">
				<span><?= lang('ui_os_label') ?></span>
			</div>
		</div>
		<div class="content scroll vertically horizontally px-0">
			<table class="ui basic celled single line unstackable table">
				<thead>
					<tr>
						<th><?= lang('ui_operating_system') ?></th>
						<th class="right aligned">%</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($operating_systems as $os => $percentage): ?>
						<tr>
							<td class="fixed wide"><?= ucfirst($os) ?></td>
							<td class="right aligned"><?= $percentage ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	window.traffic_chart_days = <?= json_encode($traffic_chart_days, TRUE) ?>;
	window.unique_visits 	  = <?= json_encode($unique_traffic_per_day, TRUE) ?>;
	window.non_unique_visits  = <?= json_encode($non_unique_traffic_per_day, TRUE) ?>;
	window.worldMapData 	  = <?= strtolower(json_encode($traffic_per_country)) ?>;
	window.chart_labels		  = {'unique_visits': '<?= lang('ui_unique_visits') ?>',
								 'non_unique_visits': '<?= lang('ui_non_unique_visits') ?>'}
</script>
<script src="<?= base_url('assets/control/js/dashboard.js?v=').time() ?>"></script>
<div class="ui hidden divider"></div>