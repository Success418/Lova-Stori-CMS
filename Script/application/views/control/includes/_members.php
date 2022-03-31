<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url("control/users/members") ?>

<div class="items top content">
	<div class="ui menu shadowless">

		<?php if(has_permission('users', 'update_role')): ?>
		<div class="ui pointing dropdown link item update user_role disabled">
			<input type="hidden" name="user_role">
			<span class="text"><?= lang('ui_roles') ?></span>
			<i class="dropdown icon"></i>
			<div class="menu">
				<div class="item" data-value="author"><?= lang('ui_author') ?></div>
				<div class="divider my-1"></div>
				<div class="item" data-value="moderator"><?= lang('ui_moderator') ?></div>
				<div class="divider my-1"></div>
				<div class="item" data-value="administrator"><?= lang('ui_administrator') ?></div>
			</div>
		</div>
		<?php endif ?>
		
		<?php if(has_permission('users', 'update')): ?>
		<a href="<?= base_url('control/users/update') ?>" class="item edit disabled"><?= lang('ui_edit') ?></a>
		<?php endif ?>
		
		<?php if(has_permission('users', 'delete')): ?>
		<a href="<?= "{$base_url}/delete/" ?>" class="item delete disabled"><?= lang('ui_delete') ?></a>
		<?php endif ?>
		
		<?php if(has_permission('users', 'add')): ?>
		<div class="right menu">
			<a href="<?= base_url('control/users/add') ?>" class="item add"><?= lang('ui_add') ?></a>
		</div>
		<?php endif ?>

	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content users">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('users', ['or', ['update', 'delete']])): ?>
				<th>&nbsp;</th>
				<?php endif ?>
				<th><?= lang('ui_username') ?> <a href="<?= "$filters_base_url/name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th>Email <a href="<?= "$filters_base_url/email/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_country') ?> <a href="<?= "$filters_base_url/country/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_date') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php if(has_permission('users', 'update_active')): ?>
				<th><?= lang('ui_active') ?> <a href="<?= "$filters_base_url/active/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
				<?php if(has_permission('users', 'update_blocked')): ?>
				<th><?= lang('ui_blocked') ?> <a href="<?= "$filters_base_url/blocked/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach($users as $user): ?>
			<tr>
				<?php if(has_permission('users', ['or', ['update', 'delete']])): ?>
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
				<?php if(has_permission('users', 'update_active')): ?>
				<td class="center aligned">
					<div class="ui active status <?= $user->user_active ? 'checked' : '' ?> fitted toggle checkbox">
						<input type="checkbox" value="<?= $user->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<?php endif ?>
				<?php if(has_permission('users', 'update_blocked')): ?>
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

<div class="ui modal users" style="max-width: 300px; width: 100%">
	<i class="close icon"></i>
	<div class="content"></div>	
</div>

<script>var users = 'members'</script>

<script src="<?= base_url('assets/control/js/users.js?v=').time() ?>"></script>
