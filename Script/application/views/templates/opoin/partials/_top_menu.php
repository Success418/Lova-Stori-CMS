<div class="ui secondary menu my-0">
	<span class="header item pl-0 pr-2" id="mobile-menu-toggler">
		<i class="bars large icon m-0"></i>
	</span>
	
	<a href="/" class="logo"><img src="<?= base_url("assets/images/logo.webp?v=") ?>" alt="Logo"></a>
	
	<form method="post" action="<?= base_url("posts/search") ?>" spellcheck="false" class="item search ui inverted form">
		<input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

		<div class="ui icon input">
			<input type="text" name="search" placeholder="Cari aja disini..."> 
			<i class="search link icon"></i>
		</div>
	</form>
	


	
	
		<?php if(!is_logged_in() || is_member()): ?>
	    <div class="right menu">
    	<form>
		<div class="ui right dropdown item lang">
		<i class="podcast icon"></i>    
		<b><?= lang('ui_halaman') ?></b>
		<input type="hidden" name="lang">
		<div class="menu">	    
	    


		<a href="<?= base_url('') ?>" class="item"><i class="home icon"></i><?= lang('ui_beranda') ?></a>	    
		<a href="<?= base_url('page/tentang') ?>" class="item"><i class="info icon"></i><?= lang('ui_about') ?></a>
		<a href="<?= base_url('page/privasi') ?>" class="item"><i class="info icon"></i><?= lang('ui_privacy') ?></a>
		<a href="<?= base_url('page/ketentuan') ?>" class="item"><i class="info icon"></i><?= lang('ui_terms_of_use') ?></a>		
		<a href="<?= base_url('page/bantuan') ?>" class="item"><i class="info icon"></i><?= lang('ui_bantuan') ?></a>
		<a href="<?= base_url('page/disclaimer') ?>" class="item"><i class="info icon"></i><?= lang('ui_disclaimer') ?></a>
		<a href="<?= base_url('page/panduan') ?>" class="item"><i class="info icon"></i><?= lang('ui_panduan') ?></a>
		<a href="<?= base_url('page/pedoman-media-siber') ?>" class="item"><i class="info icon"></i><?= lang('ui_mediacyber') ?></a>		
		<a href="javascript:void(0)" class="item contact-form-toggler"><i class="envelope icon"></i><?= lang('ui_contact') ?></a>
		<a class="ui item sign-in-form-toggler mr-0 ml-auto"><?= lang('ui_masuk_in') ?><i class="unlock icon"></i><?= lang('ui_sign_in') ?></a>
		<a class="ui item sign-up-form-toggler ml-0 mr-0"><?= lang('ui_sign_up') ?><i class="lock icon"></i><?= lang('ui_join_medialova') ?></a>		
		</form>
		</div></div></div>
	<?php endif ?>	
	

	
	
	
	<?php if(!is_logged_in() || is_member()): ?>
	<a class="ui advertise item <?php if(!is_logged_in()): ?>sign-in-form-toggler<?php endif ?> mx-0"
		 <?= is_logged_in() ? 'href="'.base_url("/advertiser").'"' : '' ?>>
		<?= lang('ui_pasangiklan') ?>
	</a>
	<?php endif ?>
	
	
	
		<?php if(!is_logged_in() || is_member()): ?>
	<a class="ui advertise item <?php if(!is_logged_in()): ?>sign-in-form-toggler<?php endif ?> mx-0"
		 <?= is_logged_in() ? 'href="'.base_url("/advertiser").'"' : '' ?>>
		<i class="wifi icon"></i>
		
	</a>
	<?php endif ?>
	

	<div class="right menu">
		
		
		<?php if(!is_logged_in() || is_member()): ?>
		<a href="<?= base_url('kontributor') ?>" class="ui item mr-0 ml-auto"><i class="user circle icon"></i></a>
		<?php endif ?>

		<?php if(!is_logged_in()): ?>

		<a class="ui item sign-in-form-toggler mr-0 ml-auto"><?= lang('ui_masuk_in') ?><i class="unlock icon"></i></a>

		<a class="ui item sign-up-form-toggler ml-0 mr-0"><?= lang('ui_sign_up') ?><i class="lock icon"></i></a>

        <a class="wmBox btnnya yt" href="#" data-popup="https://www.youtube.com/embed/pIf_vBE9tbM?rel=0&amp;controls=0&amp;showinfo=0"> <b class="ui item signal-form-toggler ml-0 mr-0"><i class="signal icon"></i></b></a> 

		<?php else: ?>
		

		<div class="user ui right top pointing dropdown outline item ml-2 mr-0 pr-0">
			<span class="user-name"><?= strtoupper($_SESSION['user_name']) ?></span>
			<?php if($_SESSION['user_image']): ?>
			<img width="35" height="35" src="<?= base_url("uploads/profiles/{$_SESSION['user_image']}") ?>" alt="avatar" class="ui avatar image ml-2">
			<?php else: ?>
			<span class="text avatar ml-2"><?= substr($_SESSION['user_name'], 0, 2) ?></span>
			<?php endif ?>
			<div class="menu mt-0">
				<?php if(has_admin_access()): ?>
				<a href="<?= base_url('control') ?>" class="item mx-0">Panel Saya</a>
				<?php endif ?>

				<?php if(!is_author()): ?>
				<a href="<?= base_url("user/{$_SESSION['user_name']}") ?>" class="item mx-0"><?= lang('ui_profile') ?></a>
				<?php else: ?>
				<div class="item credit mx-0"><?= lang('ui_credit') ?>: <p><?= $_SESSION['credit'] ?></p></div>
				<div class="ui divider my-0"></div>
				<a href="<?= base_url("author/dashboard") ?>" class="item mx-0"><?= lang('ui_dashboard') ?></a>
				<a href="<?= base_url("author/posts") ?>" class="item mx-0"><?= lang('ui_posts') ?></a>
				<a href="<?= base_url("author/posts/trash") ?>" class="item mx-0"><?= lang('ui_trash') ?></a>
				<a href="<?= base_url("author/posts/create") ?>" class="item mx-0"><?= lang('ui_add_post') ?></a>
				<a href="<?= base_url("author/comments") ?>" class="item mx-0"><?= lang('ui_comments') ?></a>
				<a href="<?= base_url("author/settings") ?>" class="item mx-0"><?= lang('ui_settings') ?></a>
				<a href="<?= base_url("author/withdrawal") ?>" class="item mx-0"><?= lang('ui_withdrawal') ?></a>
				<?php endif ?>
				<div class="ui divider my-0"></div>
				<a href="<?= current_url('logout') ?>" class="item mx-0 logout"><?= lang('ui_logout') ?></a>
			</div>
		</div>

		<?php endif ?>
	</div>
</div>