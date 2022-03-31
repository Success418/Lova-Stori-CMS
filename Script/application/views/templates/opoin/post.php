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


<html lang="en">
    
	<head><meta charset="windows-1252">

<script type="text/javascript">
    function copy_text() {
        document.getElementById("salin").select();
        document.execCommand("copy");
        alert("Berhasil Disalin");
    }
</script>    

<!-- Event snippet for Website traffic conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-622831574/pai_CNC509cBENbP_qgC'});
</script>

    <link href="/motion/app.css" rel="stylesheet">
    <link href="/motion/add.css" rel="stylesheet">	    
	    
		<?php $this->load->view('templates/opoin/partials/_head');?>
		<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/meteor-emoji@0.1.7/dist/meteorEmoji.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>


      <link rel="preload" href="https://fonts.googleapis.com/css?family=Reem+Kufi&display=swap" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

	</head>

	<body class="pushable"> 

		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('templates/opoin/partials/_mobile_menu');?>
		</div>

					<div class="Oke" id="page">
 		<div class="ui main container pusher" id="single-post">
			<div class="ui celled main grid m-0 shadowless">
				<div class="one column row content p-0">
					<div class="column">
						<div id="categories-menu">
						<?php $this->load->view('templates/opoin/partials/_categories_menu'); ?>
						</div>

						<div id="top-menu">
							<?php $this->load->view('templates/opoin/partials/_top_menu'); ?>
						</div>

						<div class="ui two columns grid">

							<div class="column p-3" id="l-side">
								
								<div class="ui menu shadowless mt-0 mb-3" id="post-extra">
									<div class="item">
										<i class="calendar icon"></i> <span><?=nice_date($post->date, 'M d, Y - H:i')?></span>
									</div>
									
									<div class="right menu">
										<a class="item" href="#comments">
											<i class="comments icon"></i>
											<span><?=round_int($post->comments_count)?></span>
										</a>

										<div class="item">
											<i class="eye icon"></i>
											<span><?= lang('ui_pembaca') ?> <?=round_int($post->views)?> <?= lang('ui_kali') ?></span>
										</div>

										<div class="item">
											<div class="ui large star rating" data-rating="<?=$post->rating?>" id="post-rating"></div>
										</div>
									</div>
								</div>
								
								
						        <div class="ui segment">
								<div id="share-buttons">
									<div class="ui big menu">
										<div class="header item radiusless">
											<?= lang('ui_share_on') ?>
										</div>
										<div class="right menu">
										    
											<a class="item" onclick="window.open('https://api.whatsapp.com/send?text=<?=current_url()?> - Hi, sahabat Netizen... Terima kasih sudah membagikan berita kami.', 'WhatsApp', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="whatsapp icon m-0"></i>
											</a>										    
											<a class="item" onclick="window.open('https://facebook.com/sharer.php?u=<?=current_url()?>', 'Facebook', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="facebook icon m-0"></i>
											</a>										    
											<a class="item" onclick="window.open('https://twitter.com/intent/tweet?text=<?=$post->summary?>&url=<?=current_url()?>', 'Twitter', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="twitter icon m-0"></i>
											</a>
											<a class="item" onclick="window.open('https://www.pinterest.com/pin/create/button/?url=<?=current_url()?>&media=<?=base_url("uploads/images/{$post->image}")?>&description=<?=$post->summary?>', 'Pinterest', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="pinterest icon m-0"></i>
											</a>
											<a onclick="window.open('https://www.linkedin.com/cws/share?url=<?=current_url()?>', 'Linkedin', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')" class="item">
												<i class="linkedin icon m-0"></i>
											</a>											
											<a class="item" onclick="window.open('https://vk.com/share.php?url=<?=current_url()?>', 'VK', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="vk icon m-0"></i>
											</a>
											<a onclick="window.open('https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?=current_url()?>', 'tumblr', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')" class="item">
												<i class="tumblr icon"></i>
											</a>
										</div>
									</div>
								</div>
								</div>								
								

								<a href="<?= ad_banner_link($banners['pb1']->link ?? null) ?>" 
									 class="my-3 d-block ad <?= ad_banner_class($banners['pb1']->link ?? null) ?>" target="Lihat" id="pb1">
									<span>pb1</span>
									<img width="100%" height="50%" src="<?= ad_banner_img($banners['pb1']->image ?? null) ?>" class="d-block mx-auto">
								</a>

								<div id="post-cover" class="mt-3">
									<img width="700" height="400" src="<?=base_url("uploads/images/{$post->image}")?>" alt="post image" class="ui fluid rounded image">
								</div>

                                

								<div class="ui raised segment shadowless px-4 purple" id="post-title">
								<center><h1><span style="font-family: 'K2D', sans-serif; small-caps;"><small><?=ucfirst($post->title)?></small></span></h1></center>
								</div>
								
								
