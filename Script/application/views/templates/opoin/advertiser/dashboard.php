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
								<h2>
                  <?= lang('ui_dashboard') ?> 
                  <a href="/advertiser/advertise" class="ui yellow labeled icon small button ml-auto mr-0"><i class="plus icon"></i>BUAT IKLAN</a>
                </h2>
							</div>

							<div class="ui fluid divider"></div>
							
							<div class="content dashboard">
								<div class="ui two doubling stackable cards">
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/money.png') ?>">
                        <span><?= lang('ui_expenses') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= number_shortener($totals->expenses) ?> <sup>IDR</sup></h1>
                      </div>
                    </div>
                  </div>
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/money-bag.png') ?>">
                        <span><?= lang('ui_balance') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= $totals->balance ?> <sup>IDR</sup></h1>
                      </div>
                    </div>
                  </div>
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/eye.png') ?>">
                        <span><?= lang('ui_views') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= $totals->views ?></h1>
                      </div>
                    </div>
                  </div>
                  <div class="card fluid">
                    <div class="content">
                      <div class="left">
                        <img src="<?= base_url('assets/control/images/article.png') ?>">
                        <span><?= lang('ui_compaigns') ?></span>
                      </div>
                      <div class="right">
                        <h1><?= $totals->compaigns ?></h1>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="table wrapper">
                  <table class="ui basic unstackable inverted table">
                    <thead>
                      <tr>
                        <th colspan="7">
                          <?= mb_strtoupper(lang('ui_latest_compaigns')) ?>
                          <a href="/advertiser/compaigns" class="ui tiny violet label ml-2">Lihat Semua</a> <b><span style="color: blue">KLIK</span> CARA DEPOSIT DAN <a href="/page/panduan-iklan" target="_blank"><span style="color: rgb(255, 0, 102);">PANDUAN BERIKLAN</span></a></b>
                        </th>
                      </tr>
                      <tr>
                        <th>ID</th>
                        <th><?= lang('ui_name') ?></th>
                        <th class="center aligned">Link</th>
                        <th class="center aligned">Banner</th>
                        <th class="center aligned">Tayang</th>
                        <th class="center aligned"><?= lang('ui_budget') ?></th>
                        <th class="center aligned"><?= lang('ui_active') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($compaigns as $compaign): ?>
                        <tr class="<?= $compaign->finished ? 'complete' : '' ?>">
                          <td><?= $compaign->id ?></td>
                          <td><?= $compaign->name ?></td>
                          <td class="center aligned"><a href="<?= $compaign->link ?>" target="_blank">Open</a></td>
                          <td class="center aligned"><a href="<?= base_url("uploads/banners/{$compaign->image}?v=".time()) ?>" target="_blank"><i class="eye icon mx-0"></i></a></td>
                          <td class="center aligned"><?= $compaign->views ?></td>
                          <td class="center aligned"><?= $compaign->budget ?> <sup>IDR</sup></td>
                          <td class="center aligned"><i class="outline large circle <?= $compaign->active ? 'green' : 'red' ?> icon mx-0"></i></td>
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