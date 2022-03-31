<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/trash/comments') ?>

<div class="items top content">
	<div class="ui menu shadowless">
		<?php if(has_permission('comments', 'delete')): ?>
		<a href="<?= "{$base_url}/delete/" ?>" class="item delete disabled"><?= lang('ui_delete') ?></span></a>
		<?php endif ?>
	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content comments">
	<table class="ui basic celled single line unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('comments', 'delete')): ?>
				<th>&nbsp;</th>
				<?php endif ?>
				<th><?= lang('ui_post') ?> <a href="<?= "$filters_base_url/post_title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_username') ?> <a href="<?= "$filters_base_url/user_name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th>Email <a href="<?= "$filters_base_url/user_email/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_content') ?></th>
				<th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php if(has_permission('comments', 'update_visibility')): ?>
				<th><?= lang('ui_approved') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach($comments as $comment): ?>
			<tr>
				<?php if(has_permission('comments', 'delete')): ?>
				<td class="center aligned">
					<div class="ui basic checkbox">
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
				<td class="center aligned p-2">
					<button class="ui yellow mini button m-0 read" data-id="<?= $comment->id ?>">Baca</button>
				</td>
				<td><?= $comment->date ?></td>
				<?php if(has_permission('comments', 'update_visibility')): ?>
				<td class="center aligned">
					<div class="ui <?= $comment->visible ? 'checked' : '' ?> visible fitted toggle checkbox">
						<input type="checkbox" value="<?= $comment->id ?>" class="hidden">
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

<div class="ui scroll small modal radiusless" id="comment-model">
	<i class="close icon"></i>
	<div class="content"></div>
</div>

<div>
	<script>var commentsTexts = <?= $comments_texts ?> </script>
</div>

<script src="<?= base_url('assets/control/js/comments.js?v=').time() ?>"></script>