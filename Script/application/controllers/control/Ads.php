<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Ads extends Admin_Core_Controller
	{
	    protected $form_response;
	    protected $model = 'ads';


		function __construct()
		{
			Parent::__construct();
			
			if(! is_main()) show_404();

			$this->load->model('control/ads_model');
		}



		public function index()
		{
			$ads = $this->db->query("SELECT * FROM ads")->result_object();

			$page_title        = 'Iklan';
			$partial           = '_ads';
			$breadcrumbs       = "Kontrol / $page_title";
			$filters_base_url  = base_url('control/ads');

          	
      $this->load->view('control/items', compact('page_title',
                                                 'partial',
                                                 'ads',
                                                 'breadcrumbs',
                                                 'filters_base_url'));
		}


		public function update()
		{
			$id 		= $this->input->post('id');
			$price 	= $this->input->post('price');

			if(!ctype_digit($id) || !ctype_digit($price)) return;

			return $this->db->query("UPDATE ads SET price = ? WHERE id = ?", [$price, $id]);
		}

	}