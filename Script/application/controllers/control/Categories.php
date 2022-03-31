<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Categories extends Admin_Core_Controller
	{

	    protected $model            = 'categories_model';
	    protected $columns_prefix   = 'category';
	    protected $sitemap_prefix   = 'categories';


		public function __construct()
		{
			Parent::__construct();

			$this->load->model('control/categories_model');

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
			extract($this->categories_model->get($uri_params));
			$page_title       = lang('ui_categories');
			$partial          = '_categories';
			$breadcrumbs 	  = "Kontrol / {$page_title}";
			$filters_base_url = base_url('control/categories/orderby');
			$this->load->view('control/items', compact('page_title',
													   'partial',
													   'breadcrumbs',
													   'categories',
													   'pagination',
													   'order',
                                                       'filters_base_url'));
		}




		public function add()
		{
			$this->form_validation->set_rules('name', 'Category name', 
													  'required|trim|strip_tags|max_length[50]|is_unique[categories.category_title]')
								  ->set_rules('order', 'Category order', 
													   'greater_than_equal_to[0]|numeric|trim|strip_tags')
								  ->set_rules('description', 'Category description',
								  							 'trim|strip_tags|max_length[200]');
			if($this->form_validation->run())
			{
				$name 		 = $this->input->post('name', TRUE);
				$order 		 = $this->input->post('order', TRUE);
				$description = $this->input->post('description', TRUE);	
				$slug 		 = url_title($name, '-', TRUE);
				$category_data = [$name, $slug, $order, $description];

				$response = $this->categories_model->add($category_data);
				
				if($response)
                {
                    $loc     = base_url("posts/category/{$slug}");
                    $lastmod = date('Y-m-d H:i:s');

                    $sitemap_url = "<url><loc>{$loc}</loc><lastmod>{$lastmod}</lastmod></url>";

                    $this->sitemap_add($sitemap_url);
                }

				$this->form_response = $response
                                 	   ? ['type' => 'success', 'response' => 'Berhasil!']
                                 	   : ['type' => 'error', 'response' => 'Error!'];
			}
			else
			{
				$this->form_response = ['type' 	 => 'error',
								  	    'response' => $this->form_validation->error_array()];
			}

			$this->session->set_flashdata('form_response', $this->form_response);

			redirect('control/categories');
		}




		public function update()
		{
			$this->form_validation->set_rules('name', 'Category name', 
													  'required|trim|strip_tags|max_length[50]')
								  ->set_rules('order', 'Category order', 
													   'greater_than_equal_to[0]|numeric|trim|strip_tags')
								  ->set_rules('description', 'Category description',
								  						'trim|strip_tags|max_length[200]')
								  ->set_rules('id', 'Category id', 
													'required|numeric|trim|strip_tags');
			if($this->form_validation->run())
			{
				$name 		   = $this->input->post('name', TRUE);
				$id 		   = $this->input->post('id', TRUE);

				$category_data = [
					'category_title' => $name,
					'category_slug' => url_title($name, '-', TRUE),
					'category_order' => $this->input->post('order', TRUE),
					'category_description' => $this->input->post('description', TRUE),
					'category_updated_at' => date('Y-m-d H:i:s')
				];

				$is_unique = $this->categories_model->is_unique('categories', 
							 ['id !=', 'category_title'],  [$id, $name]);

				if(!$is_unique)
				{
					$this->form_response = ['type' 	   => 'error', 
											'response' => "Category [$name] already exists"];
					$this->session->set_flashdata('form_response', $this->form_response);
					redirect('control/categories');
				}

				$response = $this->categories_model->update($id, $category_data);
				
				if($response)
                	$this->sitemap_regenerate();

				$this->form_response = $response
									   ? ['type' => 'success', 'response' => 'Berhasil!']
									   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];
			}
			else
			{
				$this->form_response = ['type' 	   => 'error',
								  	    'response' => $this->form_validation->error_array()];
			}

			$this->session->set_flashdata('form_response', $this->form_response);
			
			redirect('control/categories');
		}




		public function delete($ids)
		{
			if(!$ids_arr = json_decode($ids))
				show_404();

            $response = $this->categories_model->move_to_trash($ids_arr);

            if($response)
                	$this->sitemap_regenerate();

            $this->form_response = $response
                                   ? ['type' => 'success', 'response' => 'Berhasil!']
                                   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];

            $this->session->set_flashdata('form_response', $this->form_response);
            
            redirect("control/categories");
		}
	}