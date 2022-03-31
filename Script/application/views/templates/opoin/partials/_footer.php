<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="ui three columns divided grid">
	<div class="column st">
		<h2 class="ui image header">
		<center><img src="<?= base_url("icon/{$this->settings['site_logo']}?v=".time()) ?>" alt="logo"></center>    
		<div class="content"><font size="1">
			<div class="sub header">
				<center><?= $this->settings['site_description'] ?></center>
				
				</br><center>DOWNLOAD GRATIS APLIKASI IPOPULER</center><center>-</center><center><a href="/iklan/s/QRbv80" target="_blank" rel="nofollow"><center><img src="/imgsite/playstore.webp" alt="Download" title="Download"></center></a></center>
				<center><img src="/imgsite/appstore.webp" alt="Download"></center>			
				<center><a href="/short/link/?id=68747470733a2f2f7777772e6d656469616c6f76612e636f6d2f6d656469616c6f76612e657865"><img src="/imgsite/windows.webp" alt="Download" title="Download"></a></center>
			</font>	
				
			</div>
		</div>
		</h2>
	</div>

	<div class="column nd" id="newsletter">
		<h4 class="ui header"><?= lang('ui_alerts') ?></h4>
		
		<?= get_form_response('subscription') ?>
		
		

		<form action="<?= base_url("subscriber/add") ?>" method="post" class="ui form">
			<div class="field">
				<label class="mb-3"><center><?= lang('ui_newsletter_txt') ?>.</center></label>
				<input type="email" name="email" placeholder="MAU GIVEAWAY? MASUKKAN EMAILMU..." required>
				<center><button type="submit" class="ui yellow button mt-2"><?= lang('ui_subscribe') ?></button></enter>
			</div>
		</form><br>
		

		<center><img width="300" height="50" alt="Berpedia" src="/imgsite/giveaway.webp" /></center>

        <center><img width="300" height="50" src="/imgsite/yukdirumahaja.webp" alt="Komunitas"></center>




<center><b><font size="1" color="cb0c4b"><?php
$ip      = $_SERVER['REMOTE_ADDR']; // Dapatkan IP user
$tanggal = date("Ymd"); // Dapatkan tanggal sekarang
$waktu   = time(); // Dapatkan nilai waktu

$konek = mysqli_connect("localhost","biandj_visitor","dinnurjand85!!!","biandj_visitor");

