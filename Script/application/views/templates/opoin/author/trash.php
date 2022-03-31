<!DOCTYPE html>
<html lang="en">

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>

    
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_trash') ?></title>

    <!-- JQUERY -->
    <script rel="preload" src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

    <!-- JQUERY UI -->
    <script defer src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
    <script defer src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>
    
    <!-- SEMANTIC-UI -->
    <link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.css"); ?>">
    <script defer src="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.js"); ?>"></script>

    <!-- VUE.JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>

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

						<div class="page trash" id="author-page">
                                     
							<div class="ui raised center left aligned segment shadowless">
								<h2><?= lang('ui_trash') ?></h2>
							</div>
              
              <div class="ui fluid divider"></div>

              <div class="ui <?php if(styleIsDark()): ?> inverted <?php endif ?> menu shadowless">
                <a @click="restorePosts()" class="item delete" :class="{disabled: postsIds.length === 0}"><?= lang('ui_restore') ?></span></a>

                <div class="right menu">
                  <div class="ui search item xs-hidden">
                    <div class="ui transparent icon input">
                      <input class="prompt" type="text" placeholder="<?= lang('ui_search') ?>...">
                      <i class="search link icon"></i>
                    </div>
                  </div>
                </div>
              </div>

							<div class="ui fluid divider"></div>
              
              <?= get_form_response('form_response') ?>

							<div class="content posts">
                <div class="table wrapper">
                  <table class="ui basic unstackable <?php if(styleIsDark()): ?> inverted <?php endif ?> table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th><?= lang('ui_title') ?> <a href="<?= "$filters_base_url/title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th><?= lang('ui_views') ?> <a href="<?= "$filters_base_url/views/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th>
                          <div class="ui categories-list scrolling dropdown">
                            <div class="text"><?= lang('ui_category') ?></div>
                            <i class="caret down icon"></i>
                            <div class="menu">
                              <a href="/author/posts/trash" class="item">All</a>
                              <?php foreach($categories as $category): 
                                  $slug = url_title($category['category_title'], '-', TRUE) ?>
                              <a href="<?= "/author/posts/trash/id/{$category['category_id']}/category/{$slug}" ?>" class="item">
                                <?= ucfirst($category['category_title']) ?>
                              </a>
                              <?php endforeach ?>
                            </div>
                          </div>
                        </th>
                        <th><?= lang('ui_rating') ?> <a href="<?= "$filters_base_url/rating/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th><?= lang('ui_published') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($posts as $post): ?>
                      <tr>
                        <td class="center aligned">
                          <div class="ui basic fitted checkbox" @click="togglePostSelection(<?= $post->id ?>)">
                            <input type="checkbox" value="<?= $post->id ?>" class="hidden">
                            <label></label>
                          </div>	
                        </td>
                        <td>
                          <a href="<?= strtolower(base_url("post/{$post->slug}")) ?>" target="_blank">
                            <?= $post->title ?>
                          </a>
                        </td>
                        <td class="center aligned"><?= $post->views ?></td>
                        <td><?= ucfirst($post->category_title) ?></td>
                        <td><div class="ui star rating" data-rating="<?= $post->rating ?>" data-max-rating="5"></div></td>
                        <td class="center aligned">
                          <div class="ui <?= $post->visible ? 'checked' : '' ?> visible fitted toggle checkbox">
                            <input type="checkbox" value="<?= $post->id ?>" class="hidden">
                            <label></label>
                          </div>
                        </td>
                        <td><?= $post->date ?></td>
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
							</div>
						</div>

						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer'); ?>
						</div>
					</div>
				</div>
			</div>
    </div>
    
    <script type="application/javascript">
      var app = new Vue({
        el: '#page',
        data: {
          postsIds: []
        },
        methods: {
          restorePosts: function()
          {
            if(this.postsIds.length >= 1)
            {
              window.location.href = '/author/posts/trash/restore/'+this.postsIds.join(',');
            }

            return false
          },
          togglePostSelection: function(postId)
          {
            var i = this.postsIds.indexOf(postId);

            if(i < 0)
            {
              this.postsIds.push(postId)
            }
            else
            {
              this.postsIds = this.postsIds.filter(function(id)
                              {
                                return id != postId;
                              });
            }
          },
        }
      })

      $(function()
      {
        $('.ui.star.rating').rating('disable');
        $('#top-menu a.item.logout').attr('href', '/logout');
        $('.ui.checkbox').checkbox();
        $('.ui.checkbox.checked').checkbox('check');


        $('#author-page .item.search input').on('keyup', function(e) 
        {
          var val = $(this).val().trim();

          if((e.keyCode === 13) && val.length >= 1)
          {   
              val = encodeURIComponent(val);
              window.location.href = window.origin + '/author/posts/trash/search/' + val;
          }
        })


        $('#author-page .item.search .search.link.icon').on('click', function() 
        {
          var val = $(this).siblings('input').val().trim();

          if(val.length >= 1)
          {
              val = encodeURIComponent(val);

              window.location.href = window.origin + '/author/posts/trash/search/' + val;
          }
        })

        $('#author-page .inverted.table .ui.pagination').addClass('inverted');
      })
    </script>
    
    
    
    
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