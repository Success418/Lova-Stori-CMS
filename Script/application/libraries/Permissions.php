<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Permissions
	{

		private function get()
		{
			$CI =& get_instance();

			$CI->load->library('session')
            		 ->model('control/settings_model')
            		 ->driver('cache', 
                              ['adapter' => 'apc', 'backup' => 'file']);

           	if (!$settings = $CI->cache->get('settings'))
            {
                $settings = $CI->settings_model->get_settings();
            }
           	
           	return json_decode($settings['site_permissions']);
		}




		public function check($controller, $action = NULL)
		{
			$permissions = $this->get();

			if(!$permissions || !is_logged_in())
				show_404();

			$user_role = $_SESSION['user_role'];

			return $permissions->$user_role;
		}











	}