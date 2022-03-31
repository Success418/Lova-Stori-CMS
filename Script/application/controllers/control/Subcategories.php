<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Subcategories extends Admin_Core_Controller
    {
        protected $model            = 'subcategories_model';
        protected $columns_prefix   = 'subcategory';
        protected $sitemap_prefix   = 'subcategories';

		public function __construct()
		{
			Parent::__construct();
			$this->load->model(['control/subcategories_model', 
                                'control/categories_model']);

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
			$categories       = $this->categories_model->get_names_and_ids();
			$page_title  	  = lang('ui_subcategories');
            $partial          = '_subcategories';
			$breadcrumbs 	  = "Kontrol / {$page_title}";
            $filters_base_url = base_url('control/subcategories/orderby');
            extract($this->subcategories_model->get($uri_params));
			$this->load->view('control/items', compact('page_title',
                                                       'partial',
													   'breadcrumbs',
													   'subcategories',
                                                       'pagination',
													   'categories',
                                                       'order',
                                                       'filters_base_url'));
		}




        public function add()
        {
        	$this->form_validation->set_rules('name', 'Subcategory name', 
        									  		  'required|trim|strip_tags|max_length[50]|is_unique[subcategories.subcategory_title]')
        						  ->set_rules('order', 'Subcategory order', 
        						  					   'greater_than_equal_to[0]|numeric|trim|strip_tags')
        						  ->set_rules('parent_id', 'Subcategory parent id', 
        						  					   'greater_than_equal_to[0]|numeric|trim|strip_tags')
        						  ->set_rules('description', 'Subcategory description',
                                                             'trim|strip_tags|max_length[200]');
        	if($this->form_validation->run())
        	{
	        	$name 		 = $this->input->post('name', TRUE);
	        	$order 		 = $this->input->post('order', TRUE);
	        	$description = $this->input->post('description', TRUE);
                $parent_id   = $this->input->post('parent_id', TRUE);
	        	$slug 		 = url_title($name, '-', TRUE);
                $subcategory_data = [$name, $slug, $order, $parent_id, $description];

	        	$response = $this->subcategories_model->add($subcategory_data);

                if($response)
                {
                    $loc     = base_url("posts/subcategory/{$slug}");
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
                $this->form_response = ['type'     => 'error',
                                        'response' => $this->form_validation->error_array()];
        	}
            $this->session->set_flashdata('form_response', $this->form_response);
        	redirect('control/subcategories/');
        }




        public function update()
        {
        	$this->form_validation->set_rules('name', 'Category name', 
        									  		  'required|trim|strip_tags')
        						  ->set_rules('order', 'Category order', 
        						  					   'greater_than_equal_to[0]|numeric|trim|strip_tags')
                                  ->set_rules('parent_id', 'Subcategory parent id', 
                                                       'greater_than_equal_to[0]|numeric|trim|strip_tags')
        						  ->set_rules('description', 'Subcategory description',
                                                             'trim|strip_tags|max_length[200]')
                                  
        						  ->set_rules('id', 'Category id', 
        						  			  		'required|numeric|trim|strip_tags');
        	if($this->form_validation->run())
        	{
	        	$subcategory_title = $this->input->post('name', TRUE);
	        	$subcategory_id   = $this->input->post('id', TRUE);

                $subcategory_data = [
                    'subcategory_title' => $subcategory_title,
                    'subcategory_slug' => url_title($subcategory_title, '-', TRUE),
                    'subcategory_order' => $this->input->post('order', TRUE),
                    'subcategory_parent_id' => $this->input->post('parent_id', TRUE),
                    'subcategory_description' => $this->input->post('description', TRUE),
                    'subcategory_updated_at' => date('Y-m-d H:i:s')
                ];

                $is_unique = $this->subcategories_model->is_unique('subcategories', ['id !=', 'subcategory_title'],  [$subcategory_id, $subcategory_title]);

                if(!$is_unique)
                {
                    $this->form_response = ['type'     => 'error', 
                                            'response' => "Subcategory [$subcategory_title] already exists"];

                    $this->session->set_flashdata('form_response', $this->form_response);

                    redirect('control/subcategories');
                }

	        	$response = $this->subcategories_model->update($subcategory_id,
                                                        $subcategory_data);

                if($response)
                    $this->sitemap_regenerate();

                $this->form_response = $response
                                 ? ['type' => 'success', 'response' => 'Done!']
                                 : ['type' => 'error', 'response' => "Subcategory [$subcategory_title] already exists"];
        	}
        	else
	        {
                $this->form_response = ['type'     => 'error',
                                  'response' => $this->form_validation->error_array()];
        	}
            $this->session->set_flashdata('form_response', $this->form_response);
        	redirect('control/subcategories/');
        }




        public function delete($ids)
        {
            if(!$ids_arr = json_decode($ids))
                show_404();

            $response = $this->subcategories_model->move_to_trash($ids_arr);

            if($response)
                $this->sitemap_regenerate();

            $this->form_response = $response
                                   ? ['type' => 'success', 'response' => 'Berhasil!']
                                   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];

            $this->session->set_flashdata('form_response', $this->form_response);

            redirect("control/categories");
        }
        
	}