<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Users extends Admin_Core_Controller
	{
		protected $model            = 'users_model';
		protected $columns_prefix   = 'user';

		private $uri_params 		= [];
		private $order 				= 'asc';
		private $users_type 		= '';
		private $delete_conds 		= NULL;




		function __construct()
		{
			Parent::__construct();

			$this->load->model('control/users_model');

			$this->set_delete_conds();

			if(!check_permission())
				redirect('control/dashboard');
		}



		public function index($users_type)
		{
			$this->init($users_type)->view();
		}
		



		private function init($users_type)
		{
			$uri_params = $this->uri->ruri_to_assoc(4, ['page', 'orderby', 'order']);
			$order 		= $uri_params['order'];

			if($order === 'desc') $order = 'asc';
			elseif($order === 'asc') $order = 'desc';
			else $order = 'asc';

			$this->uri_params = $uri_params;
			$this->order 	  = $order;
			$this->users_type = $users_type;

			return $this;
		}




		private function view()
		{
			extract($this->users_model->get($this->users_type, $this->uri_params));

			$page_title        = ucfirst($this->users_type);
			$partial           = "_{$this->users_type}";
			$breadcrumbs       = "Kontrol / {$page_title}";
			$order 			   = $this->order;
			$filters_base_url  = base_url("control/users/{$this->users_type}/orderby");

			$this->load->view('control/items', compact('page_title',
																									'partial',
																									'breadcrumbs',
																									'users',
																									'pagination',
																									'order',
																									'filters_base_url'));
		}




		public function add()
		{
			if($this->input->method() === 'post')
			{
				$this->form_validation->set_rules('user_name', 'Username', 
												  'trim|strip_tags|required|min_length[3]|max_length[50]|alpha_dash|is_unique[users.user_name]',
												  ['is_unique' => 'The username is not available.'])

									  ->set_rules('user_email', 'Email', 
									  			  'trim|strip_tags|required|min_length[10]|max_length[50]|valid_email|is_unique[users.user_email]',
									  			  ['is_unique' => 'The email address is not available.'])

									  ->set_rules('user_pwd', 'Password', 
									  			  'trim|strip_tags|required|min_length[3]');

				if($this->form_validation->run())
				{
					$user 			 	= [];
					$user['user_ip'] 	= $this->input->ip_address();
					$user['user_name'] 	= $this->input->post('user_name', TRUE);
					$user['user_email'] = $this->input->post('user_email', TRUE);
					$user['user_pwd'] 	= $this->input->post('user_pwd', TRUE);
					$user['user_role']  = match($this->input->post('user_role', TRUE),
										  'administrator|moderator|author', 
										  'member');

					$user['user_parent_id'] = $_SESSION['user_id'] ?? NULL;
					$user['user_active'] 	= 1;

					$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');
					$data 			= $maxmind_reader->get($user['user_ip']);
					$iso_code 		= $data['country']['iso_code'] ?? NULL;

					$user['user_country'] = $iso_code;

					$response = $this->users_model->add($user);

					$this->form_response = $response
	                                       ? ['type' => 'success', 'response' => 'Berhasil']
	                                       : ['type' => 'error', 'response' => 'Error!'];

	                $this->session->set_flashdata('form_response', $this->form_response);

					redirect('control/users/add');
				}
				else
				{
					$this->form_response = ['type'     => 'error',
                                        	'response' => $this->form_validation->error_array()];
				}
			}

			$page_title        = 'Tambahkan Member';
            $partial           = "_user";
          	$breadcrumbs       = "Kontrol / Tambahan Member";

            $this->load->view('control/item', compact('page_title',
                                                      'partial',
                                                      'breadcrumbs'));
		}



		public function update(int $id)
		{
			if((!$user = $this->users_model->get_profile($id)) || $this->admin_editing_admin($user))
			{
				redirect('control/users/administrators');
			}

			settype($user, 'object');

			if($this->input->method() === 'post')
			{
				$this->form_validation->set_rules('user_name', 'Username', 'trim|strip_tags|required|min_length[3]|max_length[50]|alpha_dash')
														  ->set_rules('user_email', 'Email', 'trim|strip_tags|required|min_length[10]|max_length[50]|valid_email');

				if($this->form_validation->run())
				{
					$_user 			 	 = [];
					$_user['user_name']  = $this->input->post('user_name', TRUE);
					$_user['user_email'] = $this->input->post('user_email', TRUE);
					$_user['user_pwd'] 	 = $this->input->post('user_pwd', TRUE);
					$_user['user_role']  = match($this->input->post('user_role', TRUE), 'administrator|moderator|author', 'member');

					$username_is_unique = $this->users_model->is_unique('users', 
												     ['id !=', 'user_name'], [$user->id, $_user['user_name']]);
 
					$email_id_unique 	= $this->users_model->is_unique('users', 
												     ['id !=', 'user_email'], [$user->id, $_user['user_email']]);
					
					if(!$username_is_unique || !$email_id_unique)
					{
						$message = !$username_is_unique
								   ? 'Alamat email tidak tersedia'
								   : 'Nama pengguna tidak tersedia';

						$this->form_response = ['type' => 'error',
												'response' => $message];

		                $this->session->set_flashdata('form_response', $this->form_response);

						redirect("control/users/edit/{$user->id}");
					}

					if(empty($_user['user_pwd']))
					{
						unset($_user['user_pwd']);
					}
					else
					{
						$_user['user_pwd'] = password_hash($_user['user_pwd'],
														   PASSWORD_ARGON2I);
					}

					if(is_main())
					{
						if(ctype_digit($this->input->post('user_ad_balance')))
						{
							$_user['user_ad_balance'] = $this->input->post('user_ad_balance');
						}
					}

					$response = $this->users_model->update($user->id, $_user, 
														   NULL, NULL);

					$this->form_response = $response
	                                       ? ['type' => 'success', 'response' => 'Berhasil']
	                                       : ['type' => 'error', 'response' => 'Error!'];

	                $this->session->set_flashdata('form_response', $this->form_response);

					redirect("control/users/edit/{$user->id}");
				}
				else
				{
					$this->form_response = ['type'     => 'error',
                                        'response' => $this->form_validation->error_array()];
				}

				$this->session->set_flashdata('form_response', $this->form_response);
			}

			$page_title        = 'Edit Member';
      $partial           = "_user_edit";
    	$breadcrumbs       = "Kontrol / Edit user / {$user->user_name}";

      $this->load->view('control/item', compact('page_title','partial','breadcrumbs','user'));
		}
        



		private function update_status(int $id, string $property, string $value)
		{
			$user  = ["user_{$property}" => $value];
			$roles = 'administrator|moderators|authors';

			if(strtolower($property) === 'role' && preg_match("/^($roles)$/i", $value))
				$user['user_active'] = 1;

			$response = $this->users_model->update($id, $user, NULL);

			$this->output
		         ->set_content_type('application/json')
		         ->set_output(json_encode(['response' => $response]));
		}



		public function update_active(int $id, int $value)
		{
			return $this->update_status($id, 'active', $value);
		}



		public function update_blocked(int $id, int $value)
		{
			return $this->update_status($id, 'blocked', $value);
		}




		public function update_role(int $id, string $value)
		{
			return $this->update_status($id, 'role', $value);
		}




		public function delete($ids = NULL, $users_page = NULL)
		{	
			$ids_arr = json_decode($ids);

			if(!preg_match('/^(administrators|moderators|authors|members)$/i', 
				$users_page) || !$ids_arr)
				show_404();


			$users_page = "users/".$users_page ?? '';
            $response 	= $this->users_model->move_to_trash($ids_arr, 
            												$this->delete_conds);

            $this->form_response = $response
                                   ? ['type' => 'success', 'response' => 'Berhasil!']
                                   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];

            $this->session->set_flashdata('form_response', $this->form_response);

            redirect("control/{$users_page}");
		}




		private function set_delete_conds()
		{
			if(user_role() != 'main')
			{
				switch(user_role())
				{
					case 'administrator':
						$roles = ['main', 'administrator'];
						break;
					case 'moderator':
						$roles = ['main', 'moderator'];
						break;
					default:
						$roles = ['main', 'moderator', 'administrator'];
						break;
				}
				
				$this->delete_conds = ['where_not_in' => [
					'user_role' => $roles
				]];
			}
		}



		// check if the user (admin) is trying to
		// edit another admin, including the main.
		private function admin_editing_admin($user)
		{
			if(is_admin()
			   && in_array($user['user_role'], ['main', 'administrator']))
				return TRUE;

			return FALSE;
		}

	}