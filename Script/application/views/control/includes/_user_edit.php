<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<form action="<?= base_url("control/users/edit/{$user->id}") ?>" method="post" class="ui form">

	<div class="ui grid attached">
		<div class="sixteen column wide">
			<div class="field">
				<label><h4><?= lang('ui_username') ?></h4></label>
				<input type="text" required name="user_name" value="<?= $user->user_name ?>" placeholder="...">
			</div>
			
			<div class="ui hidden divider"></div>

			<div class="field">
				<label><h4>Email</h4></label>
				<input type="Email" required name="user_email" value="<?= $user->user_email ?>" placeholder="...">
			</div>

			<div class="ui hidden divider"></div>

			<div class="field">
				<label><h4><?= lang('ui_role') ?></h4></label>
				<div class="ui selection dropdown user_role">
					<input type="hidden" name="user_role" value="<?= $user->user_role ?>">
					<i class="dropdown icon"></i>
					<div class="default text"><?= lang('ui_role') ?></div>
					<div class="menu">
						<div class="item" data-value="administrator"><?= lang('ui_administrator') ?></div>
						<div class="item" data-value="moderator"><?= lang('ui_moderator') ?></div>
						<div class="item" data-value="author"><?= lang('ui_author') ?></div>
						<div class="item" data-value="member"><?= lang('ui_member') ?></div>
					</div>
				</div>
			</div>

			<?php if (is_main()): ?>
			<div class="ui hidden divider"></div>

			<div class="field">
				<label><h4>Saldo Iklan</h4></label>
				<input type="number" step="0.01" name="user_ad_balance" value="<?= $user->user_ad_balance ?>">
			</div>
			<?php endif ?>

			<input type="hidden" value="<?= get_csrf_token() ?>" name="csrf_token">
		</div>
	</div>

	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_save') ?></button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button"><?= lang('ui_cancel') ?></a>
	</div>
</form>

<script>
	$(function() {
		$('.user_role.dropdown')
		.dropdown({on: 'click'})
		.dropdown('set selected', '<?= $user->user_role ?>');
	})
</script>