<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<script src="<?= base_url('assets/control/libraries/html5_entities.js') ?>"></script>

<!-- QUILL PLUGIN -->
<!--<link rel="stylesheet" href="<?= base_url('assets/control/plugins/quilljs/quill.snow.css') ?>">
<script src="<?= base_url('assets/control/plugins/quilljs/quill.js') ?>"></script>
<script src="<?= base_url('assets/control/plugins/quilljs/image-resize.min.js') ?>"></script>
<script src="<?= base_url('assets/control/js/quill-setup.js?v='.time()) ?>"></script>-->

<!-- summernote css/js -->
<link href="<?= base_url('assets/plugins/summernote-lite.css') ?>" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-lite.min.js"></script>
<style>
    .note-modal-backdrop {
        display: none !important;
    }
</style>
<form action="<?= base_url('control/newsletter/send') ?>" method="post" class="ui form post">

	<div class="ui grid attached">
		<div class="sixteen wide column">
			<div class="field">
				<label><h4><?= lang('ui_subject') ?></h4></label>
				<input type="text" 
					   name="newsletter_subject" 
					   required 
					   placeholder="subject...">
			</div>

			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label>
					<h4>
						<?= lang('ui_send_to_the_following_subscribers') ?>
						<i class="exclamation circle icon mr-0" data-content="<?= lang('ui_newsletter_tooltip') ?>" ></i>
					</h4>
				</label>
				<input type="text"
					   name="newsletter_emails" 
					   placeholder="email_1, email_2...">
			</div>

			<div class="ui hidden divider"></div>

			<div class="field">
				<label><h4><?= lang('ui_content') ?></h4></label>
				<textarea name="newsletter_body" cols="30" class="d-none summernote" rows="10" placeholder="Konten..."></textarea>
				<!-- QUILL EDITOR -->
				<div id="quill_editor"></div>
			</div>

			<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
		</div>
	</div>

	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_send') ?></button>
		<a href="<?= base_url('control/newsletter/subscribers') ?>" class="ui button"><?= lang('ui_cancel') ?></a>
	</div>

</form>

<div class="ui popup small vertical menu p-0 d-none" id="vid-resize">
  <div class="item p-1">
    <div class="ui input">
      <input type="number" id="vid-h" placeholder="Height">
    </div>
  </div>
  <div class="item p-1">
    <div class="ui input">
      <input type="number" id="vid-w" placeholder="Width">
    </div>
  </div>
  <div class="item p-1 d-none">
    <div class="ui input">
      <input type="number" placeholder="index">
    </div>
  </div>
  <div class="ui selection dropdown item">
  	<input type="hidden" id="align">
    <?= lang('ui_align') ?>
    <i class="dropdown icon"></i>
    <div class="menu">
      <a class="item" data-value="center"><i class="align center icon"></i> <?= lang('ui_center') ?></a>
      <a class="item" data-value="justify"><i class="align justify icon"></i> <?= lang('ui_justify') ?></a>
      <a class="item" data-value="left"><i class="align left icon"></i> <?= lang('ui_left') ?></a>
      <a class="item" data-value="right"><i class="align right icon"></i> <?= lang('ui_right') ?></a>
    </div>
  </div>
</div>

<script>
	$(function() {
		$('.summernote')
        .summernote({
          placeholder: 'Konten...',
          tabsize: 2,
          height: 400
        })
	})
</script>