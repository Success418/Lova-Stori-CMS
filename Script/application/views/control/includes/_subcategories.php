<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<div class="items top content categories">
	<div class="ui menu shadowless m-0">
		<a class="item edit disabled"><?= lang('ui_edit') ?></a>
		<a class="item delete disabled"><?= lang('ui_delete') ?></a>
		<div class="right menu">
			<a class="item add"><?= lang('ui_add') ?></a>
		</div>
	</div>

	<form class="ui form mt-3 disabled" id="category-form" method="post" action="<?= base_url('control/subcategories/') ?>">
	 	<div class="three fields">
	 		<div class="field">
	 			<label><?= lang('ui_name') ?></label>
	 			<input type="text" name="name" required>
	 		</div>
	 		<div class="field">
	 			<label><?= lang('ui_order') ?></label>
	 			<input type="number" name="order" value="0">
	 		</div>
	 		<div class="field">
	 			<label><?= lang('ui_parent_category') ?></label>
				<div class="ui selection dropdown">
					<input type="hidden" name="parent_id">
					<i class="dropdown icon"></i>
					<div class="default text"></div>
					<div class="menu">
						<?php foreach($categories as $category): ?>
						<div class="item" data-value="<?= $category['category_id'] ?>">
							<?= ucfirst($category['category_title']) ?>
						</div>
						<?php endforeach ?>
					</div>
				</div>
	 		</div>
	 	</div>
		<div class="field">
			<label><?= lang('ui_short_description') ?></label>
			<textarea name="description" rows="2"></textarea>
		</div>
		
		<input type="text" class="d-none" name="id">

		<div class="field">
			<button type="submit" class="ui red button"><?= lang('ui_submit') ?></button>
		</div>
	</form>
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content categories">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th><?= lang('ui_name') ?> <a href="<?= "$filters_base_url/name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_order') ?> <a href="<?= "$filters_base_url/order/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_parent') ?> <a href="<?= "$filters_base_url/parent_id/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th class="center aligned"><?= lang('ui_visible') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($subcategories as $subcategory): ?>
			<?php $visible = $subcategory->visible ? 'checked' : '' ?>
			<tr>
				<td class="center aligned">
					<div class="ui basic checkbox">
						<input type="checkbox" value="<?= $subcategory->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
				<td><?= ucfirst($subcategory->name) ?></td>
				<td><?= $subcategory->order ?></td>
				<td><?= ucfirst($subcategory->parent_name) ?></td>
				<td><?= $subcategory->created_at ?></td>
				<td class="center aligned">
					<div class="ui <?= $visible ?> fitted toggle checkbox">
						<input 
							type="checkbox" 
							tabindex="0" 
							value="<?= $subcategory->id ?>"
							class="hidden">
						<label></label>
					</div>
				</td>
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
	window.subcategories = <?= json_encode($subcategories) ?>;
	window.categories    = <?= json_encode($categories) ?>;
</script>

<script src="<?= base_url('assets/control/js/subcategories.js?v=').time() ?>"></script>