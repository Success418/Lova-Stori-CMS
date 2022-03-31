<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Pages extends Admin_Core_Controller
	{
		protected $model 			= 'pages_model';
		protected $columns_prefix   = 'page';
		protected $sitemap_prefix   = 'pages';

		public function __construct()
        {
            parent::__construct();
            
            $this->load->model('control/pages_model');
           	check_permission(function($response) {
           		$allowed_methods = in_array($this->router->method, 
           									['search', 'get_by_author']);
           		           		
           		if($allowed_methods) return TRUE;
           		
           		if(!$response) redirect('control/dashboard');
			});
        }
		public function index()
		{
			$uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);
 
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->pages_model->get($uri_params));
            $authors		   = $this->pages_model->authors();
          	$page_title        = lang('ui_pages');
            $partial           = '_pages';
          	$breadcrumbs       = "Kontrol / {$page_title}";
          	$filters_base_url  = base_url('control/pages/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'authors',
                                                       'pages',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
		}
		public function add()
		{
			if($this->input->method() === 'post')
			{				
				$page_in   = $this->input->post('page_in', TRUE);
				$in_menu   = 0;
				$in_footer = 0;
				
				if(is_array($page_in))
				{
					$options = array_flip($page_in);
					
					$in_menu 	= isset($options['menu']) ? 1 : 0;
					$in_footer 	= isset($options['footer']) ? 1 : 0;
				}
				
				$this->form_validation->set_rules('page_title', 'Title', 
												  'required|trim|strip_tags|is_unique[pages.page_title]')
									  ->set_rules('page_summary', 'Summary', 
												  'trim|strip_tags')
									  ->set_rules('page_keywords', 'Keywords',
												  'trim|strip_tags')
									  ->set_rules('page_show_in', 'Show in', 
									  			  'trim|strip_tags')
									  ->set_rules('page_body', 'Content', 'required|trim|base64_decode');
				if($this->form_validation->run())
				{
					$page = [
						'page_title' 	 => $this->input->post('page_title', TRUE),
						'page_summary'   => $this->input->post('page_summary', TRUE),
						'page_keywords'  => $this->input->post('page_keywords', TRUE),
						'page_in_menu'   => $in_menu,
						'page_in_footer' => $in_footer,
						'page_body' 	 => $this->input->post('page_body', FALSE),
						'page_visible' 	 => isset($_POST['publish']) ? 1 : 0,
						'page_author_id' => $_SESSION['user_id']
					];
					
					$page['page_slug'] = url_title($page['page_title'], '-', TRUE);
					
					$response = $this->pages_model->add($page);

					if($response)
                    {
                        $loc     = base_url("page/{$page['page_slug']}");
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
					$this->form_response = ['type' 	   => 'error',
									  	    'response' => $this->form_validation->error_array()];
				}
				$this->session->set_flashdata('form_response', $this->form_response);
				if($this->form_response['type'] === 'success')
	            {
	                $destination = 'pages';
	            }
	            else
	            {
	                $this->session->set_flashdata($this->input->post());
	                $destination = 'pages/add';
	            }
				redirect("control/{$destination}");
			}
			$page_title     = lang('ui_pages').' - '.lang('ui_add');
            $partial        = '_page';
        	$breadcrumbs    = 'Kontrol / '.lang('ui_pages').' / '.lang('ui_add');
        	
        	$this->load->view('control/item', compact('page_title', 
                                                      'partial', 
                                                      'breadcrumbs'));
		}




		public function update(int $page_id)
		{
			$page_title     = lang('ui_pages').' - '.lang('ui_edit');
            $partial        = '_page_edit';
        	$breadcrumbs    = 'Kontrol / '.lang('ui_pages').' / '.lang('ui_edit');
        	
        	if($this->input->method() === 'post')
        	{
        		$page_data = json_decode(base64_decode($this->input->post('page_data')));
	            if(!$page_data)
	                redirect("control/pages/edit/{$page_id}");
	            # -------------------------------------------------------------- #
	            $page_in   = $this->input->post('page_in', TRUE);
				$in_menu   = 0;
				$in_footer = 0;
				if(is_array($page_in))
				{
					$options = array_flip($page_in);
					
					$in_menu 	= isset($options['menu']) ? 1 : 0;
					$in_footer 	= isset($options['footer']) ? 1 : 0;
				}
				$_POST['title_is_unique'] = 1;
				if($this->input->post('page_title') != $page_data->title)
				{
					$columns = ['id !=', 'page_title'];
					$values  = [$page_id, $this->input->post('page_title', TRUE)];
					$_POST['title_is_unique'] = $this->pages_model->is_unique('pages',
																	$columns, $values)
												? 1 : 0;
				}
				$this->form_validation->set_rules('page_title', 'Title', 
												  'required|trim|strip_tags')
									  ->set_rules('page_summary', 'Summary', 
												  'trim|strip_tags')
									  ->set_rules('page_keywords', 'Keywords',
												  'trim|strip_tags')
									  ->set_rules('page_show_in', 'Show in', 
									  			  'trim|strip_tags')
									  ->set_rules('page_body', 'Content', 'required|trim|base64_decode')
									  ->set_rules('title_is_unique', 'Title unique', 
									  			  'is_natural_no_zero', 
									  			  ['is_natural_no_zero' => 'Judul halaman sudah ada']);
				if($this->form_validation->run())
				{
				    $page_title = $this->input->post('page_title', TRUE);
				    
					$page = [
						'page_title' 	 => $page_title,
						'page_summary'   => $this->input->post('page_summary', TRUE),
						'page_keywords'  => $this->input->post('page_keywords', TRUE),
						'page_in_menu'   => $in_menu,
						'page_in_footer' => $in_footer,
						'page_body' 	 => $this->input->post('page_body', FALSE),
						'page_slug'  	 => url_title($page_title, '-', TRUE),
						'page_updated_at' => date('Y-m-s H:i:s')
					];
                    
					$response = $this->pages_model->update($page_data->id, $page);
					
					if($response)
	                {
	                    $page_x_slug = url_title($page_data->title, '-', TRUE); 
	                    $loc         = base_url("page/{$page['page_slug']}");
	                    $lastmod     = date('Y-m-d H:i:s');
	                    $item_slug   = base_url("page/{$page_x_slug}");

	                    $sitemap_url = "<url><loc>{$loc}</loc><lastmod>{$lastmod}</lastmod></url>";

	                    $this->sitemap_update($item_slug, $sitemap_url);
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
            	if($this->form_response['type'] === 'success')
	            {
	                $destination = 'pages';
	            }
	            else
	            {
	                $this->session->set_flashdata($this->input->post());
	                $destination = "pages/edit/{$page_data->id}";
	            }
				redirect("control/{$destination}");
        	}
        	
        	if(!$page = $this->pages_model->get_page(['pages.id' => $page_id]))
                redirect(base_url('control/pages'));
                
        	$this->load->view('control/item', compact('page_title', 
                                                      'partial',
                                                      'page',
                                                      'breadcrumbs'));
		}




		public function get_by_author()
        {
        	$uri_params = $this->uri->uri_to_assoc(3, ['page', 'id', 'category']);
            $order      = 'asc';
            extract($this->pages_model->get_by_author($uri_params));
            $authors		   = $this->pages_model->authors();
          	$page_title        = lang('ui_pages');
            $partial           = '_pages';
          	$breadcrumbs       = 'Control / '.lang('ui_pages');
          	$filters_base_url  = base_url('control/pages/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'authors',
                                                       'pages',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
        }



        public function search()
        {
        	$uri_params = $this->uri->uri_to_assoc(3, ['page', 'search']);
            $order      = 'asc';
            extract($this->pages_model->search($uri_params));
            $authors		   = $this->pages_model->authors();
          	$page_title        = lang('ui_pages');
            $partial           = '_pages';
          	$breadcrumbs       = 'Control / '.lang('ui_pages');
          	$filters_base_url  = base_url('control/pages/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'authors',
                                                       'pages',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url',
                                                       'categories'));
        }



        public function delete($ids)
		{	
			if(!$ids_arr = json_decode($ids))
				show_404();

            $response = $this->pages_model->move_to_trash($ids_arr);

            if($response)
                $this->sitemap_regenerate();
            
            $this->form_response = $response
                                   ? ['type' => 'success', 'response' => 'Berhasil!']
                                   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];

            $this->session->set_flashdata('form_response', $this->form_response);
            
            redirect("control/pages");
		}
	}