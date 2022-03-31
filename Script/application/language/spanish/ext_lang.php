<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	$lang['ext_invalid_login_crendentials'] = "El nombre de usuario o contraseña que ingresaste es incorrecto.";

	$lang['ext_non_active_user'] = "Por favor, compruebe el enlace de activación que se le envió por correo electrónico";
	
	$lang['ext_blocked_user'] = 'Esta cuenta esta bloqueada.';

	$lang['ext_reset_pwd_message'] = "
		<h3>Solicitud de cambio de contraseña - [SITE_NAME]</h3>
		<p>Hola,</p>
		<p>Usted solicitó cambiar su contraseña, si estas en el origen de eso, Por favor haga clic en el enlace de abajo para confirmar su solicitud.</p>
		<a href=\"[CONFIRM_URL]\">[CONFIRM_URL]</a>
		<p>Si no eres el origen de eso, ignorar este mensaje.</p>
		<p><strong>Gracias.</strong></p>
	";

	$lang['ext_reset_pwd_confirmation'] = 'Se ha enviado a su dirección de correo electrónico un correo electrónico con la información necesaria para cambiar su contraseña.';

	$lang['ext_reset_pwd_done'] = 'Su contraseña se ha cambiado correctamente, ahora puede iniciar sesión con su nueva contraseña.';

	$lang['ext_account_activation_message'] = "
		<h3>Activacion de cuenta - [SITE_NAME]</h3>
		<p>Hola,</p>
		<p>Por favor, haga clic en el enlace de abajo para activar su cuenta.</p>
		<p><a href=\"[ACTIV_LINK]\" [CSS_STYLE]>Activar mi cuenta</a></p>
		<br>
		<p>o copia/pega el siguiente enlace en la barra de direcciones.</p>
		<p>[ACTIV_LINK]</p>
	";

	$lang['ext_account_activation_done'] = "Hecho!<br>Te hemos enviado un correo electrónico con un enlace para activar tu cuenta..";

	$lang['ext_unknown_error'] = 'Desconocido error.';

	$lang['ext_form_error'] = 'Error!';

	$lang['ext_form_success'] = 'Hecho!';