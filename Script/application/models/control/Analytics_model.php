<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once(APPPATH.'vendor/autoload.php');


	class Analytics_model extends Admin_Core_Model
	{
		protected $columns_prefix   = 'analytics';
		protected $table 		    = 'analytics';
		



		public function __construct()
		{
			$this->load->database();
		}




		public function analytics_data()
		{
			$columns = ['analytics_browsers AS browsers', 
						'analytics_operating_systems AS operating_systems', 
						'analytics_screen_sizes AS screen_sizes',
						'analytics_robots AS robots'];

			return $this->db->select($columns)
						    ->from('analytics USE INDEX(PRIMARY)')
						    ->get()->row();
		}




		public function update_traffic_origins()
		{
			$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');

			$ip_address = $this->input->ip_address();

			$data = $maxmind_reader->get($ip_address);

			$iso_code = !is_null($data) ? $data['country']['iso_code'] :'unknown';

			$properties = 'traffic_iso_codes, traffic_created_at';
			$changes 	= "traffic_iso_codes = CONCAT(traffic_iso_codes, '|{$iso_code}')";

			$this->db->query("INSERT INTO traffic ($properties) VALUES('$iso_code', CURDATE()) ON DUPLICATE KEY UPDATE $changes");
		}




		public function get_month_traffic_data($year_month = null):array
		{
			$traffic    = [];
			$properties = 'traffic_iso_codes, EXTRACT(DAY FROM traffic_created_at) AS traffic_day';

			if(preg_match('/^\d{4}\d{2}$/', $year_month))
			{
				$condition  = "EXTRACT(YEAR_MONTH FROM traffic_created_at) = $year_month";

				$traffic = $this->db->query("SELECT $properties FROM traffic USE INDEX(traffic_created_at) WHERE EXTRACT(YEAR_MONTH FROM traffic_created_at) = $year_month")->result_object();
			}

			return $traffic;
		}




		public function get_all_traffic_data()
		{
			return $this->db->query("SELECT traffic_iso_codes FROM traffic USE INDEX(PRIMARY)")->result_object();
		}

	}