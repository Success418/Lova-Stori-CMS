<!DOCTYPE html>
<html lang="en">
    
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>

    
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_withdrawal') ?></title>

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
    
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
    <script defer src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>

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

						<div class="page withdrawal" id="author-page">
              
              <div class="ui raised center left aligned segment shadowless">
								<h2><?= lang('ui_withdrawal') ?></h2>
							</div>
              
							<div class="ui fluid divider"></div>
              
              <?= get_form_response('form_response') ?>

							<div class="content">
                <div class="ui fluid card">
                  <div class="content header">
                    <div class="header">
                      Saldo Sekarang
                    </div>
                  </div>
                  <div class="content">
                    Saldo <span class="right floated"><?= $author->points ?? 0 ?> Poin</span>
                  </div>
                </div>
                
                <div class="ui fluid card">
                  <div class="content">
                    <div class="header">
                      Kirim Permintaan Pembayaran
                    </div>
                  </div>
                  <div class="content">
                    <form action="/author/withdrawal" class="ui fluid form <?php if(styleIsDark()): ?> inverted <?php endif ?>" method="post" id="withdrawal">
                      <div class="field">
                        <?php if(isset($this->settings['minimum_withdrawal'], $this->settings['exchange_rate'])): ?>
                        <label>Poin untuk ditukarkan (Minimal <?= ceil($this->settings['minimum_withdrawal']/$this->settings['exchange_rate']) ?> <?= lang('ui_points') ?> = IDR 200.000)</label>
                        <?php else: ?>
                        <label>Poin untuk ditukarkan (Minimal ?)</label>
                        <?php endif ?>
                        <input type="number" placeholder="number of points to exchange" value="<?= session_get('old_withdrawal_points', 0) ?>" name="withdrawal_points">
                      </div>
                      <div class="field">
                        <button class="ui yellow button" type="submit">Kirim</button>
                      </div>
                    </form>
                  </div>
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
      $(function()
      {
        $('#top-menu a.item.logout').attr('href', '/logout');

        $('#author-page .inverted.table .ui.pagination').addClass('inverted');

        $('form#withdrawal').on('submit', function(e)
        {
          if($('input[name="withdrawal_points"]').val() == 0)
          {
            e.preventDefault();
            return false;
          }
        })
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