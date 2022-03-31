<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="social-icons">
	<div class="ui grid middle aligned m-0">
		<div class="column p-0">
			<a class="ui basic icon button" href="https://facebook.com/<?= $this->settings['site_facebook'] ?>" target="_blank">
				<i class="facebook icon"></i>
			</a>
			<a class="ui basic icon button" href="https://twitter.com/<?= $this->settings['site_twitter'] ?>" target="_blank">
				<i class="twitter icon"></i>
			</a>
			<a class="ui basic icon button" href="https://pinterest.com/<?= $this->settings['site_pinterest'] ?>" target="_blank">
				<i class="pinterest icon"></i>
			</a>			
			<a class="ui basic icon button" href="https://linkedin.com/in/<?= $this->settings['site_linkedin'] ?>" target="_blank">
				<i class="linkedin icon"></i>
			</a>
			<a class="ui basic icon button" href="https://youtube.com/<?= $this->settings['site_youtube'] ?>" target="_blank">
				<i class="youtube icon"></i>
			</a>
		</div>
	</div>
</div>


<a href="<?= ad_banner_link($banners['rb1']->link ?? null) ?>" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb1']->link ?? null) ?>" target="Lihat" id="rb1">
	<span style="color: #000 !important">rb1</span>
	<img width="250" height="250" src="<?= ad_banner_img($banners['rb1']->image ?? null, 'ad-placeholder-small.webp') ?>" class="d-block mx-auto">
</a><br>


<a href="https://youtu.be/pIf_vBE9tbM" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb1']->link ?? null) ?>" target="Lihat" id="rb1">
	<span style="color: #000 !important">YT</span>
	<img width="250" height="150" src="/iklan/salsa.webp" class="d-block mx-auto">
</a><br>

<a href="/iklan/s/2A0Pxs" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb1']->link ?? null) ?>" target="Lihat" id="rb1">
	<span style="color: #000 !important">rb1</span>
	<img width="250" height="250" src="/iklan/netflix2.webp" class="d-block mx-auto">
</a><br>

<a href="/short/link/?id=68747470733a2f2f6d656469616c6f76612e636f6d2f726f6f6d" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb1']->link ?? null) ?>" target="Lihat" id="rb1">
	<span style="color: #000 !important">Room</span>
	<img width="250" height="400" src="/podcast/chataku.webp" class="d-block mx-auto">
</a>


<a href="<?= ad_banner_link($banners['rb1']->link ?? null) ?>" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb1']->link ?? null) ?>" target="Lihat" id="rb1">
	
<center><script type="text/javascript" language="javascript" src="/info/md.js"></script></center>	
</a><br>




<a href="/short/link/?id=68747470733a2f2f69642d69716f7074696f6e2e636f6d2f6c616e642f73746172742d74726164696e672f69642f3f6166663d313438383133" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb2']->link ?? null) ?>" target="Lihat" id="rb2">
	<span style="color: #000 !important">rb2</span>
	<img width="250" height="250" src="/iklan/ref4.gif" class="d-block mx-auto">
</a><br>

<a href="/short/link/?id=68747470733a2f2f69642d69716f7074696f6e2e636f6d2f6c616e642f73746172742d74726164696e672f69642f3f6166663d313438383133" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb2']->link ?? null) ?>" target="Lihat" id="rb2">
	<span style="color: #000 !important">rb2</span>
	<img width="250" height="250" src="/iklan/ref3.gif" class="d-block mx-auto">
</a><br>



<a href="https://stori.id/" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb2']->link ?? null) ?>" target="Lihat" id="rb2">
	<span style="color: #000 !important"></span>
	<img width="250" height="42" src="/imgsite/dirumahaja.webp" class="d-block mx-auto">
</a>



<center><b>SPONSOR</b></center>
<!-- Composite End -->



<div class="ui hidden divider mt-0"></div>

<?php if($latest_comments): ?>
<div id="latest-comments">
	<div class="ui basic button fluid"><?= lang('ui_latest_comments') ?></div>
	<div class="ui hidden divider"></div>
	<div class="container">
		<div class="ui list">
		<?php foreach($latest_comments as $latest_comment): ?>
			<a class="item" href="<?= base_url("post/{$latest_comment->post_slug}#{$latest_comment->anchor}") ?>">
				<?php if($latest_comment->author_image): ?>
				<img width="35" height="35" class="ui mini circular image" src="<?= base_url("uploads/profiles/{$latest_comment->author_image}") ?>">
				<?php else: ?>
				<span class="ui mini circular image text">
					<?= substr($latest_comment->author, 0, 2) ?>
				</span>
				<?php endif ?>
				<div class="content">
					<div class="ui sub header author">
						<?= ucfirst($latest_comment->author) ?>
					</div>
					<span class="date">
						Diupdate <?= get_time_ago_in_words($latest_comment->date) ?>
					</span>
				</div>
				<div class="content mt-2">
					<div class="title" title="<?= $latest_comment->post_title ?>">
						<?= $latest_comment->post_title ?>
					</div>
					<div class="summary">
						<?= substr($latest_comment->body, 0, 50) ?>
					</div>
				</div>
			</a>
		<?php endforeach ?>
		</div>
	</div>
</div>
<?= get_ad_units('square') ?>
<?php endif ?>

