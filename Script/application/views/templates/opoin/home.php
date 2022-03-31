<!DOCTYPE html>
<!--POWEREDBY--><script>
/**
* Bian Dinnurjand
* Hati-hati jika Anda melihat view-source isi website kami, (hacker) artinya Anda berniat mencuri data kami.
* Segala tindakan apapun, kami telah mencatat IP Original Anda, untuk melakukan
* tindaklanjut sesuai hukum yang berlaku dan siap dipertanggung jawabkan.  
* 
* @package BianDeveloper
* @author www.stori.id
* @copyright 2020
* @terms skrip Stori mengunakan lisensi prabayar
* semua isi skrip Stori adalah hak milik Bian Dinnurjand dan Tidak diperjual belikan.
*/
</script><!--POWEREDBY-->    

<!--CONTENTCOPYRIGHT--><script>

 .d8888b.  888                       888    
d88P  Y88b 888                       888    Ini adalah fitur browser yang ditujukan 
Y88b.      888                       888    untuk pengembang. Jika seseorang meminta 
 "Y888b.   888888  .d88b.  88888b.   888    Anda untuk menyalin-menempel sesuatu 
    "Y88b. 888    d88""88b 888 "88b  888    di sini untuk mengaktifkan fitur Stori
      "888 888    888  888 888  888  Y8P    atau "meretas" akun seseorang, ini adalah 
Y88b  d88P Y88b.  Y88..88P 888 d88P         penipuan dan akan memberikannya akses 
 "Y8888P"   "Y888  "Y88P"  88888P"   888    ke akun Stori Anda. By: Bian Dinnurjand
                           888              
                           888              
                           888              

Developers /page/privasi Bian Dinnurjand.      
</script><!--CONTENTCOPYRIGHT-->

<script type="text/javascript" src="https://stori.id/room/addons/boom_embed/files/js/jquery-1.11.2.min.js"></script>

<html lang="en">
    
	<head>

<!-- Event snippet for Website traffic conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-622831574/pai_CNC509cBENbP_qgC'});
</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php $this->load->view('templates/opoin/partials/_head'); ?>
	
	</head>

	<body class="pushable">
	    

		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('templates/opoin/partials/_mobile_menu'); ?>
		</div>

		<div class="Oke" id="page">
		<div class="ui main container pusher">
			<div class="ui celled grid main m-0 shadowless">
				<div class="one column row content p-0">
					<div class="column" id="main-section">
						<div id="categories-menu">
						<?php $this->load->view('templates/opoin/partials/_categories_menu'); ?>
						</div>

						<div id="top-menu">
							<?php $this->load->view('templates/opoin/partials/_top_menu'); ?>
						</div>
						

						<div id="top-carousel">
						<?php if($carousel_posts): ?>
						<?php foreach($carousel_posts as $carousel_post): ?>
							<div>
								<a href="<?= base_url("post/{$carousel_post->slug}") ?>"><?= ucfirst($carousel_post->title) ?></a>
								<img width="100%" height="237px;" alt="Cover" src="<?= base_url("uploads/images/{$carousel_post->image}") ?>">

								<div class="ui basic label vote">
									<div class="ui star rating" data-rating="<?= $carousel_post->rating ?>"></div>
								</div>
								<div class="ui basic label date">
									<?= $carousel_post->date ?>
								</div>
							</div>
						<?php endforeach ?>
						<?php endif ?>
						</div>
						
						
						
						
                        
						
						<?php if ($this->settings['site_important_note'] ?? null): ?>
						<div class="ui fluid segment" id="important-note">
						    
							<i class="close icon link mx-0" onclick="$(this).parent().fadeOut()"></i>
							<b><font style="font-family: Arial; font-size:15px; color:#ffffff;"> <marquee scrolldelay="175" onmouseout="this.start()" onmouseover="this.stop()">Hi... <font size="3" color="FBE200"> <span class="user-name"> <span style="color: rgb(255, 252, 0);"> <?= strtoupper($_SESSION['user_name']) ?></span></span></font>
							


     
<?php
date_default_timezone_set("Asia/Jakarta");

$b = time();
$hour = date("G",$b);

