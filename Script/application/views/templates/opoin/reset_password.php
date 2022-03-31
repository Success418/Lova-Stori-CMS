<!DOCTYPE html>
<html lang="en">
    
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('templates/opoin/partials/_head'); ?>
		<title><?= lang('ui_reset_password') ?></title>
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

					<form action="<?= base_url('reset_password') ?>" method="post" class="ui large form">

						<?= get_form_response('form_response') ?>

						<div class="ui card mx-auto">
							<div class="content pt-4">
								<div class="header">
									<?= lang('ui_reset_password') ?>
									<a href="/" class="right floated">
										<i class="home icon"></i>
									</a>
								</div>
							</div>
							<div class="content">
								<div class="field">
									<label><?= lang('ui_password') ?></label>
									<div class="ui left icon input">
										<input type="password" name="user_pwd" required placeholder="Password...">
										<i class="lock icon"></i>
									</div>
								</div>
								<div class="field">
									<label><?= lang('ui_confirm_password') ?></label>
									<div class="ui left icon input">
										<input type="password" name="pwd_confirm" required placeholder="Password...">
										<i class="lock icon"></i>
									</div>
								</div>
							</div>
							<div class="content">
								<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
								<button type="submit" class="ui yellow left floated button"><?= lang('ui_sign_in') ?></button>
							</div>
						</div>

					</form>

				</div>
			</div>
			
		</div>

	</body>
</html>