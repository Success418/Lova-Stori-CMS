<!DOCTYPE html>
<html lang="en">

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>

    
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_comments') ?></title>

    <!-- JQUERY -->
    <script rel="preload" src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

    <!-- JQUERY UI -->
    <script defer src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>

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

						<div class="page comments" id="author-page">
                                     
							<div class="ui raised center left aligned segment shadowless">
								<h2><?= lang('ui_comments') ?></h2>
							</div>
              
              <div class="ui fluid divider"></div>

              <div class="ui <?php if(styleIsDark()): ?> inverted <?php endif ?> menu shadowless">
                <a @click="deleteItems()" class="item delete" :class="{disabled: itemsIds.length === 0}"><?= lang('ui_delete') ?></span></a>
              </div>

							<div class="ui fluid divider"></div>
              
              <?= get_form_response('form_response') ?>

							<div class="content posts">
                <div class="table wrapper">
                  <table class="ui basic unstackable <?php if(styleIsDark()): ?> inverted <?php endif ?> table">
                    <thead>
                      <tr>
                        <th>&nbsp;</th>
                        <th><?= lang('ui_username') ?> <a href="<?= "$filters_base_url/user_name/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th><?= lang('ui_post') ?> <a href="<?= "$filters_base_url/post_title/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th><?= lang('ui_content') ?></th>
                        <th><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                        <th><?= lang('ui_approved') ?> <a href="<?= "$filters_base_url/visible/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($comments as $comment): ?>
                        <tr>
                        <td class="center aligned">
                          <div class="ui basic checkbox" @click="toggleCommentSelection(<?= $comment->id ?>)">
                            <input type="checkbox" value="<?= $comment->id ?>" class="hidden">
                            <label></label>
                          </div>	
                        </td>
                          <td>
                            <a href="<?= base_url('user/'.mb_strtolower($comment->user_name)) ?>">
                              <?php if($comment->avatar): ?>
                              <img width="200" height="200" src="<?= base_url("uploads/profiles/{$comment->avatar}") ?>" alt="avatar" class="ui small avatar image">
                              <?php else: ?>
                                <span class="text avatar"><?= mb_substr($comment->user_name, 0, 2) ?></span>
                              <?php endif ?>
                            </a>
                          </td>
                          <td><a href="<?= base_url("post/{$comment->post_slug}") ?>#comments"><?= $comment->post_title ?></a></td>
                          <td><button class="ui tiny yellow button read" data-id="<?= $comment->id ?>"><?= lang('ui_read') ?></button></td>
                          <td><?= $comment->created_at ?></td>
                          <td class="center aligned">
                            <div class="ui <?= $comment->visible ? 'checked' : '' ?> visible fitted toggle checkbox">
                              <input type="checkbox" value="<?= $comment->id ?>" class="hidden">
                              <label></label>
                            </div>
                          </td>
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
            
            <div class="ui scroll small modal radiusless" id="comment-model">
              <i class="close icon"></i>
              <div class="content"></div>
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
          itemsIds: []
        },
        methods: {
          deleteItems: function()
          {
            if(this.itemsIds.length >= 1 && confirm("Apakah Anda Yakin ?"))
            {
              window.location.href = '/author/comments/delete/'+this.itemsIds.join(',');
            }

            return false
          },
          toggleCommentSelection: function(itemId)
          {
            var i = this.itemsIds.indexOf(itemId);

            if(i < 0)
            {
              this.itemsIds.push(itemId)
            }
            else
            {
              this.itemsIds = this.itemsIds.filter(function(id)
                              {
                                return id != itemId;
                              });
            }
          }
        }
      })

      $(function()
      {
        var commentsTexts = <?= $comments_texts ?>;

        $('.ui.star.rating').rating('disable');
        $('#top-menu a.item.logout').attr('href', '/logout');
        $('.ui.checkbox').checkbox();
        $('.ui.checkbox.checked').checkbox('check');


        $('.button.read').on('click', function() {
          var commentText = commentsTexts[$(this).data('id')];

          $('#comment-model .content').html(commentText)
                        .parent()
                        .modal('setting', 'duration', 0)
                        .modal('show');
        })

        $('#author-page .visible.toggle.checkbox input').on('change', function() {
          var visible = $(this).prop('checked') ? 1 : 0;
          var id      = parseInt($(this).val());

          if(/^(0|1)$/.test(visible) && /^(\d+)$/.test(id))
          {
              var data 		= {id: id, visible: visible};
              var ajaxReqUrl  = location.origin + '/author/comments/update_visibility';
              
              $.post(ajaxReqUrl, data);
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