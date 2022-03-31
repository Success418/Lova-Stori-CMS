<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="logo">
	<div class="ui middle aligned grid m-0">
		<a href="/" class="column p-0">
			<img class="ui image m-auto" src="<?= base_url("assets/images/{$this->settings['site_logo']}?v=".time()) ?>" alt="logo">
		</a>
	</div>
</div>

<div id="left-menu">
	<div class="ui fluid vertical menu">

		<?php foreach($menu_items as $menu_item): ?>
		
		<?php if(key_exists('subcategories', $menu_item)): ?>
		<div class="ui item">
			<a class="header" href="<?= $menu_item['slug'] ?>">
				<?= ucfirst($menu_item['name']) ?>
				<i class="circle outline icon mr-0 ml-2"></i>
			</a>
			<div class="items d-none">
				<div class="ui vertical menu sub-items">
					<?php foreach($menu_item['subcategories'] as $subcategory): ?>
					<a class="item" href="<?= $subcategory['slug'] ?>">
						<?= ucfirst($subcategory['name']) ?>
					</a>
					<?php endforeach ?>
				</div>
			</div>
		</div>

		<?php else: ?>
		
		<div class="ui item">
			<a class="header" href="<?= $menu_item['slug'] ?>">
				<?= ucfirst($menu_item['name']) ?>
				<i class="circle outline icon mr-0 ml-2"></i>
			</a>
		</div>
		
		<?php endif ?>

		<?php endforeach ?>

		<?php foreach($pages as $page): ?>
		<?php if($page->in_menu): ?>
		<div class="ui item">
			<a class="header" href="<?= base_url("page/{$page->slug}") ?>">
				<?= ucfirst($page->title) ?>
				<i class="circle outline icon mr-0 ml-2"></i>
			</a>
		</div>
		<?php endif ?>
		<?php endforeach ?>
	</div>
</div>

<form method="post" action="<?= base_url("posts/search") ?>" class="ui search form">
	<div class="ui large action input fluid shadowless">
		<input type="text" name="search" placeholder="Cari...">
		<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
		<button type="submit" class="ui icon button"><i class="search link icon m-0"></i></button>
	</div>
	<div class="ui error message"></div>
</form>