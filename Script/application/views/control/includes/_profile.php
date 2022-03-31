<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php extract($profile) ?>

<form action="<?= base_url('control/profile/update') ?>"  enctype="multipart/form-data" 
	  method="post" class="ui form" id="profile">
	
	<div class="profile-header">
		<div class="desktop-header">
			<div class="ui unstackable items hidden">
				<div class="item">

					<?php if(!$image_name): ?>
					<div class="ui placeholder">
						<div class="square image"></div>
					</div>

					<?php else: ?>

					<div class="ui image" style="display: block !important">
						<img src="<?= base_url("uploads/profiles/{$image_name}?v=").time() ?>" class="user_image">
					</div>
					<?php endif ?>

					<div class="content">
						<div class="header"><?= $user_fullname ?></div>
						<div class="ui hidden divider"></div>
						<div class="meta">
							<strong><?= lang('ui_country') ?> :</strong> <?= $user_country_en_name ?>
						</div>
						<div class="meta">
							<strong><?= lang('ui_address') ?> :</strong> <?= $user_address ?>
						</div>
						<div class="meta">
							<strong><?= lang('ui_date_of_birth') ?> :</strong> <?= $user_dob ?>
						</div>
						<div class="meta">
							<strong>Email :</strong> <?= $user_email ?>
						</div>
						<div class="meta mb-0">
							<strong><?= lang('ui_phone') ?> :</strong> <?= $user_phone ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mobile-header">
			<h2 class="ui dividing header mb-0 borderless pb-3">
				<img class="ui image mt-0" src="<?= base_url("uploads/profiles/{$image_name}?v=").time() ?>">
				<div class="content">
					<span><?= $user_fullname ?></span>
					<div class="ui hidden divider my-1"></div>
					<div class="sub header"><?= $user_email ?></div>
				</div>
			</h2>
			<div class="ui list">
				<div class="item">
					<div class="header"><?= lang('ui_country') ?></div>
					<?= $user_country_en_name ?>
				</div>
				<div class="item">
					<div class="header"><?= lang('ui_address') ?></div>
					<?= $user_address ?>
				</div>
				<div class="item">
					<div class="header"><?= lang('ui_date_of_birth') ?></div>
					<?= $user_dob ?>
				</div>
				<div class="item">
					<div class="header"><?= lang('ui_phone') ?></div>
					<?= $user_phone ?>
				</div>
			</div>
		</div>

		<input type="file" name="user_image" class="d-none" accept="image/*">
		<input type="text" name="user_image" class="d-none" value="<?= $image_id ?>">
		<input type="hidden" name="user_image_changed">
	</div>

	<div class="ui divider"></div>

	<div class="profile-body">
		<div class="field mb-3">
			<label><h4><?= lang('ui_about_me') ?></h4></label>
			<textarea name="user_about" cols="30" rows="5" placeholder="..."><?= $user_about ?></textarea>
		</div>

		<div class="ui two column stackable grid attached">
			<div class="column">
				<div class="field">
					<label><h4><?= lang('ui_first_name') ?></h4></label>
					<input type="text" name="user_firstname" value="<?= $user_firstname ?>">
				</div>

				<div class="field">
					<label><h4><?= lang('ui_last_name') ?></h4></label>
					<input type="text" name="user_lastname" value="<?= $user_lastname ?>">
				</div>

				<div class="field">
					<label><h4>Email</h4></label>
					<input type="email" name="user_email" value="<?= $user_email ?>">
				</div>

				<div class="field">
					<label><h4><?= lang('ui_password') ?></h4></label>
					<div class="ui labeled input">
						<input type="text" name="user_pwd" placeholder="<?= lang('ui_change_password') ?>">
					</div>
				</div>

				<div class="field">
					<label><h4><?= lang('ui_country') ?></h4></label>
					<input type="text" name="user_country" maxlength="2" size="2" value="<?= $user_country ?>" placeholder="country iso code (two letters)">
				</div>

				<div class="field">
					<label><h4><?= lang('ui_address') ?></h4></label>
					<input type="text" name="user_address" value="<?= $user_address ?>">
				</div>
			</div>

			<div class="column">
				<div class="field">
					<label><h4><?= lang('ui_phone') ?></h4></label>
					<input type="text" name="user_phone" value="<?= $user_phone ?>">
				</div>
				<div class="field">
					<label><h4><?= lang('ui_date_of_birth') ?></h4></label>
					<input type="date" name="user_dob" value="<?= $user_dob ?>">
				</div>
				<div class="field">
					<label><h4>Website</h4></label>
					<input type="text" name="user_linkedin" value="<?= $user_linkedin ?>">
				</div>				
				<div class="field">
					<label><h4>Facebook</h4></label>
					<input type="text" name="user_facebook" value="<?= $user_facebook ?>">
				</div>
				<div class="field">
					<label><h4>Instagram</h4></label>
					<input type="text" name="user_pinterest" value="<?= $user_pinterest ?>">
				</div>				
				<div class="field">
					<label><h4>Twitter</h4></label>
					<input type="text" name="user_twitter" value="<?= $user_twitter ?>">
				</div>
				<div class="field">
					<label><h4>Youtube</h4></label>
					<input type="text" name="user_youtube" value="<?= $user_youtube ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_save') ?></button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui button"><?= lang('ui_cancel') ?></a>
	</div>

	<input type="hidden" name="user_data" value="<?= base64_encode(json_encode($profile)) ?>">
	<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

</form>

<div class="ui modal profile" style="max-width: 300px; width: 100%">
	<i class="close icon"></i>
	<div class="content"></div>	
</div>

<script>
	$(function() {
		$('.checkbox').checkbox();

		$('.profile-header img, .profile-header .placeholder').on('click', function() {
			$('input[type="file"][name="user_image"]').click()
		});

		$('input[type="file"][name="user_image"]').on('change', function() {
			var file    = $(this)[0].files[0];
			var reader  = new FileReader();

			if(/^image\/(jpeg|jpg|ico|png|svg)$/.test(file.type))
			{				
				reader.addEventListener("load", function() {
					$('.profile-header img').attr('src', reader.result);
				}, false);

				if(file)
				{
					reader.readAsDataURL(file);
					$('.profile-header .image').show()
										       .siblings('.placeholder').hide();
				
					$('input[name="user_image_changed"]').val('1');
				}
			}
			else
			{
				$('.modal.profile').modal('show')
								.modal('setting', 'duration', 0)
								.find('.content').html('<h4>File yang dipilih tidak diizinkan</h4>\
													   <p>Ekstensi file harus berupa jpeg, jpg, png, ico atau svg</p>');

				$(this).val('');
			}
		});

		$('input[type="file"][name="user_image"]').on('change', function() {
			$('input[type="text"][name="user_image"]').val('');
		});

		if($('#profile input[type="text"][name="user_image"]').val().length)
		{
			$('#profile .ui.image').each(function(){
				$(this).show().siblings('.placeholder').hide();
			});
		}
	})
</script>
