<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?= get_form_response('form_response') ?>
<script src="<?= base_url('assets/control/libraries/html5_entities.js') ?>"></script>
<!-- summernote css/js -->
<link href="<?= base_url('assets/plugins/summernote-lite.css') ?>" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-lite.min.js"></script>
<link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/css/melovers.css"); ?>">
<script>
	var categories 	  = <?= json_encode($categories, TRUE) ?>;
	var subcategories = <?= json_encode($subcategories_by_parent_id, TRUE) ?>;
</script>
<script src="<?= base_url('assets/control/js/post.js?v=').time() ?>"></script>
<form action="<?= base_url("control/posts/edit/{$post->id}") ?>" enctype="multipart/form-data" method="post" class="ui form post">
	<div class="ui two column stackable grid attached">
		<!-- FIRST COLUMN -->
		<div class="eleven wide column">
			<div class="field">
				<label><h4><?= lang('ui_title') ?></h4></label>
				<input type="text" 
					   name="post_title" 
					   required 
					   placeholder="Judul berita..."
					   value="<?= $this->session->flashdata('post_title') ?? $post->title ?>">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_summary') ?></h4></label>
				<textarea name="post_summary" cols="30" rows="3" placeholder="deskripsi singkat... (160 karakter)"><?= $this->session->flashdata('post_summary') ?? $post->summary  ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_content') ?></h4></label>
				<textarea name="post_body" cols="30" rows="15" class="summernote" required placeholder="Konten berita..."><?= $this->session->flashdata('post_body') ?? $post->body ?></textarea>
			</div>
		</div>
		<!-- SECOND COLUMN -->
		<div class="five wide column">
			<div class="field">
				<label><h4><?= lang('ui_image') ?></h4></label>
				<img src="<?= base_url("uploads/images/{$post->image_name}?v=".time()) ?>" alt="image" class="ui fluid image post_image" style="display: block">
				<button class="ui fluid basic icon labeled button file mt-3" type="button">
					<i class="upload icon"></i>
					<?= lang('ui_select_image') ?>
				</button>
				<input type="file" accept="image/*" name="post_image" class="d-none">
				
				<input type="radio" class="d-none" name="post_image_changed">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_category') ?></h4></label>
				<div class="ui search selection dropdown post_category">
					<input type="hidden" name="post_category">
					<i class="dropdown icon"></i>
					<div class="default text"><?= lang('ui_select_category') ?></div>
					<div class="menu">
						<?php foreach($categories as $category): ?>
							<div class="item" data-value="<?= $category['category_id'] ?>">
								<?= $category['category_title'] ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_subcategory') ?></h4></label>
				<div class="ui search selection dropdown post_subcategory">
					<input type="hidden" name="post_subcategory">
					<i class="dropdown icon"></i>
					<div class="default text"><?= lang('ui_select_subcategory') ?></div>
					<div class="menu"></div>
				</div>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_kaywords') ?></h4></label>
				<input type="text"
					   name="post_keywords" 
					   placeholder="katakunci 1, katakunci 2, katakunci 3 ..."
					   value="<?= $this->session->flashdata('post_keywords') ?? $post->keywords ?>">
			</div>
		</div>
	</div>
	
	<input type="hidden" name="post_data" value="<?= base64_encode(json_encode($post)) ?>">
	
	<div class="ui blue right aligned segment">
		<button type="submit" name="edit" class="ui yellow button"><?= lang('ui_edit') ?></button>
		<a href="<?= base_url('control/posts') ?>" class="ui button"><?= lang('ui_cancel') ?></a>
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
		$('.post_category.dropdown').dropdown('set selected', 
											  '<?= $this->session->flashdata('post_category') ?? $post->category_id ?>');
		$('.post_subcategory.dropdown').dropdown('set selected', 
												 '<?= $this->session->flashdata('post_subcategory') ?? $post->subcategory_id ?>');
		
		$('.summernote')
        .summernote({
          placeholder: '----',
          tabsize: 2,
          height: 500
        })
	})
</script>