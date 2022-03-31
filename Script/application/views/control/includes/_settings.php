<?php defined('BASEPATH') OR exit('Tidak ada akses halaman yang diizinkan'); ?>
<?= get_form_response('form_response') ?>

<?php extract($settings)  ?>

<?php if($tab === 'general'): ?>

<form action="<?= base_url('control/settings/update/general') ?>" enctype="multipart/form-data" method="post" class="ui form controlled" data-method="update" data-controller="settings">
	
	<div class="ui segment">
		<div class="field">
			<div class="ui toggle checkbox <?= site_in_maintenance() ? 'checked' : '' ?>">
				<input type="checkbox" name="site_maintenance_mode">
				<label>Mode Maintenance</label>
			</div>
		</div>
		<div class="field">
			<label>Alamat IP yang diizinkan</label>
			<input type="text" name="allowed_ip_addresses" placeholder="127.0.0.1" value="<?= implode(',', maintenance_allowed_ips()) ?>">
		</div>
	</div>
	
	<div class="ui divider"></div>
	
	<div class="ui segment">
		<div class="field">
			<label>Imformasi</label>
			<input type="text" name="site_important_note" value="<?= $site_important_note ?? null ?>" placeholder="Catatan Imformasi...">
		</div>
	</div>

	<div class="ui divider"></div>

	<div class="ui two column stackable grid attached">
		<!-- FIRST COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4><?= lang('ui_name') ?></h4></label>
				<input type="text" name="site_name" value="<?= $site_name ?>" placeholder="Nama situs...">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_title') ?></h4></label>
				<input type="text" name="site_title" value="<?= $site_title ?>" placeholder="Judul situs...">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_description') ?></h4></label>
				<textarea name="site_description" cols="30" rows="10" placeholder="deskripsi situs..."><?= $site_description ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4>Email</h4></label>
				<input type="email" name="site_admin_email" value="<?= $site_admin_email ?>" placeholder="Email admin ...">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_author') ?></h4></label>
				<input type="text" name="site_admin_name" value="<?= $site_admin_name ?>" placeholder="Nama admin...">
			</div>
		
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_keywords') ?></h4></label>
				<input type="text" name="site_keywords" value="<?= $site_keywords ?>" placeholder="Kata kunci situs...">
			</div>
			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4><?= lang('ui_posts_per_page') ?></h4></label>
				<input type="number" name="site_posts_per_page" value="<?= $site_posts_per_page ?>">
			</div>
			
			<div class="ui hidden divider"></div>
			<div class="field upload">
				<label><h4>Favicon</h4></label>
				<button class="ui fluid basic button file" type="button">
					<?= lang('ui_select_image') ?>
				</button>
				<input type="file" name="site_favicon" class="d-none">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field upload">
				<label><h4>Logo</h4></label>
				<button class="ui fluid basic button file" type="button">
					<?= lang('ui_select_image') ?>
				</button>
				<input type="file" name="site_logo" class="d-none">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_licence_key') ?></h4></label>
				<input type="text" name="site_licence_key" value="<?= $site_licence_key ?>" placeholder="site <?= lang('ui_licence_key') ?>...">
			</div>
		</div>
		<!-- SECOND COLUMN -->
		<div class="column">
			<div class="field upload">
				<label><h4><?= lang('ui_cover') ?></h4></label>
				<button class="ui fluid basic button file" type="button">
					<?= lang('ui_select_image') ?>
				</button>
				<input type="file" name="site_cover" class="d-none">
			</div>

			<div class="field">
				<div class="ui hidden divider"></div>
				
				<label><h4><?= lang('ui_styles') ?></h4></label>
				<select name="site_style" class="ui dropdown">
					<?php foreach(['light', 'dark'] as $style): ?>
					<?php $default = ($style === $site_style) ? 'light' : '' ?>
					<option value="<?= $style ?>" <?= $default ?>><?= ucfirst($style) ?></option>
					<?php endforeach ?>
				</select> 
			</div>

			<div class="field">
				<div class="ui hidden divider"></div>
				
				<label><h4><?= lang('ui_templates') ?></h4></label>
				<div class="ui selection dropdown fluid">
						<input type="hidden" name="site_template" value="<?= $site_template ?? 'default' ?>">
						<div class="default text">Pilih template</div>
						<div class="menu">
							<a data-item="opoin" class="item">Opoin</a>
						</div>
				</div>
			</div>

			<div class="ui hidden divider"></div>
			<div class="ui segment">
				<div class="field">
					<div class="ui toggle checkbox <?= $site_regular_scroll ? 'checked' : '' ?>">
						<input type="checkbox" name="site_regular_scroll" value="<?= $site_regular_scroll ?>">
						<label><?= lang('ui_regular_scroll') ?></label>
					</div>
				</div>
			</div>
			<div class="ui segment">
				<div class="field">
					<div class="ui toggle checkbox <?= $site_comments_moderation ? 'checked' : '' ?>">
						<input type="checkbox" name="site_comments_moderation" value="<?= $site_comments_moderation ?>">
						<label><?= lang('ui_comments_moderation') ?></label>
					</div>
				</div>
			</div>
			<div class="ui segment">
				<div class="field">
					<div class="ui toggle checkbox <?= $site_show_posts_authors ? 'checked' : '' ?>">
						<input type="checkbox" name="site_show_posts_authors" value="<?= $site_show_posts_authors ?>">
						<label><?= lang('ui_show_posts_authors') ?></label>
					</div>
				</div>
			</div>
			<div class="ui segment">
				<div class="field">
					<div class="ui toggle checkbox <?= $site_show_post_author ? 'checked' : '' ?>">
						<input type="checkbox" name="site_show_post_author" value="<?= $site_show_post_author ?>">
						<label><?= lang('ui_show_post_author') ?></label>
					</div>
				</div>
				<div class="field">
					<div class="ui toggle checkbox <?= $site_show_post_author_at ? 'checked' : '' ?>">
						<input type="checkbox" name="site_show_post_author_at" value="<?= $site_show_post_author_at ?>">
						<label><?= lang('ui_show_at') ?></label>
					</div>
				</div>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Twitter</h4></label>
				<input type="text" name="site_twitter" placeholder="..." value="<?= $site_twitter ?>">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Youtube</h4></label>
				<input type="text" name="site_youtube" placeholder="..." value="<?= $site_youtube ?>">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Pinterest</h4></label>
				<input type="text" name="site_pinterest" placeholder="..." value="<?= $site_pinterest ?>">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Linkedin</h4></label>
				<input type="text" name="site_linkedin" placeholder="..." value="<?= $site_linkedin ?>">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Facebook</h4></label>
				<input type="text" name="site_facebook" placeholder="..." value="<?= $site_facebook ?>">
			</div>
		</div>
	</div>
	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_save') ?></button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button"><?= lang('ui_cancel') ?></a>
	</div>
