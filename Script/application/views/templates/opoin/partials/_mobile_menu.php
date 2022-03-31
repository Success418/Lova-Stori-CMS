<div class="ui vertical fluid menu m-0">
	<div class="logo">
		<div class="ui middle aligned grid m-0">
			<a href="/" class="column p-0">
				<img class="ui image mr-auto" src="<?= base_url("assets/images/logo.webp?v=") ?>" alt="logo">
			</a>
		</div>

		<i class="close bordered violet inverted icon"></i>
	</div>

	<div class="items">

		<div class="categories">

		<?php foreach($menu_items as $menu_item): ?>
		
		<?php if(key_exists('subcategories', $menu_item)): ?>
			<div class="ui item">
				<a class="header">
					<?= ucfirst($menu_item['name']) ?>
				</a>

				<div class="items subcategories d-none">
					<a class="ui item back">KEMBALI</a>
					<?php foreach($menu_item['subcategories'] as $subcategory): ?>
					<a class="ui item" href="<?= $subcategory['slug'] ?>">
						<?= ucfirst($subcategory['name']) ?>
					</a>
					<?php endforeach ?>
					<a class="ui item" href="<?= $menu_item['slug'] ?>">
						SEMUA
					</a>
				</div>
			</div>

		<?php else: ?>
			
			<div class="ui item">
				<a class="header" href="<?= $menu_item['slug'] ?>">
					<?= ucfirst($menu_item['name']) ?>
				</a>
			</div>

		<?php endif ?>

		<?php endforeach ?>

		</div>

		<div class="subcategories"></div>
	</div>

	<form method="post" action="<?= base_url("posts/search") ?>" class="ui search form">
		<div class="ui large action input fluid shadowless">
			<input type="text" name="search" placeholder="<?= lang('ui_search') ?>...">
			<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
			<button type="submit" class="ui icon button"><i class="search link icon m-0"></i></button>
		</div>
		<div class="ui error message"></div>
	</form>
</div>