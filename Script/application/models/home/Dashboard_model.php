<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Dashboard_model extends Home_Core_Model
	{


		public function update_analytics(array $analytics)
		{
			$this->db->update('analytics', $analytics);
		}




		public function get_analytics()
		{
			return $this->db->select('analytics_browsers, 
									  analytics_operating_systems,
									  analytics_robots,
									  analytics_screen_sizes')
						    ->from('analytics USE INDEX(PRIMARY)')
						    ->get()->row();
		}




        public function update_traffic_origins()
		{
			$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');

			$ip_address = $this->input->ip_address();

			$data = $maxmind_reader->get($ip_address);

			$iso_code = $data['country']['iso_code'] ?? 'unknown';

			$properties = 'traffic_iso_codes, traffic_created_at';
			$changes 	= "traffic_iso_codes = CONCAT(traffic_iso_codes, '|{$iso_code}')";

			$this->db->query("INSERT INTO traffic ($properties) VALUES('$iso_code', CURDATE()) ON DUPLICATE KEY UPDATE $changes");
		}
	}
