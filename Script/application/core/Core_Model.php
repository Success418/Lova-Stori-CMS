<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Core_Model extends CI_Model
	{
		
		public function __construct()
		{
			$this->load->database();
			$this->load->library('pagination');
		}



		/**
		* Check if a column value is unique based
		* on 1 or multiple columns
		* @param $table - DB table name
		* @param $column_name (mixed) - Array | String [column(s) name(s)]
		* @param $column_value (mixed) - Array | String [column(s) value(s)]
		* @return bool
		*/
		public function is_unique($table, $column_name, $column_value): bool
		{
			if(is_array($column_name) && is_array($column_value))
			{
				if(count($column_value) != count($column_name))
				{
					$heading = 'Error [is_unique] function';
					$message = '[keys] count doesn\'t match [values] count';
					show_error($message, NULL, $heading);
				}
				$condition = array_combine($column_name, $column_value);
			}
			elseif(is_string($column_name) && is_string($column_value))
			{
				$condition = [$column_name => $column_value];
			}
			else
			{
				$heading = 'Error [is_unique] function';
				$message = 'invalid paramaters, mixing strings and arrays';
				show_error($message, NULL, $heading);
			}
			return $this->db->limit(1)->get_where($table, $condition)->num_rows() === 0;
		}



		public function pagination($page, 
						string $base_url, 
						$total_rows, 
						array $config = []): array
		{
			$this->config->load('pagination');
			if(is_array($total_rows))
				$total_rows = $this->db->get_where(...$total_rows)->num_rows();
			$pagination_config = $this->config->item('pagination');
			if(!empty($config))
			{
				foreach($config as $key => $val)
					$pagination_config[$key] = $val;
			}

			$page 	    = ($page < 1) ? 1 : $page;
			$per_page   = ($this->router->directory === 'control/')
						  ? ($pagination_config['per_page'] ?? 15)
						  : ($this->settings['site_posts_per_page'] ?? 15);
			$offset 	= ($page * $per_page) - $per_page;
			// If the requested page exceeds the number of pages
			if($page > (ceil($total_rows/$per_page)) && $total_rows > 0)
				show_404();
        	$pagination_config['per_page']    = $per_page;
			$pagination_config['base_url']    = base_url($base_url);
			$pagination_config['total_rows']  = ($total_rows < $pagination_config['per_page']) 
												? $pagination_config['per_page']
												: $total_rows;
			$this->pagination->initialize($pagination_config);
			$pagination = $this->pagination->create_links();
			return compact('pagination', 'total_rows', 'per_page', 'offset');
		}
	
	}



	class Admin_Core_Model extends Core_Model
	{
		protected $trash_page = '';
	
	
		public function __construct()
		{
			Parent::__construct();
		}



		/**
		* update item's visibility status
		* @param $column_name (string) - DB table column name
		* @param $id (integer) - item's id
		* @param $visible (integer) - (0|1) visible | not
		* @return bool - TRUE on success | FALSE on FAILED
        */
        public function update_visibility(string $column_name, 
										  int $id, 
										  int $visible)
		{
			if(!isset($this->table))
				show_error(get_called_class().' doesn\'t have [table] property');
			
			$response = $this->db->set($column_name, $visible)
					 			 ->where('id', $id)
					 			 ->update($this->table);
			return $response;
		}



		public function count_all_non_deleted(array $optional_where_condition = []): int
		{
			if(!isset($this->columns_prefix))
				show_error(get_called_class().' doesn\'t have [columns_prefix] property');
			if(!isset($this->table))
				show_error(get_called_class().' doesn\'t have [table] property');
			
			$where_condition = ["{$this->columns_prefix}_deleted_at" => NULL];
			return $this->db->where(array_merge($where_condition, $optional_where_condition))
						 	->from("{$this->table} USE INDEX(PRIMARY)")
						 	->count_all_results();
		}



		public function move_to_trash(array $ids): bool
		{
			$this->db->set("{$this->columns_prefix}_deleted_at", 
						   "CURRENT_TIMESTAMP()", FALSE)
				     ->where_in('id', $ids)
		 		     ->update($this->table);
			return $this->db->affected_rows();
		}



		public function restore(array $ids)
		{
			$this->db->set("{$this->columns_prefix}_deleted_at", NULL)
					 ->where_in("id", $ids)
					 ->update($this->table);
			return $this->db->affected_rows();
		}



		public function delete(array $ids)
		{
			$this->db->where_in("id", $ids)
					 ->delete($this->table);
			return $this->db->affected_rows();
		}


		public function get_sitemap_urls(string $table, string $columns_prefix)
        {
        	$base_url = base_url();

        	switch($table)
        	{
        		case 'posts':
        			$base_url .= 'post/';
        			break;
        		case 'pages':
        			$base_url .= 'page/';
        			break;
        		case 'categories':
        			$base_url .= 'posts/category/';
        			break;
        		case 'subcategories':
        			$base_url .= 'posts/subcategory/';
        			break;
        	}

        	return $this->db->select("
        					CONCAT('<url>', 
					      		CONCAT('<loc>', CONCAT('{$base_url}', {$columns_prefix}_slug), '</loc>'),
					      		CONCAT('<lastmod>', IFNULL({$columns_prefix}_updated_at, {$columns_prefix}_created_at), '</lastmod>'),
					      	'</url>') AS url")
        			 		->from("{$table} USE INDEX(
	        			 			PRIMARY, 
	        			 			{$columns_prefix}_deleted_at,
	        			 			{$columns_prefix}_visible)")
        			 		->where([
        			 			"{$columns_prefix}_deleted_at" => NULL,
        			 			"{$columns_prefix}_visible" => 1
        			 		])
        			 		->get()->result_array();
        }
	}



	class Home_Core_Model extends Core_Model
	{
		
		public function __construct()
		{
			Parent::__construct();
		}
		public function get_menu_items(): array
		{
			$sql = "
                    SELECT 
                        categories.id AS category_id, 
                        categories.category_title, 
                        subcategories.id AS subcategory_id, 
                        subcategories.subcategory_title
                    FROM categories
                    LEFT JOIN subcategories
                         ON categories.id = subcategories.subcategory_parent_id
                    WHERE categories.category_deleted_at IS NULL
                          AND categories.category_visible = 1
                          AND
                          CASE
                                WHEN subcategories.id IS NOT NULL
                                THEN
                                  subcategories.subcategory_deleted_at IS NULL 
                                  AND subcategories.subcategory_visible = 1
                                ELSE
                                  1 = 1
                          END
                    ORDER BY categories.category_order, subcategories.subcategory_order ASC
            ";
            return $this->db->query($sql)->result();
		}
		public function get_archive()
		{
			$columns = "EXTRACT(YEAR FROM  posts.post_created_at) AS year,
			 COUNT(id) AS posts_count";
			return $this->db->select($columns, FALSE)
					 		->from('posts USE INDEX(PRIMARY, post_created_at)')
					 		->group_by('year')
					 		->get()->result_object();
		}
		public function get_authors($having_posts = TRUE)
		{
			$columns = "users.user_name AS username, 
						COUNT(posts.id) AS posts_count, 
						profiles.image_name AS image";
			$this->db->select($columns, FALSE)
			 		 ->from('users USE INDEX(PRIMARY)')
			 		 ->join('posts', 'posts.post_author_id = users.id', 'LEFT')
			 		 ->join('profiles', 'profiles.image_parent_id = users.id', 'LEFT')
			 		 ->group_by('users.id');
			if($having_posts)
				$this->db->having('posts_count >', 0);
			return $this->db->get()->result_object();
		}
	}