<center>
<a target="_blank" href="https://news.google.com/publications/CAAqBwgKMLfVnAsww9-0Aw?hl=id&gl=ID&ceid=ID%3Aid"><img width="100%" height="50%" src="/iklan/google-news.webp"/></a>    
</center>


								<div id="similar-posts">
									<?php $this->load->view('templates/opoin/partials/_berita_terkait', compact('similar_posts'))?>
								
								</div>

								<div id="post">
									<?=get_ad_units('rectangle')?>
									<?=htmlspecialchars_decode($post->body)?><br>
									
									Artikel berhasil ditayangkan pada: <span><?=nice_date($post->date, 'M d, Y - H:i')?></span> WIB.
									
								<p><p style="margin-bottom: 20px; font-size: 15px; line-height: 31px; color: rgb(110, 109, 109); font-family: &quot;Open Sans&quot;;"><span style="font-family: K2D;">Bagaimana? apakah kamu menyukai dengan tulisan artikel <b><span style="color: rgb(119, 29, 255);"><?=$post->author_fullname ?? $post->author_username?></span></b>?<br> Jika kamu menyukainya, silakan tulis pendapatmu di kolom komentar ya gengs 😊</span></p>

</div>

								<div id="comment-form">
								<?php $this->load->view('templates/opoin/partials/_comment_form', ['post_slug' => $post->slug]);?>
								</div>
								

								<div id="prev-next-post">
									<?php if ($prev_next_items): ?>
									<div class="ui horizontal segments shadowless my-0">
										<?php if (isset($prev_next_items['prev'])): ?>
										<a href="<?=base_url("post/{$prev_next_items['prev']->slug}")?>" class="ui segment">
											<div class="ui header">
												<h4>
													<i class="angle left icon mr-2 ml-0"></i>
													<?= lang('ui_bacajuga') ?>
												</h4>
												<div class="sub header">
													<?=$prev_next_items['prev']->title?>
												</div>
											</div>
										</a>
										<?php else: ?>
										<a href="javascript:void(0)" class="ui segment"></a>
										<?php endif?>

										<?php if (isset($prev_next_items['next'])): ?>
										<a href="<?=base_url("post/{$prev_next_items['next']->slug}")?>" class="ui right aligned segment">
											<div class="ui header">
												<h4>
													<?= lang('ui_bacajuga') ?>
													<i class="angle right icon ml-2 mr-0"> </i>
												</h4>
												<div class="sub header">
													<?=$prev_next_items['next']->title?>
												</div>
											</div>
										</a>
										<?php else: ?>
										<a href="javascript:void(0)" class="ui segment"></a>
										<?php endif?>
									</div>
									<?php endif?>
									</div>
									
								<center><img width="100%" height="50%" src="/imgsite/sukai-medialova.gif" alt="Sukai"/></center>
								

								<div id="reactions" class="reactions mb-3" >
									<h4 class="uppercase"><?= lang('ui_your_reaction') ?></h4>

									<div class="ui six cards">
										<div v-cloak v-for="reaction in reactions" class="fluid card" 
												:class="{active: isUserReaction(reaction)}" 
												:data-reaction="reaction"
												@click="react($event, reaction)">
											<div class="image">
												<img width="103" height="103" :src="'/assets/images/'+ reaction +'.gif'" :alt="reaction">
											</div>
											<div class="extra content center aligned">
												{{ postReactions[reaction] }}
											</div>
											<div class="content">
												<div class="header">{{ reaction }}</div>
											</div>
										</div>
									</div>
								</div>

								<div class="ui inverted segment">
								<small><span style="color: white;">Kolom komentar tersedia untuk diskusi, berbagi ide dan pengetahuan. Hargai pembaca lain dengan berbahasa yang baik dan sopan. Setialah pada topik. Jangan menyerang atau menebar kebencian terhadap suku, agama, ras, atau golongan tertentu. Pikirlah baik-baik sebelum mengirim komentar.</span></small>
									
<div class="ui inverted divider"></div>
<small><span style="color: white;">Silakan tulis komentar Anda sesuai dengan topik halaman berita ini. Komentar yang berisi SPAM! tidak akan ditampilkan sebelum disetujui oleh team kami. (berkomentarlah dengan baik dan sopan)</span></small>
									
