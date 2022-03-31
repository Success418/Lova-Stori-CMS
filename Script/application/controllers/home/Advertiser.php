<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Advertiser extends Home_Core_Controller
	{
    public $pages;


		function __construct()
		{
			Parent::__construct();

      if(! is_member()) show_404();

      $this->load->model(['home/pages_model']);

      $this->pages = $this->pages_model->get_pages();
		}




		public function index()
		{
			$user_id 		 = $_SESSION['user_id'];

			$pages 			 = $this->pages;
      $menu_items  = $this->get_menu_items();
			$metadata 	 = $this->metadata();
			$compaigns   = $this->db->query("SELECT compaigns.*, IF(compaigns.views >= round(compaigns.budget / ads.price), 1, 0) AS finished
																			 FROM compaigns USE INDEX(user_id) 
																			 LEFT JOIN ads USE INDEX(ref) ON compaigns.ad_ref = ads.ref
																			 WHERE user_id = ? 
																			 ORDER BY id DESC LIMIT 5", [$user_id])->result_object();

			$totals = $this->db->query("SELECT 
									IFNULL((SELECT COUNT(id) FROM compaigns WHERE user_id = ? AND active = 1), 0) AS compaigns,
									IFNULL((SELECT SUM(budget) FROM compaigns WHERE user_id = ? AND active = 1), 0) AS expenses,
									IFNULL((SELECT user_ad_balance FROM users WHERE id = ?), 0) AS balance,
									IFNULL((SELECT SUM(views) FROM compaigns WHERE user_id = ? AND active = 1), 0) AS views", [$user_id, $user_id, $user_id, $user_id])->row();
            
            
			return $this->load->view('templates/opoin/advertiser/dashboard', compact('metadata', 'menu_items', 'compaigns', 'pages', 'totals'));
		}



		public function advertise()
		{
			$pages 			 = $this->pages;
			$menu_items  = $this->get_menu_items();
			$metadata 	 = $this->metadata();
			$refs 			 = $this->db->query("SELECT ref, price from ads")->result_object();

			$refs_names = implode(',', array_column((array)$refs, 'ref'));

			if($this->input->method() === 'post')
			{
				$this->form_validation->set_rules('ad_ref', 'Ad ref', "required|in_list[$refs_names]")
														  ->set_rules('ad_name', 'Ad name', 'required|trim|strip_tags|min_length[3]|max_length[255]')
														  ->set_rules('ad_url', 'Ad url', 'required|trim|strip_tags|valid_url');

				if($ad_budget = $this->input->post('ad_budget'))
				{
					$this->form_validation->set_rules('ad_budget', 'Ad budget', "required|numeric|greater_than_equal_to[50000]");
				}
				else
				{
					$this->form_validation->set_rules('ad_custom_budget', 'Ad custom budget', "required|numeric|greater_than_equal_to[50000]");

					$ad_budget = $this->input->post('ad_custom_budget');
				}

				if($this->form_validation->run())
				{
					$compaign_id  = get_auto_increment('compaigns');

					$config['file_name']         = url_title($this->input->post('ad_name'), '-', true).'-'.$compaign_id;
	        $config['upload_path']       = FCPATH.'uploads/banners/';
	        $config['allowed_types']     = 'jpg|jpeg|png';
	        $config['file_ext_tolower']  = TRUE;
	        $config['overwrite']         = TRUE;
	        $config['max_size']          = 10*1024*1024; // (10mb)


	        $this->load->library('upload', $config);

	        if($this->upload->do_upload('ad_banner'))
	        {
	          $image = $this->upload->data('file_name');

	          $compaign = [
	          	'name' => $this->input->post('ad_name', true),
	          	'link' => $this->input->post('ad_url', true),
	          	'image' => $image,
	          	'user_id' => $_SESSION['user_id'],
	          	'ad_ref' => $this->input->post('ad_ref', true),
	          	'budget' => $ad_budget,
	          	'active' => 0
	          ];

	          $this->db->insert('compaigns', $compaign);

	          $this->form_response = ['type' => 'success', 'response' => 'Selesai!, Kampanye iklan Anda sedang menunggu verifikasi dari Administrator.'];

						$this->session->set_flashdata('form_response', $this->form_response);
	        }
	        else
	        {
	        	$this->form_response = ['type' => 'error', 'response' => $this->upload->display_errors()];

	          $this->session->set_flashdata('form_response', $this->form_response);
	          $this->session->set_flashdata('old', $_POST);
	        }
				}
				else
				{
					$this->form_response = ['type' => 'error', 'response' => $this->form_validation->error_array()];

					$this->session->set_flashdata('old', $_POST);
					$this->session->set_flashdata('form_response', $this->form_response);
				}

				redirect(base_url('advertiser/advertise'));
			}
            
            $metadata->title = 'Buat Iklan';
            
			return $this->load->view('templates/opoin/advertiser/advertise', compact('metadata', 'menu_items', 'refs', 'pages'));
		}



		public function compaigns()
		{
			$user_id 		 = $_SESSION['user_id'];
			$pages 			 = $this->pages;
			$menu_items  = $this->get_menu_items();
			$metadata 	 = $this->metadata();
			$compaigns	 = $this->db->query("SELECT compaigns.*, IF(compaigns.views >= round(compaigns.budget / ads.price), 1, 0) AS finished 
																			 FROM compaigns USE INDEX(user_id)
																			 LEFT JOIN ads USE INDEX(ref) ON compaigns.ad_ref = ads.ref
																			 WHERE user_id = ?
																			 ORDER BY id DESC", 
																			[$user_id])->result_object();

			return $this->load->view('templates/opoin/advertiser/compaigns', compact('metadata', 'menu_items', 'compaigns', 'pages'));
		}




		private function metadata()
		{
			$metadata = new stdClass();

			$metadata->title 	   = lang('ui_advertiser');
			$metadata->site_name = $this->settings['site_name'];
			$metadata->description = $this->settings['site_description'];
			$metadata->keywords  = $this->settings['site_keywords'];
			$metadata->favicon 	 = $this->settings['site_favicon'];
			$metadata->image 	 	 = base_url("assets/images/{$this->settings['site_cover']}");
			$metadata->logo 	 	 = $this->settings['site_logo'];
			$metadata->type 	 	 = 'website';
			$metadata->url 		 	 = current_url();
			$metadata->canonical = current_url();
			$metadata->author 	 = "{$this->settings['site_admin_name']}, {$this->settings['site_admin_email']}";
			$metadata->rating    = 'general';
			$metadata->date	 	   = '';

			return $metadata;
		}

}