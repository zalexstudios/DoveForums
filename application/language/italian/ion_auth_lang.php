<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Italian
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  Italian language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Account Creato con Successo';
$lang['account_creation_unsuccessful'] 	 	 = 'Impossibile Creare Account';
$lang['account_creation_duplicate_email'] 	 = 'Email gia\' usata o invalida';
$lang['account_creation_duplicate_username'] = 'Username gia\' usato o invalido';
$lang['account_creation_missing_default_group'] = 'Gruppo di Default non impostato';
$lang['account_creation_invalid_default_group'] = 'Impostato nome di gruppo invalido';


// Password
$lang['password_change_successful'] 	 	 = 'Password cambiata con Successo';
$lang['password_change_unsuccessful'] 	  	 = 'Impossibile Cambiare Password';
$lang['forgot_password_successful'] 	 	 = 'Email di Reset Password Inviata';
$lang['forgot_password_unsuccessful'] 	 	 = 'Impossibile Resettare Password';

// Activation
$lang['activate_successful'] 		  	     = 'Account Attivato';
$lang['activate_unsuccessful'] 		 	     = 'Impossibile Attivare Account';
$lang['deactivate_successful'] 		  	     = 'Account Disattivato';
$lang['deactivate_unsuccessful'] 	  	     = 'Impossibile Disattivare Account';
$lang['activation_email_successful'] 	  	 = 'Email di Attivazione Inviata';
$lang['activation_email_unsuccessful']   	 = 'Impossibile Inviare Email di Attivazione';

// Login / Logout
$lang['login_successful'] 		  	         = 'Logged In con Successo';
$lang['login_unsuccessful'] 		  	     = 'Login Incorretto';
$lang['login_unsuccessful_not_active'] 		 = 'Account non attivo';
$lang['login_timeout']                       = 'Temporaneamente bloccato. Prova piu\' tardi.';
$lang['logout_successful'] 		 	         = 'Logout con Successo';

// Account Changes
$lang['update_successful'] 		 	         = 'Informazioni Account Aggiornate con Successo';
$lang['update_unsuccessful'] 		 	     = 'Impossibile Aggiornare Informazioni Account';
$lang['delete_successful']               = 'User Cancellato';
$lang['delete_unsuccessful']           = 'Impossibile Cancellare User';

// Groups
$lang['group_creation_successful']  = 'Gruppo creato con Successo';
$lang['group_already_exists']       = 'Nome di Gruppo gia\' utilizzato';
$lang['group_update_successful']    = 'Dettagli Gruppo Aggiornati';
$lang['group_delete_successful']    = 'Gruppo Cancellato';
$lang['group_delete_unsuccessful'] 	= 'Impossibile Cancellare Gruppo';
$lang['group_delete_notallowed']    = 'Impossibile cancellare il gruppo amministratori';
$lang['group_name_required'] 		= 'Il nome del gruppo e\' un campo obbligatorio';
$lang['group_name_admin_not_alter'] = 'Il nome del gruppo Admin non puo\' essere modificato';

// Activation Email
$lang['email_activation_subject']            = 'Attivazione Account';
$lang['email_activate_heading']    = 'Attivazione Account per %s';
$lang['email_activate_subheading'] = 'Prego seguire questo link per %s.';
$lang['email_activate_link']       = 'Attivare il tuo Account';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Verificazione Password Dimenticata';
$lang['email_forgot_password_heading']    = 'Reset Password per %s';
$lang['email_forgot_password_subheading'] = 'Prego seguire questo link per %s.';
$lang['email_forgot_password_link']       = 'Resettare la tua Password';

// New Password Email
$lang['email_new_password_subject']          = 'Nuova Password';
$lang['email_new_password_heading']    = 'Nuova Password per %s';
$lang['email_new_password_subheading'] = 'La tua password e\' stata resettata a: %s';
