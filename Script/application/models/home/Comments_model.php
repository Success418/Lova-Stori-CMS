<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Comments_model extends Home_Core_Model
	{

		public function __construct()
		{
			$this->db->db_set_charset('utf8mb4');
			$this->db->query('SET collation_connection = utf8mb4_unicode_ci');
		}

		
		public function add(array $comment_data): int
		{
			return $this->db->insert('comments', $comment_data);
		}




		public function get(int $post_id)
		{
			$columns = ['comments.id', 
						'comments.comment_parent_id AS parent_id', 
						'comments.comment_body AS body', 
						'comments.comment_created_at AS date',
						'users.user_name AS author_name', 
						'IF(users.user_role = "main", "administrator", users.user_role) AS author_role', 
						'profiles.image_name AS author_image'];

			$indexes    = 'PRIMARY, comment_deleted_at, comment_visible';

			$this->db->select($columns)
		 		     ->from("comments USE INDEX ($indexes)")
		 			 ->where(['comments.comment_deleted_at' => NULL,
		 					  'comments.comment_post_id' => $post_id]);

			if($this->settings['site_comments_moderation'])
				$this->db->where('comments.comment_visible', 1);
								 
			return  $this->db->join('users', 'users.id = comments.comment_author_id', 'LEFT')
							 ->join('profiles', 'profiles.image_parent_id = comments.comment_author_id', 'LEFT')
							 ->order_by('comment_parent_id', 'DESC')
							 ->order_by('id', 'DESC')
							 ->get()
							 ->result_object();
		}




		public function get_latest(int $limit = 5)
		{
			$columns = ['comments.id', 
						'comments.comment_parent_id AS parent_id', 
						'comments.comment_body AS body', 
						'comments.comment_created_at AS date',
						'IF(comments.comment_parent_id IS NULL, CONCAT("comment_", "", MD5(comments.id)), CONCAT("subcomment_", "", MD5(comments.id))) AS anchor',
						'users.user_name AS author',
						'profiles.image_name AS author_image',
						'posts.post_slug',
						'posts.post_title'];

			$this->db->select($columns)
					 ->from('comments USE INDEX(PRIMARY, 
					 							comment_author_id, 
					 							comment_post_id)')
					 ->join('users', 'users.id = comments.comment_author_id', 'LEFT')
					 ->join('posts', 'posts.id = comments.comment_post_id', 'LEFT')
					 ->join('profiles', 'profiles.image_parent_id = comments.comment_author_id', 'LEFT')
					 ->where(['posts.post_deleted_at' => NULL, 
					 		  'posts.post_visible' => 1, 
					 		  'comments.comment_deleted_at' => NULL,
					 		  'users.user_deleted_at' => NULL]);

			if($this->settings['site_comments_moderation'])
				$this->db->where('comments.comment_visible', 1);

			return $this->db->limit($limit)
							->order_by('comments.id', 'DESC')
							->get()->result_object();
		}




		public function get_by_user_id(int $user_id, int $page = 1):array
		{
			$columns = ['comments.id', 
						'comments.comment_body AS body',
						'comments.comment_parent_id AS parent_id', 
						'DATE_FORMAT(comments.comment_created_at, "%Y-%m-%d %H:%i") AS date',
						'IF(comments.comment_parent_id IS NULL, CONCAT("comment_", "", MD5(comments.id)), CONCAT("subcomment_", "", MD5(comments.id))) AS anchor',
						'posts.post_slug',
						'posts.post_title'];

			$posts_per_page = $this->settings['site_posts_per_page'] ?? 15;

			$offset  = ($page * $posts_per_page) - $posts_per_page;
			$indexes = 'PRIMARY, comment_author_id, comment_deleted_at';
			$where_cond = ['comment_author_id'  => $user_id,
						   'comment_deleted_at' => NULL];

			if($this->settings['site_comments_moderation'])
			{
				$where_cond['comment_visible'] = 1;
				$indexes .= ', comment_visible';
			}


			$total_rows = $this->db->from("comments USE INDEX({$indexes})")
								   ->where($where_cond)
								   ->count_all_results();

			$total_comments_pages = ceil($total_rows / $posts_per_page);

			if($page > $total_comments_pages)
			{
				$user_comments = [];
			}
			else
			{
				$user_comments = $this->db->select($columns)
						 		      ->from("comments USE INDEX ({$indexes})")
						 		      ->join('posts', 'posts.id = comments.comment_post_id', 'LEFT')
						 			  ->where($where_cond)
						 			  ->limit($posts_per_page, $offset)
									  ->order_by('id', 'DESC')
									  ->get()
									  ->result_object();
			}
			
			return compact('total_comments_pages', 'user_comments');
		}



		public function get_2(array $uri_params, int $user_id)
		{
			extract($uri_params);

			$sql_index = 'comment_deleted_at';
			$sql_order = "comments.id ASC";
			$sql_props = 'id';

			$base_url = 'control/comments/page';

			if($orderby)
			{
				$base_url = "author/comments/orderby/{$orderby}/order/{$order}/page";

				# ------------------------------------------------------------- #

				if(in_array(strtolower($orderby), ['user_name', 'user_email']))
				{
					$sql_order   = "users.{$orderby} {$order}";
					$orderby 	 = 'author_id';
				}
				elseif(strtolower($orderby) === 'post_title')
				{
					$sql_order   = "posts.{$orderby} {$order}";
					$orderby 	 = 'post_id';
				}
				else
				{
					$sql_order   = "comments.comment_{$orderby} {$order}";
				}
				
				$sql_index   = "comment_{$orderby}";
			}

			$total_rows = $this->db->query("SELECT COUNT(comments.id) AS total_comments FROM comments USE INDEX(comment_deleted_at, primary) 
																			WHERE comments.comment_deleted_at IS NULL AND comments.comment_post_id IN (SELECT id FROM posts WHERE post_author_id = ?)", 
																			[$user_id])->row()->total_comments ?? 0;

			extract($this->pagination($page, $base_url, $total_rows));
			
			$comments = $this->db->query("SELECT comments.id, posts.post_title, posts.post_slug, comments.comment_visible as visible,
																		comments.comment_created_at as created_at, comments.comment_body as body,
																		profiles.image_name as avatar, users.user_name
																		FROM comments USE INDEX (comment_post_id, primary)
																		LEFT JOIN posts USE INDEX (post_author_id) ON posts.post_author_id = ?
																		LEFT JOIN users USE INDEX (primary) ON users.id = comments.comment_author_id
																		LEFT JOIN profiles USE INDEX (image_parent_id) ON image_parent_id = comments.comment_author_id
																		WHERE comments.comment_post_id = posts.id AND comments.comment_deleted_at IS NULL
																		ORDER BY {$sql_order}
																		LIMIT {$per_page} OFFSET {$offset}", 
																		[$user_id])->result_object();

        	return compact('comments', 'pagination');
		}




	}