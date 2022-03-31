<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/compaigns') ?>

<div class="ui fluid menu st search shadowless xs-up-hidden">
	<div class="ui search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="Cari...">
			<i class="search link icon"></i>
		</div>
	</div>
</div>

<div class="items bottom content compaigns">
	<table class="ui basic celled single line unstackable table">
		<thead>
			<tr>
				<th>ID</th>
				<th><?= lang('ui_name') ?> <a href="<?= "$filters_base_url/name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th class="center aligned">Link</th>
				<th class="center aligned">Gambar</th>
				<th class="center aligned">Jenis Iklan</th>
				<th class="center aligned">Harga/Tampilan</th>
				<th class="center aligned"><?= lang('ui_budget') ?> Dana <sup>IDR</sup></th>
				<th class="center aligned"><?= lang('ui_views') ?></th>
				<th class="center aligned"><?= lang('ui_active') ?> <a href="<?= "$filters_base_url/active/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th class="center aligned">Saldo <sup>(IDR)</sup></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($compaigns as $compaign): ?>
			<tr>
				<td class="center aligned"><?= $compaign->id ?></td>
				<td><?= $compaign->name ?></td>
				<td class="center aligned"><a href="<?= $compaign->link ?>" target="_blank">Lihat</a></td>
				<td class="center aligned"><a href="<?= base_url("uploads/banners/{$compaign->image}?v=".time()) ?>" target="_blank"><i class="eye icon mx-0"></i></a></td>
				<td class="center aligned"><?= strtoupper($compaign->ad_ref) ?></td>
				<td class="center aligned"><?= $compaign->price ?> <sup>(IDR)</sup></td>
				<td class="center aligned"><?= $compaign->budget ?></td>
				<td class="center aligned"><?= $compaign->views ?></td>
				<td class="center aligned">
					<div class="ui <?= $compaign->active ? 'checked' : '' ?> active fitted toggle checkbox">
						<input type="checkbox" value="<?= $compaign->id ?>" class="hidden" data-budget="<?= $compaign->budget ?>" data-balance="<?= $compaign->user_ad_balance ?>" data-userid="<?= $compaign->user_id ?>">
						<label></label>
					</div>
				</td>
				<td class="center aligned"><?= $compaign->user_ad_balance ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>

		<tfoot>
			<tr>
				<th colspan="10">
					<?= get_html_pagination($pagination) ?>
				</th>
			</tr>
		</tfoot>
	</table>
</div>

<script>
	$(function()
	{
		$('.toggle.checkbox').checkbox();
		$('.toggle.checked.checkbox').checkbox('check');

		$('.compaigns .active.toggle.checkbox input').on('change', function() 
		{
      var active   = $(this).prop('checked') ? 1 : 0;
      var id       = parseInt($(this).val());
      var budget   = parseFloat($(this).data('budget'));
      var balance  = parseFloat($(this).data('balance'));
      var userid   = $(this).data('userid');

      if(active == 1 && balance < budget)
      {
      	alert('Insufficient balance');
      	$(this).prop('checked', false);
      	return;
      }

      if(/^(0|1)$/.test(active) && /^(\d+)$/.test(id))
      {
				$.post(location.origin + '/control/compaigns/update', 
							{"id": id, "active": active, "budget": budget, "balance": balance, "user_id": userid})
				.done(function()
				{
					location.reload();
				})
      }
    })
	})
</script>