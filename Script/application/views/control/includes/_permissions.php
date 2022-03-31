<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="ui six doubling cards <?= ($user_role === 'administrator') ? "{$user_role} active" : $user_role ?>" data-tab="<?= $user_role ?>">

	<div class="card posts" data-collection="posts">
		<div class="content">
			<h4><?= lang('ui_posts') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="add">
					<input type="checkbox">
					<label><?= lang('ui_add') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update_visibility">
					<input type="checkbox">
					<label><?= lang('ui_visibility') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update_pin">
					<input type="checkbox">
					<label><?= lang('ui_pinning') ?></label>
				</div>
			</div>
			<div class="field" title="<?= lang('ui_recommendation') ?>
			">
				<div class="ui checkbox" data-name="update_recommendation">
					<input type="checkbox">
					<label><?= lang('ui_recommendation') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
		</div>
	</div>

	<div class="card pages" data-collection="pages">
		<div class="content">
			<h4><?= lang('ui_pages') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="add">
					<input type="checkbox">
					<label><?= lang('ui_add') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update_visibility">
					<input type="checkbox">
					<label><?= lang('ui_visibility') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
			<div class="field">&nbsp;</div>
		</div>
	</div>

	<div class="card users" data-collection="users">
		<div class="content">
			<h4><?= lang('ui_users') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="add">
					<input type="checkbox">
					<label><?= lang('ui_add') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update_blocked">
					<input type="checkbox">
					<label><?= lang('ui_blocking') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update_active">
					<input type="checkbox">
					<label><?= lang('ui_activation') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update_role">
					<input type="checkbox">
					<label><?= lang('ui_role') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
		</div>
	</div>

	<div class="card categories" data-collection="categories">
		<div class="content">
			<h4><?= lang('ui_categories') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="add">
					<input type="checkbox">
					<label><?= lang('ui_add') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update_visibility">
					<input type="checkbox">
					<label><?= lang('ui_visibility') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
			<div class="field">&nbsp;</div>
		</div>
	</div>
	
	<div class="card subcategories" data-collection="subcategories">
		<div class="content">
			<h4><?= lang('ui_subcategories') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="add">
					<input type="checkbox">
					<label><?= lang('ui_add') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update_visibility">
					<input type="checkbox">
					<label><?= lang('ui_visibility') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
			<div class="field">&nbsp;</div>
		</div>
	</div>

	<div class="card comments" data-collection="comments">
		<div class="content">
			<h4><?= lang('ui_comments') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update_visibility">
					<input type="checkbox">
					<label><?= lang('ui_visibility') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
			<div class="field">&nbsp;</div>
			<div class="field">&nbsp;</div>
		</div>
	</div>

	<div class="card newsletter" data-collection="newsletter">
		<div class="content">
			<h4><?= lang('ui_newsletter') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="add">
					<input type="checkbox">
					<label><?= lang('ui_add') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">&nbsp;</div>
		</div>
	</div>

	<div class="card profile" data-collection="profile">
		<div class="content">
			<h4><?= lang('ui_profile') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
		</div>
	</div>

	<div class="card settings" data-collection="settings">
		<div class="content">
			<h4><?= lang('ui_settings') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">&nbsp;</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
		</div>
	</div>

	<div class="card trash" data-collection="trash">
		<div class="content">
			<h4><?= lang('ui_trash') ?></h4>
		</div>
	
		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="index">
					<input type="checkbox">
					<label><?= lang('ui_get') ?></label>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox" data-name="delete">
					<input type="checkbox">
					<label><?= lang('ui_delete') ?></label>
				</div>
			</div>
		</div>

		<div class="extra content"><?= lang('ui_update') ?></div>

		<div class="content">
			<div class="field">
				<div class="ui checkbox" data-name="update">
					<input type="checkbox">
					<label><?= lang('ui_all') ?></label>
				</div>
			</div>
		</div>
	</div>
	
</div>