</form>
<script>
	$(function() {
		$('.dropdown[name="site_style"]').dropdown('set selected', '<?= $site_style ?>');
		$('.ui.checkbox.checked').checkbox('check');
	})
</script>

<?php elseif($tab === 'search_engines'): ?>

<form action="<?= base_url('control/settings/update/search_engines') ?>" method="post" class="ui form controlled" data-method="update" data-controller="settings">
	<div class="ui two column stackable grid attached">
		<!-- FIRST COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4>Google - <?= lang('ui_site_verfication') ?></h4></label>
				<input type="text" name="site_google_verification_code" value="<?= $site_google_verification_code ?>" placeholder="Konten meta tag...">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Bing - <?= lang('ui_site_verfication') ?></h4></label>
				<input type="text" name="site_bing_verification_code" value="<?= $site_bing_verification_code ?>" placeholder="Konten meta tag...">
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Yandex - <?= lang('ui_site_verfication') ?></h4></label>
				<input type="text" name="site_yandex_verification_code" value="<?= $site_yandex_verification_code ?>" placeholder="Konten meta tag...">
			</div>
		</div>
		<!-- SECOND COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4>Google analytics</h4></label>
				<textarea class="base64" name="site_google_analytics" cols="30" rows="5" placeholder="Kode google analytics..."><?= base64_decode($site_google_analytics) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4>Robots</h4></label>
				<input type="text" name="site_robots" value="<?= $site_robots ?>" placeholder="...">
			</div>
		</div>
	</div>
	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_save') ?></button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button"><?= lang('ui_cancel') ?></a>
	</div>
</form>

<?php elseif($tab === 'advertisement'): ?>

<form action="<?= base_url('control/settings/update/advertisement') ?>" method="post" class="ui form controlled" data-method="update" data-controller="settings">
	<div class="ui two column stackable grid attached">
		<!-- FIRST COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4>Popup</h4></label>
				<textarea class="base64" name="site_popup_code" cols="30" rows="2" placeholder="..."><?= base64_decode($site_popup_code) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_responsive_ad_unit') ?></h4></label>
				<textarea class="base64" name="site_responsive_unit_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_responsive_unit_ad) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>Otomatis <?= lang('ui_ad_unit') ?></h4></label>
				<textarea class="base64" name="site_auto_ads" cols="30" rows="2" placeholder="..."><?= base64_decode($site_auto_ads) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_in_feed') ?></h4></label>
				<textarea class="base64" name="site_in_feed_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_in_feed_ad) ?></textarea>
			</div>
	        <div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_link') ?></h4></label>
				<textarea class="base64" name="site_link_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_link_ad) ?></textarea>
			</div>
		</div>
		<!-- SECOND COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4>728x90 <?= lang('ui_ad_unit') ?></h4></label>
				<textarea class="base64" name="site_728x90_unit_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_728x90_unit_ad) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4>468x60 <?= lang('ui_ad_unit') ?></h4></label>
				<textarea class="base64" name="site_468x60_unit_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_468x60_unit_ad) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>250x250 <?= lang('ui_ad_unit') ?></h4></label>
				<textarea class="base64" name="site_250x250_unit_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_250x250_unit_ad) ?></textarea>
			</div>
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4>320x100 <?= lang('ui_ad_unit') ?></h4></label>
				<textarea class="base64" name="site_320x100_unit_ad" cols="30" rows="2" placeholder="..."><?= base64_decode($site_320x100_unit_ad) ?></textarea>
			</div>
		</div>
	</div>
	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_save') ?></button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button"><?= lang('ui_cancel') ?></a>
	</div>
