<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui secondary first menu m-0">
	<span class="header item pl-0 pr-2" id="mobile-menu-toggler">
		<i class="bars large icon m-0"></i>
	</span>
    
	<a href="/" target="Lihat" class="ui item preview">
		<?= lang('ui_preview') ?>
	</a>

	<div class="right menu pr-2">
		
		<?php if(is_logged_in()): ?>
		<div class="xs-hidden user ui dropdown outline item mr-0 ml-auto pr-0 borderless">
			<a class="ui basic huge image label">
				<?= $this->session->userdata('user_name') ?>
				<?php if($this->session->userdata('user_image')): ?>
				<img src="<?= base_url("uploads/profiles/".$this->session->userdata('user_image')).'?v='.time() ?>">
				<?php else: ?>
				<span><?= substr($this->session->userdata('user_name'), 0, 2) ?></span>
				<?php endif ?>
			</a>
			<div class="left menu shadowless borderless">
				<a href="<?= base_url('control/profile') ?>" class="item">
					<img class="ui avatar image" src="<?= base_url('assets/control/images/profile.png') ?>" alt="x">
					<?= lang('ui_profile') ?>
				</a>
				
				<?php if(has_permission('settings')): ?>
				
				<div class="divider"></div>
				<div class="item">
					<img class="ui avatar image" src="<?= base_url('assets/control/images/settings.png') ?>" alt="x">
					<?= lang('ui_settings') ?>
					<div class="menu shadowless borderless settings">
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
					</div>
				</div>
				
				<?php endif ?>

				<div class="divider"></div>

				<div class="item">
					<img class="ui avatar image" src="<?= base_url('assets/control/images/globe.png') ?>" alt="x">
					<?= lang('ui_language') ?>
					<form method="post" id="change-lang" class="menu shadowless borderless settings" action="<?= base_url("change_lang/{$this->uri->uri_string()}") ?>">
						<input type="hidden" name="lang">
						<a class="item" data-lang="indonesia">Indonesia</a>
						<a class="item" data-lang="english">Inggris</a>
					</form>
				</div>

				<div class="divider"></div>
				<a href="<?= current_url('logout') ?>" class="item">
					<img class="ui avatar image" src="<?= base_url('assets/control/images/logout.png') ?>" alt="x">
					<?= lang('ui_logout') ?>
				</a>
			</div>
		</div>
		<?php endif ?>
	</div>
</div>
<script>
	$(function() {
		$('.dropdown').dropdown({
			on: 'hover'
		});
	})
</script>