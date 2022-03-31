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

						<div class="page">

							<?php if(can_create_posts($user_profile->role)): ?>
							<div class="author">
								<div class="ui unstackable items">
									<div class="item">
										<a href="<?=base_url("user/{$user_profile->username}")?>" class="ui rounded small image">
											<img width="200" height="200" src="<?=base_url("uploads/profiles/{$user_profile->image}?v=" . time())?>">
											<span class="ui blue right bottom attached label">
												<?=ucfirst(($user_profile->role === 'main' ? 'Administrator' : $user_profile->role))?>
											</span>
										</a>

										<div class="bottom aligned content">
											<div class="header">
												<?=$user_profile->fullname ?? $user_profile->username?>
											</div>

											<div class="meta about">
												<?=$user_profile->about?>
											</div>

											<div class="meta mb-0">
												<div class="ui small basic icon buttons borderless">
													<a class="ui button" title="Website" href="<?=$user_profile->linkedin?>"  target="_blank"><i class="globe icon"></i></a>
													<a class="ui button" title="Facebook" href="https://facebook.com/<?=$user_profile->facebook?>" target="_blank"><i class="facebook icon"></i></a>
													<a class="ui button" title="Instagram" href="https://instagram.com/<?=$user_profile->pinterest?>" target="_blank"><i class="instagram icon"></i></a>
													<a class="ui button" title="Twitter" href="https://twitter.com/<?=$user_profile->twitter?>"  target="_blank"><i class="twitter icon"></i></a>													
													<a class="ui button" title="Youtube" href="https://www.youtube.com/<?=$user_profile->youtube?>"  target="_blank"><i class="youtube icon"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php endif ?>
							
							<div class="ui hidden divider mt-0"></div>
														
							<div id="author-data">
								<div class="ui top attached tabular menu">
									<?php if(can_create_posts($user_profile->role)): ?>
									<a class="active item" data-tab="posts">
										<?= lang('ui_posts') ?>
									</a>
									<?php endif ?>
									<a class="item <?= !can_create_posts($user_profile->role) ? 'active' : '' ?>" data-tab="comments">
										<?= lang('ui_comments') ?>
									</a>
								</div>
								<?php if(can_create_posts($user_profile->role)): ?>
								<div class="ui bottom attached tab segment posts px-0 active" data-tab="posts">
									<table class="ui basic celled unstackable table">
										<thead>
											<tr>
												<th><?= lang('ui_title') ?></th>
												<th class="center aligned"><?= lang('ui_date') ?></th>
												<th class="center aligned"><?= lang('ui_rating') ?></th>
												<th class="right aligned"><?= lang('ui_views') ?></th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($user_posts as $user_post): ?>
											<tr>
												<td>
													<a href="<?= base_url("post/{$user_post->slug}") ?>">
														<?= ucfirst($user_post->title)?>
													</a>
												</td>
												<td class="three wide right aligned">
													<?= $user_post->date ?>
												</td>
												<td class="three wide center aligned">
													<div class="ui star rating" data-rating="<?= $user_post->rating ?>" data-max-rating="5"></div>
												</td>
												<td class="right aligned">
													<?= round_int($user_post->views) ?>
												</td>
											</tr>
										<?php endforeach ?>
										</tbody>
										<tfoot class="full-width">
											<tr>
												<th colspan="4">
													<?php if($user_posts): ?>
													<?php if($total_posts_pages > 1): ?>
													<button class="ui small button" data-pagination="prev" disabled>
														<?= lang('ui_prev') ?>
													</button>
													<button class="ui small button" data-pagination="next">
														<?= lang('ui_next') ?>
													</button>
													<?php else: ?>
													&nbsp;
													<?php endif ?>
													<?php else: ?>
													Tidak ada tulisan yang ditemukan!
													<?php endif ?>
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
								<?php endif ?>
								<div class="ui bottom attached tab segment comments px-0 <?= !can_create_posts($user_profile->role) ? 'active' : '' ?>" data-tab="comments">
									<table class="ui basic celled <?php if(styleIsDark()): ?> inverted <?php endif ?> unstackable table">
										<thead>
											<tr>
												<th><?= lang('ui_title') ?></th>
												<th class="center aligned"><?= lang('ui_date') ?></th>
												<th class="center aligned"><?= lang('ui_read') ?></th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($user_comments as $user_comment): ?>
											<tr>
												<td>
													<a href="<?= base_url("post/{$user_comment->post_slug}#{$user_comment->anchor}") ?>">
														<?= ucfirst($user_comment->post_title)?>
													</a>
												</td>
												<td class="three wide right aligned">
													<?= $user_comment->date ?>
												</td>
												<td class="three wide center aligned">
													<div class="ui circular yellow small icon button read-comment">
														<i class="eye icon mx-0"></i>
														<div class="d-none body">
															<?= nl2br($user_comment->body) ?>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach ?>
										</tbody>
										<tfoot class="full-width">
											<tr>
												<th colspan="4">
													<?php if($user_comments): ?>
													<?php if($total_comments_pages > 1): ?>
													<button class="ui small button" data-pagination="prev" disabled>
														<?= lang('ui_prev') ?>
													</button>
													<button class="ui small button" data-pagination="next">
														<?= lang('ui_next') ?>
													</button>
													<?php else: ?>
													&nbsp;
													<?php endif ?>	
													<?php else: ?>
													Tidak ada komentar!
													<?php endif ?>
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							
							<div class="ui comment modal">
								<i class="close icon"></i>
								<div class="content" style="text-align: left"></div>
							</div>
							
							<script>
								$(function()
								{
									$('#author-data .ui.rating').rating('disable');
									$('#author-data .tabular.menu .item').tab();
									var author_data_pagination = {
										posts_page: 1,
										comments_page: 1
									};
									<?php if(can_create_posts($user_profile->role)): ?>
									$('#author-data .posts button')
									.on('click', function()
									{
										var requestUrl = '<?= base_url("user/{$user_profile->id}/posts") ?>';
										var uesrId = '<?= $user_profile->id ?>';
										var maxPages = <?= $total_posts_pages ?>;
										var pagination = $(this).data('pagination');

										if(paginationHandler('posts_page', 
																	maxPages, 
																	pagination,
																	author_data_pagination))
										{
											$.post(requestUrl, {user_id: uesrId,
																page: author_data_pagination.posts_page})
											.done(function(response)
											{
												if(response.hasOwnProperty('user_posts'))
												{
													var tableRows = '';
													var userPosts = response.user_posts;
													for(var i in userPosts)
													{
														tableRows += userPostsRow(userPosts[i]);
													}
													$('#author-data .posts tbody').html(tableRows);
												}
												$('#author-data .ui.rating')
												.rating('disable');
											});
										}
									});
									<?php endif ?>
									$('#author-data .comments button')
									.on('click', function()
									{
										var requestUrl = '<?= base_url("user/{$user_profile->id}/comments") ?>';
										var uesrId = '<?= $user_profile->id ?>';
										var maxPages = <?= $total_comments_pages ?>;
										var pagination = $(this).data('pagination');

										if(paginationHandler('comments_page', 
																	maxPages, 
																	pagination,
																	author_data_pagination))
										{
											$.post(requestUrl, {user_id: uesrId,
																page: author_data_pagination.comments_page})
											.done(function(response)
											{
												if(response.hasOwnProperty('user_comments'))
												{
													var tableRows = '';
													var userComments = response.user_comments;
													for(var i in userComments)
													{
														tableRows += userCommentsRow(userComments[i]);
													}
													$('#author-data .comments tbody').html(tableRows);
												}
											});
										}
									});
									
									$(document)
									.on('click', '#author-data .read-comment', function()
									{
										$('.comment.modal')
										.modal('toggle')
										.find('.content').html($('.body', this).html());
									});
								})
							</script>

						</div>

						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>