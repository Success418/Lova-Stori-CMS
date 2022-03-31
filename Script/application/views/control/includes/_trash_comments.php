<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/trash/comments') ?>

<div class="items top content">
	<div class="ui menu shadowless">
		<?php if(has_permission('trash', ['or', ['update', 'delete']])): ?>
		<form style="display: inherit" action="<?= $base_url ?>" method="post">
			<?php if(has_permission('trash', 'update')): ?>
			<a href="javascript:void(0)" class="item restore disabled"><?= lang('ui_restore') ?></a>
			<?php endif ?>

			<?php if(has_permission('trash', 'delete')): ?>
			<a href="javascript:void(0)" class="item delete disabled"><?= lang('ui_delete') ?></span></a>
			<?php endif ?>

			<input type="hidden" name="ids">
			<input type="hidden" name="action">
			<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
		</form>
		<?php endif ?>
	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content posts">
	<table class="ui basic celled single line unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('trash', ['or', ['update', 'delete']])): ?>
				<th class="center aligned">
					<div class="ui fitted basic checkbox all">
						<input type="checkbox" class="hidden">
						<label></label>
					</div>
				</th>
				<?php endif ?>
				<th><?= lang('ui_post') ?> <a href="<?= "$filters_base_url/post_title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_username') ?> <a href="<?= "$filters_base_url/user_name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th>Email <a href="<?= "$filters_base_url/user_email/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_deleted_at') ?> <a href="<?= "$filters_base_url/deleted_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($comments as $comment): ?>
			<tr>
				<?php if(has_permission('trash', ['or', ['update', 'delete']])): ?>
				<td class="center aligned">
					<div class="ui fitted basic checkbox">
						<input type="checkbox" value="<?= $comment->id ?>" class="hidden">
						<label></label>
					</div>	
				</td>
				<?php endif ?>
				<td class="fixed wide">
					<a href="<?= strtolower(base_url("post/{$comment->post_slug}")) ?>" target="_blank" title="<?= $comment->post_title ?>">
						<?= $comment->post_title ?>
					</a>
				</td>
				<td><?= ucfirst($comment->author_username) ?></td>
				<td><?= ucfirst($comment->author_email) ?></td>
				<td><?= $comment->date ?></td>
				<td><?= $comment->deleted_at ?></td>
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

<script src="<?= base_url('assets/control/js/trash.js?v=').time() ?>"></script>