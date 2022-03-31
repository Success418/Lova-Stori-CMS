<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Auth extends Core_Controller
	{



		function __construct()
		{
			Parent::__construct();

			$this->load->model(['control/users_model'])
					   ->library('mailer');
		}




		public function control_signin_page()
		{
			if(has_admin_access())
				redirect('control/dashboard');

			$this->load->view('control/sign_in');
		}




		public function sign_in()
		{
			$referer = @str_replace('sign_in', '', $this->uri->uri_string);
			$referer = ($referer === 'control/') ? 'control/sign_in' : $referer;

			$this->session->set_flashdata('sign_in', TRUE);

			$this->form_validation->set_rules('user', 'Name | Email', 
											  'required|trim|strip_tags|min_length[3]|max_length[50]')
								  ->set_rules('pwd', 'Password', 
								  	          'required|trim|strip_tags|min_length[3]|max_length[200]');

			$sign_in_key_sess 		= $_SESSION['sign_in_key'] ?? NULL;
			$sign_in_key_post 		= trim($this->input->post('sign_in_key'));
			$sign_in_inputs_exist 	= isset($sign_in_key_sess, $sign_in_key_post);

			if($this->form_validation->run())
			{
				$user 		  = $this->input->post('user', TRUE);
				$pwd  		  = $this->input->post('pwd', TRUE);
				$remember_me  = $this->input->post('remember_me', TRUE);
				$remember_me  = ($remember_me === 'on') ? $remember_me : NULL;

				$columns = ['users.id',
										'users.user_name',
										'users.user_email',
										'users.user_role',
										'users.user_pwd',
										'user_ip', 
										'user_country', 
										'user_active', 
										'user_blocked',
										'CONCAT(users.user_firstname, " ", users.user_lastname) AS user_fullname',
										'IFNULL(profiles.image_name, "default.png") AS user_image',
										'contributors.id AS contributor_id',
										'contributors.points AS points',
										'COUNT(posts.id) AS posts_count'];

						$user_data =  $this->db->select($columns, FALSE)
																	->from('users USE INDEX(user_name)')
																	->join('profiles', 'profiles.image_parent_id = users.id', 'LEFT')
																	->join('contributors', 'contributors.user_id = users.id', 'LEFT')
																	->join('posts', 'users.id = posts.post_author_id', 'LEFT')
																	->group_start()
																		->where('users.user_name', $user)
																		->or_where('users.user_email', $user)
																	->group_end()
																	->where(['users.user_deleted_at' => NULL])
																	->group_by('users.id')
																	->get()->row();

				if($user_data)
				{
					$wrong_pwd 		= !password_verify($pwd, $user_data->user_pwd);
					$is_not_active 	= !$user_data->user_active;
					$is_blocked 	= $user_data->user_blocked;

					if($is_not_active || $is_blocked || $wrong_pwd)
					{
						if($wrong_pwd)
							$message = lang('ext_invalid_login_crendentials');
						elseif($is_not_active) 
							$message = lang('ext_non_active_user');
						else 
							$message = lang('ext_blocked_user');

						$this->form_response = ['type' => 'error', 'response' => $message];

						$this->session->set_flashdata('form_response', $this->form_response);

						redirect($referer);
					}
					
					if($user_data->points == 0 && $user_data->posts_count > 0 && ($this->settings['points_per_post'] ?? 0))
					{
						$user_data->points = ceil($user_data->posts_count * $this->settings['points_per_post']);

						$this->db->where('user_id', $user_data->id)->update('contributors', ['points' => $user_data->points]);
					}

					if(!$user_data->contributor_id && $user_data->user_role === 'author')
					{
						$this->db->query("INSERT IGNORE INTO contributors (user_id) VALUES(?)", [$user_data->id]);
					}

					$sessions =  ['user_id' => $user_data->id,
												'user_name' => mb_strtolower($user_data->user_name),
												'user_email' => $user_data->user_email,
												'user_role' => $user_data->user_role,
												'user_image' => $user_data->user_image,
												'user_remember_me' => $remember_me,
												'credit' => $user_data->points ?? 0];

					session_unset();

					$this->session->set_tempdata($sessions, NULL, 86400);

					redirect($referer);
				}
				else
				{
					$this->form_response = ['type' 	   => 'error',
											'response' => lang('ext_invalid_login_crendentials')];
				}
			}
			else
			{
				$form_errors = $this->form_validation->error_array();

				$this->form_response = ['type' 		=> 'error',
										'response' 	=> $form_errors];
			}

			$this->session->set_flashdata('form_response', $this->form_response);

			redirect($referer);
		}




		public function logout()
		{
			$referer = @str_replace('logout', '', $this->uri->uri_string);

			session_unset();

			redirect($referer);
		}




		public function prepare_reset_password()
		{
			$referer = @str_replace('prepare_reset_password', '', $this->uri->uri_string);

			$referer = ($referer === 'control/') 
					   ? 'control/sign_in' 
					   : $referer;
					   
			if($this->input->method() != 'post')
				show_404();

			$this->session->set_flashdata('reset_pwd', TRUE);
			$this->form_validation->set_rules('user_email', 'Email', 
											  'trim|strip_tags|required|valid_email');
			
			if($this->form_validation->run())
			{
				$user_email   = $this->input->post('user_email', TRUE);
				$token 		  = md5($this->security->get_random_bytes(32));
				$confirm_url  = base_url("reset_password/{$token}");
				$site_name    = $this->settings['site_name'] ?? '';

				$language = $this->config->item('language');
				
				$language = $language !== 'indonesia' ? 'english' : $language;
				
				$email_body = $this->load->view("templates/opoin/reset_password_{$language}", '', TRUE);

				$email_body   = str_replace(['[SITE_NAME]', '[CONFIRM_URL]'],
											[$site_name, $confirm_url],
											$email_body);

				$email_data = ['subject' => $language === 'indonesia' ? 'Permintaan Perubahan Password' : 'Password Change Request',
				               'from'    => $this->settings['site_admin_email'],
							   'to' 	 => $user_email, 
							   'body' 	 => $email_body,
							   'name'    => $site_name];

				$mailer = new Mailer();
				$mail_status = @$mailer->init($this->settings)
					   		   		   ->send($email_data);

				if(!$mail_status)
				{
					$this->form_response = ['type' => 'error', 
											'response' => lang('ext_unknown_error')];
				}
				else
				{
					$this->form_response = ['type' 	   => 'success',
									  		'response' => 
									  		lang('ext_reset_pwd_confirmation')];
									  		
					$this->session->set_tempdata(
						['reset_pwd_token' => $token,
						 'user_email' => $user_email], NULL, 86400);
				}
			}
			else
			{
				$this->form_response = ['type' => 'error',
								  	    'response' => $this->form_validation->error_array()];
			}
			$this->session->set_flashdata('form_response', $this->form_response);
			redirect($referer);
		}
		



		public function reset_password_page($token = NULL)
		{
			$this->load->model('users_model');
			$user_email 	= $_SESSION['user_email'] ?? NULL;
			$session_token 	= $_SESSION['reset_pwd_token'] ?? NULL;

			if(empty($session_token || $token)
			   || urldecode($token) != $session_token 
			   || !$user_email)
				show_404();

			if(!$user = $this->users_model->get_user($user_email))
				show_404();

			$metadata = new stdClass();

			$metadata->title 	 = 'Reset password';
			$metadata->site_name = $this->settings['site_name'];
			$metadata->description = $this->settings['site_description'];
			$metadata->keywords  = $this->settings['site_keywords'];
			$metadata->favicon 	 = $this->settings['site_favicon'];
			$metadata->image 	 = base_url("assets/images/{$this->settings['site_cover']}");
			$metadata->logo 	 = $this->settings['site_logo'];
			$metadata->type 	 = 'website';
			$metadata->url 		 = current_url();
			$metadata->canonical = current_url();
			$metadata->author 	 = "{$this->settings['site_admin_name']}, {$this->settings['site_admin_email']}";
			$metadata->rating    = 'general';
			$metadata->date	 	 = '';

			$this->load->view("templates/{$this->template}/reset_password", compact('metadata'));
		}



		public function reset_password_action()
		{
			if($this->input->method() != 'post')
				show_404();
			$this->session->set_flashdata('reset_pwd', TRUE);
			$this->form_validation->set_rules('user_pwd', 'Password', 
											  'required|trim|strip_tags|min_length[3]')
								  ->set_rules('pwd_confirm', 'Password confirm', 
								  			  'required|trim|strip_tags|matches[user_pwd]');
			
			$valid_email = filter_var($_SESSION['user_email'] ?? NULL, FILTER_VALIDATE_EMAIL);
			if($this->form_validation->run() && $valid_email)
			{
				$user_pwd 	= $this->input->post('user_pwd', TRUE);
				$user_email = $_SESSION['user_email'];
				$user_pwd = password_hash($user_pwd, PASSWORD_ARGON2I);
				$this->users_model->update_password($user_pwd, $user_email);
				session_unset();
				$this->form_response = ['type' 	   => 'Done',
									  	'response' => lang('ext_reset_pwd_done')];
				$this->session->set_flashdata('form_response', $this->form_response);
				redirect('/');
			}
			else
			{
				$this->form_response = ['type' 	 => 'error',
								  	    'response' => $this->form_validation->error_array()];
			}
			$this->session->set_flashdata('form_response', $this->form_response);
			$reset_pwd_token = $_SESSION['reset_pwd_token'] ?? '';
			redirect("reset_password/{$reset_pwd_token}");
		}




		public function sign_up()
		{
			if($this->input->method() != 'post')
				show_404();

			$referer = @str_replace('sign_up', '', $this->uri->uri_string);

			$this->session->set_flashdata('sign_up', TRUE);
			$this->form_validation->set_rules('user_name', 'Username', 
											  'trim|strip_tags|required|min_length[3]|max_length[50]|alpha_dash|is_unique[users.user_name]')
								  ->set_rules('user_email', 'Email', 
								  			  'trim|strip_tags|required|min_length[10]|max_length[50]|is_unique[users.user_email]')
								  ->set_rules('user_pwd', 'Password', 
								  			  'trim|strip_tags|required|min_length[3]')
								  ->set_rules('user_pwd_verify', 'Password verify', 'trim|required|matches[user_pwd]');

			if($this->form_validation->run())
			{
				$need_activation    = TRUE;
				$user 			    = [];
				$user['user_ip'] 	= $this->input->ip_address();
				$user['user_name'] 	= $this->input->post('user_name', TRUE);
				$user['user_email'] = $this->input->post('user_email', TRUE);
				$user['user_pwd'] 	= password_hash($this->input->post('user_pwd', TRUE), PASSWORD_ARGON2I);

				$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');
				$data 			= $maxmind_reader->get($user['user_ip']);
				$iso_code 		= $data['country']['iso_code'] ?? NULL;

				$user['user_country'] = $iso_code;

				$site_name    = $this->settings['site_name'] ?? '';
				$user_email   = $user['user_email'];
				$token  	  = md5($this->security->get_random_bytes(256));
				$token 		 .= '_'.md5($user_email);
				$activ_link   = base_url("activate_account/{$token}");
				$css_style    = 'style="text-decoration: none;padding: .5rem 1rem;display: inline-block;background: #F44336;color: #fff;font-size: 1rem;font-family: roboto, sans-serif;"';
				
				$language = $this->config->item('language');
				
				$language = $language !== 'indonesia' ? 'english' : $language;
				
				$email_body = $this->load->view("templates/opoin/verify_email_address_{$language}", '', TRUE);
				
				$email_body   = str_replace(
								['[SITE_NAME]', '[ACTIV_LINK]', '[CSS_STYLE]'],
								[$site_name, $activ_link, $css_style],
								$email_body);

				$email_data = [
					'subject' => $language === 'indonesia' ? 'Verifikasi alamat email' : 'Email address verification', 
					'from'    => $this->settings['site_admin_email'],
					'to' 	  => $user_email, 
					'body' 	  => $email_body,
					'name'    => $site_name
				];

				$mailer = new Mailer();

				$mail_status = @$mailer->init($this->settings)
					   		   		   ->send($email_data);

				if(!$mail_status)
				{
					$this->form_response = ['type' => 'error', 'response' => 'Unknow error'];
				}
				else
				{
					$user['user_activation_token'] = $token;
					$response = $this->users_model->add($user);
					$this->form_response = $response
	                                       ? ['type' => 'success', 
	                                          'response' => 
	                                           lang('ext_account_activation_done')]
	                                       : ['type' => 'error', 'response' => lang('ext_form_error')];
				}
			}
			else
			{
				$this->form_response = ['type'     => 'error',
                                        'response' => $this->form_validation->error_array()];
			}

			$this->session->set_flashdata('form_response', $this->form_response);
			
			redirect($referer);
		}




		public function activate_account(string $activation_token)
		{
			list($token, $email) = explode('_', $activation_token);

			if(!$response = $this->users_model->activate($token, $email))
				show_404();

			$this->form_response = ['type' => 'success', 
									'response' => lang('ext_form_success')];

	        $this->session->set_flashdata('form_response', $this->form_response);
	        
	        redirect('/');
		}
	}