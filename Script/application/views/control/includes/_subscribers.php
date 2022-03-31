<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/newsletter/subscribers') ?>

<div class="items top content">
	<div class="ui menu shadowless">
		
	</div>
</div>

<div class="ui hidden divider my-2"></div>


<div class="items bottom content subscribers">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<th>Email <a href="<?= "$filters_base_url/email/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_country') ?> <a href="<?= "$filters_base_url/country/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th><?= lang('ui_date') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($subscribers as $subscriber): ?>
			<tr>
				<td><?= ucfirst($subscriber->email) ?></td>
				<td><?= $subscriber->country .' - '. $subscriber->country_EN ?? '-' ?></td>
				<td><?= $subscriber->created_at ?></td>
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