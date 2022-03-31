<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Subscribers_model extends CI_Model
	{


		public function __construct()
		{
			$this->load->database();
		}




		public function add(array $subscriber_data)
		{
			$insert_query = $this->db->insert_string('subscribers', $subscriber_data);
			
			$insert_query = str_replace('INSERT INTO',
										'INSERT IGNORE INTO',
										$insert_query);

			return $this->db->query($insert_query);
		}
		
		
















	}