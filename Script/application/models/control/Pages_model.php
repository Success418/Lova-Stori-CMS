<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Pages_model extends Admin_Core_Model
	{
		protected $table 		    = 'pages';
		protected $columns_prefix   = 'page';
		protected $delete_cond 		= ['pages.page_deleted_at' => NULL];
		protected $columns 			= [
						        		'pages.id',
						        		'pages.page_title AS title',
						        		'pages.page_slug AS slug',
						        		'pages.page_summary AS summary',
						        		'pages.page_keywords AS keywords',
						        		'pages.page_body AS body',
						        		'pages.page_views AS views',
						        		'pages.page_author_id AS author_id',
						        		'pages.page_created_at AS date',
						        		'pages.page_deleted_at AS deleted_at',
						        		'pages.page_visible AS visible',
						        		'pages.page_in_menu AS show_in_menu',
						        		'pages.page_in_footer AS show_in_footer'
						        	];




        public function get(array $uri_params): array
        {
        	extract($uri_params);

        	$sql_index = 'page_deleted_at';
			$sql_order = ['pages.id', 'ASC'];
			$sql_props = 'id';

			$base_url = "control/{$this->trash_page}pages/page";

			if($orderby)
			{
				$base_url = "control/{$this->trash_page}pages/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["pages.page_{$orderby}", $order];
				$sql_index   = "page_{$orderby}";
				$sql_props  .= ", page_{$orderby}";
			}

			$total_rows_params = ['pages USE INDEX(page_deleted_at)',
								  $this->delete_cond];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$this->add_users_columns();

			$pages = $this->db->select($this->columns)
					 		  ->from("pages USE INDEX ($sql_index)")
					 		  ->where($this->delete_cond)
					 		  ->join('users', 'pages.page_author_id = users.id', 'LEFT')
					 		  ->order_by(...$sql_order)
							  ->limit($per_page, $offset)->get()->result_object();

        	return compact('pages', 'pagination');
        }



        public function get_page(array $condition): object
        {
        	return $this->db->select($this->columns)
        					->from('pages USE INDEX(PRIMARY)')
        					->where($condition)
        					->get()->row();
        }



        public function add(array $page_data): bool
        {
        	return $this->db->insert('pages', $page_data);
        }




        public function update(int $id, array $page_data)
        {
        	return $this->db->where('id', $id)->update('pages', $page_data);
        }




        public function get_by_author(array $uri_params): array
        {
        	extract($uri_params);

        	$author_id 	   	   = $id;
        	$author_username   = $category;
        	$base_url 		   = "control/pages/id/{$id}/author/{$author_username}/page";
			$where_condition   = ['page_author_id' => $author_id, 'page_deleted_at' => NULL];
			$total_rows_params = ['pages USE INDEX(page_deleted_at)', $where_condition];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$this->add_users_columns();

			$pages = $this->db->select($this->columns)
					 		  ->from("pages USE INDEX (PRIMARY)")
					 		  ->where($where_condition)
							  ->join('users', 'pages.page_author_id = users.id', 'LEFT')
							  ->limit($per_page, $offset)->get()->result_object();

        	return compact('pages', 'pagination');
        }




        public function search(array $uri_params): array
        {
        	extract($uri_params);

        	$keywords 		   = url_title(urldecode($search), '-', TRUE);

        	$base_url 		   = "control/{$this->trash_page}pages/search/{$keywords}/page";
			$where_condition   = $this->delete_cond;
			$like_condition    = ['page_title' => $keywords];
			$or_like_condition = ['page_slug' => $keywords];

			$total_rows = $this->db->where($where_condition)
								   ->group_start()
								   ->like($like_condition)
								   ->or_like($or_like_condition)
								   ->or_like('page_keywords', $keywords)
								   ->group_end()
								   ->from('pages USE INDEX(page_title, page_slug, page_keywords)')
								   ->count_all_results();

			extract($this->pagination($page, $base_url, $total_rows));

			$this->add_users_columns();

			$pages = $this->db->select($this->columns)
						 	  ->from("pages USE INDEX (page_title, page_slug, page_keywords)")
						 	  ->where($where_condition)
						 	  ->group_start()
						 	  ->like($like_condition)
						 	  ->or_like($or_like_condition)
						 	  ->or_like('page_keywords', $keywords)
						 	  ->group_end()
							  ->join('users', 'pages.page_author_id = users.id', 'LEFT')
							  ->limit($per_page, $offset)->get()->result_object();

        	return compact('pages', 'pagination');
        }





        public function authors()
        {
        	$authors = [];

        	$authors_ids = $this->db->select('pages.page_author_id As author_id') 
						        	->from('pages USE INDEX(page_author_id, page_deleted_at)')
						        	->where('pages.page_deleted_at', NULL)
						        	->get()->result_array();

      		if($authors_ids)
      		{
      			$authors_ids   = array_column($authors_ids, 'author_id');

      			$users_columns = ['users.id AS author_id', 
      							  'users.user_name AS author_username'];

      			$authors = $this->db->select($users_columns)
	      					    	->from('users USE INDEX(PRIMARY)')
	      					    	->where_in('users.id', $authors_ids)
	      					    	->get()->result_array();
      		}

      		return $authors;
        }




        private function add_users_columns()
        {
        	$users_columns = ['users.user_name AS author_username',
			        		  'users.user_email AS author_email',
			        		  "CONCAT(users.user_firstname, ' ', users.user_lastname) AS author_fullname"];

			$this->columns = array_merge($this->columns, $users_columns);
        }





        public function get_deleted(array $uri_params): array
        {
        	$this->trash_page  = 'trash/';
        	$this->delete_cond = ['pages.page_deleted_at !=' => NULL];

        	if(isset($uri_params['search']))
        	{
        		return $this->search($uri_params);
        	}

        	return $this->get($uri_params);
        }



	}