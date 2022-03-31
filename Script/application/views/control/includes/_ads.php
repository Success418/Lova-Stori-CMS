<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="ui form items bottom content ads">
	<table class="ui basic celled single line unstackable table">
		<thead>
			<tr>
				<th class="center aligned">ID</th>
				<th class="center aligned">Jenis Iklan</th>
				<th class="center aligned">Harga (IDR / 1 tampilan)</th>
				<th class="center aligned">Dibuat</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($ads as $ad): ?>
			<tr>
				<td class="center aligned"><?= $ad->id ?></td>
				<td class="center aligned"><?= strtoupper($ad->ref) ?></td>
				<td class="right aligned"><input type="number" step="0.001" data-id="<?= $ad->id ?>" name="price" value="<?= $ad->price ?>"></td>
				<td class="center aligned"><?= $ad->created_at ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script>
	$(function()
	{

		$('input[name="price"]').on('change', function()
		{
			var price = $(this).val().trim();
			var id = $(this).data('id');

			if(isNaN(price) || price <= 0 || isNaN(id)) return;

			$.post('<?= base_url("control/ads/update") ?>', {"price": price, "id": id});
		})

	})
</script>