// Cek user yang mengakses berdasarkan IP-nya 
$s = mysqli_query($konek, "SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
// Kalau belum ada, simpan datanya sebagai user baru
if(mysqli_num_rows($s) == 0){
  mysqli_query($konek, "INSERT INTO statistik(ip, tanggal, hits, online) VALUES('$ip', '$tanggal', '1', '$waktu')");
}
// Kalau sudah ada, update data hits user  
else{
  mysqli_query($konek, "UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
}

$query1     = mysqli_query($konek, "SELECT * FROM statistik WHERE tanggal='$tanggal' GROUP BY ip");
$pengunjung = mysqli_num_rows($query1);

$query2        = mysqli_query($konek, "SELECT COUNT(hits) as total FROM statistik");
$hasil2        = mysqli_fetch_array($query2);
$totpengunjung = $hasil2['total'];
 
$query3 = mysqli_query($konek, "SELECT SUM(hits) as jumlah FROM statistik WHERE tanggal='$tanggal' GROUP BY tanggal");
$hasil3 = mysqli_fetch_array($query3);
$hits   = $hasil3['jumlah'];
 
$query4  = mysqli_query($konek, "SELECT SUM(hits) as total FROM statistik");
$hasil4  = mysqli_fetch_array($query4);
$tothits = $hasil4['total'];  

// Cek berapa pengunjung yang sedang online
$bataswaktu       = time() - 300; 
$pengunjungonline = mysqli_num_rows(mysqli_query($konek, "SELECT * FROM statistik WHERE online > '$bataswaktu'"));


// Angka total pengunjung dalam bentuk gambar
$folder = "counter"; // nama folder
$ext    = ".png";     // ekstension file gambar

// ubah digit angka menjadi enam digit
$totpengunjunggbr = sprintf("%06d", $totpengunjung);
// ganti angka teks dengan angka gambar
for ($i = 0; $i <= 9; $i++){
	$totpengunjunggbr = str_replace($i, "<img src=\"/statistik/counter/$i$ext\" alt=\"$i\">", $totpengunjunggbr);
} 

echo "
    
      PENGUNJUNG HARI INI: $pengunjung
      VISITOR: $totpengunjung <br />
      
      HIT:  $hits 
      TOTAL:  $tothits 
      
      ONLINE: $pengunjungonline";
?></font></b></center>

<center>
    
<?php
function getClientIP() {

    if (isset($_SERVER)) {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');

    return getenv('REMOTE_ADDR');
}
echo "<h2 align=\"center\"><font size='1'>IP TERCATAT:</font> <font size='1' color='cb0c4b'> ".getClientIP()."";
?></font>  <img width="16" height="14" src="/imgsite/live.webp">  
    
</center>



		
	</div>

	<div class="column rd">
		<h4 class="ui header"><?= lang('ui_links') ?></h4>
		<div class="ui middle aligned list">
			<?php foreach($pages as $page): ?>
			<?php if($page->in_footer): ?>
			<a href="<?= base_url("page/{$page->slug}") ?>" class="item py-2">
				<div class="content">
					<?= ucfirst($page->title) ?>
				</div>
			</a>
			<?php endif ?>
			<?php endforeach ?>
		<center><img width="300" height="50" src="/imgsite/pulsa.webp" alt="Pulsa"></center>
		<center><img width="300" height="45" src="/imgsite/pembayaran.webp" alt="Pembayaran"></center>
		<center><img width="500" height="37" src="/imgsite/bank.webp" alt="Bank"></center>		
		

</div>		
	</div>
</div>

<div class="ui text menu m-0">
	<a class="item ui basic icon button" href="https://instagram.com/medialovacom<?= $this->settings['site_instagram'] ?>" target="_blank">
		<i class="instagram icon"></i>
	</a>    
	<a class="item ui basic icon button" href="https://twitter.com/<?= $this->settings['site_twitter'] ?>" target="_blank">
		<i class="twitter icon"></i>
	</a>
	<a class="item ui basic icon button" href="https://linkedin.com/in/<?= $this->settings['site_linkedin'] ?>" target="_blank">
		<i class="linkedin icon"></i>
	</a>
	<a class="item ui basic icon button" href="https://pinterest.com/<?= $this->settings['site_pinterest'] ?>" target="_blank">
		<i class="pinterest icon"></i>
	</a>
	<a class="item ui basic icon button" href="https://youtube.com/<?= $this->settings['site_youtube'] ?>" target="_blank">
		<i class="youtube icon"></i>
	</a>
	<a class="item ui basic icon button" href="https://facebook.com/<?= $this->settings['site_facebook'] ?>" target="_blank">
		<i class="facebook icon"></i>
	</a>
	
	<div class="right menu">
		<form class="item p-0" action="<?= base_url("toggle_style/{$this->uri->uri_string()}") ?>" method="post" id="style-toggler">
			<div class="ui right dropdown item style">
				<b><?= lang('ui_style') ?></b>
				<i class="medapps icon"></i>
				<input type="hidden" name="style">
				<div class="menu">
					<div class="item" data-value="light"><?= lang('ui_modeweb1') ?></div>
					<div class="item" data-value="dark"><?= lang('ui_modeweb2') ?></div>
				</div>
			</div>
		</form>
		<form class="item p-0" action="<?= base_url("change_lang/{$this->uri->uri_string()}") ?>" method="post" id="change-lang">
			<div class="ui right dropdown item lang">
				<b><?= lang('ui_bahasa') ?></b>
				<i class="plus icon"></i>
				<input type="hidden" name="lang">
				<div class="menu">
					<div class="item" data-value="indonesia">Indonesia <i class="id flag"></i></div>
					<div class="item" data-value="english">Inggris <i class="uk flag"></i></div>
				</div>
			</div>
		</form>
	</div>	
</div>




<div class="ui text menu m-0"><b> <b class="upper"> <a href="/"><?= $this->settings['site_name'] ?? '{site_name}' ?></b></a></b>
	    <div class="right menu">
    	<form>
		<div class="ui right dropdown item lang">
		<b><?= lang('ui_halaman') ?></b>
		<i class="list icon"></i>
		<input type="hidden" name="lang">
		<div class="menu">	    
	    
	    
		<a href="<?= base_url('page/tentang') ?>" class="item"><?= lang('ui_about') ?></a>
		<a href="<?= base_url('page/privasi') ?>" class="item"><?= lang('ui_privacy') ?></a>
		<a href="<?= base_url('page/ketentuan') ?>" class="item"><?= lang('ui_terms_of_use') ?></a>		
		<a href="<?= base_url('page/bantuan') ?>" class="item"><?= lang('ui_bantuan') ?></a>
		<a href="<?= base_url('page/disclaimer') ?>" class="item"><?= lang('ui_disclaimer') ?></a>
		<a href="<?= base_url('page/panduan') ?>" class="item"><?= lang('ui_panduan') ?></a>
		<a href="<?= base_url('page/panduan-iklan') ?>" class="item"><?= lang('ui_panduaniklan') ?></a>		
		<a href="<?= base_url('page/pedoman-media-siber') ?>" class="item"><?= lang('ui_mediacyber') ?></a>		
		<a href="javascript:void(0)" class="item contact-form-toggler"><?= lang('ui_contact') ?></a>
		</form>
		</div></div></div></div>



<div class="ui stackable text menu m-0"><center><span class="p-2"><i class="heart outline icon"></i><b>MILIK &#169; HAK CIPTA <?= date('Y') ?> &#45; <a href="/short/link/?id=68747470733a2f2f66616365626f6f6b2e636f6d" target="_blank">B14N.COM</a></b> <i class="heart outline icon"></i></span></center>

<div class="right menu">
		<center><b>V2.1.8 &#45; PHP7 &#43; SUPPORT <a href="/short/link/?id=68747470733a2f2f70616e656c2e6e69616761686f737465722e636f2e69642f7265662f313334303237" target="_blank">NIAGAHOSTER</b></a></center>
	</div></div>


<?php if(!is_logged_in()): ?>

<div class="ui modal p-0 <?= $sign_in_sess = sessions_exist(['form_response', 'sign_in']) ? 'visible' : '' ?>" id="sign-in-form">
	<div class="header">
		<h4><?= lang('ui_sign_in') ?> <i class="close icon"></i></h4><center><img width="268" height="50%" src="/imgsite/masuk.webp" alt="Masuk"></center>
	</div>

	<div class="content">
		<?= $sign_in_sess ? get_form_response('form_response') : '' ?>

		<form action="<?= current_url('sign_in') ?>" method="post" spellcheck="false">
			<div class="ui big form">
				<div class="field">
					<label><h3><?= lang('ui_username_or_email') ?></h3></label>
					<div class="ui left icon input">
						<i class="user icon"></i>
						<input type="text" name="user" placeholder="Username Anda" required>
					</div>
				</div>
				<div class="field">
					<label><h3><?= lang('ui_password') ?></h3></label>
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="pwd" placeholder="Password Anda" required>
					</div>
				</div>
				<div class="field">
					<button type="submit" class="ui violet big button fluid"><?= lang('ui_sign_in') ?></button>
					<p><?= lang('ui_or') ?> <a href="javascript:void(0)" class="reset-pwd-form"><?= lang('ui_forgot_password') ?></a></p>
				</div>
				<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
			</div>
		</form>
	</div>

	<div class="actions p-4" style="text-align: center">
		<?= lang('ui_dont_have_account') ?> ? <a class="sign-up-form-toggler" href="javascript:void(0)"><?= lang('ui_join_medialova') ?></a>
	</div>
</div>


<div class="ui modal p-0 <?= $reset_pwd_sess = sessions_exist(['form_response', 'reset_pwd']) ? 'visible' : '' ?>" id="reset-pwd-form">
	<div class="header">
		<h4><?= lang('ui_reset_password') ?> <i class="close icon"></i></h4><center><img width="268" height="43" src="/imgsite/password.webp" alt="Password"></center>
	</div>

	<div class="content">
		<?= $reset_pwd_sess ? get_form_response('form_response') : '' ?>

		<form action="<?= current_url('prepare_reset_password') ?>" method="post" spellcheck="false">
			<div class="ui big form">
				<div class="field">
					<label><h3>Email</h3></label>
					<div class="ui left icon input">
						<i class="envelope icon"></i>
						<input type="email" name="user_email" required placeholder="Email Anda">
					</div>
				</div>
				<div class="field">
					<button type="submit" class="ui violet big button fluid"><?= lang('ui_reset_password') ?></button>
				</div>
				<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
			</div>
		</form>
	</div>

	<div class="actions p-4" style="text-align: center">
		atau <a class="sign-in-form-toggler" href="javascript:void(0)"><?= lang('ui_sign_in') ?></a>
	</div>
</div>


<div class="ui modal p-0 <?= $sign_up_sess = sessions_exist(['form_response', 'sign_up']) ? 'visible' : '' ?>" id="sign-up-form">
	<div class="header">
		<h4><?= lang('ui_create_new_account') ?> <i class="close icon"></i></h4><center><img width="268" height="54" src="/imgsite/daftar.webp" alt="Daftar"></center>
	</div>

	<div class="content">
		<?= $sign_up_sess ? get_form_response('form_response') : '' ?>

		<form action="<?= current_url('sign_up') ?>" method="post" spellcheck="false">
			<div class="ui big form">
				<div class="field">
					<label><h3><?= lang('ui_username') ?></h3></label>
					<div class="ui left icon input">
						<i class="user icon"></i>
						<input type="text" name="user_name" placeholder="Username Anda" required>
					</div>
				</div>
				<div class="field">
					<label><h3>Email</h3></label>
					<div class="ui left icon input">
						<i class="envelope icon"></i>
						<input type="email" name="user_email" placeholder="Email Anda" required>
					</div>
				</div>
				<div class="field">
					<label><h3><?= lang('ui_password') ?></h3></label>
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="user_pwd" placeholder="Password Anda" required>
					</div>
				</div> 
				<div class="field">
					<label><h3><?= lang('ui_verify_password') ?></h3></label>
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="user_pwd_verify" placeholder="Ulangi Password Anda" required>
					</div>
				</div>
				<div class="field">
					<button type="submit" class="ui violet big button fluid"><?= lang('ui_join_medialova') ?></button>
				</div>
				<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
			</div><center>Dengan mengklik daftar, kamu setuju dengan <a href="/page/privasi" target="_blank">Kebijakan</a> & <a href="/page/ketentuan" target="_blank">Ketentuan</a> kami.</center>
		</form>
	</div>

	<div class="actions p-4" style="text-align: center">
		<?= lang('ui_already_have_account') ?> ? <a class="sign-in-form-toggler" href="javascript:void(0)"><?= lang('ui_sign_in') ?></a>
	</div>
</div>

<?php endif ?>

<div class="ui modal p-0 <?= sessions_exist(['form_response', 'contact']) ? 'visible' : '' ?>" id="contact-form">
	<div class="header">
		<h4><?= lang('ui_contact_us') ?>! <i class="close icon"></i></h4>
	</div>

	<div class="content">
		<?= get_form_response('form_response') ?>

		<form action="<?= current_url('contact') ?>" method="post" spellcheck="false">
			<div class="ui big form">
				<div class="field">
					<label><h3><?= lang('ui_name') ?></h3></label>
					<div class="ui left icon input">
						<i class="user plus icon"></i>
						<input type="text" name="contact-name" placeholder="Nama Lengkap Anda">
					</div>
				</div>
				<div class="field">
					<label><h3>Email</h3></label>
					<div class="ui left icon input">
						<i class="envelope icon"></i>
						<input type="text" name="contact-email" placeholder="Email Anda">
					</div>
				</div>
				<div class="field">
					<label><h3><?= lang('ui_subject') ?></h3></label>
					<div class="ui left icon input">
						<i class="edit outline icon"></i>
						<input type="text" name="contact-subject" placeholder="Subjek Anda">
					</div>
				</div>
				<div class="field">
					<textarea name="contact-body" cols="30" rows="5" placeholder="Apa Keluhan Anda...."></textarea>
				</div>
				<div class="field mb-0">
					<button type="submit" name="contact" class="ui purple big button fluid"><?= lang('ui_submit') ?></button>
				</div>
				<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
			</div>
		</form>
	</div>
</div>

<?php if($this->settings['site_regular_scroll'] ?? null): ?>
<style>
	html.regular {
		overflow-y: auto;
	}
	html.regular body {
		overflow-y: auto;
	}
	html.regular #l-side {
		height: 100vh;
		position: fixed;
	}
	html.regular #r-side {
		max-height: 100%;
		margin-left: 250px;
	}
	html.regular #r-side-last {
		max-height: 100%;
	}
	@media (max-width: 1100px) {
		#r-side {
			margin-left: 0 !important;
		}
	}
