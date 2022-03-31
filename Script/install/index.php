<?php session_start() ?>
<?php require_once('helpers.php') ?>

<?php if(!get_step()) exit; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
	<title>Installation - Database</title>

	<link rel="stylesheet" href="//<?= $_SERVER['HTTP_HOST'] ?>/assets/frameworks/semantic-ui-2.4.1/semantic.min.css">

	<link rel="stylesheet" href="//<?= $_SERVER['HTTP_HOST'] ?>/assets/css/spacing.css">

	<style>
		@import url("//<?= $_SERVER['HTTP_HOST'] ?>/assets/fonts/font-face.css");

		html, body, span, div, h1, h2, h3, h4, h5, h6, select, input, textarea, button, a {
		  font-family: 'armata' !important;
		}

		.grid {
		    height: 100vh;
		    width: 100%;
		}
	</style>
</head>

<body>
	<div class="ui grid middle aligned m-0">
		<div class="row">
			<div class="column">
				<form action="proc.php?step=<?= get_step() ?>" class="ui form" method="post" spellcheck="false" id="form">
					<div class="ui card mx-auto">
						<div class="content center aligned header">
							<div class="header">
								<?= get_step_title() ?>
							</div>
						</div>

						<?= get_form_message() ?>

						<div class="content">
							<?php if(get_step() === 1): ?>

							<div class="field">
								<label>Hostname</label>
								<input type="text" name="_hostname" placeholder="localhost or 127.0.0.1" required>
							</div>
							<div class="field">
								<label>Username</label>
								<input type="text" name="_username" placeholder="..." required>
							</div>
							<div class="field">
								<label>Password</label>
								<input type="text" name="_password" placeholder="..." required>
							</div>
							<div class="field">
								<label>Database</label>
								<input type="text" name="_database" placeholder="..." required>
							</div>

							<?php elseif(get_step() === 2): ?>

							<div class="field">
								<label>Name</label>
								<input type="text" name="_site_name" placeholder="..." required>
							</div>
							<div class="field">
								<label>Title</label>
								<input type="text" name="_site_title" placeholder="..." required>
							</div>
							<div class="field">
								<label>Description</label>
								<textarea type="text" name="_site_description" placeholder="..." required></textarea>
							</div>

							<?php elseif(get_step() === 3): ?>

							<div class="field">
								<label>Maxmind GeoLite2-City Download Link</label>
								<input type="url" name="_maxmind_database" placeholder="..." required>
							</div>	
							
							<?php else: ?>

							<div class="field">
								<label>Username</label>
								<input type="text" name="_user_name" placeholder="..." required>
							</div>
							<div class="field">
								<label>Email</label>
								<input type="email" name="_user_email" placeholder="..." required>
							</div>
							<div class="field">
								<label>Password</label>
								<input type="text" name="_user_pwd" placeholder="..." required>
							</div>

							<?php endif ?>
						</div>

						<div class="extra content">
							<?php if(get_step() > 1): ?>
							<a href="/install/?step=<?= get_step()-1 ?>" class="ui small button">Back</a>
							<?php endif ?>
							<button type="submit" class="ui small red button right floated">Next</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>		
		document.querySelector('#form').addEventListener('submit', function(e)
		{
			if(<?= get_step() ?? 1 ?> === 4)
			{
				e.target.disabled = true;
				e.target.classList.add("loading");
			}
		}, null)
	</script>
</body>

</html>