if ($hour>=0 && $hour<=11)
{
echo "SELAMAT PAGI & AWALI HARIMU DENGAN DOA!";
}
elseif ($hour >=12 && $hour<=14)
{
echo "SELAMAT SIANG & SELAMAT BERAKTIVITAS!";
}
elseif ($hour >=15 && $hour<=17)
{
echo "SELAMAT SORE & JANGAN LUPA UNTUK BAHAGIA!";
}
elseif ($hour >=17 && $hour<=18)
{
echo "SELAMAT PETANG KAMU YANG ADA DISANA!";
}
elseif ($hour >=19 && $hour<=23)
{
echo "SELAMAT MALAM KEKASIH GELAPKU!";
}

?>							
							
							
						<?= $this->settings['site_important_note'] ?> - <font size="3" color="FBE200"><?= lang('ui_hati-hati') ?></font> </marquee></font></b>
						</div>
						

						<a href="/iklan/s/2A0Pxs" 
							 class="my-3 d-block ad <?= ad_banner_class($banners['hb1']->link ?? null) ?>" target="Lihat" id="hb1">
							<span>Netflix</span>
							<img width="970px;" height="50%" alt="Iklan" src="/iklan/drakor1.webp" class="d-block mx-auto">
						</a>
						
						<?php endif ?>
						

						<!-- LATEST POSTS START -->
						<?php if($latest_posts ?? []): ?>
						<div class="home latest-posts mt-3">
							<div class="ui tabular menu mb-0">
								<span class="item active"> <font size="3" color="6406D0"> <?= lang('ui_latest_posts') ?></font></span>

								<span class="ml-auto"></span>
								<a class="item prev"><font size="3" color="D00661"><b><?= lang('ui_kiri') ?></b></font></a>
								<a class="item next"><font size="3" color="D00661"><b><?= lang('ui_kanan') ?></b></font></a>
								<span class="item active"><a href="/posts/subcategory/film"><font size="3" color="D00661"><?= lang('ui_drakorred') ?></b></font><font size="3" color="000000"><?= lang('ui_drakorblack') ?></b></font></a></span>								
							</div>

							<div class="ui basic tab active segment p-0">
								<div class="ui unstackable items slick wrapper">
									<?php foreach($latest_posts as $latest_post): ?>
										<div class="item">
											<div class="ui tiny image" width="700" height="400" alt="Berita" style="background: url(<?= base_url("uploads/images/{$latest_post->image}") ?>)"></div>

											<div class="content">
												<div class="header"><?= ucfirst($latest_post->title) ?></div>
												<div class="description"><?= substr($latest_post->summary, 0, 80).'...' ?></div>
											</div>

											<a class="link" href="<?= base_url("post/{$latest_post->slug}") ?>" title="<?= $latest_post->title ?>"></a>
										</div>
									<?php endforeach ?>
								</div>
							</div>
						</div>

						<div class="ui hidden divider"></div>
						<?php endif ?>
						<!-- LATEST POSTS END -->


						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="F54600"> <?= lang('ui_iklan_premium') ?></font></span>
						</div>					
						
						<a href="<?= ad_banner_link($banners['hb1']->link ?? null) ?>" 
							 class="my-3 d-block ad <?= ad_banner_class($banners['hb1']->link ?? null) ?>" target="Lihat" id="hb1">
							<span>hb1</span>
							<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb1']->image ?? null) ?>" class="d-block mx-auto">
						</a>
						

						<?php if($latest_comments): ?>
						<div id="home-latest-comments">
							<div class="ui tabular menu mb-0">
								<span class="item active"><?= lang('ui_latest_comments') ?></span>

								<span class="ml-auto"></span>
								<a class="item prev"><?= lang('ui_kiri') ?></a>
								<a class="item next"><?= lang('ui_kanan') ?></a>
							</div>
							
							
							<div class="ui basic tab active segment p-0">
								<div class="slick wrapper">
									<?php foreach($latest_comments as $latest_comment): ?>
										<a class="item" href="<?= base_url("post/{$latest_comment->post_slug}#{$latest_comment->anchor}") ?>">
											<div class="content">
												<div class="l-side">
													<?php if($latest_comment->author_image): ?>
													<img class="ui mini circular image" width="35px;" height="35px;" alt="Member" src="<?= base_url("uploads/profiles/{$latest_comment->author_image}") ?>">
													<?php else: ?>
													<span class="ui mini circular image text">
														<?= substr($latest_comment->author, 0, 2) ?>
													</span>
													<?php endif ?>
												</div>
												<div class="r-side">
													<div class="ui sub header author">
														<?= ucfirst($latest_comment->author) ?>
													</div>
													<span class="date">
														Update <?= get_time_ago_in_words($latest_comment->date) ?>
													</span>
												</div>
											</div>
											<div class="content mt-2">
												<div class="title" title="<?= $latest_comment->post_title ?>">
													<?= $latest_comment->post_title ?>
												</div>
												<div class="summary">
													<?= substr($latest_comment->body, 0, 50).(strlen($latest_comment->body) > 50 ? '...' : '') ?>
												</div>
											</div>
										</a>
									<?php endforeach ?>
								</div>
							</div>
						</div>
						

						<?php endif ?>

						<?= get_ad_units('rectangle') ?>

						<div class="ui hidden divider"></div>

						<section class="posts-cards" id="tabs-wrapper">
						<?php $wrappers = [] ?>

						<?php foreach($posts['categories']['names'] as $category_id => $category_title): ?>

							<?php $category_slug = url_title($category_title, '-', TRUE) ?>
							
							<div class="tabs-wrapper">

								<div class="ui tabular menu mb-0">
									<a class="item active" data-tab="<?= "c-{$category_slug}{$category_id}" ?>">
										<?= ucfirst($category_title) ?>
									</a>

									<span class="ml-auto"></span>
									<?php if($subcategories = @$posts['subcategories']['names'][$category_id]): ?>
									<?php foreach($subcategories as $subcategory_id => $subcategory_title): ?>
									<a class="item" data-tab="<?= "s-{$category_slug}{$subcategory_id}" ?>">
										<?= ucfirst($subcategory_title) ?>
									</a>
									<?php endforeach ?>
									<?php endif ?>
									<a href="<?= base_url("posts/category/{$category_slug}") ?>" class="item all active">
										<?= lang('ui_semua') ?>
									</a>
								</div>

								<div class="ui basic tab segment active p-0" data-tab="<?= "c-{$category_slug}{$category_id}" ?>">
									<div class="ui four doubling stackable cards">
										<?php foreach($posts['categories']['posts'][$category_id] as $post): ?>
										<div class="ui fluid card">
											<a href="<?= base_url("post/{$post->slug}") ?>" title="<?= ucfirst($post->title) ?>" class="image item-image">
												<img width="700" height="400" alt="Berita" src="<?= base_url("uploads/images/{$post->image}") ?>">
											</a>
											<div class="content p-0 item-title">
												<div class="header">
													<a href="<?= base_url("post/{$post->slug}") ?>" title="<?= ucfirst($post->title) ?>">
														<?= ucfirst($post->title) ?>
													</a>
												</div>
											</div>
											<div class="content p-0 pb-3 item-summary">
												<div class="description p-3">
													<?= ucfirst($post->title) ?>
													<br>
													<?= $post->summary ?>
												</div>
											</div>
										</div>
										<?php endforeach ?>
									</div>
								</div>
								
								<?php if($posts_by_subcategories = @$posts['subcategories']['posts'][$category_id]): ?>
								<?php foreach($posts_by_subcategories as $subcategory_id => $posts_by_subcategory): ?>
								<div class="ui basic tab segment p-0" data-tab="<?= "s-{$category_slug}{$subcategory_id}" ?>">
									<div class="ui four doubling stackable cards">
										<?php foreach($posts_by_subcategory as $_post): ?>
										<div class="ui fluid card">
											<a href="<?= base_url("post/{$_post->slug}") ?>" title="<?= ucfirst($_post->title) ?>" class="image item-image">
												<img width="700" height="400" alt="Berita" src="<?= base_url("uploads/images/{$_post->image}") ?>">
											</a>
											<div class="content p-0 item-title">
												<div class="header">
													<a href="<?= base_url("post/{$_post->slug}") ?>" title="<?= ucfirst($_post->title) ?>">
														<?= ucfirst($_post->title) ?>
													</a>
												</div>
											</div>
											<div class="content p-0 pb-3 item-summary">
												<div class="description p-3">
													<?= $_post->summary ?>
												</div>
											</div>
										</div>
										<?php endforeach ?>
									</div>
								</div>
								<?php endforeach ?>
								<?php endif ?>
								

							<div class="ui hidden divider"></div>
							
							</div>
							

							<!-- ADVERTISER ADS START -->

							<?php if($category_id === 4): ?>

						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="121212"> <?= lang('ui_iklan_premium') ?></font></span></div>

							<a href="<?= ad_banner_link($banners['hb2']->link ?? null) ?>" 
								 class="my-3 d-block ad <?= ad_banner_class($banners['hb2']->link ?? null) ?>" target="Lihat" id="hb2">
								<span>hb2</span>
								<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb2']->image ?? null) ?>" class="d-block mx-auto">
							</a>

							<?php elseif($category_id === 6): ?>
							

						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="121212"> <?= lang('ui_iklan_premium') ?></font></span></div>
							
							<a href="<?= ad_banner_link($banners['hb3']->link ?? null) ?>" 
								 class="my-3 d-block ad <?= ad_banner_class($banners['hb3']->link ?? null) ?>" target="Lihat" id="hb3">
								<span>hb3</span>
								<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb3']->image ?? null) ?>" class="d-block mx-auto">
							</a>

							<?php elseif($category_id === 9): ?>
							
						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="121212"> <?= lang('ui_iklan_premium') ?></font></span></div>							
							
							<a href="<?= ad_banner_link($banners['hb4']->link ?? null) ?>" 
								 class="my-3 d-block ad <?= ad_banner_class($banners['hb4']->link ?? null) ?>" target="Lihat" id="hb4">
								<span>hb4</span>
								<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb4']->image ?? null) ?>" class="d-block mx-auto">
							</a>

							<?php elseif($category_id === 13): ?>
							
						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="121212"> <?= lang('ui_iklan_premium') ?></font></span></div>							
							
							<a href="<?= ad_banner_link($banners['hb5']->link ?? null) ?>" 
								 class="my-3 d-block ad <?= ad_banner_class($banners['hb5']->link ?? null) ?>" target="Lihat" id="hb5">
								<span>hb5</span>
								<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb5']->image ?? null) ?>" class="d-block mx-auto">
							</a>

							<?php elseif($category_id === 16): ?>
							
						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="121212"> <?= lang('ui_iklan_premium') ?></font></span></div>							

							<a href="<?= ad_banner_link($banners['hb6']->link ?? null) ?>" 
								 class="my-3 d-block ad <?= ad_banner_class($banners['hb6']->link ?? null) ?>" target="Lihat" id="hb6">
								<span>hb6</span>
								<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb6']->image ?? null) ?>" class="d-block mx-auto">
							</a>

							<?php elseif($category_id === 19): ?>
							
						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="121212"> <?= lang('ui_iklan_premium') ?></font></span></div>							

							<a href="<?= ad_banner_link($banners['hb7']->link ?? null) ?>" 
								 class="my-3 d-block ad <?= ad_banner_class($banners['hb7']->link ?? null) ?>" target="Lihat" id="hb7">
								<span>hb7</span>
								<img width="970px;" height="50%" alt="Iklan" src="<?= ad_banner_img($banners['hb7']->image ?? null) ?>" class="d-block mx-auto">
							</a>

							<?php endif ?>

							<!-- ADVERTISER ADS END -->

							<?php if(array_search($category_id, array_keys($posts['categories']['names']))%2): ?>

							<!-- AUTHORS START -->
							<?php if(! in_array('authors', $wrappers)): $wrappers[] = 'authors' ?>
							<?php if($authors ?? []): ?>
							<div class="authors">
								<div class="ui tabular menu mb-0">
									<span class="item active"><?= lang('ui_author_penulis') ?></span>

									<span class="ml-auto"></span>
									<a class="item prev"><?= lang('ui_kiri') ?></a>
									<a class="item next"><?= lang('ui_kanan') ?></a>
								</div>

								<div class="ui basic tab active segment p-0">
									<div class="slick wrapper">
										<?php foreach(array_chunk($authors, 2) as $author_chunk): ?>
										<div class="ui list">
											<?php foreach($author_chunk as $author): ?>
											<a class="item" href="<?= base_url("posts/author/{$author->username}") ?>">
												<?php if($author->image): ?>
												<img class="ui mini circular image" width="35px;" height="35px;" alt="Member" src="<?= base_url("uploads/profiles/{$author->image}") ?>">
												<?php else: ?>
												<span class="ui mini circular image text">
													<?= substr($author->username, 0, 2) ?>
												</span>
												<?php endif ?>
												<div class="content">
													<div class="ui sub header author">
														<?= ucfirst($author->username) ?>
													</div>
													<span class="date">
														<?= $author->posts_count ?> story
													</span>
												</div>
											</a>
											<?php endforeach ?>
										</div>
										<?php endforeach ?>
									</div>
								</div>
							</div>
							
							
						<a href="/iklan/s/2A0Pxs" 
							 class="my-3 d-block ad <?= ad_banner_class($banners['hb1']->link ?? null) ?>" target="Lihat" id="hb1">
							<span>Netflix</span>
							<img width="970px;" height="50%" alt="Iklan" src="/iklan/drakor2.webp" class="d-block mx-auto">
						</a>
							
							
							<?= get_ad_units('rectangle') ?>
							<div class="ui hidden divider"></div>
							<?php endif ?>
							<!-- AUTHORS END -->

							
							<!-- POPULAR POSTS START -->
							<?php elseif(! in_array('popular-posts', $wrappers)): $wrappers[] = 'popular-posts' ?>
							<?php if($popular_posts ?? []): ?>
							<div class="popular-posts">
								<div class="ui tabular menu mb-0">
									<span class="item active"><?= lang('ui_popular_posts') ?></span>

									<span class="ml-auto"></span>
									<a class="item prev"><?= lang('ui_kiri') ?></a>
									<a class="item next"><?= lang('ui_kanan') ?></a>
								</div>

								<div class="ui basic tab active segment p-0">
									<div class="ui unstackable items slick wrapper">
										<?php foreach($popular_posts as $popular_post): ?>
											<div class="item">
												<div class="ui tiny image" width="700px;" height="400px;" alt="Berita" style="background: url(<?= base_url("uploads/images/{$popular_post->image}") ?>)"></div>

												<div class="content">
													<div class="header"><?= ucfirst($popular_post->title) ?></div>
													<div class="description"><?= substr($popular_post->summary, 0, 80).'...' ?></div>
												</div>

												<a class="link" href="<?= base_url("post/{$popular_post->slug}") ?>" title="<?= $popular_post->title ?>"></a>
											</div>
										<?php endforeach ?>
									</div>
								</div>
							</div>
							<?= get_ad_units('rectangle') ?>

							<div class="ui hidden divider"></div>
							<?php endif ?>
							<!-- POPULAR POSTS END -->
							
							<!-- RANDOM POSTS START -->
							<?php elseif(! in_array('random-posts', $wrappers)): $wrappers[] = 'random-posts' ?>
							<?php if($random_posts ?? []): ?>
							<div class="random-posts">
								<div class="ui tabular menu mb-0">
									<span class="item active"><?= lang('ui_random_posts') ?></span>

									<span class="ml-auto"></span>
									<a class="item prev"><?= lang('ui_kiri') ?></a>
									<a class="item next"><?= lang('ui_kanan') ?></a>
								</div>

								<div class="ui basic tab active segment p-0">
									<div class="ui unstackable items slick wrapper">
										<?php foreach($random_posts as $random_post): ?>
											<div class="item">
												<div class="ui tiny image" width="700px;" height="400px;" alt="Berita" style="background: url(<?= base_url("uploads/images/{$random_post->image}") ?>)"></div>

												<div class="content">
													<div class="header"><?= ucfirst($random_post->title) ?></div>
													<div class="description"><?= substr($random_post->summary, 0, 80).'...' ?></div>
												</div>

												<a class="link" href="<?= base_url("post/{$random_post->slug}") ?>" title="<?= $random_post->title ?>"></a>
											</div>
										<?php endforeach ?>
									</div>
								</div>
							</div>

							<?= get_ad_units('rectangle') ?>
							<?php endif ?>
							<?php endif ?>
							<!-- RANDOM POSTS END -->

							<?php endif ?>
						<?php endforeach ?>

							<div class="ui hidden divider"></div>

							<?php if($recommended_posts ?? []): ?>
							<div class="recommended-posts">
								<div class="ui tabular menu mb-0">
									<span class="item active"><?= lang('ui_recommended_posts') ?></span>

									<span class="ml-auto"></span>
									<a class="item prev"><?= lang('ui_kiri') ?></a>
									<a class="item next"><?= lang('ui_kanan') ?></a>
								</div>

								<div class="ui basic tab active segment p-0">
									<div class="ui unstackable items slick wrapper">
										<?php foreach($recommended_posts as $recommended_post): ?>
											<div class="item">
												<div class="ui tiny image" width="80px;" height="90px;" alt="Berita" style="background: url(<?= base_url("uploads/images/{$recommended_post->image}") ?>)"></div>

												<div class="content">
													<div class="header"><?= ucfirst($recommended_post->title) ?></div>
													<div class="description"><?= substr($recommended_post->summary, 0, 80).'...' ?></div>
												</div>

												<a class="link" href="<?= base_url("post/{$recommended_post->slug}") ?>" title="<?= $recommended_post->title ?>"></a>
											</div>
										<?php endforeach ?>
									</div>
								</div>
							</div>
							
							
						<a href="/iklan/s/2A0Pxs" 
							 class="my-3 d-block ad <?= ad_banner_class($banners['hb1']->link ?? null) ?>" target="Lihat" id="hb1">
							<span>Netflix</span>
							<img width="970px;" height="50%" alt="Iklan" src="/iklan/film-barat-1.webp" class="d-block mx-auto">
						</a>							
							
							
							<?= get_ad_units('rectangle') ?>
							<?php endif ?>
						</section>

						<div class="ui fluid hidden divider mt-5 mb-0"></div>

						
						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer'); ?>
						</div>
						
						
