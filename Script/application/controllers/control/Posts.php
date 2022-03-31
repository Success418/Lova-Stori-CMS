<?php
  
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Posts extends Admin_Core_Controller
  {
        protected $model            = 'posts_model';
        protected $columns_prefix   = 'post';
        protected $sitemap_prefix   = 'posts';


      public function __construct()
        {
            parent::__construct();
            
            $this->load->model(['control/posts_model',
                                'control/subcategories_model',
                                'control/categories_model']);
            check_permission(function($response) {
                $allowed_methods = in_array($this->router->method, 
                                            ['search', 'get_by_category']);
                                
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
            extract($this->posts_model->get($uri_params));
            $page_title        = lang('ui_posts');
            $partial           = '_posts';
            $breadcrumbs       = 'Kontrol / '.lang('ui_posts');
            $filters_base_url  = base_url('control/posts/orderby');
            $categories        = $this->get_categories_subcategories(FALSE);
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'posts',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url',
                                                       'categories'));
        }




        public function get_by_category()
        {
            $uri_params = $this->uri->uri_to_assoc(3, ['page', 'id', 'category']);
            $order      = 'asc';
            extract($this->posts_model->get_by_category($uri_params));
            $page_title        = lang('ui_posts');
            $partial           = '_posts';
            $breadcrumbs       = 'Kontrol / '.lang('ui_posts');
            $filters_base_url  = base_url('control/posts/orderby');
            $categories        = $this->get_categories_subcategories(FALSE);
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'posts',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url',
                                                       'categories'));
        }




        public function search()
        {
            $uri_params = $this->uri->uri_to_assoc(3, ['page', 'search']);
            $order      = 'asc';
            extract($this->posts_model->search($uri_params));
            $page_title        = lang('ui_posts');
            $partial           = '_posts';
            $breadcrumbs       = 'Kontrol / '.lang('ui_posts');
            $filters_base_url  = base_url('control/posts/orderby');
            $categories        = $this->get_categories_subcategories(FALSE);
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'posts',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url',
                                                       'categories'));
        }




        public function add()
        {            
            if($this->input->method() === 'post')
                $this->add_action();
            $page_title     = lang('ui_post').' - '.lang('ui_add');
            $partial        = '_post';
            $breadcrumbs    = 'Kontrol / '.lang('ui_post').' / '.lang('ui_add');
            
            extract($this->get_categories_subcategories());

            $this->load->view('control/item', compact('page_title', 
                                                        'partial', 
                                                        'breadcrumbs',
                                                        'categories',
                                                        'subcategories_by_parent_id'));
        }




        private function add_action()
        {
            $this->form_validation->set_rules('post_title', 'Post title', 
                                              'required|trim|strip_tags|is_unique[posts.post_title]')
                                  ->set_rules('post_summary', 'Post summary', 'trim|strip_tags')
                                  ->set_rules('post_body', 'Post body', 
                                              'required|trim|html_escape')
                                  ->set_rules('post_category', 'Post category', 
                                              'required|trim|strip_tags')
                                  ->set_rules('post_subcategory', 
                                              'Post subcategory', 'trim|strip_tags')
                                  ->set_rules('post_keywords', 'Post keywords', 
                                              'trim|strip_tags');            
            

            if($this->form_validation->run())
            {
                $post_id = get_auto_increment('posts');
                $post    = [];
                $post['post_author_id']      = $_SESSION['user_id'];
                $post['post_title']          = $this->input->post('post_title', TRUE);
                $post['post_slug']           = url_title($post['post_title'], '-', TRUE);
                $post['post_summary']        = $this->input->post('post_summary', TRUE);
                $post['post_body']           = $this->input->post('post_body', FALSE);
                $post['post_keywords']       = $this->input->post('post_keywords', TRUE);
                $post['post_category_id']    = $this->input->post('post_category', TRUE);
                $post['post_subcategory_id'] = $this->input->post('post_subcategory', TRUE);
                $post['post_visible']        = isset($_POST['publish']) ? 1 : 0;
                # FILE UPLOAD CONFIG -----------------------------------
                $config['file_name']         = md5($post_id);
                $config['upload_path']       = FCPATH.'uploads/images/';
                $config['allowed_types']     = 'gif|jpg|jpeg|svg|png|ico';
                $config['file_ext_tolower']  = TRUE;
                $config['overwrite']         = TRUE;
                # ------------------------------------------------------
               
                $this->load->library('upload', $config);

                if($this->upload->do_upload('post_image'))
                {
                    $post_image = $this->upload->data('file_name');
                    $response   = $this->posts_model->add($post, $post_image); 
                    $this->form_response = $response
                                           ? ['type' => 'success', 'response' => 'Berhasil!']
                                           : ['type' => 'error', 'response' => 'Error!'];
                    if(!$response) unlink(FCPATH."uploads/images/{$post_image}");

                    if($response)
                    {
                        $loc     = base_url("post/{$post['post_slug']}");
                        $lastmod = date('Y-m-d H:i:s');

                        $sitemap_url = "<url><loc>{$loc}</loc><lastmod>{$lastmod}</lastmod></url>";

                        $this->sitemap_add($sitemap_url);
                        
                        watermark_img($post_image);
                    }
                }
                else
                {
                    $this->form_response = ['type'     => 'error', 
                                            'response' => $this->upload->display_errors()];
                }
            }
            else
            {
                $this->form_response = ['type'     => 'error',
                                        'response' => $this->form_validation->error_array()];
            }

            $this->session->set_flashdata('form_response', $this->form_response);

            if($this->form_response['type'] === 'success')
            {
                $destination = 'posts';
            }
            else
            {
                $this->session->set_flashdata($this->input->post());
                $destination = 'posts/add';
            }
            redirect("control/{$destination}");
        }




        public function update(int $post_id)
        {
            if($this->input->method() === 'post')
                $this->update_action($post_id);

            $page_title     = lang('ui_post').' - '.lang('ui_edit');
            $partial        = '_post_edit';
            $breadcrumbs    = 'Kontrol / '.lang('ui_post').' / '.lang('ui_edit');

            extract($this->get_categories_subcategories());

            if(!$post = $this->posts_model->get_post($post_id))
                redirect(base_url('control/posts'));

            $this->load->view('control/item', compact('page_title', 
                                                      'partial',
                                                      'post', 
                                                      'breadcrumbs',
                                                      'categories',
                                                      'subcategories_by_parent_id'));
        }




        private function update_action(int $post_id)
        {            
            $post_data = json_decode(base64_decode($this->input->post('post_data')));

            if(!$post_data)
                redirect("control/posts/edit/{$post_data->id}");

            $this->form_validation->set_rules('post_title', 'Post title', 
                                              'required|trim|strip_tags')
                                  ->set_rules('post_summary', 'Post summary', 'trim|strip_tags')
                                  ->set_rules('post_body', 'Post body', 
                                              'required|trim|html_escape')
                                  ->set_rules('post_category', 'Post category', 
                                              'required|trim|strip_tags')
                                  ->set_rules('post_subcategory', 
                                              'Post subcategory', 'trim|strip_tags')
                                  ->set_rules('post_keywords', 'Post keywords', 
                                              'trim|strip_tags');
            if($this->form_validation->run())
            {
                $post                        = [];
                $post['post_title']          = $this->input->post('post_title', TRUE);
                $post['post_slug']           = url_title($post['post_title'], '-', TRUE);
                $post['post_summary']        = $this->input->post('post_summary', TRUE);
                $post['post_body']           = $this->input->post('post_body', FALSE);
                $post['post_keywords']       = $this->input->post('post_keywords', TRUE);
                $post['post_category_id']    = $this->input->post('post_category', TRUE);
                $post['post_subcategory_id'] = $this->input->post('post_subcategory', TRUE);
                $post['post_updated_at']     = date('Y-m-d H:i:s');

                $images_abs_path    = FCPATH.'uploads/images';
                // if post title has been changed
                if($post_data->title != $post['post_title'])
                {
                    $post_title_changed = TRUE;
                    $is_unique          = $this->posts_model->is_unique(
                                                    'posts',
                                                    ['id !=', 'post_title'], 
                                                    [$post_data->id, $post['post_title']]);
                   
                    if(!$is_unique)
                    {
                        $this->form_response = ['type'     => 'error',
                                                'response' => "Post title [{$post['post_title']}] already exists"];
                        $this->session->set_flashdata('form_response', $this->form_response);
                        redirect("control/posts/edit/{$post_data->id}");
                    }
                }
                
                if($this->input->post('post_image_changed', TRUE))
                {
                    # FILE UPLOAD CONFIG -----------------------------------
                    $config['upload_path']       = FCPATH.'uploads/images/';
                    $config['allowed_types']     = 'gif|jpg|jpeg|svg|png|ico';
                    $config['file_ext_tolower']  = TRUE;
                    $config['overwrite']         = TRUE;
                    $config['file_name']         = md5($post_id);
                    # -------------------------------------------------------
                    
                    $imgs = glob("{$images_abs_path}/{$config['file_name']}.*");
                    foreach($imgs as $img) unlink($img);
                    $this->load->library('upload', $config);
                    if(!$this->upload->do_upload('post_image'))
                    {
                        $this->form_response = ['type'     => 'error', 
                                                'response' => $this->upload->display_errors()];
                        $this->session->set_flashdata('form_response', $this->form_response);
                        redirect("control/posts/edit/{$post_data->id}");
                    }
                    $post_image = $this->upload->data('file_name');
                    watermark_img($post_image);
                }

                $response = $this->posts_model->update($post_data->id, 
                                                       $post, 
                                                       $post_image ?? NULL);

                if($response)
                {
                    $loc        = base_url("post/{$post['post_slug']}");
                    $lastmod    = date('Y-m-d H:i:s');
                    $item_slug  = base_url("post/{$post_data->slug}");

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
            redirect("control/posts/edit/{$post_data->id}");
        }




        public function update_pin()
        {
            $id     = $this->input->post('id', TRUE);
            $pinned = $this->input->post('pinned', TRUE);
            
            if(preg_match('/^(\d+)$/', $id) && preg_match('/^(0|1)$/', $pinned))
               $this->posts_model->update_pin_status($id, $pinned);
            else
                show_404();
        }




        public function update_recommendation()
        {
            $id          = $this->input->post('id', TRUE);
            $recommended = $this->input->post('recommended', TRUE);
            if(preg_match('/^(\d+)$/', $id) && preg_match('/^(0|1)$/', $recommended))
               $this->posts_model->update_recommendation_status($id, $recommended);
            else
                show_404();
        }




        public function delete($ids)
        {   
            if(!$ids_arr = json_decode($ids))
                show_404();

            $response = $this->posts_model->move_to_trash($ids_arr);

            if($response)
                $this->sitemap_regenerate();

            $this->form_response = $response
                                   ? ['type' => 'success', 'response' => 'Berhasil!']
                                   : ['type' => 'error', 'response' => 'Tindakan tidak diizinkan'];

            $this->session->set_flashdata('form_response', $this->form_response);
            
            redirect("control/posts");
        }
    }