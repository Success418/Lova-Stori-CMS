<!DOCTYPE html>
<html lang="en">
    
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>

    
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_dashboard') ?></title>

    <!-- JQUERY -->
    <script rel="preload" src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

    <!-- JQUERY UI -->
    <script defer src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>

    <!-- SEMANTIC-UI -->
    <link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.css"); ?>">
    <script defer src="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.js"); ?>"></script>

    <!-- JS -->
    <script src="<?= base_url("assets/js/app.js") ?>"></script>

    <?php
      $style = get_cookie('style') 
          ?? $this->settings['site_style'] 
          ?? 'light';
    ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/css/opoin_{$style}.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/spacing.css") ?>">
    <link id="scrollbar" rel="stylesheet" href="<?= base_url("assets/css/scrollbar.css") ?>">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
    <script defer src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>
	</head>

	<body class="pushable">
		
		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('templates/opoin/partials/_mobile_menu'); ?>
		</div>
		
		<div class="ui main container pusher" id="page">
			<div class="ui celled grid main m-0 shadowless">
				<div class="one column row content p-0">
					<div class="column" id="main-section">
						<div id="categories-menu">
						<?php $this->load->view('templates/opoin/partials/_categories_menu'); ?>
						</div>

						<div id="top-menu">
							<?php $this->load->view('templates/opoin/partials/_top_menu'); ?>
						</div>

						<div class="page dashboard" id="author-page">
                                     
							<div class="ui raised center left aligned segment shadowless">
								<h2><?= lang('ui_dashboard') ?></h2> <b><a href="/post/daftar-kontributor-panduan-penulis" target="Pinterest"><span style="color: #771dff;">LIHAT CARA PENARIKAN POIN</span></a></b>
							</div>

							<div class="ui fluid divider"></div>
							
							<div class="content dashboard">
								<div class="ui two doubling stackable cards">
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/article.png') ?>" alt="posts">
                        <span><?= lang('ui_posts') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= $counts->posts ?></h1>
                      </div>
                    </div>
                  </div>
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/comments.png') ?>" alt="comments">
                        <span><?= lang('ui_comments') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= $counts->comments ?></h1>
                      </div>
                    </div>
                  </div>
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/star.png') ?>" alt="points">
                        <span><?= lang('ui_points') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= number_shortener($counts->points ?? 0) ?></h1>
                      </div>
                    </div>
                  </div>
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/money.png') ?>" alt="withdrawals">
                        <span><?= lang('ui_withdrawal') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= number_shortener($counts->withdrawals ?? 0) ?></h1>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="table wrapper">
                  <table class="ui basic unstackable <?php if(styleIsDark()): ?> inverted <?php endif ?> table">
                    <thead>
                      <tr>
                        <th colspan="5"><?= mb_strtoupper(lang('ui_latest_posts')) ?></th>
                      </tr>
                      <tr>
                        <th class="capitalize"><?= lang('ui_title') ?></th>
                        <th><?= lang('ui_views') ?></th>
                        <th><?= lang('ui_rating') ?></th>
                        <th><?= lang('ui_category') ?></th>
                        <th><?= lang('ui_created_at') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($latest_posts as $latest_post): ?>
                      <tr>
                        <td class="seven wide column"><?= $latest_post->title ?></td>
                        <td><a href="<?= base_url("post/{$latest_post->slug}") ?>"><?= $latest_post->views ?></a></td>
                        <td><div class="ui star rating" data-rating="<?= $latest_post->rating ?>" data-max-rating="5"></div></td>
                        <td><?= $latest_post->category ?></td>
                        <td><?= $latest_post->created_at ?></td>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>

                <div class="table wrapper">
                  <table class="ui basic unstackable inverted table">
                    <thead>
                      <tr>
                        <th colspan="5"><?= mb_strtoupper(lang('ui_latest_comments')) ?></th>
                      </tr>
                      <tr>
                        <th><?= lang('ui_author') ?></th>
                        <th><?= lang('ui_post') ?></th>
                        <th><?= lang('ui_read') ?></th>
                        <th><?= lang('ui_created_at') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($latest_comments as $latest_comment): ?>
                      <tr>
                        <td>
                          <a href="<?= base_url('user/'.mb_strtolower($latest_comment->user_name)) ?>">
                            <?php if($latest_comment->avatar): ?>
                            <img width="200" height="200" src="<?= base_url("uploads/profiles/{$latest_comment->avatar}") ?>" alt="avatar" class="ui small avatar image">
                            <?php else: ?>
                              <span class="text avatar"><?= mb_substr($latest_comment->user_name, 0, 2) ?></span>
                            <?php endif ?>
                          </a>
                        </td>
                        <td><a href="<?= base_url("post/{$latest_comment->post_slug}") ?>#comments"><?= $latest_comment->post_title ?></a></td>
                        <td><button class="ui tiny yellow button read" data-id="<?= $latest_comment->id ?>"><?= lang('ui_read') ?></button></td>
                        <td><?= $latest_comment->created_at ?></td>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
							</div>
              
              <div class="ui scroll small modal radiusless" id="comment-model">
                <i class="close icon"></i>
                <div class="content"></div>
              </div>

              <script>
              $(function()
              {
                var commentsTexts = <?= $comments_texts ?>;

                $('.ui.star.rating').rating('disable');
                $('#top-menu a.item.logout').attr('href', '/logout');

                $('.button.read').on('click', function() {
                  var commentText = commentsTexts[$(this).data('id')];

                  $('#comment-model .content').html(commentText)
                                .parent()
                                .modal('setting', 'duration', 0)
                                .modal('show');
                })
              })
              </script>
						</div>

						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		

<script type="text/javascript">
function parseJSAtOnload() {
var links = ["assets/libraries/jquery-3.3.1/jquery.min.js", "assets/plugins/jquery-ui.min-1.12.0.js", "assets/frameworks/Semantic-UI-CSS-master/semantic.min.js", "assets/plugins/slick-carousel/slick.min.js"],
headElement = document.getElementsByTagName("head")[0],
linkElement, i;
for (i = 0; i < links.length; i++) {
linkElement = document.createElement("script");
linkElement.src = links[i];
headElement.appendChild(linkElement);
}
}
if (window.addEventListener)
window.addEventListener("load", parseJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", parseJSAtOnload);
else window.onload = parseJSAtOnload;
</script>		
		
		
		
		
	</body>

</html>