<div class="ui divider fluid"></div>

<div class="rainbow">
<small><span style="color: white;">Jika Anda merasa bahwa Artikel ini bermanfaat, Anda bisa membagikannya ke teman, sahabat, pacar, keluarga ke <b><a href="https://facebook.com/groups/mediastory/"target="Facebook"><span style="color: #3b5998;">Facebook</span></a></b>, <b><a href="https://twitter.com/medialova" target="Twitter"><span style="color: #00acee;">Twitter</span><span style="color: yellow;"></a></b>, <b><a href="whatsapp://send?text=https://www.stori.id/"><span style="color: #1EAA52;">WhatsApp</span></a></b>, <b><a href="https://pinterest.com/medialova" target="Pinterest"><span style="color: #E60023;">Pinterest</span></a></b> &#38; <b><a href="https://linkedin.com/in/medialova" target="LinkedIn"><span style="color: #0e76a8;">LinkedIn</span></a></b>.</span></small>
</font></div></div>

<div class="ui inverted segment">
<div class="dafta">
<small><span style="color: white;">Ini adalah artikel dari komunitas Stori dan telah disunting sesuai standar penulisan kami. Andapun bisa membuatnya <b><a href="/short/link/?id=68747470733a2f2f7777772e6d656469616c6f76612e636f6d2f6b6f6e7472696275746f72"><span style="color: #DF135A;">disini</span><span style="color: white;">.</span></a></span></b></small>

<div class="ui inverted divider"></div>

<small><span style="color: white;">Penayang artikel dari pengguna Stori yang diposting di halaman M-story yang berbasis user generate content (UGC). Semua isi tulisan dan konten di dalamnya sepenuhnya menjadi tanggung jawab penulis atau pengguna.</span></small>

<div class="ui inverted divider"></div>

<small><span style="color: white;">Seluruh isi konten adalah sepenuhnya hak milik Stori, jika mengambil isi konten dari Stori, harap mencantumkan sumber konten link website Stori. Seluruh isi konten Stori, mengandung hak cipta yang diterbitkan oleh para penulis (kontributor) Stori.id.</span></small>

</div>
  <h4 class="ui horizontal inverted divider">
    <strong><span style="color: white;">DISCLAIMER</span></strong>
  </h4>
  
            <center>  
            <a href="https://www.stori.id" title="stori.id">
                <!-- <img width="169" height="22" class="imgsticky-no" src="/assets/images/logo.webp?v=" alt="logo stori"> -->
                <div class="logomotion">
                <div class="logomotion-wrap imgsticky-no ">
                  <div class="mot-medialova">
                    <span class="mot-s"><img src="/motion/s.png" alt="s"></span>                
                    <span class="mot-t"><img src="/motion/t.png" alt="t"></span>
                    <span class="mot-o"><img src="/motion/o.png" alt="o"></span>
                    <span class="mot-r"><img src="/motion/r.png" alt="r"></span> 
                    <span class="mot-i"><img src="/motion/i.png" alt="i"></span>

                    <span class="mot-dot"><img src="/room/motion/dot.png" alt="dot"></span>
                    <span class="mot-ai"><img src="/room/motion/ai.png" alt="ai"></span>
                    <span class="mot-di"><img src="/room/motion/di.png" alt="di"></span>   

              
                <img class="imgsticky" src="/assets/images/logo.webp" alt="logo stori">
            </a>


  
                </div>
              </div>



                <img class="imgsticky" width="169" height="22" src="/assets/images/logo.webp" alt="logo stori">
            </a>
            </center>
  
</div>

<div class="berhasil">
<i class="star icon"></i><font size="2" color="000000"><b>MODERATOR:</b></font> <font size="2" color="cb0c4b"><b>Vioza, Agez, Feronica</b></font>
</div>

<div class="informasi">
<i class="edit icon"></i><font size="2" color="000000"><b>TEAM EDITOR:</b></font> <font size="2" color="cb0c4b"><b>Bian, Ayoe, Roys</b></font>
</div>





<div class="ui clearing segment">

<div class="ui divided items">
  <div class="item">
    <div class="ui tiny image">
      <img width="60" height="60" src="/icon/stori.png">
    </div>
    <div class="content">
      <a class="header"><strong><a href="/iklan/s/QRbv80" target="_blank"><span style="color: black;">Stori</span></a></strong>
      <div class="meta">
        <span class="cinema"><span style="color: black;">Rilis 03/11/2020 - v.30.1.0</span></span>

