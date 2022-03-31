<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/pages') ?>

<style>
	.sitemaps {
		overflow-x: auto;
		height: calc(100vh - 214px);
		height: -webkit-calc(100vh - 214px);
		height: -moz-calc(100vh - 214px);
		height: -o-calc(100vh - 214px);
		height: -ms-calc(100vh - 214px);
	}

	.sitemaps tbody tr td:not(:first-child) {
		text-align: right;
	}

	.sitemaps tbody tr td:first-child {
		width: 100%;
	}

	.sitemaps tbody .button {
		min-width: 120px;
	}
</style>

<div class="ui fluid menu st search shadowless xs-up-hidden">
	&nbsp;
</div>

<div class="ui hidden divider my-2"></div>

<div class="items bottom content sitemaps">
	<table class="ui single line unstackable table">
		<tbody>
			<tr>
				<td><?= lang('ui_posts') ?></td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/posts-sitemap.xml/read') ?>" target="_blank"><?= lang('ui_read') ?></a>
				</td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/posts-sitemap.xml/download') ?>" target="_blank"><?= lang('ui_download') ?></a>
				</td>
				<td>
					<form action="<?= base_url("control/sitemaps/generate") ?>" method="post">
						<input type="hidden" name="items" value="posts">
						<button type="submit" class="ui basic small button"><?= lang('ui_generate') ?></button>
					</form>
				</td>
			</tr>
			<tr>
				<td><?= lang('ui_pages') ?></td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/pages-sitemap.xml/read') ?>" target="_blank"><?= lang('ui_read') ?></a>
				</td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/pages-sitemap.xml/download') ?>" target="_blank"><?= lang('ui_download') ?></a>
				</td>
				<td>
					<form action="<?= base_url("control/sitemaps/generate") ?>" method="post">
						<input type="hidden" name="items" value="pages">
						<button type="submit" class="ui basic small button"><?= lang('ui_generate') ?></button>
					</form>
				</td>
			</tr>
			<tr>
				<td><?= lang('ui_categories') ?></td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/categories-sitemap.xml/read') ?>" target="_blank"><?= lang('ui_read') ?></a>
				</td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/categories-sitemap.xml/read') ?>" target="_blank"><?= lang('ui_download') ?></a>
				</td>
				<td>
					<form action="<?= base_url("control/sitemaps/generate") ?>" method="post">
						<input type="hidden" name="items" value="categories">
						<button type="submit" class="ui basic small button"><?= lang('ui_generate') ?></button>
					</form>
				</td>
			</tr>
			<tr>
				<td><?= lang('ui_subcategories') ?></td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/subcategories-sitemap.xml/read') ?>" target="_blank"><?= lang('ui_read') ?></a>
				</td>
				<td>
					<a class="ui basic small button" href="<?= base_url('control/sitemaps/subcategories-sitemap.xml/read') ?>" target="_blank"><?= lang('ui_download') ?></a>
				</td>
				<td>
					<form action="<?= base_url("control/sitemaps/generate") ?>" method="post">
						<input type="hidden" name="items" value="subcategories">
						<button type="submit" class="ui basic small button"><?= lang('ui_generate') ?></button>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>