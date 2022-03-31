<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/posts') ?>

<div class="ui fluid menu st search shadowless xs-up-hidden">
	<div class="ui search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="<?= lang('ui_search') ?>...">
			<i class="search link icon"></i>
		</div>
	</div>
</div>

<div class="items top content">
	<div class="ui menu shadowless">
		<?php if(has_permission('posts', 'update')): ?>
		<a href="<?= "{$base_url}/edit/" ?>" class="item edit disabled"><?= lang('ui_edit') ?></a>
		<?php endif ?>

		<?php if(has_permission('posts', 'delete')): ?>
		<a href="<?= "{$base_url}/delete/" ?>" class="item delete disabled"><?= lang('ui_delete') ?></span></a>
		<?php endif ?>

		<div class="right menu">
			<div class="ui search item xs-hidden">
				<div class="ui transparent icon input">
					<input class="prompt" type="text" placeholder="<?= lang('ui_search') ?>...">
					<i class="search link icon"></i>
				</div>
			</div>
			<?php if(has_permission('posts', 'add')): ?>
			<a href="<?= "{$base_url}/add" ?>" class="item"><?= lang('ui_add') ?></a>
			<?php endif ?>
		</div>
	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content posts">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('posts', ['or', ['update', 'delete']])): ?>
				<th>&nbsp;</th>
				<?php endif ?>
				<th><?= lang('ui_title') ?> <a href="<?= "$filters_base_url/title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_views') ?> <a href="<?= "$filters_base_url/views/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th>
					<div class="ui categories-list scrolling dropdown">
						<div class="text"><?= lang('ui_category') ?></div>
						<i class="caret down icon"></i>
						<div class="menu">
							<a href="<?= $base_url ?>" class="item">All</a>
							<?php foreach($categories as $category): 
									$slug = url_title($category['category_title'], '-', TRUE) ?>
							<a href="<?= "{$base_url}/id/{$category['category_id']}/category/{$slug}" ?>" class="item">
								<?= ucfirst($category['category_title']) ?>
							</a>
							<?php endforeach ?>
						</div>
					</div>
				</th>
				<th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php if(has_permission('posts', 'update_visibility')): ?>
				<th><?= lang('ui_published') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
				<?php if(has_permission('posts', 'update_pin')): ?>
				<th><?= lang('ui_pinned') ?> <a href="<?= "$filters_base_url/pinned/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
				<?php if(has_permission('posts', 'update_recommendation')): ?>
				<th><?= lang('ui_recommended') ?> <a href="<?= "$filters_base_url/recommended/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach($posts as $post): ?>
			<tr>
				<?php if(has_permission('posts', ['or', ['update', 'delete']])): ?>
				<td class="center aligned">
					<div class="ui basic checkbox">
						<input type="checkbox" value="<?= $post->id ?>" class="hidden">
						<label></label>
					</div>	
				</td>
				<?php endif ?>
				<td>
					<a href="<?= strtolower(base_url("post/{$post->slug}")) ?>" target="_blank">
						<?= $post->title ?>
					</a>
				</td>
				<td class="right aligned"><?= $post->views ?></td>
				<td><?= ucfirst($post->category_title) ?></td>
				<td><?= $post->date ?></td>
				<?php if(has_permission('posts', 'update_visibility')): ?>
				<td class="center aligned">
					<div class="ui <?= $post->visible ? 'checked' : '' ?> visible fitted toggle checkbox">
						<input type="checkbox" value="<?= $post->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<?php endif ?>
				<?php if(has_permission('posts', 'update_pin')): ?>
				<td class="center aligned">
					<div class="ui <?= $post->pinned ? 'checked' : '' ?> pinned fitted toggle checkbox">
						<input type="checkbox" value="<?= $post->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<?php endif ?>
				<?php if(has_permission('posts', 'update_recommendation')): ?>
				<td class="center aligned">
					<div class="ui <?= $post->recommended ? 'checked' : '' ?> recommended fitted toggle checkbox">
						<input type="checkbox" value="<?= $post->id ?>" class="hidden">
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

<script src="<?= base_url('assets/control/js/posts.js?v=').time() ?>"></script>