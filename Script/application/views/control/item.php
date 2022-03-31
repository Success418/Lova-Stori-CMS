<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('control/includes/_head'); ?>
		<title>Panel - <?= $page_title ?></title>
		<link rel="icon" href="/assets/images/favicon.ico">
	</head>

	<body class="pushable" >

		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('control/includes/_mobile_menu'); ?>
		</div>

 		<div class="ui main container pusher">
			<div class="ui celled grid m-0" style="min-height: 100vh;">
				<div class="row content p-0">

					<div class="three wide column large screen only p-3 l-side" id="l-side">
						<?php $this->load->view('control/includes/_left_sidebar'); ?>
					</div>

    
					<div class="sixteen wide tablet thirteen wide large screen column r-side p-3" id="r-side">

						<div id="top-menu">
							<?php $this->load->view('control/includes/_top_menu'); ?>

							<div class="ui secondary second menu p-0">
								<div class="item"><h3><?= $page_title ?></h3></div>
								<div class="right menu xs-hidden">
									<div class="item"><?= $breadcrumbs ?></div>
								</div>
							</div>
						</div>
						

						<div class="ui hidden divider my-2"></div>

						
						<div id="item" class="ui three column doubling stackable">
							<?php $this->load->view("control/includes/{$partial}") ?>
						</div>


						<div class="ui divider" style="border-bottom: none"></div>


						<div class="footer">
							<?php $this->load->view('control/includes/_footer'); ?>
						</div>
					</div>

				</div>
			</div>
		</div>

	</body>
</html>