<div class="ui right floated"><button class="ui black button"><span style="color: white;">DOWNLOAD!</span> <a href="/iklan/s/QRbv80" class="os-style os-icon android trs" title="Android"></a></button></div>

<div class="ui right floated"><button class="ui inverted violet button"><span style="color: black;">PLAYSTORE</span> <a href="/iklan/s/QRbv80" class="os-style os-icon android trs" title="Android"></a></button></div>

      </div>
      <div class="description">
     
      </div>
      <div class="extra">
        <div class="ui label"><a href="/iklan/s/QRbv80" target="_blank"><span style="color: black;">Android</span></a></div>
        <div class="ui label"><i class="globe icon red"></i><a href="https://stori.id/" target="_blank"><span style="color: black;">Stori</span></a></div>
      </div>
    </div>
  </div>

</div></div>

<div class="ui divider fluid"></div>

						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="008FF5"> <span style="color: black;"><?= lang('ui_sponsor_iklan') ?></span></font></span></div>

<center><img width="100%" height="50%" alt="Iklan" src="/ads.webp" /></center>

								<a href="/iklan/s/2A0Pxs" 
									 class="my-3 d-block ad <?= ad_banner_class($banners['pb1']->link ?? null) ?>" target="Lihat" id="pb1">
									<span>Netflix</span>
									<img width="100%" height="50%" src="/iklan/film-indo-1.webp" class="d-block mx-auto">
								</a>


<center>
<a target="_blank" href="/short/link/?id=68747470733a2f2f69642d69716f7074696f6e2e636f6d2f6c616e642f73746172742d74726164696e672f69642f3f6166663d313438383133"><img width="100%" height="50%" src="/iklan/ref2.jpg"/></a>    
</center>

<div class="ui divider fluid"></div>

<center><a target="_blank" href="/short/link/?id=68747470733a2f2f7777772e6d656469616c6f76612e636f6d2f6d656469616c6f76612e61706b"><img width="100%" height="50%" src="/iklan/download.webp" /></a></center>


<div class="ui divider fluid"></div>
								
<center><b>Kerjasama</b><br><br>
medialova.com[at]gmail.com</center>

<div class="ui divider fluid"></div>

<div class="ui raised segment shadowless" id="post-ads">

						<div class="ui tabular menu mb-0">
						<span class="item active"> <font size="2" color="008FF5"> <?= lang('ui_sponsor_iklan') ?></font></span></div>

