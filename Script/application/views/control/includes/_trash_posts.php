<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/trash/posts') ?>

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

		<div class="right menu">
			<div class="ui search item xs-hidden">
				<div class="ui transparent icon input">
					<input class="prompt" type="text" placeholder="<?= lang('ui_search') ?>...">
					<i class="search link icon"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content posts">
	<table class="ui basic celled unstackable table">
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
				<th><?= lang('ui_title') ?> <a href="<?= "$filters_base_url/title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
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
				<th><?= lang('ui_deleted_at') ?> <a href="<?= "$filters_base_url/deleted_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($posts as $post): ?>
			<tr>
				<?php if(has_permission('trash', ['or', ['update', 'delete']])): ?>
				<td class="center aligned">
					<div class="ui fitted basic checkbox">
						<input type="checkbox" value="<?= $post->id ?>" class="hidden">
						<label></label>
					</div>	
				</td>
				<?php endif ?>
				<td><?= $post->title ?></td>
				<td><?= ucfirst($post->category_title) ?></td>
				<td><?= $post->date ?></td>
				<td><?= $post->deleted_at ?></td>
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

<script>
	$(function() {

		$('.categories-list.dropdown').dropdown({on: 'hover'});


	    $('.item.search input').on('keyup', function(e) {
	    	var val = $(this).val().trim();

	        if((e.keyCode === 13) && val.length > 1)
	        {   	            
	            window.location.href = window.origin + '/control/trash/posts/search/' + encodeURIComponent(val);
	        }
	    });


	    $('.item.search .search.link.icon').on('click', function() {
	    	var val = $(this).siblings('input').val().trim();

	        if(val.length > 1)
	        {
	            window.location.href = window.origin + '/control/trash/posts/search/' + encodeURIComponent(val);
	        }
	    });

	})
</script>

<script src="<?= base_url('assets/control/js/trash.js?v=').time() ?>"></script>