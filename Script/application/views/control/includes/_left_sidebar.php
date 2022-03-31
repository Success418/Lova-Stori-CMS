<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui header p-0">
	<a href="/control">
		<img class="ui image m-auto p-3" width="169" height="22" src="<?= base_url("assets/images/logo_panel.png") ?>" alt="logo">
	</a>
</div>
<div id="left-menu">
	<div class="ui fluid inverted vertical menu py-0">
		<!-- DASHBOARD -->
		<div class="item">
			<a class="header" href="<?= base_url("control/dashboard") ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/chart-white.png') ?>" alt="x">
				</span>
				<?= lang('ui_dashboard') ?>
			</a>
		</div>
		<?php if(has_permission('posts')): ?>
		<!-- POSTS -->
		<div class="item">
			<div class="item parent">
				<div class="header">
					<span class="ui avatar image">
						<img src="<?= base_url('assets/control/images/article-white.png') ?>" alt="x">
					</span>
					<?= lang('ui_posts') ?>
				</div>
			</div>
			<div class="menu">
				<a href="<?= base_url('control/posts/add') ?>" class="item">
					<?= lang('ui_add_post') ?>
				</a>
				<a href="<?= base_url('control/posts') ?>" class="item">
					<?= lang('ui_posts_list') ?>
				</a>
			</div>
		</div>
		<?php endif ?>
		<?php if(has_permission('pages')): ?>
		<!-- PAGES -->
		<div class="item">
			<div class="item parent borderless">
				<div class="header">
					<span class="ui avatar image">
						<img src="<?= base_url('assets/control/images/page-white.png') ?>" alt="x">
					</span>
					<?= lang('ui_pages') ?>
				</div>
			</div>
			<div class="menu">
				<a href="<?= base_url('control/pages/add') ?>" class="item">
					<?= lang('ui_add_page') ?>
				</a>
				<a href="<?= base_url('control/pages') ?>" class="item">
					<?= lang('ui_pages_list') ?>
				</a>
			</div>
		</div>
		<?php endif ?>
		<?php if(has_permission('users')): ?>
		<!-- USERS -->
		<div class="item">
			<div class="item parent borderless">
				<div class="header">
					<span class="ui avatar image">
						<img src="<?= base_url('assets/control/images/users-white.png') ?>" alt="x">
					</span>
					<?= lang('ui_users') ?>
				</div>
			</div>
			<div class="menu">
				<a href="<?= base_url('control/users/members') ?>" class="item">
					<?= lang('ui_members') ?>
				</a>
				<a href="<?= base_url('control/users/authors') ?>" class="item">
					<?= lang('ui_authors') ?>
				</a>
				
				<a href="<?= base_url('control/users/moderators') ?>" class="item">
					<?= lang('ui_moderators') ?>
				</a>
				<a href="<?= base_url('control/users/administrators') ?>" class="item">
					<?= lang('ui_administrators') ?>
				</a>
				
				<?php if(has_permission('users', 'add')): ?>
				<a href="<?= base_url('control/users/add') ?>" class="item">
					<?= lang('ui_add_user') ?>
				</a>
				<?php endif ?>
			</div>
		</div>
		<?php endif ?>
		
		<?php if(has_permission('categories')): ?>
		<!-- CATEGORIES -->
		<div class="item">
			<a class="header" href="<?= base_url("control/categories") ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/tags-white.png') ?>" alt="x">
				</span>
				<?= lang('ui_categories') ?>
			</a>
		</div>
		<?php endif ?>
		<?php if(has_permission('subcategories')): ?>
		<!-- SUBCATEGORIES -->
		<div class="item">
			<a class="header" href="<?= base_url("control/subcategories") ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/tags-white.png') ?>" alt="x">
				</span>
				<?= lang('ui_subcategories') ?>
			</a>
		</div>
		<?php endif ?>
		<?php if(has_permission('comments')): ?>
		<!-- COMMENTS -->
		<div class="item">
			<a class="header" href="<?= base_url("control/comments") ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/comments-white.png') ?>" alt="x">
				</span>
				<?= lang('ui_commentar') ?>
			</a>
		</div>
		<?php endif ?>
		
		<?php if(is_main()): ?>
		<div class="item">
			<a class="header" href="/control/payments">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/withdrawals.png') ?>" alt="x">
				</span>
				<?= lang('ui_withdrawals') ?>
			</a>
		</div>
		<a href="<?= base_url('control/ads') ?>" class="item">Iklan Prabayar</a>
		<a href="<?= base_url('control/compaigns') ?>" class="item">Kampanye Iklan</a>
		<?php endif ?>	

		<?php if(has_permission('newsletter')): ?>
		<!-- NEWSLETTER -->
		<div class="item">
			<div class="item parent">
				<div class="header">
					<span class="ui avatar image">
						<img src="<?= base_url('assets/control/images/email-white.png') ?>" alt="x">
					</span>
					Surat Berita
				</div>
			</div>
			<div class="menu">
				<a href="<?= base_url('control/newsletter/send') ?>" class="item">
					<?= lang('ui_send') ?>
				</a>
				<a href="<?= base_url('control/newsletter/subscribers') ?>" class="item">
					<?= lang('ui_subscribers') ?>
				</a>
			</div>
		</div>
		<?php endif ?>
		
		<?php if(has_permission('settings')): ?>
		<!-- SETTINGS -->
		<div class="item">
			<div class="item parent borderless">
				<div class="header">
					<span class="ui avatar image">
						<img src="<?= base_url('assets/control/images/settings-white.png') ?>" alt="x">
					</span>
					<?= lang('ui_settings') ?>
				</div>
			</div>
			<div class="menu">
				<a href="<?= base_url('control/settings/general') ?>" class="item">
					<?= lang('ui_general') ?>
				</a>
				<a href="<?= base_url('control/settings/search_engines') ?>" class="item">
					<?= lang('ui_search_engines') ?>
				</a>
				<a href="<?= base_url('control/settings/advertisement') ?>" class="item">
					<?= lang('ui_advertisement') ?>
				</a>
				<a href="<?= base_url('control/settings/email') ?>" class="item">
					Email
				</a>
				<a href="<?= base_url('control/settings/permissions') ?>" class="item">
					<?= lang('ui_permissions') ?>
				</a>
				<?php if(is_main()): ?>
				<a href="<?= base_url('control/settings/points_and_withdrawals') ?>" class="item">
					<?= lang('ui_points_and_withdrawals') ?>
				</a>
				<?php endif ?>
			</div>
		</div>
		<?php endif ?>
		<!-- SITEMAPS -->
		<div class="item">
			<a class="header" href="<?= base_url("control/sitemaps") ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/sitemap-white.png') ?>" alt="x">
				</span>
				Sitemaps
			</a>
		</div>
		<?php if(has_permission('trash')): ?>
		<!-- TRASH -->
		<div class="item collapsed">
			<div class="item parent borderless">
				<div class="header">
					<span class="ui avatar image">
						<img src="<?= base_url('assets/control/images/trash-white.png') ?>" alt="x">
					</span>
					<?= lang('ui_trash') ?>
				</div>
			</div>
			<div class="menu">
				<a href="<?= base_url('control/trash/posts') ?>" class="item">
					<?= lang('ui_posts') ?>
				</a>
				<a href="<?= base_url('control/trash/pages') ?>" class="item">
					<?= lang('ui_pages') ?>
				</a>
				<a href="<?= base_url('control/trash/users') ?>" class="item">
					<?= lang('ui_users') ?>
				</a>
				<a href="<?= base_url('control/trash/comments') ?>" class="item">
					<?= lang('ui_commentar') ?>
				</a>
				<a href="<?= base_url('control/trash/categories') ?>" class="item">
					<?= lang('ui_categories') ?>
				</a>
				<a href="<?= base_url('control/trash/subcategories') ?>" class="item">
					<?= lang('ui_subcategories') ?>
				</a>
			</div>
		</div>
		<?php endif ?>
		<?php if(has_permission('profile')): ?>
		<!-- PROFILE -->
		<div class="item">
			<a class="header" href="<?= base_url("control/profile") ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/profile-white.png') ?>" alt="x">
				</span>
				<?= lang('ui_profile') ?>
			</a>
		</div>
		<?php endif ?>
		<!-- LOGOUT -->
		<div class="item">
			<a class="header" href="<?= current_url('logout') ?>">
				<span class="ui avatar image">
					<img src="<?= base_url('assets/control/images/logout-white.png') ?>" alt="x">
				</span>
				<?= lang('ui_logout') ?>
			</a>
		</div>
	</div>
</div>
<script>
	$(function() 
	{
		$('.item.parent').on('click', function()
		{
			$(this).parent('.item').toggleClass('collapsed');
		})
	})
</script>