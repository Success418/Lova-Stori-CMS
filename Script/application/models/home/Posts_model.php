<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Posts_model extends Home_Core_Model
	{

		protected $columns	= [
		        		'posts.id',
		        		'posts.post_title AS title',
		        		'posts.post_slug AS slug',
		        		'posts.post_views AS views',
		        		'posts.post_summary AS summary',
		        		'posts.post_body AS body',
		        		'posts.post_rating AS rating',
		        		'posts.post_created_at AS date',
		        		'posts.post_category_id AS category_id',
		        		'categories.category_title AS category',
		        		'subcategories.subcategory_title AS subcategory',
		        		'count(comments.id) AS comments_count',
		        		'images.image_name AS image',
		        		'IFNULL(profiles.image_name, "default.png") AS author_image',
		        		'users.user_name AS author_username',
						'users.user_firstname AS author_firstname',
						'users.user_lastname AS author_lastname',
						'users.user_role AS author_role',
						"CONCAT(user_firstname, ' ', user_lastname) AS author_fullname",
						'users.user_email AS author_email',
						'users.user_facebook AS author_facebook',
						'users.user_twitter AS author_twitter',
						'users.user_linkedin AS author_linkedin',
						'users.user_pinterest AS author_pinterest',
						'users.user_youtube AS author_youtube',
						'users.user_about AS author_about',
						'IFNULL(users.user_dob, "N/A") AS author_dob',
						'IFNULL(users.user_country, "N/A") AS author_country',
						'IFNULL(users.user_phone, "N/A") AS author_phone',
						'IFNULL(users.user_address, "N/A") AS author_address',
		        	];




        public function get_grouped_by_category(int $limit_per_category = 4): array
        {
        	$sql = "
				SELECT *
				FROM (
				        SELECT 
				            _posts.id, 
				            _posts.post_title AS title, 
				            _posts.post_slug AS slug, 
				            _posts.post_summary AS summary,
				            _posts.post_created_at AS date, 
				            _posts.post_deleted_at AS deleted_at, 
				            _posts.post_visible AS visible, 
				            _posts.post_category_id AS category_id, 
				            _categories.category_title AS category_title,
				            _images.image_name AS image,
				            @num_row := IF(@current_category_id = post_category_id, 
				                            @num_row + 1, 1) AS num_row, 
				            @current_category_id := post_category_id AS current_category_id 
			            FROM posts AS _posts
			                LEFT JOIN categories AS _categories
			                     ON _categories.id = _posts.post_category_id
			                LEFT JOIN images AS _images
			                     ON _images.image_parent_id = _posts.id
			            WHERE
			                post_visible = 1
			                AND post_deleted_at IS NULL
			                AND category_visible = 1
			                AND category_title IS NOT NULL
			            ORDER BY category_id ASC
			        )
				AS posts 
				WHERE num_row < {$limit_per_category}+1";

			$this->db->simple_query("SET @num_row = 0, @current_category_id = 0");

			return $this->db->query($sql)->result_object();
        }





        public function get_grouped_by_subcategory(array $subcategories, int $limit = 4): array
        {
        	if(!$subcategories)
        		return [];
            
        	$subcategories = implode(', ', $subcategories);

        	$sql = "
				SELECT *
				FROM (
				        SELECT 
				            _posts.id, 
				            _posts.post_title AS title, 
				            _posts.post_slug AS slug, 
				            _posts.post_summary AS summary,
				            _posts.post_created_at AS date, 
				            _posts.post_deleted_at AS deleted_at, 
				            _posts.post_visible AS visible, 
				            _posts.post_category_id AS category_id, 
				            _categories.category_title AS category_title,
				            _posts.post_subcategory_id AS subcategory_id, 
				            _subcategories.subcategory_title AS subcategory_title,
				            _images.image_name AS image,
				            @num_row := IF(@current_subcategory_id = post_subcategory_id, 
				                            @num_row + 1, 1) AS num_row, 
				            @current_subcategory_id := post_subcategory_id AS current_subcategory_id 
			            FROM posts AS _posts
			            	LEFT JOIN categories AS _categories
			                     ON _categories.id = _posts.post_category_id
			                LEFT JOIN subcategories AS _subcategories
			                     ON _subcategories.id = _posts.post_subcategory_id
			                LEFT JOIN images AS _images
			                     ON _images.image_parent_id = _posts.id
			            WHERE
			            	post_subcategory_id IN({$subcategories})
			                AND post_visible = 1
			                AND subcategory_title IS NOT NULL
			                AND post_deleted_at IS NULL
			            ORDER BY subcategory_id DESC
			        )
				AS posts 
				WHERE num_row < {$limit}+1";

			$this->db->simple_query("SET @num_row = 0, @current_subcategory_id = 0");

			return $this->db->query($sql)->result_object();
        }




        public function get_ordered_by(string $filter, string $order = 'DESC', int $limit = 5): array
        {
        	$this->db->select(['posts.post_title AS title',
        							  'posts.post_slug AS slug',
					        	      'posts.post_summary AS summary',
					        	      'images.image_name AS image'])
					 ->from("posts USE INDEX(PRIMARY, {$filter})")
					 ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
					 ->where(['posts.post_deleted_at' => NULL,
							 'posts.post_visible' => 1]);

			if($filter === 'post_recommended')
				$this->db->where('post_recommended', 1);
			elseif($filter === 'post_views')
				$this->db->where('post_views >', 0);

			return	$this->db->order_by("posts.{$filter}", $order)
							 ->limit($limit)
							 ->get()->result_object();
        }



        public function get_by_slug(string $slug)
        {
        	return $this->db->select($this->columns)
	        			    ->from('posts USE INDEX(PRIMARY, 
	        			 						 post_slug,
	        			 						 post_author_id, 
	        			 						 post_category_id, 
	        			 						 post_subcategory_id)')
	        			    ->where(['post_slug' => $slug,
	        					  'post_deleted_at' => NULL,
	        					  'post_visible' => 1])
	        			    ->join('categories', 'categories.id = posts.post_category_id', 'LEFT')
	        			    ->join('subcategories', 'subcategories.id = posts.post_subcategory_id', 'LEFT')
	        			    ->join('comments', 'comments.comment_post_id = posts.id', 'LEFT')
	        			    ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
	        			    ->join('users', 'users.id = posts.post_author_id', 'LEFT')
	        			    ->join('profiles', 'profiles.image_parent_id = posts.post_author_id', 'LEFT')
	        			    ->group_by('1')
	        			    ->get()->row();
        }




        public function get_prev_next(int $current_post_id): array
        {
        	$sql = "
				SELECT id, post_title AS title, post_slug AS slug
				FROM posts USE INDEX(PRIMARY) 
				WHERE ( 
					id = IFNULL((SELECT MIN(id) FROM posts WHERE id > {$current_post_id}), 0) 
					OR id = IFNULL((SELECT MAX(id) FROM posts WHERE id < {$current_post_id}), 0)
				) AND post_deleted_at IS NULL AND post_visible = 1
        	";

        	return $this->db->query($sql)->result_object();
        }



        public function get_similar(int $post_id, int $category_id)
        {
        	$columns = [
				'posts.post_title AS title',
				'posts.post_slug AS slug',
				'posts.post_summary AS summary',
				'images.image_name AS image_name'
        	];

        	return  $this->db->select($columns)
		        			 ->from('posts USE INDEX(PRIMARY, post_category_id)')
		        			 ->join('images', 'images.image_parent_id = posts.id')
		        			 ->where([
		        			 	'posts.post_visible' => 1,
		        			 	'posts.post_deleted_at' => NULL,
		        			 	'posts.post_category_id' => $category_id,
		        			 	'posts.id !=' => $post_id
		        			 ])
		        			 ->limit(4)
		        			 ->order_by('RAND()', 'ASC', FALSE)
		        			 ->get()->result_object();
        }



        public function get_id_by_slug(string $post_slug)
        {
        	return $this->db->select('id')
	        			    ->from('posts USE INDEX(post_slug)')
	        			    ->where('post_slug', $post_slug)
	        			    ->get()->row();
        }




        public function update_views(int $post_id)
        {
        	$this->db->set('post_views', 'post_views + 1', FALSE)
        			 ->where('id', $post_id)
        			 ->update('posts');
        }




        public function get_by_category(array $uri_params): array
        {
        	extract($uri_params);

        	$columns = 'id, category_title, category_description';

        	$category_obj = $this->db->select($columns)
        						 	 ->from('categories USE INDEX(category_slug)')
        						 	 ->where('category_slug', $category)
        						 	 ->get()->row();

        	if(!$category_obj)
        		show_404();

        	$category_id 		  = $category_obj->id;
        	$category_title 		  = $category_obj->category_title;
        	$category_description = $category_obj->category_description;

        	$base_url 		   = "posts/category/{$category}/page";
			$where_condition   = ['post_category_id' => $category_id, 
								  'posts.post_deleted_at' => NULL];
			$total_rows_params = ['posts USE INDEX(post_deleted_at)', $where_condition];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX (PRIMARY)")
					 		->where($where_condition)
					 		->order_by('posts.post_pinned', 'DESC')
        					->order_by('posts.id', 'DESC')
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$columns = ['posts.id', 
						'posts.post_title AS title', 
						'posts.post_slug AS slug',
						'posts.post_summary AS summary',
						'posts.post_rating AS rating',
						'posts.post_views AS views',
					    'posts.post_created_at AS date',
						'images.image_name AS image',
						'COUNT(comments.id) AS comments_count',
						'CONCAT(users.user_firstname, " ", users.user_lastname) AS author_realname',
						'users.user_name AS author_username',
						'profiles.image_name AS author_image',];

        	$this->db->select($columns)
        		     ->from('posts USE INDEX(PRIMARY, post_author_id)')
        		     ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
        		     ->join('comments', 'comments.comment_post_id = posts.id', 'LEFT')
        		     ->join('users', 'users.id = posts.post_author_id', 'LEFT')
        		     ->join('profiles', 'profiles.image_parent_id = posts.post_author_id', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('posts.id', $ids);
        	else 
        		$this->db->where($where_condition);

        	$posts = $this->db->group_by('1')
        					  ->order_by('posts.post_pinned', 'DESC')
        					  ->order_by('posts.id', 'DESC')
        					  ->get()->result();

        	return compact('posts', 
		        		   'category_title',
		        		   'category_description',
		        		   'pagination');
        }




        public function get_by_subcategory(array $uri_params): array
        {
        	extract($uri_params);

        	$columns = 'id, subcategory_title, subcategory_description';

        	$subcategory_obj = $this->db->select($columns)
        						 	 	->from('subcategories USE INDEX(subcategory_slug)')
        						 	 	->where('subcategory_slug', $subcategory)
        						 	 	->get()->row();

        	if(!$subcategory_obj)
        		show_404();

        	$subcategory_id   		 = $subcategory_obj->id;
        	$subcategory_title 		 = $subcategory_obj->subcategory_title;
        	$subcategory_description = $subcategory_obj->subcategory_description;

        	$base_url 		   = "posts/subcategory/{$subcategory}/page";
			$where_condition   = ['post_subcategory_id' => $subcategory_id, 
								  'posts.post_deleted_at' => NULL];
			$total_rows_params = ['posts USE INDEX(post_deleted_at)', $where_condition];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX (PRIMARY)")
					 		->where($where_condition)
					 		->order_by('posts.post_pinned', 'DESC')
        					->order_by('posts.id', 'DESC')
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$columns = ['posts.id', 
						'posts.post_title AS title', 
						'posts.post_slug AS slug',
						'posts.post_summary AS summary',
						'posts.post_rating AS rating',
						'posts.post_views AS views',
					    'posts.post_created_at AS date',
						'images.image_name AS image',
						'COUNT(comments.id) AS comments_count',
						'CONCAT(users.user_firstname, " ", users.user_lastname) AS author_realname',
						'users.user_name AS author_username',
						'profiles.image_name AS author_image'];

        	$this->db->select($columns)
        		     ->from('posts USE INDEX(PRIMARY, post_author_id)')
        		     ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
        		     ->join('comments', 'comments.comment_post_id = posts.id', 'LEFT')
        		     ->join('users', 'users.id = posts.post_author_id', 'LEFT')
        		     ->join('profiles', 'profiles.image_parent_id = posts.post_author_id', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('posts.id', $ids);
        	else 
        		$this->db->where($where_condition);

        	$posts = $this->db->group_by('1')
        					  ->order_by('posts.post_pinned', 'DESC')
        					  ->order_by('posts.id', 'DESC')
        					  ->get()->result();

        	return compact('posts', 'subcategory_title', 
        				   'subcategory_description', 'pagination');
        }




		public function get_by_keywords(array $uri_params): array
		{
			extract($uri_params);

			$keywords 		     = strip_tags(urldecode($search));
			$base_url 		     = "posts/search/{$keywords}/page";
			$where_condition     = ['posts.post_deleted_at' => NULL,
        							'posts.post_visible' => 1];
			$like_condition      = ['post_title' => $keywords];
			$or_like_condition   = ['post_slug' => $keywords];
			$or_like_condition_2 = ['post_keywords' => $keywords];

			$total_rows 	   = $this->db->where($where_condition)
										  ->group_start()
										  ->like($like_condition, 'both')
										  ->or_like($or_like_condition, 'both')
										  ->or_like($or_like_condition_2, 'both')
										  ->group_end()
										  ->from('posts USE INDEX (post_title, post_slug)')
										  ->count_all_results();

			extract($this->pagination($page, $base_url, $total_rows));

			$ids = $this->db->select('posts.id')
					 		->from("posts USE INDEX (post_title, post_slug)")
					 		->where($where_condition)
					 		->group_start()
					 		->like($like_condition)
					 		->or_like($or_like_condition)
					 		->or_like($or_like_condition_2, 'both')
					 		->group_end()
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$columns = ['posts.id', 
						'posts.post_title AS title', 
						'posts.post_slug AS slug',
						'posts.post_summary AS summary',
						'posts.post_rating AS rating',
						'posts.post_views AS views',
					    'posts.post_created_at AS date',
						'images.image_name AS image',
						'COUNT(comments.id) AS comments_count',
						'CONCAT(users.user_firstname, " ", users.user_lastname) AS author_realname',
						'users.user_name AS author_username',
						'profiles.image_name AS author_image'];

        	$this->db->select($columns)
					 ->from('posts USE INDEX(PRIMARY)')
        		     ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
        		     ->join('users', 'users.id = posts.post_author_id', 'LEFT')
        		     ->join('profiles', 'profiles.image_parent_id = posts.post_author_id', 'LEFT')
        		     ->join('comments', 'comments.comment_post_id = posts.id', 'LEFT');

        	if(count($ids))
        	{
        		$this->db->where_in('posts.id', $ids);
        	}
        	else
        	{
        		$this->db->where($where_condition)
        				 ->group_start()
		        	     ->like($like_condition)
		        		 ->or_like($or_like_condition)
		        		 ->or_like($or_like_condition_2, 'both')
		        		 ->group_end();
        	}

        	$posts 		   = $this->db->group_by('1')
        					 		  ->get()->result();
        	$results_count = $total_rows;

        	return compact('posts', 'pagination', 'keywords', 'results_count');
        }




        public function update_rating(int $post_id, int $rating)
        {
        	$this->db->set('post_rating', 
        		           "IF(post_rating > 0, CEIL((post_rating+{$rating})/2)
        		            , $rating)", FALSE)
        			 ->where('id', $post_id)
        			 ->update('posts');
        }




        public function get_by_year(array $uri_params): array
        {
        	extract($uri_params);

        	$base_url 		     = "posts/year/{$year}/page";
        	$where_condition     = ['posts.post_deleted_at' => NULL,
        							'posts.post_visible' => 1,
        							'EXTRACT(YEAR FROM posts.post_created_at) =' => $year];
        	$total_rows_params = ['posts USE INDEX(PRIMARY, post_created_at)',
								  $where_condition];

			extract($this->pagination($page, $base_url, 
									  $total_rows_params, ['uri_segment' => 5]));

			$ids = $this->db->select('posts.id')
					 		->from("posts USE INDEX(PRIMARY, post_created_at)")
					 		->where($where_condition)
							->limit($per_page, $offset)
							->get()->result_object();

			$ids = array_column($ids, 'id');

			$columns = ['posts.id', 
						'posts.post_title AS title', 
						'posts.post_slug AS slug',
						'posts.post_summary AS summary',
						'posts.post_rating AS rating',
						'posts.post_views AS views',
					    'posts.post_created_at AS date',
						'images.image_name AS image',
						'COUNT(comments.id) AS comments_count',
						'CONCAT(users.user_firstname, " ", users.user_lastname) AS author_realname',
						'users.user_name AS author_username',
						'profiles.image_name AS author_image'];

        	$this->db->select($columns)
					 ->from('posts USE INDEX(PRIMARY)')
        		     ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
        		     ->join('users', 'users.id = posts.post_author_id', 'LEFT')
        		     ->join('profiles', 'profiles.image_parent_id = posts.post_author_id', 'LEFT')
        		     ->join('comments', 'comments.comment_post_id = posts.id', 'LEFT');

        	if(count($ids))
        	{
        		$this->db->where_in('posts.id', $ids);
        	}
        	else
        	{
        		$this->db->where($where_condition);
        	}

        	$posts = $this->db->group_by('1')
        					  ->get()->result_object();

        	return compact('posts', 'pagination', 'year');
        }




        public function get_by_author(array $uri_params): array
        {
        	extract($uri_params);

        	$base_url 		     = "posts/author/{$author}/page";
        	$where_condition     = ['posts.post_deleted_at' => NULL,
        							'posts.post_visible' => 1,
        							'users.user_name' => $author];

        	$total_rows = $this->db->from('posts USE INDEX (PRIMARY, 
        		 						   post_author_id, 
        							       post_deleted_at, 
        							       post_visible)')
        						   ->join('users', 'users.id = posts.post_author_id', 'LEFT')
								   ->where($where_condition)
								   ->count_all_results();

			extract($this->pagination($page, $base_url, $total_rows));

			$ids = $this->db->select('posts.id')
					 		->from("posts USE INDEX(PRIMARY, 
		 						    post_author_id, 
							        post_deleted_at, 
							        post_visible)")
					 		->join('users', 'users.id = posts.post_author_id', 'LEFT')
					 		->where($where_condition)
							->limit($per_page, $offset)
							->get()->result_object();

			$ids = array_column($ids, 'id');
         
			$columns = ['posts.id', 
						'posts.post_title AS title', 
						'posts.post_slug AS slug',
						'posts.post_summary AS summary',
						'posts.post_rating AS rating',
						'posts.post_views AS views',
					    'posts.post_created_at AS date',
						'images.image_name AS image',
						'COUNT(comments.id) AS comments_count',
						'CONCAT(users.user_firstname, " ", users.user_lastname) AS author_realname',
						'users.user_name AS author_username',
						'profiles.image_name AS author_image'];

        	$this->db->select($columns)
					 ->from('posts USE INDEX(PRIMARY)')
        		     ->join('images', 'images.image_parent_id = posts.id', 'LEFT')
        		     ->join('users', 'users.id = posts.post_author_id', 'LEFT')
        		     ->join('profiles', 'profiles.image_parent_id = posts.post_author_id', 'LEFT')
        		     ->join('comments', 'comments.comment_post_id = posts.id', 'LEFT');
                
        	if(count($ids))
        	{
        		$this->db->where_in('posts.id', $ids);
        	}
        	else
        	{
        		$this->db->where($where_condition);
        	}

        	$posts = $this->db->group_by('1')
        					  ->get()->result_object();

        	return compact('posts', 'pagination', 'author');
        }




        public function get_by_user_id(int $user_id, int $page = 1):array
        {
        	$columns = ['posts.id', 
						'posts.post_title AS title', 
						'posts.post_slug AS slug',
						'posts.post_rating AS rating',
						'posts.post_views AS views',
					    'DATE_FORMAT(posts.post_created_at, "%Y-%m-%d") AS date'];

			$posts_per_page = $this->settings['site_posts_per_page'] ?? 15;

			$offset  = ($page * $posts_per_page) - $posts_per_page;
			$indexes = 'PRIMARY, post_author_id, post_deleted_at, post_visible';

			$total_rows = $this->db->from("posts USE INDEX({$indexes})")
								   ->where(['post_author_id' => $user_id,
											'post_deleted_at' => NULL,
											'post_visible' => 1])
								   ->count_all_results();

			$total_posts_pages = ceil($total_rows / $posts_per_page);

			if($page > $total_posts_pages)
			{
				$user_posts = [];
			}
			else
			{
				$user_posts = $this->db->select($columns)
        					  ->from('posts USE INDEX(PRIMARY, post_author_id)')
        					  ->where(['post_author_id' => $user_id,
									   'post_deleted_at' => NULL,
									   'post_visible' => 1])
        					  ->limit($posts_per_page, $offset)
        					  ->order_by('id', 'DESC')
        					  ->get()->result_object();
			}
        	
			return compact('total_posts_pages', 'user_posts');
		}



		public function get_carousel_posts(int $limit = 10)
		{
			return $this->db->select('post_title AS title, 
										post_slug AS slug, 
										post_rating AS rating,
										post_created_at AS date,
										images.image_name AS image')
							->from('posts USE INDEX(PRIMARY, 
													post_pinned,
													post_deleted_at,
													post_visible)')
							->join('images', 'images.image_parent_id = posts.id', 	'LEFT')
							->where(['posts.post_pinned' => 1,
										'posts.post_deleted_at' => NULL,
										'posts.post_visible' => 1])
							->order_by('posts.id', 'DESC')
							->limit($limit)
							->get()->result_object();
		}




		
		
		public function get(array $uri_params, $user_id, $trashed = false): array
		{
			extract($uri_params);

			$sql_index = 'post_deleted_at';
			$sql_order = ['posts.id', 'DESC'];
			$sql_props = 'id';

			$base_url = "author/posts/page";

			if($orderby)
			{
				$base_url = "author/posts/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["posts.post_{$orderby}", $order];
				$sql_index   = "post_{$orderby}";
				$sql_props  .= ", post_{$orderby}";
			}

			$where_cond = ['posts.post_deleted_at' => NULL, 'posts.post_author_id' => $user_id];
			$total_rows_params = ['posts USE INDEX(post_deleted_at)', $where_cond];

			if($trashed)
			{
				$base_url = 'author/posts/trash/page';
			
				if($orderby)
					$base_url = "author/posts/trash/orderby/{$orderby}/order/{$order}/page";

				unset($where_cond['posts.post_deleted_at']);

				$where_cond['posts.post_deleted_at !='] = NULL;

				$total_rows_params[1] = $where_cond;
			}

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX ($sql_index)")
					 		->where($where_cond)
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$this->db->select([
									'posts.id',
									'posts.post_title AS title',
									'posts.post_slug AS slug',
									'posts.post_views AS views',
									'posts.post_rating AS rating',
									'posts.post_category_id AS category_id',
									'posts.post_created_at AS date',
									'posts.post_deleted_at AS deleted_at',
									'posts.post_visible AS visible',
									'posts.post_pinned AS pinned',
									'posts.post_recommended AS recommended',
									'categories.category_title AS category_title'
								])
							->from('posts USE INDEX(PRIMARY)')
							->join('categories', 'posts.post_category_id = categories.id', 'LEFT');

			if(count($ids))
				$this->db->where_in('posts.id', $ids);
			else 
				$this->db->where($where_cond);

			$this->db->order_by(...$sql_order);

			$posts = $this->db->get()->result_object();

			return compact('posts', 'pagination');
		}



		public function get_by_category_2(array $uri_params, $user_id, $trashed = false): array
		{
			extract($uri_params);

			$category_id 	   		= $id;
			$category_slug 	   	= $category;
			$base_url 		   		= "author/posts/id/{$id}/category/{$category_slug}/page";
			$where_condition   	= ['posts.post_category_id' => $category_id, 'posts.post_deleted_at' => NULL, 'posts.post_author_id' => $user_id];
			$total_rows_params 	= ['posts USE INDEX(post_deleted_at)', $where_condition];

			if($trashed)
			{
				$base_url	= "author/posts/trash/id/{$id}/category/{$category_slug}/page";

				unset($where_condition['posts.post_deleted_at']);

				$where_condition['posts.post_deleted_at !='] = NULL;

				$total_rows_params[1] = $where_condition;
			}

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX (PRIMARY)")
					 		->where($where_condition)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$this->db->select([
										'posts.id',
										'posts.post_title AS title',
										'posts.post_slug AS slug',
										'posts.post_views AS views',
										'posts.post_rating AS rating',
										'posts.post_category_id AS category_id',
										'posts.post_created_at AS date',
										'posts.post_deleted_at AS deleted_at',
										'posts.post_visible AS visible',
										'posts.post_pinned AS pinned',
										'posts.post_recommended AS recommended',
										'categories.category_title AS category_title'
									])
							->from('posts USE INDEX(PRIMARY)')
							->join('categories', 'posts.post_category_id = categories.id', 'LEFT');

			if(count($ids))
				$this->db->where_in('posts.id', $ids);
			else 
				$this->db->where($where_condition);

			$posts = $this->db->get()->result_object();

			return compact('posts', 'pagination');
		}




		public function search(array $uri_params, $user_id, $trashed = false): array
		{
			extract($uri_params);

			$keywords 		   = strip_tags(urldecode($search));
			$base_url 		   = "author/posts/search/{$keywords}/page";
			$like_condition    = ['post_title' => $keywords];
			$or_like_condition = ['post_slug' => $keywords];
			$where_condition   	= ['posts.post_deleted_at' => NULL, 'posts.post_author_id' => $user_id];

			if($trashed)
			{
				unset($where_condition['posts.post_deleted_at']);

				$where_condition['posts.post_deleted_at !='] = NULL;

				$base_url = "author/posts/trash/search/{$keywords}/page";
			}

			$total_rows	= $this->db->where($where_condition)
										  ->group_start()
										  ->like($like_condition, 'both')
										  ->or_like($or_like_condition, 'both')
										  ->group_end()
										  ->from('posts USE INDEX (post_title, post_slug)')
										  ->count_all_results();

			extract($this->pagination($page, $base_url, $total_rows));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX (post_title, post_slug)")
					 		->where($where_condition)
					 		->group_start()
					 		->like($like_condition)
					 		->or_like($or_like_condition)
					 		->group_end()
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$this->db->select([
										'posts.id',
										'posts.post_title AS title',
										'posts.post_slug AS slug',
										'posts.post_views AS views',
										'posts.post_rating AS rating',
										'posts.post_category_id AS category_id',
										'posts.post_created_at AS date',
										'posts.post_deleted_at AS deleted_at',
										'posts.post_visible AS visible',
										'posts.post_pinned AS pinned',
										'posts.post_recommended AS recommended',
										'categories.category_title AS category_title'
									])
							->from('posts USE INDEX(PRIMARY)')
							->join('categories', 'posts.post_category_id = categories.id', 'LEFT');

			if(count($ids))
			{
				$this->db->where_in('posts.id', $ids);
			}
			else
			{
				$this->db->where($where_condition)
							->group_start()
								->like($like_condition)
							->or_like($or_like_condition)
							->group_end();
			}

			$posts = $this->db->get()->result_object();

			return compact('posts', 'pagination');
		}
	}

