<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once(APPPATH.'vendor/autoload.php');



	class Mailer
	{
		private $mailer;
		private $sender = 'Admin';
        public $error_missing_params = FALSE;



		public function init($config = [])
		{
			$config_keys = ['site_smtp_host', 'site_smtp_port', 'site_smtp_crypto', 'site_smtp_user', 'site_smtp_pass'];
			settype($config, 'array');
            
			if(!array_keys_exist($config_keys, $config))
				show_error('Bad config params for Mailer constructor', 'Mailer error');
        
            $set_params = array_filter($config_keys, function($v) use ($config)
            {
                return isset($config[$v]);
            }, ARRAY_FILTER_USE_BOTH);
            
            if(count($config_keys) != count($set_params))
                $this->error_missing_params = TRUE;
                
			$this->sender = $config['site_smtp_user'];

			$transport = (new Swift_SmtpTransport($config['site_smtp_host'], 
												  $config['site_smtp_port'],
												  $config['site_smtp_crypto']))
											->setUsername($config['site_smtp_user'])
											->setPassword($config['site_smtp_pass']);

			$this->mailer = new Swift_Mailer($transport);
			return $this;
		}




		public function send($email_data = [])
		{
		    if($this->error_missing_params)
		    {
		        if(ENVIRONMENT === 'development')
		            show_error('Username (Email), Host and Password are missing in Settings / Email', 'Mailer error');
		        else
		            redirect($_SERVER['HTTP_REFERER'] ?? '/');
		    }
		        
			settype($email_data, 'array');

			$email_data_keys = ['subject', 'to', 'body'];
			
			if( ! array_keys_exist($email_data_keys, $email_data))
			{
			    if(ENVIRONMENT === 'development')
		            show_error('Send Mailer function\'s parameter doesn\'t have the required keys', 'Mailer error');
		        else
		            redirect($_SERVER['HTTP_REFERER'] ?? '/');
			}

			$message = new Swift_Message($email_data['subject']);

			$message->setFrom([$this->sender => $email_data['name']])
				    ->setBody($email_data['body'], 'text/html')
				    ->setTo($email_data['to']);
            
			try
			{
				return $this->mailer->send($message);
			}
			catch(Exception $error)
			{
				if(ENVIRONMENT === 'development')
				{
					printr($error);
					exit;
				}
			}
		}
	}