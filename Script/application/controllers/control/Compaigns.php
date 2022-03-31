<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Compaigns extends Admin_Core_Controller
	{
	    protected $form_response;
	    protected $model = 'compaigns';


		function __construct()
		{
			Parent::__construct();

			if(! is_main()) show_404();

			$this->load->model('control/compaigns_model');
		}



		public function index()
		{
			$uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);
 
      $order = $uri_params['order'];

      if($order === 'desc') $order = 'asc';
      elseif($order === 'asc') $order = 'desc';
      else $order = 'asc';

      extract($this->compaigns_model->get($uri_params));

			$page_title        = 'Iklan';
			$partial           = '_compaigns';
			$breadcrumbs       = "Kontrol / $page_title";
			$filters_base_url  = base_url('control/compaigns');

          	
      $this->load->view('control/items', compact('page_title',
                                                 'partial',
                                                 'compaigns',
                                                 'breadcrumbs',
                                                 'order',
                                                 'pagination',
                                                 'filters_base_url'));
		}


		public function update()
		{
			if(!is_main()) show_404();

			$id 			= $this->input->post('id');
			$active 	= $this->input->post('active');
			$balance  = $this->input->post('balance');
			$budget   = $this->input->post('budget');
			$user_id  = $this->input->post('user_id');

			if(!ctype_digit($id) || !preg_match("/^(0|1)$/", $active)) return;

			if($active == 1 && $balance >= $budget && ctype_digit($user_id))
			{
				$this->db->query("UPDATE compaigns SET active = 1 WHERE id = ?", [$id]);
				$this->db->query("UPDATE users SET user_ad_balance = (user_ad_balance - ?) WHERE id = ?", [$budget, $user_id]);
			}
			else
			{
				return $this->db->query("UPDATE compaigns SET active = ? WHERE id = ?", [$active, $id]);
			}
		}

	}