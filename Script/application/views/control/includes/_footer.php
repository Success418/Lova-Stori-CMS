<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="ui text menu m-0">
	<div class="header item">
		<a href="/"><?= $this->settings['site_name'] ?? '{site_name}' ?></a>
		<span class="p-2">-</span>
		<span>Copyright <?= date('Y') ?></span>
	</div>
</div>