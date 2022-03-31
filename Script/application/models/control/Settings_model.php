<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Settings_model extends Admin_Core_Model
	{

		public function __construct()
        {
        	$this->load->database();
        }


		public function update($data)
		{
			return $this->db->where('id', 1)->update('settings', $data);
		
			// dd($this->db->error());
		}


			
		public function get_settings()
		{
			return $this->db->select('*')->get('settings')->row_array();
		}



	}


