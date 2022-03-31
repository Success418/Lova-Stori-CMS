<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/users/moderators') ?>

<div class="items top content">
	<div class="ui menu shadowless">
		<?php if(has_permission('users', 'update') && (is_admin() || is_main())): ?>
		<a href="<?= "{$base_url}/edit/" ?>" class="item edit disabled"><?= lang('ui_edit') ?></a>
		<?php endif ?>

		<?php if(has_permission('users', 'delete') && (is_admin() || is_main())): ?>
		<a href="<?= "{$base_url}/delete/" ?>" class="item delete disabled"><?= lang('ui_delete') ?></a>
		<?php endif ?>

		<?php if(has_permission('users', 'add') && (is_admin() || is_main())): ?>
		<div class="right menu">
			<a href="<?= "{$base_url}/add" ?>" class="item"><?= lang('ui_add') ?></a>
		</div>
		<?php endif ?>
	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content users">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('users', ['or', ['update', 'delete']]) && (is_admin() || is_main())): ?>
				<th>&nbsp;</th>
				<?php endif ?>
				<th><?= lang('ui_username') ?> <a href="<?= "$filters_base_url/name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th>Email <a href="<?= "$filters_base_url/email/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_country') ?> <a href="<?= "$filters_base_url/country/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_date') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php if(has_permission('users', 'update_blocked') && (is_admin() || is_main())): ?>
				<th><?= lang('ui_blocked') ?> <a href="<?= "$filters_base_url/blocked/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach($users as $user): ?>
			<tr>
				<?php if(has_permission('users', ['or', ['update', 'delete']]) && (is_admin() || is_main())): ?>
				<td class="center aligned">
					<div class="ui basic checkbox">
						<input type="checkbox" value="<?= $user->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<?php endif ?>
				<td><?= ucfirst($user->user_name) ?></td>
				<td><?= $user->user_email ?></td>
				<td><?= $user->user_country .' - '. $user->user_country_EN ?? '-' ?></td>
				<td><?= $user->user_created_at ?></td>
				<?php if(has_permission('users', 'update_blocked') && (is_admin() || is_main())): ?>
				<td class="center aligned">
					<div class="ui blocked status <?= $user->user_blocked ? 'checked' : '' ?> fitted toggle checkbox">
						<input type="checkbox" value="<?= $user->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<?php endif ?>
			</tr>
			<?php endforeach ?>
		</tbody>

		<tfoot>
			<tr>
				<th colspan="8">
					<?= get_html_pagination($pagination) ?>
				</th>
			</tr>
		</tfoot>
	</table>
</div>

<script>var users = 'moderators'</script>

<script src="<?= base_url('assets/control/js/users.js?v=').time() ?>"></script>