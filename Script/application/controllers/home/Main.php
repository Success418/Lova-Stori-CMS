<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Main extends Home_Core_Controller
	{

		function __construct()
		{
			Parent::__construct();
				
    		if(in_array($this->router->method, 
    		            ['index', 'post', 'page', 'get_posts_by_category', 'get_posts_by_subcategory', 'get_posts_by_keywords', 'search', 'get_posts_by_year', 'get_posts_by_author', 'user'])
    		)
    		{
    		$this->dashboard_model->update_traffic_origins();
            $this->update_analytics();    
			}
		}




		public function index()
		{			
			$base_data 	  = $this->base(10, 10, 100, 20);
			$metadata  	  = $this->metadata();
			$carousel_posts = $this->posts_model->get_carousel_posts(10);
            $latest_posts = $this->posts_model->get_ordered_by('id', 'DESC', 20) ?? [];
            
			$posts = ['categories' 	=> ['names' => [], 'posts' => []],
					  'subcategories' => ['names' => [], 'posts' => []]
					 ];

			if($posts_by_categories = $this->posts_model
									       ->get_grouped_by_category(4))
			{
				foreach($posts_by_categories as $post)
				{
					$posts['categories']['names'][$post->category_id] = $post->category_title;

					$posts['categories']['posts'][$post->category_id][] = $post;
				}

				$categories_ids = array_keys($posts['categories']['names']);

				if($subcategories = $this->subcategories_model->get_by_category_id($categories_ids))
				{
					$subcategories_ids = array_column($subcategories, 'id');

					if($posts_by_subcategories = $this->posts_model->get_grouped_by_subcategory($subcategories_ids))
					{
						foreach($posts_by_subcategories as $post)
						{	
							$posts['subcategories']['names'][$post->category_id][$post->subcategory_id] = $post->subcategory_title;

							$posts['subcategories']['posts'][$post->category_id][$post->subcategory_id][] = $post;
						}
					}
				}
			}

			$view_data = array_merge($base_data, compact('metadata', 'posts', 'carousel_posts', 'latest_posts'));

			$this->load->view("templates/{$this->template}/home", $view_data);
		}




		public function post(string $slug)
		{
			$this->load->library('encryption');

			$base_data = $this->base();

			if(!$post = $this->posts_model->get_by_slug($slug))
				show_404();

			if(! $reactions = $this->db->query("SELECT * FROM reactions USE INDEX(post_id) WHERE post_id = ?", [$post->id])->row())
			{
				$reactions = (object)['suka' => 0, 'cinta' => 0, 'senang' => 0, 'kaget' => 0, 'sedih' => 0, 'marah' => 0];
			}

			$metadata = $this->metadata();

			$metadata->type  		= 'article';
			$metadata->image 		= base_url("uploads/images/{$post->image}");
			$metadata->description  = $post->summary;
			$metadata->title 		= $post->title;
			$metadata->url   		= current_url();
			$metadata->rating    	= $post->rating;
			$metadata->date	 	 	= $post->date;
			$metadata->author 		= $post->author_fullname ?? ($post->author_username . ", {$post->author_email}");

			$this->posts_model->update_views($post->id);

			$prev_next_items = [];

			if($prev_next = $this->posts_model->get_prev_next($post->id))
			{
				foreach($prev_next as $prev_next_item)
				{
					if($prev_next_item->id < $post->id)
						$prev_next_items['prev'] = $prev_next_item;
					else
						$prev_next_items['next'] = $prev_next_item;
				}
			}

			if($comments = $this->comments_model->get($post->id))
			{
				$comments = $this->order_post_comments($comments);
			}

			$similar_posts = $this->posts_model->get_similar($post->id, $post->category_id);

			$view_data = array_merge($base_data, compact('metadata', 
														 'post', 
														 'prev_next_items',
														 'similar_posts',
														 'comments',
														 'reactions'));

			$this->load->view("templates/{$this->template}/post", $view_data);
		}




		public function page(string $slug)
		{
			$base_data = $this->base();

			if(!$page = $this->pages_model->get_page($slug))
				show_404();

			$metadata = $this->metadata();

			$metadata->type  		= 'article';
			$metadata->description  = $page->summary;
			$metadata->title 		= $page->title;
			$metadata->url   		= current_url();
			$metadata->date	 	 	= $page->date;
			$metadata->author 		= $page->author_fullname
									  ?? $page->author_username . ", {$page->author_email}";

			$this->pages_model->update_views($page->id);

			$view_data = array_merge($base_data, compact('metadata', 
														 'page'));

			$this->load->view("templates/{$this->template}/page", $view_data);
		}




		public function get_posts_by_category()
        {
        	$base_data  = $this->base();
            $uri_params = $this->uri->uri_to_assoc(2, ['page', 'category']);
            $posts_data = $this->posts_model->get_by_category($uri_params);
            $metadata   = $this->metadata();

			$metadata->description  = $posts_data['category_description'];
			$metadata->url   		= current_url();
			$metadata->title 		= "{$metadata->site_name} - {$posts_data['category_title']}";
			$metadata->posts_group_title = ucfirst($posts_data['category_title']);

			$view_data = array_merge($base_data, $posts_data, 
									 compact('metadata'));

            $this->load->view("templates/{$this->template}/posts", $view_data);
        }




		public function get_posts_by_subcategory(string $subcategory_slug)
		{
			$base_data  = $this->base();
            $uri_params = $this->uri->uri_to_assoc(2, ['page', 'subcategory']);
            $posts_data = $this->posts_model->get_by_subcategory($uri_params);
            $metadata   = $this->metadata();

			$metadata->description  = $posts_data['subcategory_description'];
			$metadata->url   		= current_url();
			$metadata->title 		= "{$metadata->site_name} - {$posts_data['subcategory_title']}";
			$metadata->posts_group_title = ucfirst($posts_data['subcategory_title']);

			$view_data = array_merge($base_data, $posts_data, 
									 compact('metadata'));

            $this->load->view("templates/{$this->template}/posts", $view_data);
		}




		public function get_posts_by_keywords()
		{
			$base_data  = $this->base();
            $uri_params = $this->uri->uri_to_assoc(2, ['page', 'search']);
            $posts_data = $this->posts_model->get_by_keywords($uri_params);
            $metadata 	= $this->metadata();

			$metadata->url = current_url();
			$metadata->title = "Cari - {$posts_data['keywords']}";
			$metadata->posts_group_title = "ada {$posts_data['results_count']} artikel, yang kamu cari adalah: {$posts_data['keywords']}";

			$view_data = array_merge($base_data, $posts_data, 
									 compact('metadata'));

            $this->load->view("templates/{$this->template}/posts", $view_data);
		}




		public function search()
		{
			if(!$keywords = $this->input->post('search', TRUE))
				redirect($_SERVER['HTTP_REFERER'] ?? '/');

			redirect("posts/search/{$keywords}");
		}




		public function get_posts_by_year()
		{
			$base_data  = $this->base();
            $uri_params = $this->uri->uri_to_assoc(2, ['page', 'year']);
            $posts_data = $this->posts_model->get_by_year($uri_params);
            $metadata 	= $this->metadata();

			$metadata->title = "{$metadata->site_name} - {$posts_data['year']}";
			$metadata->posts_group_title = "Posts - {$posts_data['year']}";

            $view_data  = array_merge($base_data, $posts_data, 
									  compact('metadata'));

            $this->load->view("templates/{$this->template}/posts", $view_data);
		}




		public function get_posts_by_author(string $author)
		{
			$base_data  = $this->base();
            $uri_params = $this->uri->uri_to_assoc(2, ['page', 'author']);
            $posts_data = $this->posts_model->get_by_author($uri_params);
            $metadata 	= $this->metadata();

			$metadata->title = "{$metadata->site_name} - {$posts_data['author']}";
			$metadata->posts_group_title = "Berita - {$posts_data['author']}";

            $view_data  = array_merge($base_data, $posts_data, 
									  compact('metadata'));

            $this->load->view("templates/{$this->template}/posts", $view_data);
		}



		public function contributor_form()
		{
			if(is_author()) redirect('/');

			$base_data  = $this->base();
			$metadata 	= $this->metadata();

			$view_data  = array_merge($base_data, compact('metadata'));

 			$this->load->view("templates/{$this->template}/contributor_form", $view_data);
		}



		public function contributor_form_store()
		{			
			$verification_code = $_SESSION['contributor_verification_code'] ?? '';

			$input = $this->input;
			$user_id = $_SESSION['user_id'] ?? null;


			if($input->method() != 'post' || is_author())
				show_404();

			$form_validation = $this->form_validation;

			if(! is_logged_in())
			{
				$form_validation->set_rules('user_name', 'Username', 'trim|strip_tags|required|min_length[3]|max_length[255]|alpha_dash|is_unique[users.user_name]')
												->set_rules('user_email', 'Email', 'trim|strip_tags|required|min_length[10]|max_length[255]|is_unique[users.user_email]')
												->set_rules('user_pwd', 'Password', 'trim|strip_tags|required|min_length[3]');

				$user_id = $users_table = $this->db->query("SHOW TABLE STATUS where name = 'users'")->result_object()[0]->Auto_increment;
			}
			else
			{
				if(!is_member())
				{
					$this->form_response = ['type'     => 'error',
																	'response' => 'Tindakan tidak diizinkan, Anda masuk sebagai '. (is_moderator() ? 'Moderator' : 'Administrator'. ". Silakan hubungi tim medialova jika Anda ingin mengubah peran atau level Anda.")];
				
					$this->session->set_flashdata('form_response', $this->form_response);
					
					redirect('kontributor');
				}
				else
				{
					$exists = $this->db->query("SELECT COUNT(id) AS _count FROM contributors USE INDEX(user_id) 
																			WHERE user_id = ?", [$_SESSION['user_id']])->row()->_count ?? 0;

					if($exists)
					{
						$this->form_response = ['type' => 'error', 'response' => 'Anda sudah menjadi seorang Penulis'];
					
						$this->session->set_flashdata('form_response', $this->form_response);
						
						redirect('kontributor');
					}
				}
			}
			
			$form_validation->set_rules('user_firstname', 'First name', 'trim|strip_tags|required|min_length[3]|max_length[255]')
											->set_rules('user_lastname', 'Last name', 'trim|strip_tags|required|min_length[3]|max_length[255]')
											->set_rules('user_phone_number', 'Phone numnber', 'trim|strip_tags|required|max_length[255]')
											->set_rules('user_bank_account_number', 'Bank account number', 'trim|strip_tags|required|max_length[255]')
											->set_rules('user_bank_name', 'Bank name', 'trim|strip_tags|required|max_length[255]')
											->set_rules('user_description', 'Description', 'trim|strip_tags|required|max_length[1000]')
											->set_rules('verification_code', 'Verification code', "trim|strip_tags|required|max_length[6]|in_list[$verification_code]");
			
			if(! $form_validation->run())
			{
				$this->form_response = ['type'     => 'error',
																'response' => $form_validation->error_array()];
				
				$this->session->set_flashdata('form_response', $this->form_response);
				
				redirect('kontributor');
			}

			
			$this->load->library('upload');

			$file_upload_config =  ['file_name' 			 => md5($user_id),
															'upload_path' 		 => './uploads/profiles/',
															'allowed_types' 	 => 'jpg|jpeg|png',
															'file_ext_tolower' => true,
															'overwrite' 			 => true];

			$this->upload->initialize($file_upload_config);

			// USER_AVATAR
			if($_FILES['user_avatar']['tmp_name'] ?? null)
			{
				$this->load->library('upload', $file_upload_config);

				if($this->upload->do_upload('user_avatar'))
				{
						$user_avatar = $this->upload->data('file_name');
				}
				else
				{
						$this->form_response = ['type'     => 'error', 
																		'response' => $this->upload->display_errors()];

						$this->session->set_flashdata('form_response', $this->form_response);

						redirect('kontributor');
				}	
			}
			
			
			// USER_CARD_ID_1
			$file_upload_config['file_name'] = "{$user_id}-1";
			$file_upload_config['upload_path'] = './uploads/ids/';
			$file_upload_config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';

			$this->upload->initialize($file_upload_config, TRUE);

			if($this->upload->do_upload('user_card_id_1'))
			{
					$user_card_id_1 = $this->upload->data('file_name');
			}
			else
			{
					$this->form_response = ['type'     => 'error', 
																	'response' => $this->upload->display_errors()];

					if($user_avatar ?? null)
						unlink(FCPATH."uploads/profiles/{$user_avatar}");
						
					$this->session->set_flashdata('form_response', $this->form_response);

					redirect('kontributor');
			}	

			// USER_CARD_ID_2
			$file_upload_config['file_name'] 		 = "{$user_id}-2";
			$file_upload_config['upload_path'] 	 = './uploads/ids/';
			$file_upload_config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';

			$this->upload->initialize($file_upload_config, TRUE);

			if($this->upload->do_upload('user_card_id_2'))
			{
					$user_card_id_2 = $this->upload->data('file_name');
			}
			else
			{
					$this->form_response = ['type'     => 'error', 
																	'response' => $this->upload->display_errors()];

					if($user_avatar ?? null)
					{
						unlink(FCPATH."uploads/profiles/{$user_avatar}");
					}

					unlink(FCPATH."uploads/ids/{$user_card_id_1}");
						
					$this->session->set_flashdata('form_response', $this->form_response);

					redirect('kontributor');
			}	

			if(! is_logged_in())
			{
				$user 			 						= [];
				$user['user_ip'] 				= $input->ip_address();
				$user['user_name'] 			= $input->post('user_name', TRUE);
				$user['user_email'] 		= $input->post('user_email', TRUE);
				$user['user_pwd']				= password_hash($this->input->post('user_pwd', TRUE), PASSWORD_ARGON2I);
				$user['user_firstname']	= $input->post('user_firstname');
				$user['user_lastname'] 	= $input->post('user_lastname');
				$user['user_role'] 			= 'author';

				$maxmind_reader = new \MaxMind\Db\Reader(APPPATH.'GeoIP2-City.mmdb');

				$data				= $maxmind_reader->get($user['user_ip']);
				$iso_code		= $data['country']['iso_code'] ?? NULL;

				$user['user_country'] = $iso_code;
				$user['user_active'] 	= 1;

				$this->db->insert('users', $user);
				$this->db->insert('profiles', ['image_name' => $user_avatar, 'image_parent_id' => $user_id]);
			}
			else
			{
				$this->db->query("UPDATE users SET user_role = 'author' WHERE id = ?", [$_SESSION['user_id']]);
			}
			
			$contributor = [
				'user_id' 									=> $user_id,
				'user_firstname'						=> $input->post('user_firstname'),
				'user_lastname'							=> $input->post('user_lastname'),
				'user_phone_number'					=> $input->post('user_phone_number'),
				'user_bank_account_number' 	=> $input->post('user_bank_account_number'),
				'user_bank_name' 						=> $input->post('user_bank_name'),
				'user_description' 					=> $input->post('user_description'),
				'active'										=> 1,
				'user_card_id_1' 						=> $user_card_id_1,
				'user_card_id_2' 						=> $user_card_id_2
			];

			$this->db->insert('contributors', $contributor);

			$this->session->set_flashdata('form_response', ['type' => 'success', 'response' => 'Pendaftaran berhasil. Silakan masuk lagi.']);

			if(! is_logged_in())
			{
				$sessions =  ['user_id' => $user_id,
											'user_name' => $user['user_name'],
											'user_email' => $user['user_email'],
											'user_role' => 'author',
											'user_image' => $user_avatar,
											'user_remember_me' => 1,
											'credit' => 0];

				$this->session->set_tempdata($sessions, NULL, 86400);
			}
			else
			{
				foreach(['user_id','user_name','user_email','user_role','user_image','user_remember_me','credit'] as $val)
				{
					unset($_SESSION[$val]);
				}
			}

			redirect('kontributor');
		}
		
		



		public function user(string $username)
		{
			$base_data  = $this->base();
			$metadata 	= $this->metadata();

			$this->load->model('home/users_model');

			if(!$user_profile = $this->users_model->get_user($username))
				show_404();

			$user_posts    = $this->posts_model->get_by_user_id($user_profile->id);

			$user_comments = $this->comments_model->get_by_user_id($user_profile->id);

			$auhtor = ucfirst($user_profile->realname ?? $user_profile->username);

			$metadata->title 		= "{$metadata->site_name} - {$auhtor}";
			$metadata->user  		= ucfirst($auhtor);
			$metadata->description  = html_entity_decode($user_profile->about);
			$metadata->image        = base_url("uploads/profiles/{$user_profile->image}");
			$metadata->keywords     = '';

			$view_data  = array_merge($base_data, $user_posts, $user_comments,  
																compact('metadata', 'user_profile'));

			$this->load->view("templates/{$this->template}/user", $view_data);
		}




		public function get_posts_by_author_ajax()
		{
			$page 	 = (int)$this->input->post('page', TRUE);
			$user_id = (int)$this->input->post('user_id', TRUE);

			if(!$page || !$user_id)
				exit;

			$page = $page ? $page : 1;

			$posts = $this->posts_model
						  ->get_by_user_id($user_id, $page);

			$this->output->set_content_type('application/json')
						 ->set_output(json_encode($posts));
		}




		public function get_comments_by_author_ajax()
		{
			$page 	 = (int)$this->input->post('page', TRUE);
			$user_id = (int)$this->input->post('user_id', TRUE);

			if(!$page || !$user_id)
				exit;

			$page = $page ? $page : 1;

			$comments = $this->comments_model
						     ->get_by_user_id($user_id, $page);

			$this->output->set_content_type('application/json')
						 ->set_output(json_encode($comments));
		}




		public function update_rating()
		{
			$post_id 	 = (int)$this->input->post('id', TRUE);
			$post_rating = (int)$this->input->post('rating', TRUE);

			if(!$post_id || !$post_rating || $post_rating > 5)
				return;

			$this->posts_model->update_rating($post_id, $post_rating);
		}



		public function toggle_style()
		{
			$referer = str_ireplace('toggle_style', '', $this->uri->uri_string());

			$this->form_validation->set_rules('style', 'Style', 
									'required|regex_match[/^(light|dark)$/]');

			if($this->form_validation->run())
			{
				$style = $this->input->post('style', TRUE);

				$expire = 30*86400;

				$this->input->set_cookie('style', $style, $expire);
			}
			
			redirect($referer);
		}



		public function change_lang()
		{
			$referer = str_ireplace('change_lang', '', $this->uri->uri_string());

			$lang = $this->input->post('lang', TRUE);

			if(in_array($lang, ['indonesia', 'english']))
			{
				$expire = 30*86400;

				$this->input
					 ->set_cookie('lang', $lang, $expire);
			}
			
			redirect($referer);
		}



		public function contact()
		{
			$referer = str_ireplace('contact', '', $this->uri->uri_string());

			$this->form_validation->set_rules('contact-email', 'Email', 
									'required|valid_email')
								  ->set_rules('contact-name', 'Nama', 
									'required|strip_tags|trim')
								  ->set_rules('contact-subject', 'Subjek', 'required')
								  ->set_rules('contact-body', 'Pesan', 'required|strip_tags|trim');

			if($this->form_validation->run())
			{
				$this->load->library('mailer');

				$name 	  = $this->input->post('contact-name', TRUE);
				$email 	  = $this->input->post('contact-email', TRUE);
				$subject  = $this->input->post('contact-subject', TRUE);
				$body 	  = $this->input->post('contact-body', TRUE);

				$email_data = [
					'subject' => $subject, 
				    'to' 	  => $this->settings['site_admin_email'], 
				    'body' 	  => "{$body}<br><p>Dari: {$email}</p>",
				    'name'    => $name
				];

				$mailer = new Mailer();

				$mail_status = @$mailer->init($this->settings)
					   		   		   ->send($email_data);

				if(!$mail_status)
				{
					$this->form_response = ['type' => 'error', 
											'response' => 'Kesalahan yang tidak diketahui'];
				}
				else
				{
					$this->form_response = ['type' 	   => 'success',
									  		'response' => '<center>Terima kasih! atas laporan Anda.<br> Pesan Anda akan kami<br>respon dijam kerja.</center>'];
				}

				$this->session->set_flashdata([
					'form_response' => $this->form_response, 
					'contact' => true
				]);
			}

			redirect($referer);
		}




		private function order_post_comments(array $u_comments): array
		{
			$o_comments   = [];

			foreach($u_comments as &$comment)
			{
				if(!$comment->parent_id)
				{
					$comment->subcomments = [];

					foreach($u_comments as $_comment) 
					{
						if($comment->id === $_comment->parent_id)
							$comment->subcomments[] = $_comment;
					}

					$comment->subcomments = array_reverse($comment->subcomments);

					$o_comments[] = $comment;
				}
			}

			return $o_comments;
		}


		public function save_reaction()
		{
			$reactions = ['suka', 'cinta', 'senang', 'kaget', 'sedih', 'marah'];

			$old_reaction = $this->input->post('old_reaction', true);
			$new_reaction = $this->input->post('new_reaction', true);
			$post_id 			= $this->input->post('id');

			if(ctype_digit($post_id) && in_array($new_reaction, $reactions))
			{
				if(! $old_reaction)
				{
					$reactions[$new_reaction] = 1;

					$this->db->query("INSERT INTO reactions (post_id, {$new_reaction}) VALUES(?, ?) 
														ON DUPLICATE KEY UPDATE {$new_reaction} = {$new_reaction}+1", 
														[$post_id, 1]);
				}
				else
				{
					if(in_array($old_reaction, $reactions))
					{
						$this->db->query("INSERT INTO reactions (post_id, {$new_reaction}) VALUES(?, ?) 
															ON DUPLICATE KEY UPDATE {$new_reaction} = {$new_reaction}+1,
																											{$old_reaction} = {$old_reaction} - IF({$old_reaction} > 0, 1, 0)", 
															[$post_id, 1]);
					}
				}
			}
		}





		public function message_author($output = true)
		{
			$this->form_validation->set_rules('contact-email', 'Email', 
									'required|valid_email')
								  ->set_rules('contact-subject', 'Subjek', 'required')
								  ->set_rules('contact-body', 'Pesan', 'required|trim');

			if($this->form_validation->run())
			{
				$this->load->library('mailer');

				$email 	  = $this->input->post('contact-email', TRUE);
				$subject  = $this->input->post('contact-subject', TRUE);
				$body 	  = $this->input->post('contact-body', TRUE);

				$email_data = [
					'subject' => $subject, 
					'from'    => $this->settings['site_admin_email'],
					'to' 	  	=> $email, 
					'body' 	  => "{$body}",
					'name'    => $this->settings['site_name']
				];

				$mailer = new Mailer();

				$mail_status = @$mailer->init($this->settings)
					   		   		   ->send($email_data);

				if(!$mail_status)
				{
					$this->form_response = ['type' => 'error', 'response' => 'Kesalahan yang tidak diketahui'];
				}
				else
				{
					$this->form_response = ['type'=> 'success', 'response' => 'Berhasil!'];
				}

				if($output)
					$this->output->set_content_type('application/json')->set_output(json_encode($this->form_response));
				else
					return $this->form_response;
			}
		}



		public function mark_payment_as_paid()
		{
			if(!ctype_digit($this->input->post('id')) || 
				 !ctype_digit($this->input->post('author_id')) || 
				 !ctype_digit($this->input->post('points_to_exchange')))
			{
				return;
			}

			$response = $this->message_author(false);

			if(($response['type'] ?? null) === 'success')
			{
				$this->db->query("UPDATE payments SET paid = 1 WHERE id = ?", [$this->input->post('id')]);

				$author_id 				= (int)$this->input->post('author_id');
				$exchanged_points = (float)$this->input->post('points_to_exchange');
				$withdrawal				= $exchanged_points * (float)$this->settings['exchange_rate'];

				$this->db->query("UPDATE contributors SET points = points - ?, 
																									exchanged_points = exchanged_points + ?, 
																									withdrawals = withdrawals + ? 
													WHERE user_id = ?", 
													[$exchanged_points, $exchanged_points, $withdrawal, $author_id]);
			}
		}


		private function metadata()
		{
			$metadata = new stdClass();

			$metadata->title 	 = $this->settings['site_title'];
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

			return $metadata;
		}


	}