<div class="ui fluid segment inverted" id="cookies">
	<h5>
		<span style="color: red; font-family: Verdana,Arial,Helvetica,Georgia; font-size: 12px;"><?= lang('ui_terimacookie') ?></span>  
		<button class="ui tiny yellow button">OK</button>
	</h5>
</div>
						
						
					</div>
				</div>
			</div>
		</div>
		
		

<script type='text/javascript'>
//<![CDATA[
$(document).ready(function(){$.wmBox()}),function(o){o.wmBox=function(){o("body").prepend('<div class="wmBox_overlay"><div class="wmBox_centerWrap"><div class="wmBox_centerer">')},o("[data-popup]").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeIn(750);var a=o(this).attr("data-popup");o(".wmBox_overlay .wmBox_centerer").html('<div class="wmBox_contentWrap"><div class="wmBox_scaleWrap"><div class="wmBox_closeBtn"><p>x</p></div><iframe src="'+a+'">'),o(".wmBox_overlay iframe").click(function(o){o.stopPropagation()}),o(".wmBox_overlay").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeOut(750)})})}(jQuery);
//]]>
</script>		
		

	</body>
	<script>
		$(function() 
		{
			$('.posts-cards .item-title a')
			.popup({delay: {show: 300,hide: 0}});
            
			$('#top-carousel .star.rating').rating('disable');
            
			$('#tabs-wrapper .menu .item')
  			.tab({
  				context: '.tabs-wrapper',
  				childrenOnly: true
  			});
  			
  			$('#top-carousel').slick({
    			infinite: true,
    			slidesToShow: 3,
    			slidesToScroll: 1,
    			dots: false,
    			arrows: false,
    			responsive: [
    			{
    				breakpoint: 1025,
    				settings: {
    					slidesToShow: 3,
    					slidesToScroll: 3
    				}
    			},
    			{
    				breakpoint: 1024,
    				settings: {
    					slidesToShow: 3,
    					slidesToScroll: 3
    				}
    			},
    			{
    				breakpoint: 768,
    				settings: {
    					slidesToShow: 2,
    					slidesToScroll: 2
    				}
    			},
    			{
    				breakpoint: 480,
    				settings: {
    					slidesToShow: 1,
    					slidesToScroll: 1
    				}
    			}]
				});
			
			$('.slick.wrapper').slick({
				infinite: false,
			slidesToShow: 4,
			slidesToScroll: 4,
			dots: false,
			arrows: false,
			responsive: [
			{
				breakpoint: 1025,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}]
			})

			
			$('#home-latest-comments .tabular.menu a.next, \
				 #tabs-wrapper .authors .tabular.menu a.next, \
				 #tabs-wrapper .popular-posts .tabular.menu a.next, \
				 #tabs-wrapper .random-posts .tabular.menu a.next, \
				 #tabs-wrapper .recommended-posts .tabular.menu a.next, \
				 .latest-posts .tabular.menu a.next')
			.on('click', function()
			{
				$(this).closest('.menu').siblings('.segment').find('.wrapper').slick('slickNext')
			})

			$('#home-latest-comments .tabular.menu a.prev, \
				 #tabs-wrapper .authors .tabular.menu a.prev, \
				 #tabs-wrapper .popular-posts .tabular.menu a.prev, \
				 #tabs-wrapper .random-posts .tabular.menu a.prev, \
				 #tabs-wrapper .recommended-posts .tabular.menu a.prev, \
				 .latest-posts .tabular.menu a.prev')
			.on('click', function()
			{
				$(this).closest('.menu').siblings('.segment').find('.wrapper').slick('slickPrev')
			})

		})
	</script>
