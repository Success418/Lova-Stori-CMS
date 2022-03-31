<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Comments extends Admin_Core_Controller
	{
	    protected $form_response;
	    protected $model            = 'comments_model';
	    protected $columns_prefix   = 'comment';



		function __construct()
		{
			Parent::__construct();

			$this->load->model('control/comments_model');
			
			if(!check_permission())
                redirect('control/dashboard');
		}



		public function index()
		{
			$uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);

			$order = $uri_params['order'];

			if($order === 'desc') $order = 'asc';
			elseif($order === 'asc') $order = 'desc';
			else $order = 'asc';

			extract($this->comments_model->get($uri_params));

			$page_title        = lang('ui_commentar');
			$partial           = '_comments';
			$breadcrumbs       = "Kontrol / $page_title";
			$filters_base_url  = base_url('control/comments/orderby');

			$comments_bodies = array_column($comments, 'comment_body');
			$comments_ids 	 = array_column($comments, 'id');
			$comments_texts  = array_combine($comments_ids, $comments_bodies);
			$comments_texts  = array_map('nl2br', $comments_texts);
			$comments_texts  = json_encode($comments_texts);
          	
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'comments',
                                                       'comments_texts',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
		}




		public function delete($ids)
		{
			if(!$ids_arr = json_decode($ids))
                show_404();

            $response = $this->comments_model->move_to_trash($ids_arr);

            $this->form_response = $response
                                   ? ['type' => 'success', 'response' => 'Berhasil!']
                                   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];

            $this->session->set_flashdata('form_response', $this->form_response);

            redirect("control/comments");
		}

	}