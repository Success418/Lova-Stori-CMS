<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Payments extends Admin_Core_Controller
	{
	    protected $form_response;
	    protected $model = 'payments_model';


		function __construct()
		{
			Parent::__construct();
			
			if(! is_main()) show_404();

			$this->load->model('control/payments_model');
		}



		public function index()
		{
			$uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);

			$order = $uri_params['order'];

			if($order === 'desc') $order = 'asc';
			elseif($order === 'asc') $order = 'desc';
			else $order = 'asc';

			extract($this->payments_model->get($uri_params));

			$page_title        = lang('ui_payment_requests');
			$partial           = '_payments';
			$breadcrumbs       = "Kontrol / $page_title";
			$filters_base_url  = base_url('control/payments/orderby');

          	
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'payments',
                                                       'breadcrumbs',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
		}





	}