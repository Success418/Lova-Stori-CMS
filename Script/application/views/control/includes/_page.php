<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<script src="<?= base_url('assets/control/libraries/html5_entities.js') ?>"></script>

<!-- QUILL PLUGIN -->
<link rel="stylesheet" href="<?= base_url('assets/control/plugins/quilljs/quill.snow.css') ?>">
<script src="<?= base_url('assets/control/plugins/quilljs/quill.js') ?>"></script>
<script src="<?= base_url('assets/control/plugins/quilljs/image-resize.min.js') ?>"></script>
<script src="<?= base_url('assets/control/js/quill-setup.js?v='.time()) ?>"></script>

<form action="<?= base_url('control/pages/add') ?>" enctype="multipart/form-data" method="post" class="ui form post">

	<div class="ui grid attached">
		<div class="sixteen wide column">
			<div class="field">
				<label><h4><?= lang('ui_title') ?></h4></label>
				<input type="text" 
					   name="page_title" 
					   required 
					   placeholder="Judul halaman..."
					   value="">
			</div>

			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4><?= lang('ui_summary') ?></h4></label>
				<textarea name="page_summary" cols="30" rows="3" placeholder="deskripsi singkat... (160 karakter)"></textarea>
			</div>

			<div class="ui hidden divider"></div>

			<div class="field">
				<label><h4><?= lang('ui_keywords') ?></h4></label>
				<input type="text"
					   name="page_keywords" 
					   placeholder="katakunci 1, katakunci 2, katakunci 3 ..."
					   value="">
			</div>

			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4><?= lang('ui_show_in') ?></h4></label>
				<select class="ui dropdown" name="page_in[]" multiple>
					<option value="menu">Menu</option>
					<option value="footer">Footer</option>
			  	</select>
			</div>

			<div class="ui hidden divider"></div>

			<div class="field">
				<label><h4><?= lang('ui_content') ?></h4></label>
				<textarea name="page_body" id="item_body" cols="30" class="d-none" rows="10" placeholder="Konten halaman..."></textarea>
				<!-- QUILL EDITOR -->
				<div id="quill_editor"></div>
			</div>
		</div>
	</div>

	<div class="ui blue right aligned segment">
		<button type="submit" name="publish" class="ui yellow button"><?= lang('ui_publish') ?></button>
		<button type="submit" name="draft" class="ui blue button"><?= lang('ui_draft') ?></button>
		<a href="<?= base_url('control/pages') ?>" class="ui button"><?= lang('ui_cancel') ?></a>
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