<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Posts_model extends Admin_Core_Model
	{
		protected $table 		    = 'posts';
		protected $columns_prefix   = 'post';
		protected $delete_cond 		= ['posts.post_deleted_at' => NULL];
		protected $columns 			= [
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
							        	];
		


		public function __construct()
		{
			$this->load->database();
		}




        public function get(array $uri_params): array
        {
        	extract($uri_params);

        	$sql_index = 'post_deleted_at';
			$sql_order = ['posts.id', 'DESC'];
			$sql_props = 'id';

			$base_url = "control/{$this->trash_page}posts/page";

			if($orderby)
			{
				$base_url = "control/{$this->trash_page}posts/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["posts.post_{$orderby}", $order];
				$sql_index   = "post_{$orderby}";
				$sql_props  .= ", post_{$orderby}";
			}

			$total_rows_params = ['posts USE INDEX(post_deleted_at)',
								  $this->delete_cond];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX ($sql_index)")
					 		->where($this->delete_cond)
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

        	$this->db->select($this->columns)
        		     ->from('posts USE INDEX(PRIMARY)')
        		     ->join('categories', 'posts.post_category_id = categories.id', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('posts.id', $ids);
        	else 
        		$this->db->where($this->delete_cond);

        	$this->db->order_by(...$sql_order);

        	$posts = $this->db->get()->result_object();

        	return compact('posts', 'pagination');
        }




		public function get_by_category(array $uri_params): array
		{
			extract($uri_params);

			$category_id 	   = $id;
			$category_slug 	   = $category;
			$base_url 		   = "control/{$this->trash_page}posts/id/{$id}/category/{$category_slug}/page";
			$where_condition   = array_merge(['post_category_id' => $category_id], $this->delete_cond);
			$total_rows_params = ['posts USE INDEX(post_deleted_at)', $where_condition];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX (PRIMARY)")
					 		->where($where_condition)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$this->db->select($this->columns)
							->from('posts USE INDEX(PRIMARY)')
							->join('categories', 'posts.post_category_id = categories.id', 'LEFT');

			if(count($ids))
				$this->db->where_in('posts.id', $ids);
			else 
				$this->db->where($where_condition);

			$posts = $this->db->get()->result_object();

			return compact('posts', 'pagination');
		}




		public function search(array $uri_params): array
		{
			extract($uri_params);

			$keywords 		   = strip_tags(urldecode($search));
			$base_url 		   = "control/{$this->trash_page}posts/search/{$keywords}/page";
			$like_condition    = ['post_title' => $keywords];
			$or_like_condition = ['post_slug' => $keywords];

			$total_rows 	   = $this->db->where($this->delete_cond)
										  ->group_start()
										  ->like($like_condition, 'both')
										  ->or_like($or_like_condition, 'both')
										  ->group_end()
										  ->from('posts USE INDEX (post_title, post_slug)')
										  ->count_all_results();

			extract($this->pagination($page, $base_url, $total_rows));

			$ids = $this->db->select('id')
					 		->from("posts USE INDEX (post_title, post_slug)")
					 		->where($this->delete_cond)
					 		->group_start()
					 		->like($like_condition)
					 		->or_like($or_like_condition)
					 		->group_end()
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$this->db->select($this->columns)
							->from('posts USE INDEX(PRIMARY)')
							->join('categories', 'posts.post_category_id = categories.id', 'LEFT');

			if(count($ids))
			{
				$this->db->where_in('posts.id', $ids);
			}
			else
			{
				$this->db->where($this->delete_cond)
							->group_start()
								->like($like_condition)
							->or_like($or_like_condition)
							->group_end();
			}

			$posts = $this->db->get()->result_object();

			return compact('posts', 'pagination');
		}






		
		
				public function delete(array $ids): bool
		{
			$this->db->trans_start();

			$this->db->where_in('id', $ids)
					 ->delete('posts');

			$images = $this->db->select('image_name')
							   ->from('images USE INDEX(image_parent_id)')
							   ->where_in('image_parent_id', $ids)
							   ->get()->result_array();

			$this->db->where_in('image_parent_id', $ids)
					 ->delete('images');

			$this->db->trans_complete();

			$response = $this->db->trans_status();

			if($response)
			{
				foreach(array_column($images, 'image_name') as $image)
					@unlink(FCPATH."uploads/images/$image");
			}

			return $response;
		}






		public function move_to_trash(array $ids): bool
		{
			$this->db->trans_start();

			$this->db->set('post_deleted_at', 'CURRENT_TIMESTAMP()', FALSE)
				     ->where_in('id', $ids)
		 		     ->update('posts');

			$this->db->set('image_deleted_at', 'CURRENT_TIMESTAMP()', FALSE)
				     ->where_in('image_parent_id', $ids)
		 		     ->update('images');

			$this->db->trans_complete();

			return $this->db->trans_status();
		}



		public function update($id, $post_data, $post_image): bool
		{
			$this->db->trans_start();

			if($post_image)
			{
				$results = $this->db->where('image_parent_id', $id)
							 	    ->from("images USE INDEX(image_parent_id)")
							 	    ->count_all_results();

				if($results)
				{
					$this->db->set('image_name', $post_image)
							 ->where('image_parent_id', $id)
							 ->update('images');	
				}
				else
				{
					$this->db->insert('images', ['image_name' => $post_image,
												   'image_parent_id' => $id]);
				}
			}
			
			$this->db->where('id', $id)
					 ->update('posts', $post_data);

			$this->db->trans_complete();

			return $this->db->trans_status();
		}




		public function add(array $post_data, string $post_image): bool
		{
			$this->db->trans_start();
			$this->db->insert('posts', $post_data);

			$inserted_post_id = $this->db->insert_id();

			$this->db->insert('images', ['image_name'	=> $post_image, 
										 							 'image_parent_id' => $inserted_post_id]);
			$this->db->trans_complete();

			return $this->db->trans_status();
		}




		public function get_post(int $post_id)
		{
			$columns = [
        		'posts.id',
        		'posts.post_title AS title',
        		'posts.post_slug AS slug',
        		'posts.post_body AS body',
        		'posts.post_keywords AS keywords',
        		'posts.post_summary AS summary',
        		'posts.post_category_id AS category_id',
        		'posts.post_subcategory_id AS subcategory_id',
        		'images.image_name'
        	];

        	$this->db->select($columns)
        		     ->from('posts USE INDEX(PRIMARY)')
        		     ->join('images', 'posts.id = images.image_parent_id', 'LEFT')
        		     ->where('posts.id', $post_id);

        	return $this->db->get()->row();
		}




		public function update_pin_status(int $id, int $pinned)
		{
			$this->db->set('post_pinned', $pinned)
		 			 ->where('id', $id)
		 			 ->update('posts');

			return $this->db->affected_rows();
		}




		public function update_recommendation_status(int $id, int $recommended)
		{
			$this->db->set('post_recommended', $recommended)
		 			 ->where('id', $id)
		 			 ->update('posts');

			return $this->db->affected_rows();
		}




		public function get_insert_id(): int
		{
			$result = $this->db->query("SELECT IF(MAX(id) IS NOT NULL, MAX(id)+1, 1) AS last_id FROM posts")->row();

			return (int)$result->last_id;
		}



		public function get_deleted(array $uri_params): array
        {
        	$this->trash_page  = 'trash/';
        	$this->delete_cond = ['posts.post_deleted_at !=' => NULL];

        	if(isset($uri_params['search']))
        	{
        		return $this->search($uri_params);
        	}
        	elseif(isset($uri_params['category']))
        	{
        		return $this->get_by_category($uri_params);
        	}

        	return $this->get($uri_params);
        }




        public function restore(array $ids)
		{
			$this->db->trans_start();

			$this->db->set('post_deleted_at', NULL)
					 ->where_in("id", $ids)
					 ->update('posts');

			$this->db->set('image_deleted_at', NULL)
					 ->where_in("image_parent_id", $ids)
					 ->update('images');

			$this->db->trans_complete();

			return $this->db->trans_status();
		}


        

        public function popular(int $limit)
        {
        	$indexes = 'post_views, post_deleted_at';
        	$cond    = ['post_deleted_at' => NULL, 'post_visible' => 1];

        	return $this->db->select(['post_title', 'post_slug', 'post_views'])
        			 		->from("posts USE INDEX($indexes)")
        			 		->where($cond)
        			 		->order_by('post_views', 'DESC')
        			 		->limit($limit)
        			 		->get()->result_object();
        }
	}