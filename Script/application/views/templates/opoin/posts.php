<!DOCTYPE html>
<html lang="en">
    
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('templates/opoin/partials/_head');?>
		<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/meteor-emoji@0.1.7/dist/meteorEmoji.min.js"></script>
		
		
	</head>

	<body class="pushable">

		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('templates/opoin/partials/_mobile_menu');?>
		</div>

 		<div class="ui main container pusher" id="posts-group">
			<div class="ui celled main grid m-0 shadowless">
				<div class="one column row content p-0">
					<div class="column">
						<div id="categories-menu">
						<?php $this->load->view('templates/opoin/partials/_categories_menu'); ?>
						</div>

						<div id="top-menu">
							<?php $this->load->view('templates/opoin/partials/_top_menu'); ?>
						</div>

						<div class="ui two columns my-0 grid">

							<div class="column p-3" id="l-side">
								<div class="ui segment" id="posts-group-title">
									<h3 class="ui header my-2">
										<?= $metadata->posts_group_title ?>
									</h3>
								</div>

								<div class="posts-cards" id="posts">
									<?= get_ad_units('rectangle') ?>
										
									<div class="ui basic segment p-0">
										<div class="ui three doubling cards initial">
											<?php
													if($posts)
													{
															$posts_indexes = array_keys($posts);
															$posts_indexes = array_chunk($posts_indexes, ceil(count($posts)/3), TRUE);
															$posts_indexes = array_map('max', $posts_indexes);
															
															array_pop($posts_indexes);
													}
											?>
												
											<?php foreach($posts as $index => $post): ?>
											<div class="ui fluid card">
												<?php if($this->settings['site_show_posts_authors']): ?>
												<div class="top content">
													<div class="left">
														<div class="header" title="<?= $post->author_realname ?>">
															<?= ucfirst($post->author_realname ?? 
																$post->author_username) ?>
														</div>

														<div class="meta" title="<?= $post->date ?>">
															<?= nice_date($post->date, 'Y-m-d') ?>
														</div>
													</div>

													<?php if($post->author_image): ?>
													<a class="right floated mini ui rounded image" href="<?= base_url("user/{$post->author_username}") ?>">
														<img width="200" height="200" src="<?= base_url("uploads/profiles/{$post->author_image}") ?>" alt="img">
													</a>
													<?php else: ?>
													<a class="right floated avatar" href="<?= base_url("user/{$post->author_username}") ?>">
														<?= substr($post->author_username, 0, 2) ?>
													</a>
													<?php endif ?>
												</div>
												<?php endif ?>
												
												<a href="<?= base_url("post/{$post->slug}") ?>" title="<?= ucfirst($post->title) ?>" class="image item-image">
													<img width="700" height="400" src="<?= base_url("uploads/images/{$post->image}") ?>">
												</a>

												<div class="content p-0 item-title">
													<div class="header">
														<a href="<?= base_url("post/{$post->slug}") ?>" title="<?= ucfirst($post->title) ?>">
															<?= ucfirst($post->title) ?>
														</a>
													</div>
												</div>

												<div class="content p-0 item-summary">
													<div class="description p-3">
														<?= ucfirst($post->title) ?>
														<br>
														<?= $post->summary ?>
													</div>
												</div>

												<div class="extra content">
													<span class="right floated">
														<div class="ui star rating" data-rating="<?= $post->rating ?>"></div>
													</span>
													<span>
														<i class="comments icon"></i>
														<?= round_int($post->comments_count) ?>
													</span>
													<span class="px-2"></span>
													<span>
														<i class="eye icon"></i>
														<?= round_int($post->views) ?>
													</span>
												</div>
											</div>
											
											<?php if(in_array($index, $posts_indexes)): ?>
													<?php // echo get_ad_units('feed') ?>
											<?php endif ?>
																				
											<?php endforeach ?>

											<script>
												$(function()
												{
													$('.posts-cards .item-title a')
														.popup({delay: {show: 300,hide: 0}});

													$('#posts .ui.rating').rating('disable')
												})
											</script>
										</div>
									</div>
								</div>

								<div class="ui fluid divider"></div>

								<?= get_html_pagination($pagination, styleIsDark()) ?>
							</div>

							<div class="column p-3" id="r-side">
								<?php $this->load->view('templates/opoin/partials/_right_sidebar');?>
							</div>

						</div>

						<div class="footer pt-3 px-3 pb-0">
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
		

	</body>
</html>