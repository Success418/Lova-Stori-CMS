<!DOCTYPE html>
<html lang="en">
    
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>

    
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_settings') ?></title>

    <!-- JQUERY -->
    <script rel="preload" src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

    <!-- JQUERY UI -->
    <script defer src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>

    <!-- SEMANTIC-UI -->
    <link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.css"); ?>">
    <script defer src="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.js"); ?>"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
    <script defer src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>
    
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

						<div class="page settings" id="author-page">
                                     
							<div class="ui raised center left aligned segment shadowless">
                <h2><?= lang('ui_settings') ?></h2>
                <button class="ui yellow button ml-auto mr-0" type="button" onclick="$('#settings-form').submit()"><?= lang('ui_update') ?></button>
							</div>
              
							<div class="ui fluid divider"></div>
              
              <?= get_form_response('form_response') ?>

							<div class="content">
                <form action="/author/settings" class="ui fluid form" method="post" enctype="multipart/form-data" id="settings-form">
                  <div class="ui grid">
                    <div class="left column">
                      <div class="ui vertical <?php if(styleIsDark()): ?> inverted <?php endif ?> fluid tabular menu">
                        <a class="active item" data-tab="profile">Profil</a>
                        <a class="item" data-tab="social">Sosial Media</a>
                        <a class="item" data-tab="payment">Pembayaran</a>
                        <a class="item" data-tab="ids">ID</a>
                      </div>
                    </div>
                    <div class="right stretched column">
                      <div class="ui <?php if(styleIsDark()): ?> inverted <?php endif ?> active tab segment my-0" data-tab="profile">
                        <div class="ui rounded small image" onclick="$('input[name=\'user_image\']').click()">
                          <img width="200" height="200" src="<?= base_url("uploads/profiles/".($author->avatar ?? 'default.png')) ?>" alt="avatar">
                        </div>
                        <input type="file" class="d-none" name="user_image" accept=".jpeg,.jpg,.png">

                        <div class="field mt-3">
                          <label>Username</label>
                          <input type="text" readonly disabled value="<?= $author->username ?>">
                        </div>

                        <div class="field mt-3">
                          <label>Email</label>
                          <input type="text" readonly disabled value="<?= $author->email ?>">
                        </div>

                        <div class="field mt-3">
                          <label>Nama Depan</label>
                          <input type="text" name="user_firstname" value="<?= session_get('old_author.user_firstname', $author->firstname ?? $author->firstname_alt) ?>">
                        </div>

                        <div class="field mt-3">
                          <label>Nama Belakang</label>
                          <input type="text" name="user_lastname" value="<?= session_get('old_author.user_lastname', $author->lastname ?? $author->lastname_alt) ?>">
                        </div>

                        <div class="field mt-3">
                          <label>Telp</label>
                          <input type="text" name="user_phone" value="<?= session_get('old_author.user_phone', $author->phone) ?>">
                        </div>

                        <div class="field mt-3">
                          <label>Tentang | Deskripsi</label>
                          <textarea name="user_about" cols="30" rows="5"><?= session_get('old_author.user_about', $author->about ?? $author->about_alt) ?></textarea>
                        </div>

                        <div class="field mt-3">
                          <label>Ganti Password</label>
                          <input type="text" name="new_password" value="<?= session_get('old_author.new_password') ?>">
                        </div>
                      </div>

                      <div class="ui <?php if(styleIsDark()): ?> inverted <?php endif ?> tab segment my-0" data-tab="social">
                        <div class="field">
                          <label>Website</label>
                          <input type="text" name="user_linkedin" value="<?= session_get('old_author.user_linkedin', $author->linkedin) ?>">
                        </div>

                        <div class="field">
                          <label>Facebook</label>
                          <input type="text" name="user_facebook" value="<?= session_get('old_author.user_facebook', $author->facebook) ?>">
                        </div>

                        <div class="field">
                          <label>Instagram</label>
                          <input type="text" name="user_pinterest" value="<?= session_get('old_author.user_pinterest', $author->pinterest) ?>">
                        </div>                        
                        
                        <div class="field">
                          <label>Twitter</label>
                          <input type="text" name="user_twitter" value="<?= session_get('old_author.user_twitter', $author->twitter) ?>">
                        </div>

                        <div class="field">
                          <label>Youtube</label>
                          <input type="text" name="user_youtube" value="<?= session_get('old_author.user_youtube', $author->twitter) ?>">
                        </div>
                      </div>

                      <div class="ui <?php if(styleIsDark()): ?> inverted <?php endif ?> tab segment my-0" data-tab="payment">
                        <div class="field">
                          <label>Nomor Rekening Bank</label>
                          <input type="text" name="user_bank_account_number" value="<?= session_get('old_author.user_bank_account_number', $author->bank_account_number) ?>">
                        </div>

                        <div class="field">
                          <label>Nama Bank</label>
                          <input type="text" name="user_bank_name" value="<?= session_get('old_author.user_bank_name', $author->bank_name) ?>">
                        </div>
                      </div>

                      <div class="ui <?php if(styleIsDark()): ?> inverted <?php endif ?> tab segment my-0" data-tab="ids">
                        <div class="field">
                          <label>ID KTP Depan</label>
                          <?php if($author->card_id_1): ?>
                          <input type="text" readonly disabled value="ID Sudah Terverifikasi">
                          <?php else: ?>
                          <div class="ui left action input">
                            <button class="ui yellow button" type="button" onclick="this.nextElementSibling.click()"><?= lang('ui_select') ?></button>
                            <input type="file" name="user_card_id_1" class="d-none" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <input type="text" disabled readonly placeholder="Upload ID KTP Depan">
                          </div>
                          <?php endif ?>
                        </div>

                        <div class="field">
                          <label>ID KTP Belakang</label>
                          <?php if($author->card_id_2): ?>
                          <input type="text" readonly disabled value="ID Sudah Terverifikasi">
                          <?php else: ?>
                          <div class="ui left action input">
                            <button class="ui yellow button" type="button" onclick="this.nextElementSibling.click()"><?= lang('ui_select') ?></button>
                            <input type="file" name="user_card_id_2" class="d-none" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <input type="text" disabled readonly placeholder="Upload ID KTP Belakang">
                          </div>
                          <?php endif ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
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
        $('#author-page .menu .item').tab();

        $('#top-menu a.item.logout').attr('href', '/logout');
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