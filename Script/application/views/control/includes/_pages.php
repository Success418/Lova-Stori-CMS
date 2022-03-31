<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/pages') ?>

<div class="ui fluid menu st search shadowless xs-up-hidden">
	<div class="ui search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="Cari...">
			<i class="search link icon"></i>
		</div>
	</div>
</div>

<div class="items top content">
	<div class="ui menu shadowless">
		<?php if(has_permission('pages', 'update')): ?>
		<a href="<?= "{$base_url}/edit/" ?>" class="item edit disabled"><?= lang('ui_edit') ?></a>
		<?php endif ?>
		
		<?php if(has_permission('pages', 'delete')): ?>
		<a href="<?= "{$base_url}/delete/" ?>" class="item delete disabled"><?= lang('ui_delete') ?></span></a>
		<?php endif ?>

		<div class="right menu">
			<div class="ui search item xs-hidden">
				<div class="ui transparent icon input">
					<input class="prompt" type="text" placeholder="Cari...">
					<i class="search link icon"></i>
				</div>
			</div>
			<?php if(has_permission('pages', 'add')): ?>
			<a href="<?= "{$base_url}/add" ?>" class="item"><?= lang('ui_add') ?></a>
			<?php endif ?>
		</div>
	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content pages">
	<table class="ui basic celled single line unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('pages', ['or', ['update', 'delete']])): ?>
				<th>&nbsp;</th>
				<?php endif ?>
				<th><?= lang('ui_title') ?> <a href="<?= "$filters_base_url/title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_views') ?> <a href="<?= "$filters_base_url/views/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th>
					<div class="ui authors-list scrolling dropdown">
						<div class="text"><?= lang('ui_author') ?></div>
						<i class="caret down icon"></i>
						<div class="menu">
							<?php foreach($authors as $author): ?>
							<a href="<?= "{$base_url}/id/{$author['author_id']}/author/{$author['author_username']}" ?>" class="item">
								<?= ucfirst($author['author_username']) ?>
							</a>
							<?php endforeach ?>
							<a href="<?= $base_url ?>" class="item"><?= lang('ui_all') ?></a>
						</div>
					</div>
				</th>
				<th><?= lang('ui_show_in') ?></th>
				<th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_visible') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($pages as $page): ?>
			<?php $page_in = [$page->show_in_menu, $page->show_in_footer] ?>
			<tr>
				<?php if(has_permission('pages', ['or', ['update', 'delete']])): ?>
				<td class="center aligned">
					<div class="ui basic checkbox">
						<input type="checkbox" value="<?= $page->id ?>" class="hidden">
						<label></label>
					</div>	
				</td>
				<?php endif ?>
				<td>
					<a href="<?= strtolower(base_url("page/{$page->slug}")) ?>" target="_blank">
						<?= $page->title ?>
					</a>
				</td>
				<td class="right aligned"><?= $page->views ?></td>
				<td><?= ucfirst($page->author_username) ?></td>
				<td class="three wide">
					<div class="ui basic fluid labels"></div>
					<?php if($page->show_in_menu): ?>
					<span class="ui basic label">Menu</span>
					<?php endif ?>
					<?php if($page->show_in_footer): ?>
					<span class="ui basic label">Footer</span>
					<?php endif ?>
				</td>
				<td><?= $page->date ?></td>
				<?php if(has_permission('pages', 'update_visibility')): ?>
				<td class="center aligned">
					<div class="ui <?= $page->visible ? 'checked' : '' ?> visible fitted toggle checkbox">
						<input type="checkbox" value="<?= $page->id ?>" class="hidden">
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

<script src="<?= base_url('assets/control/js/pages.js?v=').time() ?>"></script>