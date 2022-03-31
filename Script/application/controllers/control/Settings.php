<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Settings extends Admin_Core_Controller
  	{
	    protected $model            = 'settings_model';
			protected $columns_prefix   = 'setting';

		function __construct()
		{
			Parent::__construct();

			if(! check_permission()) redirect('control/dashboard');
		}


		public function index($page = 'general')
		{
			if(strtolower($page) === 'points_and_withdrawals' && !is_main()) show_404();

			$this->view($page);
		}


		public function update_general()
		{
			if($this->input->method() === 'post')
			{
				$config['upload_path']       = FCPATH.'assets/images/';
				$config['allowed_types']     = 'gif|jpg|jpeg|png|ico|svg';
				$config['file_ext_tolower']  = TRUE;
				$config['encrypt_name'] 	 = FALSE;
				$config['overwrite']         = TRUE;
				$this->load->library('upload');
				$data   = array_map('trim', $this->input->post());
				$data   = array_map('strip_tags', $data);
				$this->form_validation->set_rules('site_author_email', 'Email', 'valid_email')
																	->set_rules('site_posts_per_page', 'numeric|greater_than_equal_to[10]')
										->set_rules('site_style', 'Style', 'regex_match[/(light|dark)/]')
										->set_rules('site_template', 'Template', 'regex_match[/(default|opoin)/]');

				if($this->form_validation->run())
				{
					$data['site_comments_moderation'] = isset($_POST['site_comments_moderation']) ? 1 : 0;
					$data['site_regular_scroll'] 			= isset($_POST['site_regular_scroll']) ? 1 : 0;
					$data['site_show_posts_authors'] 	= isset($_POST['site_show_posts_authors']) ? 1 : 0;
					$data['site_show_post_author'] 		= isset($_POST['site_show_post_author']) ? 1 : 0;
					$data['site_show_post_author_at'] = isset($_POST['site_show_post_author_at']) ? 1 : 0;
					$data['site_template'] 						= $this->input->post('site_template');
					$data['site_important_note'] 			= $this->input->post('site_important_note', true);

					unset($data['allowed_ip_addresses'], $data['site_maintenance_mode']);

					$config['file_name'] = 'favicon';
					
					$this->upload->initialize($config);
					if($this->upload->do_upload('site_favicon'))
					{
						if($favicon = $this->upload->data('file_name'))
							$data['site_favicon'] = $favicon;
					}
					# ------------------------------------------------------- #
					
					$config['file_name'] = 'logo';
					
					$this->upload->initialize($config);
					if($this->upload->do_upload('site_logo'))
					{
						if($logo = $this->upload->data('file_name'))
							$data['site_logo'] = $logo;
					}
					# ------------------------------------------------------- #
					$config['file_name'] = 'cover';
					
					$this->upload->initialize($config);
					if($this->upload->do_upload('site_cover'))
					{
						if($cover = $this->upload->data('file_name'))
							$data['site_cover'] = $cover;
					}
					# ------------------------------------------------------- #
					$config['file_name'] = 'search_bg';
					
					$this->upload->initialize($config);
					if($this->upload->do_upload('site_search_bg'))
					{
							if($search_bg = $this->upload->data('file_name'))
									$data['site_search_bg'] = $search_bg;
					}
					# ------------------------------------------------------- #
					$config['file_name'] = 'left_menu_bg';
					
					$this->upload->initialize($config);
					if($this->upload->do_upload('site_left_menu_bg'))
					{
							if($left_menu_bg = $this->upload->data('file_name'))
									$data['site_left_menu_bg'] = $left_menu_bg;
					}
					# ------------------------------------------------------- #
					$response = $this->settings_model->update($data);
					

					$this->form_response = $response
																				? ['type' => 'success', 'response' => 'Berhasil!']
																				: ['type' => 'error', 'response' => 'Error!'];
								$this->cache->delete('settings');
				}
				else
				{
					$this->form_response = ['type' 	   => 'error',
											'response' => $this->form_validation->error_array()];
				}

				if(isset($_POST['site_maintenance_mode']))
				{
					if($allowed_ips = $this->input->post('allowed_ip_addresses', null))
					{
						$allowed_ips = json_encode(array_filter(array_map('trim', explode(',', $allowed_ips))));
					}

					file_put_contents(FCPATH.'.maintenance', $allowed_ips ?? '');
				}
				else
				{
					if(site_in_maintenance())
					{
						try
						{
							unlink(FCPATH.'.maintenance');
						}
						catch(\Exception $e)
						{

						}
					}
				}

				$this->session->set_flashdata('form_response', $this->form_response);
			}
			redirect('control/settings/general');
		}



		public function update($page = 'general')
		{
			if($this->input->method() === 'post')
			{
				if($page === 'points_and_withdrawals')
				{
					$this->form_validation->set_rules('points_per_post', 'Points per post', 'required|greater_than[0]|numeric')
																->set_rules('minimum_withdrawal', 'Minimum withdrawal', 'required|greater_than[0]|numeric')
																->set_rules('exchange_rate', 'Exchange rate', 'required|numeric|greater_than[10]');

					if(! $this->form_validation->run())
					{
						$this->session->set_flashdata('form_response', ['type' => 'error', 'response' => $this->form_validation->error_array()]);
						$this->session->set_flashdata('old', $_POST);

						redirect("control/settings/$page");
					}
				}

				$data   = array_map('trim', $this->input->post());
				$data   = array_map('strip_tags', $data);

				$response = $this->settings_model->update($data);
				$this->form_response = $response
																	? ['type' => 'success', 'response' => 'Berhasil!']
																	: ['type' => 'error', 'response' => 'Error!'];
			
				$this->session->set_flashdata('form_response', $this->form_response);

				$this->cache->delete('settings');
			}

			redirect("control/settings/$page");
		}



		private function view($page)
		{
			$_page       = lang("ui_{$page}") ? lang("ui_{$page}") : 'Email';
			$page_title  = lang('ui_settings').' - '.$_page;
			$partial     = '_settings';
			$breadcrumbs = 'Kontrol / '.lang('ui_settings').' / '.$_page;
			$tab 		 		 = $page;
			$settings 	 = $this->settings;

			$this->load->view('control/item', compact('page_title', 'partial', 'breadcrumbs', 'tab', 'settings'));
		}
	}