<?php if($popular_posts): ?>
<div id="popular-posts" class="mt-5">
	<div class="ui basic button fluid"><?= lang('ui_popular_posts') ?></div>
	<div class="ui hidden divider"></div>
	<div class="container">
		<div class="ui unstackable items">
			<?php foreach($popular_posts as $popular_post): ?>
			<div class="item">
				<div width="80" height="90" class="ui tiny image" style="background: url(<?= base_url("uploads/images/{$popular_post->image}") ?>)">
				</div>
				<div class="content">
					<div class="header"><?= ucfirst($popular_post->title) ?></div>
					<div class="description"><?= substr($popular_post->summary, 0, 80).'...' ?></div>
				</div>
				<a class="link" href="<?= base_url("post/{$popular_post->slug}") ?>" title="<?= $popular_post->title ?>"></a>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
<?= get_ad_units('square') ?>
<?php endif ?>

<?php if($random_posts): ?>
<div id="random-posts" class="mt-5">
	<div class="ui basic button fluid"><?= lang('ui_random_posts') ?></div>
	<div class="ui hidden divider"></div>
	<div class="container">
		<div class="ui unstackable items">
			<?php foreach($random_posts as $random_post): ?>
			<div class="item">
				<div width="80" height="90" class="ui tiny image" style="background: url(<?= base_url("uploads/images/{$random_post->image}") ?>)">
				</div>
				<div class="content">
					<div class="header"><?= ucfirst($random_post->title) ?></div>
					<div class="description"><?= substr($random_post->summary, 0, 80).'...' ?></div>
				</div>
				<a class="link" href="<?= base_url("post/{$random_post->slug}") ?>" title="<?= $random_post->title ?>"></a>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
<?= get_ad_units('square') ?>
<?php endif ?>

<?php if($recommended_posts): ?>
<div id="recommended-posts" class="mt-5">
	<div class="ui basic button fluid"><?= lang('ui_recommended_posts') ?></div>
	<div class="ui hidden divider"></div>
	<div class="container">
		<div class="ui unstackable items">
			<?php foreach($recommended_posts as $recommended_post): ?>
			<div class="item">
				<div width="80" height="90" class="ui tiny image" style="background: url(<?= base_url("uploads/images/{$recommended_post->image}") ?>)">
				</div>
				<div class="content">
					<div class="header"><?= ucfirst($recommended_post->title) ?></div>
					<div class="description"><?= substr($recommended_post->summary, 0, 80).'...' ?></div>
				</div>
				<a class="link" href="<?= base_url("post/{$recommended_post->slug}") ?>" title="<?= $recommended_post->title ?>"></a>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
<?= get_ad_units('square') ?>
<?php endif ?>

<?php if($archive): ?>
<div id="archive" class="my-5">
	<div class="ui basic button fluid"><?= lang('ui_archive') ?></div>
	<div class="ui hidden divider mb-0"></div>
	<div class="container">
		<div class="ui scrolling fluid selection dropdown">
			<?= lang('ui_year') ?>
			<i class="dropdown icon"></i>
			<div class="menu">
				<?php foreach($archive as $label): ?>
				<a href="<?= base_url("posts/year/{$label->year}") ?>" class="item">
					<span class="description"><?= $label->posts_count ?></span>
					<span class="text"><?= $label->year ?></span>
				</a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
<?php endif ?>

<?php if($authors): ?>
<div id="authors" class="my-5">
	<div class="ui basic button fluid"><?= lang('ui_author_penulis') ?></div>
	<div class="ui hidden divider mt-0"></div>
	<div class="container">
		<div class="ui list">
		<?php foreach($authors as $author): ?>
			<a class="item" href="<?= base_url("posts/author/{$author->username}") ?>">
				<?php if($author->image): ?>
				<img width="35" height="35" class="ui mini circular image" src="<?= base_url("uploads/profiles/{$author->image}") ?>">
				<?php else: ?>
				<span class="ui mini circular image text">
					<?= substr($author->username, 0, 2) ?>
				</span>
				<?php endif ?>
				<div class="content">
					<div class="ui sub header author">
						<?= ucfirst($author->username) ?>
					</div>
					<span class="date">memiliki
						<?= $author->posts_count ?> artikel
					</span>
				</div>
			</a>
		<?php endforeach ?>
		</div>
	</div>
</div>
<?php endif ?>

<a href="<?= ad_banner_link($banners['rb2']->link ?? null) ?>" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb2']->link ?? null) ?>" target="Lihat" id="rb2">
	<span style="color: #000 !important">rb2</span>
	<img width="250" height="250" src="<?= ad_banner_img($banners['rb2']->image ?? null, 'ad-placeholder-small.webp') ?>" class="d-block mx-auto">
</a>

<div class="ui hidden divider mt-0"></div>

<a href="<?= ad_banner_link($banners['rb3']->link ?? null) ?>" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb3']->link ?? null) ?>" target="Lihat" id="rb3">
	<span style="color: #000 !important">rb3</span>
	<img width="250" height="250" src="<?= ad_banner_img($banners['rb3']->image ?? null, 'ad-placeholder-small.webp') ?>" class="d-block mx-auto">
</a>

<div class="ui hidden divider mt-0"></div>

<a href="<?= ad_banner_link($banners['rb4']->link ?? null) ?>" style="margin: 0 -1rem !important;"
	 class="my-3 d-block ad <?= ad_banner_class($banners['rb4']->link ?? null) ?>" target="Lihat" id="rb4">
	<span style="color: #000 !important">rb4</span>
	<img width="250" height="250" src="<?= ad_banner_img($banners['rb4']->image ?? null, 'ad-placeholder-small.webp') ?>" class="d-block mx-auto">
</a>