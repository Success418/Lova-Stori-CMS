<div class="ui tabular menu">
	<h4 class="active item">
		<?= lang('ui_bacajuga') ?>
	</h4>
</div>

<div class="ui four doubling stackable cards initial">
	<?php foreach($similar_posts as $similar_post): ?>
	<div class="ui fluid card">
		<div class="image item-image">
			<img width="165" height="94" alt="Berita" src="<?= base_url("uploads/images/{$similar_post->image_name}") ?>">
		</div>
		<div class="content p-0 item-title">
			<div class="header">
				<a href="<?= base_url("post/{$similar_post->slug}") ?>" title="<?= ucfirst($similar_post->title) ?>">
					<?= ucfirst($similar_post->title) ?>
				</a>
			</div>
		</div>

	</div>
	<?php endforeach ?>
</div>