</html>

<div id="RibbonFall"><div id="wapclick" class="section"></div></div>



<div id="corner_boom" value="TUTUP" style="height:480px; width:320px; right:20px;">
	<div style="background:linear-gradient(to right,#771DFF,#FF004E); height:33px;" id="corner_boom_top"><p id="corner_boom_title" style="color:#FFF;">CHAT</p>
	<a href="https://stori.id/room"><img src="https://stori.id/room/addons/boom_embed/files/images/boom_embed_expand.png"/></a></div>
	<div style="background:#000 url('https://stori.id/room/addons/boom_embed/files/images/loading.gif')" id="corner_boom_content"><iframe name="https://stori.id/room/addons/boom_embed/system/boom_embed_blank.php" id="corner_boom_iframe" value="https://stori.id/room/index.php" src=""></iframe></div>
	<script type="text/javascript" src="https://stori.id/room/addons/boom_embed/files/js/boom_embed.js"></script>
</div>



<!--POWEREDBY--><script>
/**
* Bian Dinnurjand
* Hati-hati jika Anda melihat view-source isi website kami, (hacker) artinya Anda berniat mencuri data kami.
* Segala tindakan apapun, kami telah mencatat IP Original Anda, untuk melakukan
* tindaklanjut sesuai hukum yang berlaku dan siap dipertanggung jawabkan.  
* 
* @package BianDeveloper
* @author www.stori.id
* @copyright 2020
* @terms skrip Stori mengunakan lisensi prabayar
* semua isi skrip Stori adalah hak milik Bian Dinnurjand dan Tidak diperjual belikan.
*/
</script><!--POWEREDBY-->    

<!--CONTENTCOPYRIGHT--><script>

 .d8888b.  888                       888    
d88P  Y88b 888                       888    Ini adalah fitur browser yang ditujukan 
Y88b.      888                       888    untuk pengembang. Jika seseorang meminta 
 "Y888b.   888888  .d88b.  88888b.   888    Anda untuk menyalin-menempel sesuatu 
    "Y88b. 888    d88""88b 888 "88b  888    di sini untuk mengaktifkan fitur Stori
      "888 888    888  888 888  888  Y8P    atau "meretas" akun seseorang, ini adalah 
Y88b  d88P Y88b.  Y88..88P 888 d88P         penipuan dan akan memberikannya akses 
 "Y8888P"   "Y888  "Y88P"  88888P"   888    ke akun Stori Anda. By: Bian Dinnurjand
                           888              
                           888              
                           888              

Developers /page/privasi Bian Dinnurjand.      
</script><!--CONTENTCOPYRIGHT-->