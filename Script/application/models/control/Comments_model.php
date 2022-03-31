<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Comments_model extends Admin_Core_Model
	{
		protected $table 		  = 'comments';
		protected $columns_prefix = 'comment';
		protected $delete_cond 	  = ['comments.comment_deleted_at' => NULL];
		protected $columns	  	  = [
										'comments.id',
										'comments.comment_body',
										'comments.comment_created_at AS date',
										'comments.comment_deleted_at AS deleted_at',
										'comments.comment_visible AS visible',
										'comments.comment_parent_id',
										'users.user_name AS author_username',
										'users.user_email AS author_email',
										'posts.post_title AS post_title',
										'posts.post_slug AS post_slug'
									];




		public function __construct()
        {
        	Parent::__construct();
        }




		public function get($uri_params)
		{
			extract($uri_params);

        	$sql_index = 'comment_deleted_at';
			$sql_order = ['comments.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/comments/page';

			if($orderby)
			{
				$base_url = "control/comments/orderby/{$orderby}/order/{$order}/page";

				# ------------------------------------------------------------- #

				if(in_array(strtolower($orderby), ['user_name', 'user_email']))
				{
					$sql_order   = ["users.{$orderby}", $order];
					$orderby 	 = 'author_id';
				}
				elseif(strtolower($orderby) === 'post_title')
				{
					$sql_order   = ["posts.{$orderby}", $order];
					$orderby 	 = 'post_id';
				}
				else
				{
					$sql_order   = ["comments.comment_{$orderby}", $order];
				}
				
				$sql_index   = "comment_{$orderby}";
				$sql_props  .= ", comment_{$orderby}";
			}

			$total_rows_params = ['comments USE INDEX(comment_deleted_at)',
								  $this->delete_cond];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$comments = $this->db->select($this->columns)
					 		  ->from("comments USE INDEX ($sql_index)")
					 		  ->where($this->delete_cond)
					 		  ->join('users', 'comments.comment_author_id = users.id', 'LEFT')
					 		  ->join('posts', 'comments.comment_post_id = posts.id', 'LEFT')
					 		  ->order_by(...$sql_order)
							  ->limit($per_page, $offset)->get()->result_object();

        	return compact('comments', 'pagination');
		}




		public function get_deleted(array $uri_params): array
        {
        	$this->trash_page  = 'trash/';
        	$this->delete_cond = ['comments.comment_deleted_at !=' => NULL];

        	return $this->get($uri_params);
        }

	}