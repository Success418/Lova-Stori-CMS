<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('templates/opoin/partials/_head'); ?>
		<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
		<script type="text/javascript" src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>

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

						<div class="page contributor-form">
							                            
							<div class="content">
							
								<form action="<?= base_url('kontributor-submit') ?>" method="post" enctype="multipart/form-data" class="ui form error success">
									<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

									<div class="ui fluid card mt-0">
										<div class="content header"><center><img width="268" height="36" src="/imgsite/kontributor.webp" alt="Kontributor"></center>
											<center><font color="red"><h2>+ SEBAGAI <?= lang('ui_become_contributor') ?> +</h2></font></center><br>
											
<center>Mulai <b>20/02/20</b>, kami membuat limitasi kontribusi terhadap akses publikasi konten Stori. Untuk menciptakan ekosistem konten yang positif dan dapat dipertanggung jawabkan dengan baik oleh seluruh kontribusi Stori.</center><center>Silahkan lengkapi data dibawah ini sesuai peraturan kami:<br> Anda dapat mempublikasikan konten baru jika Anda menyelesaikan pendaftaran dengan benar.</center><br>										
											
										</div>
										<div class="content">

											<?= get_form_response('form_response') ?>

											<?php if(! is_logged_in()): ?>
											<div class="two fields">
												<div class="field">
													<label>Username</label>
													<input type="text" name="user_name" placeholder="..." >
												</div>
												<div class="field">
													<label>Password</label>
													<input type="password" name="user_pwd" placeholder="..." >
												</div>
											</div>
											<?php endif ?>
											<div class="two fields">
												<div class="field">
													<label>Nama Depan</label>
													<input type="text" name="user_firstname" placeholder="..." >
												</div>
												<div class="field">
													<label>Nama Belakang</label>
													<input type="text" name="user_lastname" placeholder="..." >
												</div>
											</div>
											<div class="two fields">
												<?php if(! is_logged_in()): ?>
												<div class="field">
													<label>Email</label>
													<input type="email" name="user_email" placeholder="..." >
												</div>
												<?php endif ?>
												<div class="field">
													<label>No. Telp</label>
													<input type="text" name="user_phone_number" placeholder="...">
												</div>
											</div>
											<div class="two fields">
												<div class="field">
													<label>No. Rekening</label>
													<input type="text" name="user_bank_account_number" placeholder="..." >
												</div>
												<div class="field">
													<label>Nama Bank</label>
													<input type="text" name="user_bank_name" placeholder="...">
												</div>
											</div>
											<?php if(! ($_SESSION['user_image'] ?? null)): ?>
											<div class="field">
												<label>Foto Anda</label>
												<button type="button" class="ui pink fluid button" onclick="this.nextElementSibling.click()">Upload</button>
												<input type="file" style="display: none" accept=".jpg,.jpeg,.png" name="user_avatar" placeholder="..." >
											</div>
											<?php endif ?>
											<div class="two fields">
												<div class="field">
													<label>KTP Tampak Depan</label>
													<button type="button" class="ui yellow fluid button" onclick="this.nextElementSibling.click()">Upload</button>
													<input type="file" style="display: none" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" name="user_card_id_1" placeholder="..." >
												</div>
												<div class="field">
													<label>KTP Tampak Belakang</label>
													<button type="button" class="ui yellow fluid button" onclick="this.nextElementSibling.click()">Upload</button>
													<input type="file" style="display: none" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" name="user_card_id_2" placeholder="..." >
												</div>
											</div>
											<div class="field">
												<label>Deskripsi Anda</label>
												<textarea name="user_description" cols="30" rows="5" placeholder="..."></textarea>
											</div>
											<div class="field">
												<label>Kode Verifkasi</label>
												<div class="ui right labeled input fluid">
													<input type="text" maxlength="6" name="verification_code" placeholder="Masukkan kode verifikasi">
													<div class="ui green label code"><?= get_verification_code() ?></div>
												</div>
											</div><center>Dengan mengklik daftar, kamu setuju</center> <center>dengan <b><a href="/page/privasi" target="_blank">Kebijakan</a></b> dan <b><a href="/page/ketentuan" target="_blank">Ketentuan</a></b> kami.</center>
										</div>
										<div class="content">
											<button type="submit" class="ui button purple">Daftar</button>
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
	</body>
	
	

<script type='text/javascript'>
//<![CDATA[
$(document).ready(function(){$.wmBox()}),function(o){o.wmBox=function(){o("body").prepend('<div class="wmBox_overlay"><div class="wmBox_centerWrap"><div class="wmBox_centerer">')},o("[data-popup]").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeIn(750);var a=o(this).attr("data-popup");o(".wmBox_overlay .wmBox_centerer").html('<div class="wmBox_contentWrap"><div class="wmBox_scaleWrap"><div class="wmBox_closeBtn"><p>x</p></div><iframe src="'+a+'">'),o(".wmBox_overlay iframe").click(function(o){o.stopPropagation()}),o(".wmBox_overlay").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeOut(750)})})}(jQuery);
//]]>
</script>	
	
	

</html>