<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Subscribers extends Home_Core_Controller
	{
		public function __construct()
		{
			Parent::__construct();
			$this->load->model('home/subscribers_model');
		}
		
		public function add()
		{
			if(!isset($_SERVER['HTTP_REFERER']))
				show_404();
			$email = $this->input->post('email', TRUE);
			if(! filter_var($email, FILTER_VALIDATE_EMAIL))
				redirect($_SERVER['HTTP_REFERER']);
			$iso_code = NULL;
			if($ip = $this->input->ip_address())
			{
				$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');
				$data 			= $maxmind_reader->get($ip);
				$iso_code 		= $data['country']['iso_code'] ?? NULL;
			}
			$data = ['subscriber_email' 	=> $email, 
					 'subscriber_ip' 		=> $ip,
					 'subscriber_country' 	=> $iso_code];
			$this->subscribers_model->add($data);
			
			$this->session->set_flashdata('subscription',
						    ['type' => 'success', 'response' => 'Berhasil!']);
			redirect("{$_SERVER['HTTP_REFERER']}#newsletter");
		}
		
		public function add_async()
		{
			$email = $this->input->post('email', TRUE);
			
			if(! filter_var($email, FILTER_VALIDATE_EMAIL))
			{
			    $this->output->set_content_type('application/json')
                             ->set_output(json_encode(['status' => false]));
			}
				
			$iso_code = NULL;
			
			if($ip = $this->input->ip_address())
			{
				$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');
				$data 			= $maxmind_reader->get($ip);
				$iso_code 		= $data['country']['iso_code'] ?? NULL;
			}
			
			$data = ['subscriber_email' 	=> $email, 
					 'subscriber_ip' 		=> $ip,
					 'subscriber_country' 	=> $iso_code];
					 
			$this->subscribers_model->add($data);
			
			$this->output->set_content_type('application/json')
                             ->set_output(json_encode(['status' => true]));
		}
	}