</form>

<?php elseif($tab === 'email'): ?>

<form action="<?= base_url('control/settings/update/email') ?>" method="post" class="ui form controlled" data-method="update" data-controller="settings">
	<div class="ui two column stackable grid attached">
		<!-- FIRST COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4>Email</h4></label>
				<input type="email" name="site_smtp_user" value="<?= $site_smtp_user ?>" placeholder="...">
			</div>
			
			<div class="ui hidden divider"></div>
			<div class="field">
				<label><h4><?= lang('ui_password') ?></h4></label>
				<input type="text" name="site_smtp_pass" value="<?= $site_smtp_pass ?>" placeholder="...">
			</div>
		</div>
		<!-- SECOND COLUMN -->
		<div class="column">
			<div class="field">
				<label><h4><?= lang('ui_host') ?></h4></label>
				<input type="text" name="site_smtp_host" value="<?= $site_smtp_host ?>" placeholder="...">
			</div>
			<div class="ui hidden divider"></div>
			
			<div class="field">
				<label><h4><?= lang('ui_port') ?></h4></label>
				<input type="text" name="site_smtp_port" value="<?= $site_smtp_port ?>" placeholder="...">
			</div>
		</div>
	</div>
	
	<div class="field mt-3">
		<label><h4><?= lang('ui_encryption') ?></h4></label>
		<input type="text" name="site_smtp_crypto" value="<?= $site_smtp_crypto ?>" placeholder="ssl or tls">
	</div>
	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button">Save</button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button">Cancel</a>
	</div>
</form>

<?php elseif($tab === 'points_and_withdrawals'): ?>

<form action="<?= base_url('control/settings/update/points_and_withdrawals') ?>" method="post" class="ui form" style="min-height: 500px;">
	<div class="field">
		<label>Poin Per Posting</label>
		<input type="number" step="0.01" name="points_per_post" value="<?= session_get('old.points_per_post', $points_per_post ?? 0) ?>">
	</div>

	<div class="field">
		<label>Nilai Tukar (IDR / Poin)</label>
		<input type="number" step="0.001" name="exchange_rate" value="<?= session_get('old.exchange_rate', $exchange_rate ?? 0) ?>">
	</div>

	<div class="field">
		<label>Jumlah minimum penarikan (IDR)</label>
		<input type="number" step="0.001" name="minimum_withdrawal" value="<?= session_get('old.minimum_withdrawal', $minimum_withdrawal ?? 0) ?>">
	</div>

	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button">Simpan</button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button">Batalkan</a>
	</div>
</form>

<?php else: $roles = ['administrator', 'moderator', 'author']; ?>

<form action="<?= base_url('control/settings/update/permissions') ?>" method="post" class="ui permissions form">
	
	<div class="ui vertical fluid right tabular menu">
		<a class="item active" data-tab="administrator"><?= lang('ui_administrators') ?></a>
		<a class="item" data-tab="moderator"><?= lang('ui_moderators') ?></a>
		<a class="item" data-tab="author"><?= lang('ui_authors') ?></a>
	</div>
	
	<div class="ui divider"></div>
	<?php foreach($roles as $user_role): ?>
		<?php $this->load->view('control/includes/_permissions', 
								compact('user_role')) ?>
	<?php endforeach ?>
	
	<input type="hidden" name="site_permissions" id="site_permissions">
	<div class="ui blue right aligned segment">
		<button type="submit" class="ui yellow button"><?= lang('ui_save') ?></button>
		<a href="<?= base_url('control/dashboard') ?>" class="ui white button"><?= lang('ui_cancel') ?></a>
	</div>
</form>
<script> window.permissions = '<?= $site_permissions ?>'; </script>
<script src="<?= base_url('assets/control/js/settings_permissions.js?v='.time()) ?>"></script>

<?php endif ?>

<div id="user-message" class="ui tiny modal">
	<i class="close icon"></i>
	<div class="content"></div>
</div>

<script>
	$(function() {
		$('form').on('submit', function() {
			$('.base64').each(function() {
				$(this).val(b64EncodeUnicode($(this).val()));
			})
		})
	})
</script>