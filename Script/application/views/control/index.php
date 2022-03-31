<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('control/includes/_head'); ?>
		<title>Panel - Dashboard</title>
		<link rel="icon" href="/assets/images/favicon.ico">

		<!-- CHARTJS PLUGIN -->
		<script src="<?= base_url('assets/control/plugins/chartjs/chartjs.bundle.min.js') ?>"></script>

		<!-- J.VECTOR.MAP PLUGIN -->
		<link rel="stylesheet" href="<?= base_url('assets/control/plugins/jvectormap/jquery-jvectormap-2.0.3.css') ?>?v=<?= time() ?>">
		<script src="<?= base_url('assets/control/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') ?>?v=<?= time() ?>"></script>
		<script src="<?= base_url('assets/control/plugins/jvectormap/jquery-jvectormap-world.js') ?>?v=<?= time() ?>"></script>
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
								<div class="item"><h3>Dashboard</h3></div>
								<div class="right menu">
									<div class="item">Kontrol / Dashboard</div>
								</div>
							</div>
						</div>
						

						<div class="ui hidden divider"></div>

						
						<div id="item" class="ui three column doubling stackable dashboard">
							<?php $this->load->view('control/includes/_dashboard'); ?>
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