</style>

<script type="application/javascript">
	$(function()
	{
		$('html').addClass('regular');
	})
</script>
<?php endif ?>




<!--NEWSLETTER MODAL START-->
<div class="ui modal" id="newsletter-subscribe">
  <div class="header">
    <?= lang('ui_berlangganan') ?>
    <i class="right floated link close icon"></i>
    <center><h4>
    <?= lang('ui_berlangganan_giveaway') ?>
    </h4></center>
  </div>
  <div class="content">
    <div class="ui left icon big input fluid">
      <input type="email" placeholder="Masukkan eMail...">
      <i class="envelope outline icon"></i>
    </div>
    
    <div class="ui fluid message"></div>
        
    <button class="ui fluid big button"><?= lang('ui_maudong') ?></button>
  </div>
</div>

<style>
  #newsletter-subscribe {
    background: -webkit-linear-gradient(345deg, #ce0a46, #6026E9) !important;
    background: -moz-linear-gradient(345deg, #ce0a46, #6026E9) !important;
    background: -o-linear-gradient(345deg, #ce0a46, #6026E9) !important;
    background: linear-gradient(75deg, #ce0a46, #6026E9) !important;
    min-width: 600px;
  }
  
  #newsletter-subscribe .message.success {
    display: block;
    background: #771dff;
  }

  #newsletter-subscribe .message.error {
    display: block;
    background: #8e2222;
  }

  #newsletter-subscribe .message {
    display: none;
    color: #fff;
    font-size: 1.2rem;
    padding: .75rem 1rem;
  }

  #newsletter-subscribe .header {
    color: #fff !important;  
  }

  #newsletter-subscribe .header, #newsletter-subscribe .content {
    background: transparent !important;
  }

  #newsletter-subscribe .header h4 {
    margin-top: .5rem;
    color: #fff !important;
  }

  #newsletter-subscribe .button {
    margin-top: 1rem;
    background: #3a2e28;
    color: #fff;
    font-weight: normal;
  }

  #newsletter-subscribe .button:hover {
    font-weight: bold;
  }

  #newsletter-subscribe input {
    border: none;
  }
  
  @media (max-width: 600px) {
    #newsletter-subscribe {
      width: 100% !important;
      min-width: 90% !important;
      margin: auto ;
    }
  }
</style>

<script>
  if(localStorage.getItem('subscribedToNewsletter') === null)
  {
    setTimeout(function()
    {
      $('#newsletter-subscribe').modal('show')
    }, 160000);
  }

  $('#newsletter-subscribe .button').on('click', function()
  {
    var emailAddress = $('#newsletter-subscribe input').val().trim();

    if(/^.+@.+\.[a-z]{2,}$/i.test(emailAddress))
    {
      $.post('/subscriber/add_async', {"email": emailAddress}, null, 'json')
      .done(function(res)
      {
        if(res.status)
        {
          localStorage.setItem('subscribedToNewsletter', true);

          $('#newsletter-subscribe .message').text('Terima Kasih!').removeClass('error').addClass('success');
        }
        else
        {
          $('#newsletter-subscribe .message').text('Ups, Email Salah!').removeClass('success').addClass('error');
        }
      })
    }
    else
    {
        $('#newsletter-subscribe .message').text('Ups, Email Salah!').removeClass('success').addClass('error');
    }
  })
  
  $('#newsletter-subscribe .close.icon').on('click', function()
  {
      $('#newsletter-subscribe').modal('hide');
  })
</script>
<!--NEWSLETTER MODAL END -->