<center><a target="_blank" href="/short/link/?id=68747470733a2f2f69642d69716f7074696f6e2e636f6d2f6c616e642f73746172742d74726164696e672f69642f3f6166663d313438383133"><img width="100%" height="50%" src="/iklan/ref1.gif"/></a></center></div>

								<a href="/iklan/s/2A0Pxs" 
									 class="my-3 d-block ad <?= ad_banner_class($banners['pb1']->link ?? null) ?>" target="Lihat" id="pb1">
									<span>Netflix</span>
									<img width="100%" height="50%" src="/iklan/film-indo-2.webp" class="d-block mx-auto">
								</a>
								
								<?=get_ad_units('rectangle')?>

								<div class="author">
									<div class="ui unstackable items">
										<div class="item">
											<a href="<?=base_url("user/{$post->author_username}")?>" class="ui rounded small image">
												<img width="150" height="150" src="<?=base_url("uploads/profiles/{$post->author_image}?v=" . time())?>">
												<span class="ui right bottom attached label">
													<?=ucfirst(($post->author_role === 'main' ? 'Administrator' : $post->author_role))?>
												</span>
											</a>

											<div class="content">
												<div class="header">
													<small><i class="coffee icon"></i></small> <span style="font-variant: small-caps;"> <span style="color: #ff004e;"> <?=$post->author_fullname ?? $post->author_username?></span></span> <small><i class="coffee icon"></i></small> <small><i class="fa fa-check-circle"></i></font> Penulis Terverifikasi <i class="fa fa-check-circle"></i> </small> 
												</div>

												<div class="about">
													<i class="handshake icon"></i> <?=$post->author_about?> <i class="handshake icon"></i>
												</div>

												<div class="ui small icon buttons">
													<a class="ui linkedin rounded-corner icon button" title="Website" href="<?=$post->author_linkedin?>" target="_blank">
														<i class="globe icon"></i>
													</a>												    
													<span class="p-1"></span>
													<a class="ui facebook rounded-corner icon button" title="Facebook" href="https://facebook.com/<?=$post->author_facebook?>" target="_blank">
														<i class="facebook icon"></i>
													</a>
													<span class="p-1"></span>
													<a class="ui instagram rounded-corner icon button" title="Twitter" href="https://instagram.com/<?=$post->author_pinterest?>" target="_blank">
														<i class="instagram icon"></i>
													</a>													
													<span class="p-1"></span>
													<a class="ui twitter rounded-corner icon button" title="Twitter" href="https://twitter.com/<?=$post->author_twitter?>" target="_blank">
														<i class="twitter icon"></i>
													</a>
													<span class="p-1"></span>
													<a class="ui youtube rounded-corner icon button" title="Youtube" href="https://www.youtube.com/<?=$post->author_youtube?>"  target="_blank">
														<i class="youtube icon"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div id="share-buttons">
									<div class="ui big menu">
										<div class="header item radiusless">
											<?= lang('ui_share_on') ?>
										</div>
										<div class="right menu">
										    
											<a class="item" onclick="window.open('https://api.whatsapp.com/send?text=<?=current_url()?> - Hi, sahabat Netizen... Terima kasih sudah membagikan berita kami.', 'WhatsApp', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="whatsapp icon m-0"></i>
											</a>										    
											<a class="item" onclick="window.open('https://facebook.com/sharer.php?u=<?=current_url()?>', 'Facebook', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="facebook icon m-0"></i>
											</a>										    
											<a class="item" onclick="window.open('https://twitter.com/intent/tweet?text=<?=$post->summary?>&url=<?=current_url()?>', 'Twitter', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="twitter icon m-0"></i>
											</a>
											<a class="item" onclick="window.open('https://www.pinterest.com/pin/create/button/?url=<?=current_url()?>&media=<?=base_url("uploads/images/{$post->image}")?>&description=<?=$post->summary?>', 'Pinterest', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="pinterest icon m-0"></i>
											</a>
											<a onclick="window.open('https://www.linkedin.com/cws/share?url=<?=current_url()?>', 'Linkedin', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')" class="item">
												<i class="linkedin icon m-0"></i>
											</a>											
											<a class="item" onclick="window.open('https://vk.com/share.php?url=<?=current_url()?>', 'VK', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')">
												<i class="vk icon m-0"></i>
											</a>
											<a onclick="window.open('https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?=current_url()?>', 'tumblr', 'toolbar=0, status=0, width=\'auto\', height=\'auto\'')" class="item">
												<i class="tumblr icon"></i>
											</a>
										</div>
									</div>
								</div>

								<div id="prev-next-post">
									<?php if ($prev_next_items): ?>
									<div class="ui horizontal segments shadowless my-0">
										<?php if (isset($prev_next_items['prev'])): ?>
										<a href="<?=base_url("post/{$prev_next_items['prev']->slug}")?>" class="ui segment">
											<div class="ui header">
												<h4>
													<i class="angle left icon mr-2 ml-0"></i>
													<?= lang('ui_prev_post') ?>
												</h4>
												<div class="sub header">
													<?=$prev_next_items['prev']->title?>
												</div>
											</div>
										</a>
										<?php else: ?>
										<a href="javascript:void(0)" class="ui segment"></a>
										<?php endif?>

										<?php if (isset($prev_next_items['next'])): ?>
										<a href="<?=base_url("post/{$prev_next_items['next']->slug}")?>" class="ui right aligned segment">
											<div class="ui header">
												<h4>
													<?= lang('ui_next_post') ?>
													<i class="angle right icon ml-2 mr-0"> </i>
												</h4>
												<div class="sub header">
													<?=$prev_next_items['next']->title?>
												</div>
											</div>
										</a>
										<?php else: ?>
										<a href="javascript:void(0)" class="ui segment"></a>
										<?php endif?>
									</div>
									<?php endif?>
								</div>

								<?=get_ad_units('rectangle')?>

								<div class="ui divider fluid"></div>
								
