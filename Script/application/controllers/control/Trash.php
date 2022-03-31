<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Trash extends Admin_Core_Controller
	{
        private $action;
        private $ids;


	    public function __construct()
        {
            parent::__construct();
            
            $this->load->model(['control/posts_model',
                                'control/pages_model',
                                'control/users_model',
                                'control/comments_model',
                                'control/subcategories_model',
                                'control/categories_model']);
            check_permission(function($response) {
                if(!$response && !has_permission('trash', 'index'))
                    redirect('control/dashboard');
            });
        }



        public function posts()
        {
            $this->update_delete();
            $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order', 'search', 'id', 'category']);
 
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->posts_model->get_deleted($uri_params));
            $page_title        = lang('ui_trash').' - '.lang('ui_posts');
            $partial           = '_trash_posts';
            $breadcrumbs       = 'Kontrol / '.lang('ui_trash').' / '.lang('ui_posts');
            $filters_base_url  = base_url('control/trash/posts/orderby');
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



        public function pages()
        {
            $this->update_delete();
            $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order', 'search', 'id']);
 
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->pages_model->get_deleted($uri_params));
            $page_title        = lang('ui_trash').' - '.lang('ui_pages');
            $partial           = '_trash_pages';
            $breadcrumbs       = 'Kontrol / '.lang('ui_trash').' / '.lang('ui_pages');
            $filters_base_url  = base_url('control/trash/pages/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'pages',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
        }



        public function users()
        {
            $this->update_delete();
            $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order']);
            $order      = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->users_model->get_deleted($uri_params));
            $page_title        = lang('ui_trash').' - '.lang('ui_users');
            $partial           = '_trash_users';
            $breadcrumbs       = 'Kontrol / '.lang('ui_trash').' / '.lang('ui_users');
            $filters_base_url  = base_url("control/trash/users/orderby");
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'users',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
        }



        public function comments()
        {
            $this->update_delete();
            $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order', 'id']);
 
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->comments_model->get_deleted($uri_params));
            $page_title        = lang('ui_trash').' - '.lang('ui_commentar');
            $partial           = '_trash_comments';
            $breadcrumbs       = 'Kontrol / '.lang('ui_trash').' / '.lang('ui_commentar');
            $filters_base_url  = base_url('control/trash/comments/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'comments',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
        }



        public function categories()
        {
            $this->update_delete();
            $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order', 'id']);
 
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->categories_model->get_deleted($uri_params));
            $page_title        = lang('ui_trash').' - '.lang('ui_categories');
            $partial           = '_trash_categories';
            $breadcrumbs       = 'Kontrol / '.lang('ui_trash').' / '.lang('ui_categories');
            $filters_base_url  = base_url('control/trash/categories/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'categories',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
        }



        public function subcategories()
        {
            $this->update_delete();
            $uri_params = $this->uri->ruri_to_assoc(3, ['page', 'orderby', 'order', 'id']);
 
            $order = $uri_params['order'];
            if($order === 'desc') $order = 'asc';
            elseif($order === 'asc') $order = 'desc';
            else $order = 'asc';
            extract($this->subcategories_model->get_deleted($uri_params));
            $page_title        = lang('ui_trash').' - '.lang('ui_subcategories');
            $partial           = '_trash_subcategories';
            $breadcrumbs       = 'Kontrol / '.lang('ui_trash').' / '.lang('ui_subcategories');
            $filters_base_url  = base_url('control/trash/subcategories/orderby');
            $this->load->view('control/items', compact('page_title',
                                                       'partial',
                                                       'breadcrumbs',
                                                       'subcategories',
                                                       'pagination',
                                                       'order',
                                                       'filters_base_url'));
        }



        private function update_delete()
        {
            if($this->input->method() === 'post')
            {
                $table       = $this->router->method;
                $model_name  = "{$table}_model";
                $action      = strtolower($this->input->post('action'));
                $ids         = json_decode($this->input->post('ids', TRUE));
                $valid_input  = is_array($ids);
                $valid_action = preg_match('/^(delete|restore)$/i', $action);

                if(!$valid_action || !$valid_input)
                    show_404();

                if($action === 'restore')
                {
                    // All users with admin access can restore
                    // deleted items as long as they have
                    // permission for that
                    if(!is_main() && !has_permission('trash', 'update'))
                    {
                        $this->session->set_flashdata('form_response',
                        ['type' => 'error', 'response' => 'Tindakan tidak diizinkan']);
                        
                        redirect("control/trash/{$table}");
                    }

                    if($response = $this->$model_name->restore($ids))
                    {
                        $has_sitemap = preg_match('/^(posts|categories|subcategories|pages)$/', $table);

                        if($has_sitemap)
                        {
                            $columns_prefixes = [
                              'posts' => 'post',
                              'pages' => 'page',
                              'subcategories' => 'subcategory',
                              'categories' => 'category'
                            ];

                            $this->sitemap_prefix = $table;
                            $this->columns_prefix = $columns_prefixes[$table];
                            $this->model          = $model_name;

                            $this->sitemap_regenerate();
                        }
                    }
                }
                else
                {
                    // Only admins (including the main one) 
                    // can delete items definitively
                    if((!is_main() && !is_admin())
                       || !has_permission('trash', 'delete'))
                    {
                        $this->session->set_flashdata('form_response',
                        ['type' => 'error', 'response' => 'Tindakan tidak diizinkan']);
                        
                        redirect("control/trash/{$table}");
                    }
                    
                    $response = $this->$model_name->delete($ids);
                }
                
                $form_response = $response
                                 ? ['type' => 'success', 'response' => 'Berhasil!']
                                 : ['type' => 'error', 'response' => 'Error!'];
                
                $this->session->set_flashdata('form_response', $form_response);
                
                redirect("control/trash/{$table}");
            }
        }
    }