<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	$lang['ext_invalid_login_crendentials'] = "Le nom d'utilisateur ou mot de passe que vous avez entré est incorrect.";

	$lang['ext_non_active_user'] = "Veuillez verifier le lien d'activation qui vous a été envoyé via email.";
	
	$lang['ext_blocked_user'] = 'Ce compte est bloqué.';

	$lang['ext_reset_pwd_message'] = "
		<h3>Demande de changement de mot de passe - [SITE_NAME]</h3>
		<p>Salut,</p>
		<p>Vous avez demandé à changer votre mot de passe, si vous etes à l'origine de ça, veuillez cliquer sur le lien ci-dessous pour confirmer votre demande.</p>
		<a href=\"[CONFIRM_URL]\">[CONFIRM_URL]</a>
		<p>Si vous n'etes pas à l'origine de ça, veuillez simplement ignorer ce message.</p>
		<p><strong>Merci.</strong></p>
	";

	$lang['ext_reset_pwd_confirmation'] = 'Un email contenant les informations nécessaires pour le changement de votre mot de passe vous a été envoyé à votre adresse email.';

	$lang['ext_reset_pwd_done'] = 'Votre mot de passe a été changé avec succès, vous pouvez desormais vous connectez avec votre nouveau mot de passe.';

	$lang['ext_account_activation_message'] = "
		<h3>Activation du compte - [SITE_NAME]</h3>
		<p>Salut,</p>
		<p>Veuillez cliquer sur le lien ci-dessous pour activer votre compte.</p>
		<p><a href=\"[ACTIV_LINK]\" [CSS_STYLE]>Activer mon compte</a></p>
		<br>
		<p>ou copier/coller le lien suivant sur la barre d'adresse.</p>
		<p>[ACTIV_LINK]</p>
	";

	$lang['ext_account_activation_done'] = "Fait!<br>Un email vous a été envoyé pour l'activation de votre compte.";

	$lang['ext_unknown_error'] = 'Erreur inconnue.';

	$lang['ext_form_error'] = 'Erreur!';

	$lang['ext_form_success'] = 'Fait!';