<center><a target="_blank" href="/short/link/?id=68747470733a2f2f69642d69716f7074696f6e2e636f6d2f6c616e642f73746172742d74726164696e672f69642f3f6166663d313438383133"><img width="100%" height="50%" src="/iklan/ref.gif" alt="Iklan"/></a></center>

								<div class="ui divider fluid"></div>


								<div id="similar-posts">
									<?php $this->load->view('templates/opoin/partials/_similar_posts', compact('similar_posts'))?>
								</div>
								

								<?=get_ad_units('rectangle')?>
									
								<?php if($comments): ?>
								<div id="comments">
									<?php $this->load->view('templates/opoin/partials/_comments', compact('comments'))?>
								</div>
								<?php endif ?>

								<div id="comment-form">
									<?php $this->load->view('templates/opoin/partials/_comment_form', ['post_slug' => $post->slug]);?>
								</div>
								<br>



<div class="ui segment">
  <h4 class="ui right floated header"><span style="color: black;">ATURAN KOMENTAR</span></h4>
  <div class="ui clearing divider"></div>
  <p><small><span style="color: black;">MOHON UNTUK SELALU MENGGUNAKAN ALAMAT EMAIL YANG VALID ( AKTIF ) AGAR KAMI DAPAT MEMBALAS KOMENTAR SOBAT.</span></small></p>
  <div class="ui clearing divider"></div>  
  <p><small><span style="color: black;">Kolom komentar tersedia untuk diskusi, berbagi ide dan pengetahuan. Hargai pembaca lain dengan berbahasa yang baik dan sopan. Setialah pada topik. Jangan menyerang atau menebar kebencian terhadap suku, agama, ras, atau golongan tertentu. Pikirlah baik-baik sebelum mengirim komentar.</span></small></p>  
</div>

								<script>

									var reactions = new Vue({
										el: "#reactions",
										data: {
											userReaction: null,
											userReactions: {},
											reactions: ['suka', 'cinta', 'senang', 'kaget', 'sedih', 'marah'],
											postId: <?= $post->id ?>,
											postReactions: <?= json_encode($reactions) ?>
										},
										methods: {
											react: function(e, reaction)
											{
												if(this.reactions.indexOf(reaction) < 0 || isNaN(this.postId) || this.isUserReaction(reaction))
													return;

												this.updateUserReactions(reaction);

												$(e.target).find('img').transition('bounce')
											},
											isUserReaction(reaction)
											{
												return this.userReaction === reaction;
											},
											updateUserReactions: function(reaction)
											{
												var userReactions = this.userReactions;
												var postReactions = this.postReactions;

												postReactions[reaction] = parseInt(postReactions[reaction])+1;

												if(Object.keys(postReactions).indexOf(this.userReaction) >= 0)
												{
													postReactions[this.userReaction] -= (postReactions[this.userReaction] >= 1) ? 1 : 0;
												}
												
												this.postReactions = postReactions;

												userReactions[this.postId] = reaction;

												$.post('/save_reaction', {"id": this.postId, "old_reaction": this.userReaction, "new_reaction": reaction});

												this.userReactions = userReactions;
												this.userReaction  = reaction;

												localStorage.setItem('userReactions', JSON.stringify(userReactions));
											}
										},
										mounted: function() 
										{
											var userReactions = JSON.parse(localStorage.getItem('userReactions')) || {};

											if(Object.keys(userReactions).length > 0)
											{
												this.userReactions = userReactions;
												
												if(Object.keys(userReactions).indexOf(String(this.postId)) >= 0)
												{
													this.userReaction = userReactions[this.postId];
												}
											}
										}
									})

									$(function()
									{
										$('#post-rating').rating({
											onRate: function(newRating)
											{
												var reqUrl = location.origin + '/post/update_rating';
												var data = {'id': <?= $post->id ?>,
															'rating': newRating};
												var rating = <?= $post->rating ?>;

												$.post(reqUrl, data);

												rating = (rating == 0)
														? newRating
														: Math.ceil((rating+newRating)/2);

												$(this)
												.attr('data-rating', rating)
												.rating()
												.rating('disable');
											}
										});

										new MeteorEmoji();

										$('<a href="<?= ad_banner_link($banners['pb2']->link ?? null) ?>" \
												 class="my-3 d-block ad <?= ad_banner_class($banners['pb2']->link ?? null) ?>" target="Lihat" id="pb2">\
												<span>pb2</span>\
												<img width="100%" height="50%" src="<?= ad_banner_img($banners['pb2']->image ?? null) ?>" class="d-block mx-auto">\
											</a>').insertAfter('#post p:nth-child('+ Math.round($('#post p').length / 2) +')');
									})
								</script>
							</div>

							<div class="column p-3" id="r-side">
								<?php $this->load->view('templates/opoin/partials/_right_sidebar');?>
							</div>

						</div>
						

						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer');?>
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

	</body>
</html>