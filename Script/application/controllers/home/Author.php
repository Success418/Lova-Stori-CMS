<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Author extends Home_Core_Controller
	{
    public $pages;

		function __construct()
		{
			Parent::__construct();

      if(! is_author()) show_404();

      $this->load->model(['home/posts_model', 'home/comments_model', 'home/pages_model']);

      $this->pages = $this->pages_model->get_pages();
		}



    public function index()
    {
      $user_id = $_SESSION['user_id'];

      $menu_items  = $this->get_menu_items();
			$metadata 	= $this->metadata();

      $counts = $this->db->query("SELECT (SELECT COUNT(posts.id) FROM posts USE INDEX (post_author_id) WHERE post_author_id = ?) as posts, 
                                         (SELECT COUNT(comments.id) FROM comments USE INDEX (comment_post_id) WHERE comment_post_id = ?) as comments,
                                         (SELECT exchanged_points FROM contributors USE INDEX (user_id) WHERE contributors.user_id = ?) as exchanged_points,
                                         (SELECT points FROM contributors USE INDEX (user_id) WHERE contributors.user_id = ?) as points,
                                         (SELECT withdrawals FROM contributors USE INDEX (user_id) WHERE contributors.user_id = ?) as withdrawals",
                                  [$user_id, $user_id, $user_id, $user_id, $user_id])->row();

      $latest_posts = $this->db->query("SELECT post_title as title, post_slug as slug, post_views as views, post_rating as rating, 
                                        categories.category_title as category, post_created_at as created_at
                                        FROM posts USE INDEX (primary) 
                                        LEFT JOIN categories ON categories.id = posts.post_category_id
                                        WHERE posts.post_author_id = ? ORDER BY posts.post_created_at DESC LIMIT 5",
                                        [$user_id])->result_object();
      
      $latest_comments = $this->db->query("SELECT comments.id, posts.post_title, posts.post_slug, 
                                           comments.comment_created_at as created_at, comments.comment_body as body,
                                           profiles.image_name as avatar, users.user_name
                                           FROM comments USE INDEX (comment_post_id, primary)
                                           LEFT JOIN posts USE INDEX (post_author_id) ON posts.post_author_id = ?
                                           LEFT JOIN users USE INDEX (primary) ON users.id = comments.comment_author_id
                                           LEFT JOIN profiles USE INDEX (image_parent_id) ON image_parent_id = comments.comment_author_id
                                           WHERE comments.comment_post_id = posts.id
                                           ORDER BY comments.comment_created_at
                                           LIMIT 5",
                                           [$user_id])->result_object();
      
      $comments_bodies = array_column($latest_comments, 'body');
      $comments_ids 	 = array_column($latest_comments, 'id');
      $comments_texts  = array_combine($comments_ids, $comments_bodies);
      $comments_texts  = array_map('nl2br', $comments_texts);
      $comments_texts  = json_encode($comments_texts);

      $pages = $this->pages;

      $this->load->view("templates/{$this->template}/author/dashboard", compact('metadata', 'menu_items', 'pages', 
                                                                                'counts', 'latest_posts', 'latest_comments', 'comments_texts'));
    }



    public function comments()
    {
      $menu_items  = $this->get_menu_items();
			$metadata 	 = $this->metadata();
      
      $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);

      $order = $uri_params['order'];

      if($order === 'desc') $order = 'asc';
      elseif($order === 'asc') $order = 'desc';
      else $order = 'asc';

      extract($this->comments_model->get_2($uri_params, $_SESSION['user_id']));

      $filters_base_url  = base_url("author/comments/orderby");

      $categories = $this->get_categories_subcategories(FALSE);
      $pages      = $this->pages;

      $comments_bodies = array_column($comments, 'body');
      $comments_ids 	 = array_column($comments, 'id');
      $comments_texts  = array_combine($comments_ids, $comments_bodies);
      $comments_texts  = array_map('nl2br', $comments_texts);
      $comments_texts  = json_encode($comments_texts);

      $this->load->view("templates/{$this->template}/author/comments", compact('menu_items', 'metadata', 'pages', 'comments',
                                                                            'pagination','order','filters_base_url','categories', 'comments_texts'));
    }




    public function update_comment_visibility()
    {
      if(! isset($_SESSION['user_id']))
        return;

      $id      = $this->input->post('id');
      $visible = $this->input->post('visible');

      return $this->db->query("UPDATE comments SET comment_visible = ? WHERE comments.id = ? AND 
                               comments.comment_post_id IN (SELECT id FROM posts WHERE posts.post_author_id = ?)", 
                              [$visible, $id, $_SESSION['user_id']]);
    }



    public function posts()
    {
      $menu_items  = $this->get_menu_items();
			$metadata 	 = $this->metadata();
      
      $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);

      $order = $uri_params['order'];

      if($order === 'desc') $order = 'asc';
      elseif($order === 'asc') $order = 'desc';
      else $order = 'asc';

      extract($this->posts_model->get($uri_params, $_SESSION['user_id']));

      $filters_base_url  = base_url("author/posts/orderby");

      $categories = $this->get_categories_subcategories(FALSE);
      $pages      = $this->pages;

      $this->load->view("templates/{$this->template}/author/posts", compact('menu_items', 'metadata', 'pages', 'posts',
                                                                            'pagination','order','filters_base_url','categories'));
    }



    public function posts_by_category()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();
      
      $uri_params = $this->uri->uri_to_assoc(3, ['page', 'id', 'category']);
      $order      = 'asc';
      extract($this->posts_model->get_by_category_2($uri_params, $_SESSION['user_id']));

      $filters_base_url  = base_url('author/posts');
      $categories        = $this->get_categories_subcategories(FALSE);
      $pages            = $this->pages;
      
      $this->load->view("templates/{$this->template}/author/posts", compact('menu_items', 'metadata', 'pages', 'posts',
                                                                            'pagination','order','filters_base_url','categories'));
    }



    public function search_posts()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();

      $uri_params = $this->uri->uri_to_assoc(3, ['page', 'search']);
      $order      = 'asc';

      extract($this->posts_model->search($uri_params, $_SESSION['user_id']));

      $filters_base_url  = base_url('author/posts/orderby');
      $categories        = $this->get_categories_subcategories(FALSE);
      $pages            = $this->pages;
      
      $this->load->view("templates/{$this->template}/author/posts", compact('menu_items', 'metadata', 'pages', 'posts',
                                                                            'pagination','order','filters_base_url','categories'));
    }


    public function trash_by_category()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();
      
      $uri_params = $this->uri->uri_to_assoc(4, ['page', 'id', 'category']);
      $order      = 'asc';
      extract($this->posts_model->get_by_category_2($uri_params, $_SESSION['user_id'], true));

      //dd($posts);
      $filters_base_url  = base_url('author/posts/trash/orderby');
      $categories        = $this->get_categories_subcategories(FALSE);
      $pages            = $this->pages;
      
      $this->load->view("templates/{$this->template}/author/trash", compact('menu_items', 'metadata', 'pages', 'posts',
                                                                            'pagination','order','filters_base_url','categories'));
    }



    public function search_trash()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();

      $uri_params = $this->uri->uri_to_assoc(4, ['page', 'search']);
      $order      = 'asc';

      extract($this->posts_model->search($uri_params, $_SESSION['user_id'], $trashed = true));

      $filters_base_url  = base_url('author/posts/trash/orderby');
      $categories        = $this->get_categories_subcategories(FALSE);
      $pages              = $this->pages;
      
      $this->load->view("templates/{$this->template}/author/trash", compact('menu_items', 'metadata', 'pages', 'posts',
                                                                            'pagination','order','filters_base_url', 'categories'));
    }



    public function restore_posts(string $ids)
    {
      $ids     = array_filter(array_map('trim', explode(',', $ids)));
      $user_id = $_SESSION['user_id'];


      $this->db->query("UPDATE posts SET post_deleted_at = NULL, post_deleted_by = NULL 
                        WHERE posts.id IN ? AND posts.post_author_id = ?", 
                        [$ids, $user_id]);


      if($this->settings['points_per_post'] ?? null)
      {
        $incr = ceil(count($ids) * $this->settings['points_per_post']);
        $this->db->query("UPDATE contributors SET points = points+? WHERE user_id = ?", [$incr, (int)$_SESSION['user_id']]);
        $_SESSION['credit'] = ceil((float)$_SESSION['credit'] + $incr);
      }
      

      $this->session->set_flashdata('form_response', ['type' => 'success', 'response' => 'Berhasil!']);

      redirect('/author/posts/trash');
    }




    public function create_post()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();
      $pages              = $this->pages;

      extract($this->get_categories_subcategories());

      $this->load->view("templates/{$this->template}/author/post_create", compact('categories', 'subcategories_by_parent_id', 'menu_items', 'metadata', 'pages'));
    }
    


    public function store_post()
    {
      $this->form_validation->set_rules('post_title', 'Post title', 'required|trim|strip_tags|is_unique[posts.post_title]')
                            ->set_rules('post_summary', 'Post summary', 'trim|strip_tags')
                            ->set_rules('post_body', 'Post body', 'required|trim|html_escape')
                            ->set_rules('post_category', 'Post category', 'required|trim|numeric|strip_tags')
                            ->set_rules('post_subcategory', 'Post subcategory', 'trim|strip_tags')
                            ->set_rules('post_keywords', 'Post keywords', 'trim|strip_tags');            
      
      if($this->form_validation->run())
      {
        $post_id  = get_auto_increment('posts');

        $post = [
          'post_title'           => $this->input->post('post_title', true),
          'post_slug'            => url_title($this->input->post('post_title', true), '-', true),
          'post_summary'         => $this->input->post('post_summary', true),
          'post_body'            => $this->input->post('post_body', true),
          'post_category_id'     => $this->input->post('post_category', true),
          'post_subcategory_id'  => $this->input->post('post_subcategory', true),
          'post_keywords'        => $this->input->post('post_keywords', true),
          'post_visible'         => 1,
          'post_author_id'       => (int)$_SESSION['user_id'],
        ];

          
        $config['file_name']         = md5($post_id);
        $config['upload_path']       = FCPATH.'uploads/images/';
        $config['allowed_types']     = 'jpg|jpeg|svg|png';
        $config['file_ext_tolower']  = TRUE;
        $config['overwrite']         = TRUE;
        $config['max_size']          = 10*1024*1024; // (10mb)


        $this->load->library('upload', $config);

        if($this->upload->do_upload('post_image'))
        {
          $post_image = $this->upload->data('file_name');
            
          watermark_img($post_image);
          
          $this->db->trans_start();
          $this->db->insert('posts', $post);
          $this->db->insert('images', ['image_name'	=> $post_image, 'image_parent_id' => $post_id]);
          $this->db->trans_complete();
    
          if(! $trans_status = $this->db->trans_status())
          {
            unlink(FCPATH."uploads/images/{$post_image}");

            $this->form_response = ['type' => 'error', 'response' => lang('ui_error')];
            
            $this->session->set_flashdata('form_response', $this->form_response);
            $this->session->set_flashdata('old_post', $_POST);

            redirect('/author/posts/create');
          }
          else
          {
            $loc     = base_url("post/{$post['post_slug']}");
            $lastmod = date('Y-m-d H:i:s');

            $sitemap_url = "<url><loc>{$loc}</loc><lastmod>{$lastmod}</lastmod></url>";

            $this->sitemap_add($sitemap_url);

            $this->form_response = ['type' => 'success', 'response' => lang('ui_done')];
            
            $this->session->set_flashdata('form_response', $this->form_response);

            if($this->settings['points_per_post'] ?? null)
            {
              $this->db->query("UPDATE contributors SET points = points+? WHERE user_id = ?", [$this->settings['points_per_post'], (int)$_SESSION['user_id']]);
              $_SESSION['credit'] = ceil((float)$_SESSION['credit'] + (float)$this->settings['points_per_post']);
            }

            redirect('/author/posts');
          }
        }
        else
        {
          $this->form_response = ['type' => 'error', 'response' => $this->upload->display_errors()];

          $this->session->set_flashdata('form_response', $this->form_response);
          $this->session->set_flashdata('old_post', $_POST);

          redirect('/author/posts/create');
        }
      }
      else
      {
        $this->form_response = ['type' => 'error', 'response' => $this->form_validation->error_array()];

        $this->session->set_flashdata('form_response', $this->form_response);
        $this->session->set_flashdata('old_post', $_POST);

        redirect('/author/posts/create');
      }
    }



    public function edit_post($id)
    {
      if(! ctype_digit($id)) show_404();

      $post = $this->db->query("SELECT posts.*, images.image_name FROM posts USE INDEX(post_author_id, id)
                                LEFT JOIN images USE INDEX(image_parent_id) ON posts.id = images.image_parent_id 
                                WHERE posts.id = ? AND posts.post_author_id = ?", [$id, $_SESSION['user_id']])->row();

      if(! $post) show_404();      

      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();
      $pages       = $this->pages;

      extract($this->get_categories_subcategories());

      $this->load->view("templates/{$this->template}/author/post_edit", compact('post', 'categories', 'subcategories_by_parent_id', 
                                                                                'menu_items', 'metadata', 'pages'));
    }


    public function update_post($id)
    {
      if(! ctype_digit($id)) show_404();


      $this->form_validation->set_rules('post_title', 'Post title', 'required|trim|strip_tags')
                            ->set_rules('post_summary', 'Post summary', 'trim|strip_tags')
                            ->set_rules('post_body', 'Post body', 'required|trim|html_escape')
                            ->set_rules('post_category', 'Post category', 'required|trim|numeric|strip_tags')
                            ->set_rules('post_subcategory', 'Post subcategory', 'trim|strip_tags')
                            ->set_rules('post_keywords', 'Post keywords', 'trim|strip_tags');
    
      if($this->form_validation->run())
      {
        $results = $this->db->query("SELECT COUNT(id) as _count FROM posts USE INDEX(primary) WHERE post_title = ? AND id != ? AND post_author_id = ?",
                                    [$this->input->post('post_title', true), $id, $_SESSION['user_id']])->row();

        if($results->_count > 0)
        {
          $this->form_response = ['type' => 'error', 'response' => lang('ui_title').' '.lang('ui_already_exists')];
            
          $this->session->set_flashdata('form_response', $this->form_response);

          redirect("/author/posts/edit/{$id}");

          return;
        }

        $post = [
          'post_title'           => $this->input->post('post_title', true),
          'post_slug'            => url_title($this->input->post('post_title', true), '-', true),
          'post_summary'         => $this->input->post('post_summary', true),
          'post_body'            => $this->input->post('post_body', true),
          'post_category_id'     => $this->input->post('post_category', true),
          'post_subcategory_id'  => $this->input->post('post_subcategory', true),
          'post_keywords'        => $this->input->post('post_keywords', true),
          'post_visible'         => 1,
          'post_author_id'       => (int)$_SESSION['user_id'],
        ];
          
        $config['file_name']         = md5($id);
        $config['upload_path']       = FCPATH.'uploads/images/';
        $config['allowed_types']     = 'jpg|jpeg|svg|png';
        $config['file_ext_tolower']  = TRUE;
        $config['overwrite']         = TRUE;
        $config['max_size']          = 10*1024*1024; // (10mb)

        if($_FILES['post_image']['tmp_name'] ?? null)
        {
          $md5_id = md5($id);
          
          if($old_image = glob(FCPATH."uploads/images/{$md5_id}.*")[0] ?? null)
          {
            $old_image = basename($old_image);
          }

          $this->load->library('upload', $config);

          if($this->upload->do_upload('post_image'))
          {
            $post_image = $this->upload->data('file_name');
            
            watermark_img($post_image);
            
            if(! $this->db->where('image_parent_id', $id)->update('images', ['image_name'	=> $post_image]))
            {
              if(isset($old_image, $post_image) && $post_image != $old_image)
                unlink(FCPATH."uploads/images/{$post_image}");
  
              $this->form_response = ['type' => 'error', 'response' => lang('ui_error')];
              
              $this->session->set_flashdata('form_response', $this->form_response);
              $this->session->set_flashdata('old_post', $_POST);
  
              redirect("/author/posts/edit/{$id}");
            }
            else
            {
              if(isset($old_image, $post_image) && $post_image != $old_image)
                unlink(FCPATH."uploads/images/{$old_image}");
            }
          }
          else
          {
            $this->form_response = ['type' => 'error', 'response' => $this->upload->display_errors()];
  
            $this->session->set_flashdata('form_response', $this->form_response);
            $this->session->set_flashdata('old_post', $_POST);
  
            redirect("/author/posts/edit/{$id}");
          }  
        }
        
        $this->db->where('id', $id)->update('posts', $post);

        $loc     = base_url("post/{$post['post_slug']}");
        $lastmod = date('Y-m-d H:i:s');

        $sitemap_url = "<url><loc>{$loc}</loc><lastmod>{$lastmod}</lastmod></url>";

        $this->sitemap_add($sitemap_url);

        $this->form_response = ['type' => 'success', 'response' => lang('ui_done')];
        
        $this->session->set_flashdata('form_response', $this->form_response);

        redirect('/author/posts');
      }
      else
      {
        $this->form_response = ['type' => 'error', 'response' => $this->form_validation->error_array()];

        $this->session->set_flashdata('form_response', $this->form_response);
        $this->session->set_flashdata('old_post', $_POST);

        redirect("/author/posts/edit/{$id}");
      }
    }


    public function delete_posts($ids)
    {
      $ids     = array_filter(array_map('trim', explode(',', $ids)));
      $user_id = $_SESSION['user_id'];


      $this->db->query("UPDATE posts SET post_deleted_at = CURRENT_TIMESTAMP, post_deleted_by = ? 
                        WHERE posts.id IN ? AND posts.post_author_id = ?", 
                        [$user_id, $ids, $user_id]);
      

      if($this->settings['points_per_post'] ?? null)
      {
        $incr = ceil(count($ids) * $this->settings['points_per_post']);
        $this->db->query("UPDATE contributors SET points = IF(points-? >= 0, points-?, 0) WHERE user_id = ?", [$incr, $incr, (int)$_SESSION['user_id']]);

        $_SESSION['credit'] = ceil((float)$_SESSION['credit'] - $incr);
      }


      $this->session->set_flashdata('form_response', ['type' => 'success', 'response' => 'Berhasil!']);

      redirect('/author/posts');
    }


    public function update_post_visibility()
    {
      if(! $post_id = $this->input->post('postId'))
        show_404();

      $this->db->query("UPDATE posts SET post_visible = IF(post_visible = 1, 0, 1) WHERE id = ? AND post_author_id = ?", [$post_id, $_SESSION['user_id']]);
    }


    public function add_subcategory()
    {
      $this->form_validation->set_rules('categoryId', 'Category id', 'required|trim|numeric')
                            ->set_rules('title', 'Subcategory title', 'trim|strip_tags|required');            
      
      if(! $this->form_validation->run())
        show_404();

      $subcategory = [
        'subcategory_title'     => $this->input->post('title', TRUE),
        'subcategory_slug'      => url_title($this->input->post('title'), '-', TRUE),
        'subcategory_parent_id' => $this->input->post('categoryId', TRUE),
      ];

      $insert_query = $this->db->insert_string('subcategories', $subcategory);
      $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);

      $res = $this->db->query($insert_query);
    
      $this->output->set_content_type('application/json')
                   ->set_output(json_encode(['res' => $res, 'insertId' => $this->db->insert_id()]));
    }



    public function add_category()
    {
      $this->form_validation->set_rules('title', 'Category title', 'trim|strip_tags|required');            
      
      if(! $this->form_validation->run())
        show_404();

      $category = [
        'category_title'  => $this->input->post('title', TRUE),
        'category_slug'   => url_title($this->input->post('title'), '-', TRUE)
      ];

      $insert_query = $this->db->insert_string('categories', $category);
      $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);

      $res = $this->db->query($insert_query);
    
      $this->output->set_content_type('application/json')
                   ->set_output(json_encode(['res' => $res, 'insertId' => $this->db->insert_id()]));
    }


    
    public function trash()
    {
      $menu_items  = $this->get_menu_items();
			$metadata 	 = $this->metadata();
      
      $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);

      $order = $uri_params['order'];

      if($order === 'desc') $order = 'asc';
      elseif($order === 'asc') $order = 'desc';
      else $order = 'asc';

      extract($this->posts_model->get($uri_params, $_SESSION['user_id'], true));

      $filters_base_url  = base_url("author/posts/trash/orderby");

      $categories = $this->get_categories_subcategories(FALSE);
      $pages      = $this->pages;

      $this->load->view("templates/{$this->template}/author/trash", compact('menu_items', 'metadata', 'pages', 'posts',
                                                                            'pagination','order','filters_base_url','categories'));
    }
    


    public function settings()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();
      $pages       = $this->pages;
      
      $author =  $this->db->query("SELECT users.id, users.user_name as username, users.user_email as email, users.user_firstname as firstname, 
                                    users.user_lastname as lastname, 
                                    users.user_phone as phone, users.user_country as country, users.user_facebook as facebook, users.user_twitter as twitter, 
                                    users.user_pinterest as twitter, users.user_linkedin as linkedin, users.user_youtube as youtube, users.user_pinterest as pinterest, users.user_about as about,
                                    contributors.user_firstname as firstname_alt, contributors.user_lastname as lastname_alt, 
                                    contributors.user_phone_number as phone_alt, contributors.user_bank_account_number as bank_account_number, 
                                    contributors.user_bank_name as bank_name, contributors.user_card_id_1 as card_id_1, contributors.user_card_id_2 as card_id_2,
                                    contributors.user_description as about_alt, profiles.image_name as avatar FROM users USE INDEX(primary)
                                    LEFT JOIN contributors USE INDEX (user_id) ON users.id = contributors.user_id
                                    LEFT JOIN profiles USE INDEX (image_parent_id) ON profiles.image_parent_id = users.id
                                    WHERE users.id = ?", [$_SESSION['user_id']])->row();

  
      if($this->input->method() === 'post')
      {
        $user = [
          'user_firstname' => $this->input->post('user_firstname', true),
          'user_lastname' => $this->input->post('user_lastname', true),
          'user_phone' => $this->input->post('user_phone', true),
          'user_twitter' => $this->input->post('user_twitter', true),
          'user_facebook' => $this->input->post('user_facebook', true),
          'user_pinterest' => $this->input->post('user_pinterest', true),
          'user_linkedin' => $this->input->post('user_linkedin', true),
          'user_youtube' => $this->input->post('user_youtube', true),
          'user_about' => $this->input->post('user_about', true),
        ];

        if($new_password = $this->input->post('new_password'))
        {
          $user['user_pwd'] = password_hash($new_password, PASSWORD_ARGON2I);
        }

        $contributor = [
          'user_firstname' => $this->input->post('user_firstname', true),
          'user_lastname' => $this->input->post('user_lastname', true),
          'user_phone_number' => $this->input->post('user_phone', true),
          'user_bank_account_number' => $this->input->post('user_bank_account_number', true),
          'user_bank_name' => $this->input->post('user_bank_name', true),
          'user_description' => $this->input->post('user_about', true),
          'user_id' => $author->id
        ];

        $this->load->library('upload');

        $config =  ['file_name' => "{$author->id}-1",
                    'upload_path' => FCPATH.'uploads/ids/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|docx|doc',
                    'file_ext_tolower'  => TRUE,
                    'overwrite' => TRUE,
                    'max_size'  => 10*1024*1024];
        

        if($_FILES['user_image']['tmp_name'] ?? null)
        {
          $config['file_name'] = md5($author->id);
          $config['upload_path'] = FCPATH.'uploads/profiles/';
          $config['allowed_types'] = 'jpg|jpeg|png';

          $this->upload->initialize($config, TRUE);

          if($this->upload->do_upload('user_image'))
          {
            $user_image = $this->upload->data('file_name');
          }
        }
      
        if($_FILES['user_card_id_1']['tmp_name'] ?? null)
        {
		    	$this->upload->initialize($config, TRUE);

          if($this->upload->do_upload('user_card_id_1'))
          {
            $contributor['user_card_id_1'] = $this->upload->data('file_name');
          }
        }

        if($_FILES['user_card_id_2']['tmp_name'] ?? null)
        {
          $config['file_name']  = "{$author->id}-2";

          $this->upload->initialize($config, TRUE);

          if($this->upload->do_upload('user_card_id_2'))
          {
            $contributor['user_card_id_2'] = $this->upload->data('file_name');
          }
        }

        if(isset($user_image))
        {
          $this->db->query("INSERT INTO profiles (image_name, image_parent_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE image_name = ?",
                          [$user_image, $author->id, $user_image]);
        }

        $this->db->where('id', $author->id)->update('users', $user);
        
        $this->db->where('user_id', $author->id)->on_duplicate('contributors', $contributor);

        $this->form_response = ['type' => 'success', 'response' => lang('ui_done')];
        
        $this->session->set_flashdata('form_response', $this->form_response);

        redirect('/author/settings');
      }

      $this->load->view("templates/{$this->template}/author/settings", compact('menu_items', 'metadata', 'pages', 'author'));
    }



    public function withdrawal()
    {
      $menu_items  = $this->get_menu_items();
      $metadata 	 = $this->metadata();
      $pages       = $this->pages;

      $user = $this->db->query("SELECT IFNULL(contributors.user_firstname, users.user_firstname) AS firstname, IFNULL(contributors.user_lastname, users.user_lastname) AS lastname,
                                contributors.user_bank_account_number, contributors.user_bank_name, contributors.user_card_id_1, contributors.user_card_id_2
                                FROM contributors USE INDEX(active, user_id) 
                                LEFT JOIN users USE INDEX(primary) ON users.id = contributors.user_id
                                WHERE active = 0 AND user_id = ?", [$_SESSION['user_id']])->row();
      
      settype($user, 'array');

      if(count(array_filter($user)) === count(array_keys($user)))
      {
        $this->db->query("UPDATE contributors USE INDEX (user_id) SET active = 1 WHERE user_id = ?", [$_SESSION['user_id']]);
      }

      $author = $this->db->query("SELECT contributors.*, IF(contributors.user_card_id_1 IS NULL OR contributors.user_card_id_2 IS NULL, 0, 1) AS _active, 
                                  COUNT(posts.id) AS posts_count FROM contributors USE INDEX(primary)
                                  LEFT JOIN posts USE INDEX(post_author_id) ON posts.post_author_id = contributors.user_id
                                  WHERE user_id = ?", [$_SESSION['user_id']])->row();

      if($this->input->method() === 'post')
      {
        if(! $author->_active)
        {
          $this->session->set_flashdata('form_response', ['type' => 'error', 'response' => lang('ui_author_action_required')]);

          redirect('/author/withdrawal');
        }

        $withdrawal_points = (int)$this->input->post('withdrawal_points');
        $minimum_points    = (int)ceil($this->settings['minimum_withdrawal']/$this->settings['exchange_rate']) ?? 0;

        if(! $author->points < $withdrawal_points)
        {
          $this->session->set_flashdata('form_response', ['type' => 'error', 'response' => "Mintalah <a href='https://api.whatsapp.com/send?phone=62895357296100&text=Mohon%20bantuan%20*Withdraw*%20poin%20saya.%0A%0A*Nama%20Akun%3A*%0A*Username%3A*%0A*Email%3A*%0A*Nama%20Lengkap%3A*%0A*Nama%20Bank%3A*%0A*No.%20Rekening%3A*' target='_blank'><span style='color: #DF135A;'>bantuan</span></a> karyawan kami. (Anda memiliki {$author->points} poin)"]);

          redirect('/author/withdrawal');
        }

        if(! $minimum_points)
        {
          $this->session->set_flashdata('form_response', ['type' => 'error', 'response' => 'Tim Medialova belum mengonfigurasi pembayaran']);

          redirect('/author/withdrawal');
        }

        $this->form_validation->set_rules('withdrawal_points', "Poin", "required|trim|numeric|greater_than_equal_to[$minimum_points]", 
                                          ['greater_than_equal_to' => "Hubungi kami. (Minimum $minimum_points poin)"]);

        if(! $this->form_validation->run())
        {
          $this->form_response = ['type' => 'error', 'response' => $this->form_validation->error_array()];

          $this->session->set_flashdata('form_response', $this->form_response);
          $this->session->set_flashdata('old_post', $_POST);

          redirect('/author/withdrawal');
        }
        else
        {
          $this->db->query("INSERT INTO payments (user_id, points) VALUES(?, ?)", [$_SESSION['user_id'], $withdrawal_points]);
          
          $this->session->set_flashdata('form_response', ['type' => 'success', 'response' => lang('ui_withdrawal_success')]);

          redirect('/author/withdrawal');
        }
      }

      $this->load->view("templates/{$this->template}/author/withdrawal", compact('menu_items', 'metadata', 'pages', 'author'));
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


    protected function get_categories_subcategories($subcategories = TRUE)
    {
        $categories = $this->categories_model->get_names_and_ids();
        if(!$subcategories)
        {
            return $categories;
        }
        $subcategories  = $this->subcategories_model->get_names_ids_and_parent_ids();
        $subcategories_by_parent_id = [];
        foreach($subcategories as $subcategory)
        {
            $parent_id  = $subcategory->subcategory_parent_id;
            # For Semantic-ui dropdown list ------------------ #
            $subcat_arr = ['value' => $subcategory->subcategory_id, 
                            'name'  => ucfirst($subcategory->subcategory_title)];
            $subcategories_by_parent_id[$parent_id]['values'][] = $subcat_arr;
        }
        return compact('categories', 'subcategories_by_parent_id');
    }



    public function sitemap_add($sitemap_url)
    {
        $file = "{$_SERVER['DOCUMENT_ROOT']}/{$this->sitemap_prefix}-sitemap.xml";

        $sitemap_url = preg_replace("/(\n|\r|\t)+/", '', $sitemap_url);

        if(file_exists($file))
        {
            $sitemap = file_get_contents($file);
            $sitemap = str_replace("</urlset>", 
                                    "{$sitemap_url}</urlset>", 
                                    $sitemap);

            $sitemap = preg_replace("/(\n|\r|\t)+/", "", $sitemap);

            file_put_contents($file, $sitemap);
        }
        else
        {
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$sitemap_url.'</urlset>';

            file_put_contents($file, $sitemap);
        }
    }



    public function sitemap_update($item_slug, $sitemap_url)
    {
        $file = "{$_SERVER['DOCUMENT_ROOT']}/{$this->sitemap_prefix}-sitemap.xml";

        $sitemap_obj = simplexml_load_file($file);

        if($sitemap_obj)
        {
            $sitemap_arr = array_merge(...array_values((array)$sitemap_obj));
            $locs         = array_column($sitemap_arr, 'loc');
            $sitemap_arr = array_combine($locs, $sitemap_arr);

            $sitemap_arr[$item_slug] = simplexml_load_string($sitemap_url);

            $sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach($sitemap_arr as $url)
            {
                $sitemap .= "
                            <url>
                                <loc>{$url->loc}\</loc>
                                <lastmod>{$url->lastmod}</lastmod>
                            </url>";
            }

            $sitemap .= '</urlset>'; 

            $sitemap = preg_replace("/(\n|\r|\t)+/", "", $sitemap);

            file_put_contents($file, $sitemap);
        }
        else
        {
            file_put_contents($file, '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$sitemap_url.'</urlset>');
        }
    }

	}