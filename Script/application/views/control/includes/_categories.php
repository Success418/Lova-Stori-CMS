<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<div class="items top content categories">
	<div class="ui menu shadowless m-0">
		<?php if(has_permission('categories', 'update')): ?>
		<a class="item edit disabled"><?= lang('ui_edit') ?></a>
		<?php endif ?>

		<?php if(has_permission('categories', 'delete')): ?>
		<a class="item delete disabled"><?= lang('ui_delete') ?></a>
		<?php endif ?>

		<?php if(has_permission('categories', 'add')): ?>
		<div class="right menu">
			<a class="item add"><?= lang('ui_add') ?></a>
		</div>
		<?php endif ?>
	</div>
	
	<?php if(has_permission('categories', ['or', ['add', 'update']])): ?>
	<form class="ui form mt-3 disabled" id="category-form" method="post" action="<?= base_url('control/categories/') ?>">
	 	<div class="two fields">
	 		<div class="field">
	 			<label><?= lang('ui_name') ?></label>
	 			<input type="text" name="name" required>
	 		</div>
	 		<div class="field">
	 			<label><?= lang('ui_order') ?></label>
	 			<input type="number" name="order" value="0">
	 		</div>
	 	</div>
		
		<div class="field">
			<label><?= lang('ui_short_description') ?></label>
			<textarea name="description" rows="2"></textarea>
		</div>
		
		<input type="hidden" name="id">

		<div class="field">
			<button type="submit" class="ui red button"><?= lang('ui_submit') ?></button>
		</div>
	</form>
	<?php endif ?>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content categories">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<?php if(has_permission('categories', ['or', ['update', 'delete']])): ?>
				<th>&nbsp;</th>
				<?php endif ?>
				<th><?= lang('ui_name') ?> <a href="<?= "$filters_base_url/name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_order') ?> <a href="<?= "$filters_base_url/order/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_subcategories_count') ?></th>
				<?php if(has_permission('categories', 'update_visibility')): ?>
				<th class="center aligned"><?= lang('ui_visible') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<?php endif ?>
			</tr>
		</thead>
		<tbody>

			<?php foreach($categories as $category): ?>
			<?php $visible = $category->visible ? 'checked' : '' ?>
			<tr>
				<?php if(has_permission('categories', ['or', ['update', 'delete']])): ?>
				<td class="center aligned">
					<div class="ui basic checkbox">
						<input type="checkbox" value="<?= $category->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<?php endif ?>
				<td><?= ucfirst($category->name) ?></td>
				<td><?= $category->order ?></td>
				<td><?= $category->created_at ?></td>
				<td><?= $category->subcategories_count ?></td>
				<?php if(has_permission('categories', 'update_visibility')): ?>
				<td class="center aligned">
					<div class="ui <?= $visible ?> fitted toggle checkbox">
						<input 
							type="checkbox" 
							tabindex="0" 
							value="<?= $category->id ?>"
							class="hidden">
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

<script>
	window.categories = <?= json_encode($categories) ?>;
</script>

<script src="<?= base_url('assets/control/js/categories.js?v=').time() ?>"></script>