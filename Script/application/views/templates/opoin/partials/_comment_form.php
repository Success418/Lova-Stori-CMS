<div class="ui tabular menu">
	<h4 class="active item">
		<?= lang('ui_post_a_comment') ?>
	</h4>
</div>

<?php if(!is_logged_in()): ?>

<div class="ui fluid message">
    <strong class="sign-up-form-toggler"><?= lang('ui_create_new_account') ?></strong> 
    <?= lang('ui_or') ?> 
    <strong class="sign-in-form-toggler"><?= lang('ui_sign_in') ?></strong> 
    <?= lang('ui_to_write_a_comment') ?> 
</div>

<?php else: ?>

<?= get_form_response('comment_response') ?>

<form action="<?= base_url("post/{$post_slug}/comment") ?>" method="post" class="ui equal width form">
	
	<div class="field" id="reply-to">
		<input type="hidden" name="reply_to">

		<div class="ui label">
			<span></span>
			<i class="delete icon"></i>
		</div>	
	</div>

	<div class="field content">
		<textarea name="comment_body" data-meteor-emoji="true" placeholder="Tulis komentar..." required></textarea>
	</div>
	
	<div class="field d-none">
		<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>" >
	</div>

	<button type="submit" class="ui button">
		<?= lang('ui_publish') ?>
	</button>

</form>

<?php endif ?>