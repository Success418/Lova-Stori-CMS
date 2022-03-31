<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Core_Controller extends CI_Controller
    {
        protected $form_response;
        
        public function __construct()
        {
            Parent::__construct();
            
            $this->load->library(['session', 'form_validation'])
                       ->helper(['date', 'cookie', 'language']);
            
            $lang = get_cookie('lang') ?? 'indonesia';

            $this->config->set_item('language', $lang);

            $this->lang->load(['ext_lang', 'ui_lang']);
            
            $this->set_settings();

            if(! maintenance_access_allowed())
            {
                exit(file_get_contents('./application/views/templates/maintenance.php'));
            }
        }

        protected function set_settings()
        {
            $this->load->library('session')
                       ->model('control/settings_model')
                       ->driver('cache', ['adapter' => 'apc', 'backup' => 'file'])
                       ->config('main_perms');
            if (!$settings = $this->cache->get('settings'))
            {
                $settings = $this->settings_model->get_settings();
                $this->cache->save('settings', $settings, 31536000);
            }
            $main_perms  = ['main' => $this->config->item('main_perms')];
            $perms       = json_decode($settings['site_permissions'], TRUE);
            $settings['site_permissions'] = json_encode(array_merge($main_perms, (array)$perms));
            $this->settings = $settings;
        }
    }
    
    class Admin_Core_Controller extends Core_Controller
    {
        public function __construct()
        {
            Parent::__construct();
            if(!has_admin_access())
                redirect('control/dashboard');
            $_ENV['perms'] = json_decode($this->settings['site_permissions']);
        }



        public function update_visibility()
        {
            if($this->input->method() === 'get')
                show_404();
            $id       = $this->input->post('id', TRUE);
            $visible  = $this->input->post('visible', TRUE);
            $column   = "{$this->columns_prefix}_visible";
            $response = ['response' => ''];
            if(preg_match('/^(\d+)$/', $id) && preg_match('/^(0|1)$/', $visible))
            {
                $this->{$this->model}->update_visibility("{$this->columns_prefix}_visible", $id, $visible);
            }
        }



        protected function move_to_trash($ids, $additional_conds = NULL)
        {
            if($ids_arr = json_decode($ids, TRUE))
            {           
                $response = $this->{$this->model}->move_to_trash($ids_arr, $additional_conds);
                
                $this->form_response = $response
                                       ? ['type' => 'success', 'response' => 'Done!']
                                       : ['type' => 'error', 'response' => 'Error!'];
                $this->session->set_flashdata('form_response', $this->form_response);
            }
            redirect("control/{$this->model}");
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


        
        protected function sitemap_regenerate()
        {
            // sitemap filename prefix is the same as the db table name

            $sitemap_urls = $this->{$this->model}
                                  ->get_sitemap_urls($this->sitemap_prefix, 
                                                     $this->columns_prefix);

            if($sitemap_urls)
            {
                $sitemap_urls = array_column($sitemap_urls, 'url');

                $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.implode('', $sitemap_urls).'</urlset>';

                $file = "{$_SERVER['DOCUMENT_ROOT']}/{$this->sitemap_prefix}-sitemap.xml";

                if(file_exists($file))
                    file_put_contents($file, $xml);
            }
        }
    }
    
    class Home_Core_Controller extends Core_Controller
    {
        public $template = null;

        public function __construct()
        {
            Parent::__construct();
            $this->load->model(['home/posts_model',
                                'home/pages_model',
                                'home/subcategories_model',
                                'home/categories_model',
                                'home/comments_model',
                                'home/dashboard_model'])
                       ->library('user_agent');


            $this->template = $this->settings['site_template'] ?? 'default';
        }
        public function get_menu_items()
        {
            $grouped_menu_items = [];
            if($menu_items = $this->posts_model->get_menu_items())
            {
                foreach($menu_items as $menu_item)
                {
                    $grouped_menu_items[$menu_item->category_id]['name'] = $menu_item->category_title;
                    $grouped_menu_items[$menu_item->category_id]['slug'] = base_url('posts/category/'.url_title($menu_item->category_title, '-', TRUE));
                    if(!empty($menu_item->subcategory_id && $menu_item->subcategory_title))
                    {
                        $grouped_menu_items[$menu_item->category_id]['subcategories'][] = 
                        ['name' => $menu_item->subcategory_title,
                         'slug' => base_url('posts/subcategory/'.url_title($menu_item->subcategory_title, '-', TRUE))];
                    }
                }
            }
            return $grouped_menu_items;
        }
        public function update_analytics()
        {
            if(!isset($_SESSION['analytics']))
            {
                $analytics   = $this->dashboard_model->get_analytics();
                $analytics   = array_map('json_decode', (array)$analytics);
                $browser     = $this->agent->browser() ?? 'other';
                $os          = $this->agent->platform() ?? 'other';
                $robot       = $this->agent->robot();
                $screen_size = $this->input->post('screen_size');
                
                if($this->agent->is_robot())
                {
                    init_increase_val($analytics['analytics_robots'], 
                                        $robot);
                }

                if(array_keys_exist(['width', 'height'], (array)$screen_size))
                {
                    $screen_size = "{$screen_size['width']}x{$screen_size['height']}";
                    
                    init_increase_val($analytics['analytics_screen_sizes'], 
                                        $screen_size);
                }

                init_increase_val($analytics['analytics_browsers'], 
                                    $browser);

                init_increase_val($analytics['analytics_operating_systems'],
                                    $os);

                $analytics = array_map('json_encode', $analytics);
                
                $this->dashboard_model->update_analytics($analytics);

                $this->session->set_tempdata('analytics', TRUE, 60);
            }
        }
        protected function base($popular_posts_limit = null, $random_posts_limit = null, $recommended_posts_limit = null, $latest_comments_limit = null)
        {
            $menu_items        = $this->get_menu_items();
            
            $popular_posts     = $this->posts_model->get_ordered_by('post_views', 'ASC', $popular_posts_limit ?? 4);
            
            $random_posts      = $this->posts_model->get_ordered_by('id', 'RANDOM', $random_posts_limit ?? 4);
            
            $recommended_posts = $this->posts_model->get_ordered_by('post_recommended', 'DESC', $recommended_posts_limit ?? 4);

            $latest_comments   = $this->comments_model->get_latest($latest_comments_limit ?? 5);

            $banners = [];

            $route = $this->uri->segment(1);

            if(is_null($route) || preg_match('/^(post|posts)$/i', $route))
            {
              $banners =  $this->db->select('DISTINCT ad_ref, compaigns.*', false)
                                 ->from('compaigns USE INDEX(active, primary)')
                                 ->join('ads', 'ads.ref = compaigns.ad_ref')
                                 ->where(['active' => 1, 'compaigns.views <' => 'round(compaigns.budget / ads.price)'], null, FALSE);

              if(is_null($route))
              {
                $banners->like('compaigns.ad_ref', 'hb', 'after');
              }
              else
              {
                $banners->not_like('compaigns.ad_ref', 'hb', 'after');

                if($route === 'posts')
                {
                    $banners->not_like('compaigns.ad_ref', 'pb', 'after');
                }
              }

              $banners = $banners->get()->result_object();

              $banners = array_combine(array_column((array)$banners, 'ad_ref'), $banners);
              
              if($banners_ids = array_column($banners, 'id'))
              {
                $this->db->set('views', 'views+1', FALSE)
                         ->where_in('id', $banners_ids)
                         ->update('compaigns USE INDEX(primary)');
              }
            }
            
            $pages             = $this->pages_model->get_pages();
            $archive           = $this->posts_model->get_archive();
            $authors           = $this->posts_model->get_authors();

            return compact('menu_items', 'popular_posts', 
                           'random_posts', 'recommended_posts', 
                           'latest_comments', 'pages', 
                           'archive', 'authors', 'banners');
        }
    }