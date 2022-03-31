<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Comments extends Home_Core_Controller
	{

		function __construct()
		{
			Parent::__construct();

			$this->load->library('encryption')
            		   ->model(['home/posts_model', 'home/comments_model'])
            		   ->helper('security');
		}






		public function add()
		{
			$pattern 	 = '/post\/(?P<post_slug>[\w-]+)\/comment/';

			$uri_matches = preg_match($pattern, uri_string(), $uri_params);

			if(!$uri_matches || !is_logged_in())
				show_404();

			$this->form_validation->set_rules('comment_body','Comment body', 
									'trim|strip_tags|required');

			if($this->form_validation->run())
			{
				$data = [];

				$reply_to_id  = $this->encryption
									 ->decrypt($_POST['reply_to'] ?? '');

				$data['comment_body'] = strip_tags(html_entity_decode($this->input->post('comment_body', TRUE)));
				
				$data['comment_author_id'] = $_SESSION['user_id'];

				if($reply_to_id)
					$data['comment_parent_id'] = $reply_to_id;

				$post_slug = xss_clean($uri_params['post_slug']);

				if(!$post = $this->posts_model->get_id_by_slug($post_slug))
					show_404();

				$data['comment_post_id'] = $post->id;

				if(! is_member())
					$data['comment_visible'] = 1;

				$this->comments_model->add($data);

				if($this->settings['site_comments_moderation'])
				{
					$response = !is_member()
								? ['type' => 'success',
								   'response' => 'Done!']
								: ['type' => 'error',
								   'response' => 'Komentar Anda menunggu persetujuan.'];

					$this->form_response = $response;
				}
				else
				{
					$this->form_response = ['type' 	 => 'success',
								  	    	'response' => 'Berhasil!'];
				}
			}
			else
			{
				$this->form_response = ['type' 	   => 'error',
								  	    'response' => $this->form_validation->error_array()];
			}

			$this->session->set_flashdata('comment_response', $this->form_response);

			redirect("post/{$uri_params['post_slug']}#comment-form");
		}
















	}