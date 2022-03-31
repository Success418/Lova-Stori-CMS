<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('control/includes/_head'); ?>
		<title>Panel - <?= lang('ui_sign_in') ?></title>
		<link rel="icon" href="/assets/images/favicon.ico">

        <style>
        body{background:url(/assets/images/bg.webp);background-position:top left;background-repeat:;}
        </style>
		
		<style>
			.grid {
				height: 100vh;
				width: 100%;
			}
			
			.card .header {
			    font-size: 18px !important;
			    color: #fff !important;
			}
			.content.pt-4 {
				background: #4c4c4c !important;
			}
			.content.pt-4 i {
				color: white !important;
			}
			#forms-container form.nd {
				display: none;
			}
			.message {
				max-width: 290px;
				margin: auto auto 0 !important;
				display: block !important;
			}
		</style>
	</head>
	<body>
		<div class="ui grid middle aligned m-0">
			<div class="row py-0">
				<div class="column" id="forms-container">
					<form action="<?= current_url() ?>" method="post" class="ui large form">
						<?= get_form_response('form_response') ?>
						<div class="ui card mx-auto">
							<div class="content pt-4">
								<div class="header">
									Kontrol - <?= lang('ui_sign_in') ?>
									<a href="/" class="right floated">
										<i class="home icon"></i>
									</a>
								</div>
							</div><br><center><b>HALAMAN TEAM STORI</b></center><br>
							<div class="content">
								<div class="field">
									<label><?= lang('ui_username') ?></label>
									<div class="ui left icon input">
										<input type="text" name="user" placeholder="Username atau Email">
										<i class="user icon"></i>
									</div>
								</div>
								<div class="field">
									<label><?= lang('ui_password') ?></label>
									<div class="ui left icon input">
										<input type="password" name="pwd" placeholder="Password...">
										<i class="lock icon"></i>
									</div>
								</div>
								<div class="ui checkbox">
									<input type="checkbox" name="remember_me">
									<label><?= lang('ui_remember_me') ?></label>
								</div>
								<div class="ui hidden divider"></div>
								<div class="field right aligned">
									<label><a class="form-toggler"><?= lang('ui_forgot_password') ?> ?</a></label>
								</div>
							</div>
							<?php if(session_exists('sign_in_key')): ?>
							<div class="content">
								<div class="field">
									<textarea name="sign_in_key" cols="30" rows="5" placeholder="<?= lang('ui_login_key') ?> ..."></textarea>
								</div>
							</div>
							<?php endif ?>
							<div class="content">
								<button type="submit" class="ui yellow left floated button"><?= lang('ui_sign_in') ?></button>
							</div>
							<input type="hidden" class="d-none" name="csrf_token" value="<?= get_csrf_token() ?>">
						</div>
					</form>
					<form action="<?= base_url('control/prepare_reset_password') ?>" method="post" class="ui large form nd">
						<?= get_form_response('form_response') ?>
						<div class="ui card mx-auto">
							<div class="content pt-4">
								<div class="header">Panel - <?= lang('ui_reset_password') ?></div>
							</div>
							<div class="content">
								<div class="field">
									<label>Email</label>
									<div class="ui left icon input">
										<input type="email" name="user_email" placeholder="Email">
										<i class="envelope icon"></i>
									</div>
								</div>
							</div>
							<input type="hidden" class="d-none" name="csrf_token" value="<?= get_csrf_token() ?>">
							<div class="content">
								<button type="submit" class="ui yellow left floated button"><?= lang('ui_submit') ?></button>
								<a class="ui white right floated button form-toggler"><?= lang('ui_sign_in') ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	
	<script>
		$(function() {
			$('.ui.checkbox').checkbox();
			$('.form-toggler').on('click', function() {
				$(this).closest('form').hide().siblings('form').show();
			})
		})
	</script>
	</body>
</html>