<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once(APPPATH.'vendor/autoload.php');


	class Ads_model extends Admin_Core_Model
	{
		protected $columns_prefix   = 'ads';
		protected $table 		    		= 'ads';
		

		
		public function __construct()
		{
			$this->load->database();
		}




	}