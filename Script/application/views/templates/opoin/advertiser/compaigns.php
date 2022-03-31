<!DOCTYPE html>
<html lang="en">

    
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>

    
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_compaigns') ?></title>

    <!-- JQUERY -->
    <script src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

    <!-- JQUERY UI -->
    <script src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>

    <!-- SEMANTIC-UI -->
    <link rel="stylesheet" href="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.css"); ?>">
    <script src="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.js"); ?>"></script>

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
    <script type="text/javascript" src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>
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

						<div class="page dashboard compaigns" id="author-page">
                                     
							<div class="ui raised center left aligned segment shadowless">
								<h2><?= lang('ui_compaigns') ?></h2>
                <a href="/advertiser/advertise" class="ui yellow labeled icon small button ml-auto mr-0"><i class="plus icon"></i>KAMPANYE IKLAN</a>
							</div>

							<div class="ui fluid divider"></div>
							
							<div class="table wrapper mt-0">
                <table class="ui basic celled unstackable inverted table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th><?= lang('ui_name') ?></th>
                      <th class="center aligned">Link</th>
                      <th class="center aligned">Banner</th>
                      <th class="center aligned"><?= lang('ui_budget') ?></th>
                      <th class="center aligned"><?= lang('ui_views') ?></th>
                      <th class="center aligned">Ref</th>
                      <th class="center aligned"><?= lang('ui_active') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($compaigns as $compaign): ?>
                      <tr class="<?= $compaign->finished ? 'complete' : '' ?>">
                        <td><?= $compaign->id ?></td>
                        <td><?= $compaign->name ?></td>
                        <td class="center aligned"><a href="<?= $compaign->link ?>" target="_blank">Open</a></td>
                        <th class="center aligned"><a href="<?= base_url("uploads/banners/{$compaign->image}?v=".time()) ?>" target="_blank"><i class="eye icon mx-0"></i></a></th>
                        <td class="center aligned"><?= $compaign->budget ?> <sup>(IDR)</sup></td>
                        <td class="center aligned"><?= $compaign->views ?></td>
                        <td class="center aligned"><?= strtoupper($compaign->ad_ref) ?></td>
                        <td class="center aligned"><i class="outline large circle <?= $compaign->active ? 'green' : 'red' ?> icon mx-0"></i></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>

              <script>
              $(function()
              {
                $('#top-menu a.item.logout').attr('href', '/logout');
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