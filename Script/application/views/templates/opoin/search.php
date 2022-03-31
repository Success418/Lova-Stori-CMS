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
								<div class="items-results">
									<h3>
										<span class="posts-found">[<?= $total_rows ?>]</span> <?= lang('ui_search_resulats') ?> <span class="keyword">[<?= $keyword ?>]</span> : 
										<span class="pages">[<?= lang('ui_page') ?> <?= "{$page}/{$total_pages}" ?>]</span>
									</h3>
								</div>
			
								<div class="ui hidden divider"></div>

								<div id="posts" class="ui three column doubling stackable masonry grid images-hidden">
									<?php $this->load->view('templates/opoin/partials/_posts'); ?>
								</div>
						
								<div class="ui divider" style="border-bottom: none"></div>
							
								<div id="pagination">
									<div class='ui pagination menu'>
										<?= $pagination ?>
									</div>
								</div>
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

	</body>
</html>