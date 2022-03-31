<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Sitemaps extends Admin_Core_Controller
	{
		private $db_inf = [
			'posts' => 'post',
			'pages' => 'page',
			'subcategories' => 'subcategory',
			'categories' => 'category'
		];




		function __construct()
		{
			Parent::__construct();
		}




		public function index()
		{
			$page_title  = lang('ui_sitemaps_generator');
			$partial 	 = '_sitemaps';
			$breadcrumbs = 'Kontrol / '.lang('ui_sitemaps_generator');

            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs'));
		}



		
		public function generate()
		{			
			if($this->input->method() != 'post')
				show_404();

			$this->load->model(['control/posts_model', 
								'control/pages_model', 
								'control/categories_model', 
								'control/subcategories_model']);

			$this->form_validation->set_rules('items', 'Items type', 
				'required|trim|strip_tags|regex_match[/(posts|pages|categories|subcategories)/]');

			if($this->form_validation->run())
			{
				$items = $this->input->post('items', TRUE);

				$model_name = "{$items}_model";
				$sitemap_urls = $this->$model_name
				                      ->get_sitemap_urls($items,
														 $this->db_inf[$items]);
				if($sitemap_urls)
				{
					$sitemap_urls = array_column($sitemap_urls, 'url');

					$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.implode('', $sitemap_urls).'</urlset>';

					$file = "{$_SERVER['DOCUMENT_ROOT']}/{$items}-sitemap.xml";

					file_put_contents($file, $xml);
				}

				$form_response = ['type' => 'success', 'response' => 'Berhasil!'];
			}
			else
			{
				$form_response = ['type' => 'error', 'response' => $this->form_validation->error_array()];
			}

			$this->session->set_flashdata('form_response', $form_response);

			redirect('control/sitemaps');
		}




		public function read($file_name)
		{
			$file = "{$_SERVER['DOCUMENT_ROOT']}/{$file_name}-sitemap.xml";

			if(file_exists($file))
			{
				$this->output
			         ->set_content_type('text/xml')
			         ->set_output(file_get_contents($file));
			}
		}




		public function download($file_name)
		{
			$file = "{$_SERVER['DOCUMENT_ROOT']}/{$file_name}-sitemap.xml";

			if(file_exists($file))
			{
				$this->load->helper('download');
				
				force_download($file, NULL);
			}
		}

	}