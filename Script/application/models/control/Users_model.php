<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Users_model extends Admin_Core_Model
	{
		protected $columns_prefix   = 'user';
		protected $table 			= 'users';
		protected $columns 			= [ 'users.id', 
										'user_name', 
										'user_email', 
										'user_ip', 
										'user_country', 
										'user_active', 
										'user_blocked',
										'user_is_online',
										'user_created_at', 
										'user_deleted_at', 
										'countries.country_fr_name AS user_country_FR', 
										'countries.country_en_name AS user_country_EN', 
										'countries.country_de_name AS user_country_DE', 
										'countries.country_es_name AS user_country_ES'];

		protected $delete_cond_keys = [ 'where', 
										'where_in', 
										'where_not_in', 
										'or_where', 
										'or_where_in', 
										'or_where_not_in'];




        public function get(string $users_type, array $uri_params): array
        {
        	$func = 'get_'.$users_type;

					return call_user_func([$this, $func], $uri_params);
        }




		public function get_members(array $uri_params): array
		{
			extract($uri_params);

        	$sql_index = 'user_deleted_at';
			$sql_order = ['users.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/users/members/page';

			if($orderby)
			{
				$base_url = "control/users/members/orderby/{$orderby}/order/{$order}/page";


				$sql_order   = ["users.user_{$orderby}", $order];
				$sql_index   = "user_{$orderby}";
				$sql_props  .= ", user_{$orderby}";
			}

			$total_rows_params = ['users USE INDEX(user_deleted_at)',
								  ['user_deleted_at' => NULL, 'user_role' => 'member']];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('users.id')
					 		->from("users USE INDEX ($sql_index)")
					 		->where(['user_deleted_at' => NULL, 'user_role' => 'member'])
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();


			$ids = array_column($ids, 'id');

        	$this->db->select($this->columns)
        		     ->from('users USE INDEX(user_country)')
        		     ->join('countries', 'users.user_country = countries.country_iso_code', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('users.id', $ids);
        	else 
        		$this->db->where('users.user_deleted_at', NULL);

        	$this->db->order_by(...$sql_order);

        	$users = $this->db->get()->result_object();

        	return compact('users', 'pagination');
		}




		public function get_administrators(array $uri_params): array
		{
			extract($uri_params);

        	$sql_index = 'user_deleted_at';
			$sql_order = ['users.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/users/administrators/page';

			if($orderby && $orderby != 'posts_count')
			{
				$base_url = "control/users/administrators/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["users.user_{$orderby}", $order];
				$sql_index   = "user_{$orderby}";
				$sql_props  .= ", user_{$orderby}";
			}

			$total_rows_params = ['users USE INDEX(user_deleted_at)',
								  ['user_deleted_at' => NULL, 'user_role' => 'administrator']];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('users.id')
					 		->from("users USE INDEX ($sql_index)")
					 		->where(['user_deleted_at' => NULL, 'user_role' => 'administrator'])
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

        	$this->db->select(array_merge($this->columns,
        								  ['count(posts.id) AS user_posts_count']))
        		     ->from('users USE INDEX(user_country)')
        		     ->join('countries', 'users.user_country = countries.country_iso_code', 'LEFT')
        		     ->join('posts', 'users.id = posts.post_author_id', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('users.id', $ids);
        	else 
        		$this->db->where('users.user_deleted_at', NULL);

        	if($orderby === 'posts_count')
				$sql_order   = ["user_posts_count", $order];

        	$this->db->group_by('1')
					 ->order_by(...$sql_order);

        	$users = $this->db->get()->result_object();

        	return compact('users', 'pagination');
		}




		public function get_moderators(array $uri_params): array
		{
			extract($uri_params);

        	$sql_index = 'user_deleted_at';
			$sql_order = ['users.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/users/moderators/page';

			if($orderby && $orderby != 'posts_count')
			{
				$base_url = "control/users/moderators/orderby/{$orderby}/order/{$order}/page";

				

				$sql_order   = ["users.user_{$orderby}", $order];
				$sql_index   = "user_{$orderby}";
				$sql_props  .= ", user_{$orderby}";
			}

			$total_rows_params = ['users USE INDEX(user_deleted_at)',
								  ['user_deleted_at' => NULL, 'user_role' => 'moderator']];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('users.id')
					 		->from("users USE INDEX ($sql_index)")
					 		->where(['user_deleted_at' => NULL, 'user_role' => 'moderator'])
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();


			$ids = array_column($ids, 'id');

        	$this->db->select(array_merge($this->columns,
        								  ['count(posts.id) AS user_posts_count']))
        		     ->from('users USE INDEX(user_country)')
        		     ->join('countries', 'users.user_country = countries.country_iso_code', 'LEFT')
        		     ->join('posts', 'users.id = posts.post_author_id', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('users.id', $ids);
        	else 
        		$this->db->where('users.user_deleted_at', NULL);

        	if($orderby === 'posts_count')
				$sql_order   = ["user_posts_count", $order];

        	$this->db->group_by('1')
					 ->order_by(...$sql_order);

        	$users = $this->db->get()->result_object();

        	return compact('users', 'pagination');
		}




		public function get_authors(array $uri_params): array
		{
			extract($uri_params);

      $sql_index = 'user_deleted_at';
			$sql_order = ['users.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/users/authors/page';

			if($orderby && $orderby != 'posts_count')
			{
				$base_url = "control/users/authors/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["users.user_{$orderby}", $order];
				$sql_index   = "user_{$orderby}";
				$sql_props  .= ", user_{$orderby}";
			}

			$total_rows_params = ['users USE INDEX(user_deleted_at)',
								  ['user_deleted_at' => NULL, 'user_role' => 'author']];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('users.id')
					 		->from("users USE INDEX ($sql_index)")
					 		->where(['user_deleted_at' => NULL, 'user_role' => 'author'])
							->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();


			$ids = array_column($ids, 'id');

			$this->db->select(array_merge($this->columns, ['count(posts.id) AS user_posts_count']))
							->from('users USE INDEX(user_country)')
							->join('countries', 'users.user_country = countries.country_iso_code', 'LEFT')
							->join('posts', 'users.id = posts.post_author_id', 'LEFT');

			if(count($ids))
				$this->db->where_in('users.id', $ids);
			else 
				$this->db->where('users.user_deleted_at', NULL);

			if($orderby === 'posts_count')
				$sql_order   = ["user_posts_count", $order];

        	$this->db->group_by('1, country_fr_name, country_en_name, country_de_name, country_es_name')
					 ->order_by(...$sql_order);

        	$users = $this->db->get()->result_object();

        	return compact('users', 'pagination');
		}




		public function get_user(string $user)
		{
			$columns = ['users.id',
						'users.user_name',
						'users.user_pwd',
						'users.user_firstname',
						'users.user_lastname',
						'users.user_role',
						'users.user_active',
						'users.user_blocked',
						"CONCAT(user_firstname, ' ', user_lastname) AS user_fullname",
						'users.user_email',
						'users.user_country',
						'users.user_ip',
						'profiles.image_name AS user_image'
					];

			return $this->db->select($columns)
							->where('user_name', $user)
							->or_where('user_email', $user)
							->where('user_deleted_at', NULL)
							->join('profiles', 'image_parent_id = users.id', 'LEFT')
							->limit(1)
							->get('users')->row();
		}

  


		public function get_profile(int $id)
		{
			$columns = ['users.id',
						'users.user_name',
						'users.user_firstname',
						'users.user_lastname',
						"CONCAT(user_firstname, ' ', user_lastname) AS user_fullname",
						'users.user_email',
						'users.user_role',
						'users.user_parent_id',
						'users.user_country',
						'users.user_phone',
						'users.user_dob',
						'users.user_address',
						'users.user_facebook',
						'users.user_twitter',
						'users.user_linkedin',
						'users.user_pinterest',
						'users.user_youtube',
						'users.user_about',
						'users.id AS image_id',
						'users.user_ad_balance',
						'profiles.image_name',
						'countries.country_en_name AS user_country_en_name',
						'countries.country_de_name AS user_country_de_name',
						'countries.country_fr_name AS user_country_fr_name',
						'countries.country_es_name AS user_country_es_name',
						];

			return $this->db->select($columns, FALSE)
							->join('profiles', 'image_parent_id = users.id', 'LEFT')
							->join('countries', 'country_iso_code = users.user_country', 'LEFT')
							->where('users.id', $id)
							->get('users')->row_array();
		}




		public function update($id, $user_data, $user_image): bool
		{
			$this->db->trans_start();
			
			if($user_image)
			{
				$results = $this->db->where('image_parent_id', $id)
							 	    ->from("profiles USE INDEX(image_parent_id)")
							 	    ->count_all_results();

				if($results)
				{
					$this->db->set('image_name', $user_image)
							 ->where('image_parent_id', $id)
							 ->update('profiles');	
				}
				else
				{
					$this->db->insert('profiles', ['image_name' => $user_image,
												   'image_parent_id' => $id]);
				}
			}

			$this->db->where('id', $id)
					 ->update('users', $user_data);

			$this->db->trans_complete();

			return $this->db->trans_status();
		}




		public function update_password(string $user_pwd, string $user_email)
		{
			return $this->db->set(['user_pwd' => $user_pwd])
						 	->where('user_email', $user_email)
					 		->update('users');
		}




		public function delete(array $ids): bool
		{
			$this->db->trans_start();

			$this->db->where_in('id', $ids)
					 ->delete('users');

			$images = $this->db->select('image_name')
							   ->from('profiles USE INDEX(image_parent_id)')
							   ->where_in('image_parent_id', $ids)
							   ->get()->result_array();

			$this->db->where_in('image_parent_id', $ids)
					 ->delete('profiles');

			$this->db->trans_complete();

			$response = $this->db->trans_status();

			if($response)
			{
				foreach(array_column($images, 'image_name') as $image)
					@unlink(FCPATH."uploads/profiles/$image");
			}

			return $response;
		}




		public function add(array $user_data)
		{
			return $this->db->insert('users', $user_data);
		}




		public function activate($token, $email)
		{
			$this->db->set('user_active', 1)
					 ->where(['user_active' 		 => 0,
							 'MD5(user_email)' 		 => $email,
							 'user_activation_token' => "{$token}_{$email}"],
							 FALSE)
					 ->update('users');

			return $this->db->affected_rows();
		}


			

		public function move_to_trash(array $ids, $additional_conds = NULL): bool
		{
			$this->db->where_in('id', $ids);

			if(is_array($additional_conds)
			   && in_array(array_keys($additional_conds)[0],
			   			   $this->delete_cond_keys))
			{
				$func_name 	 = array_keys($additional_conds)[0];
				$column_name = array_keys($additional_conds[$func_name])[0];
				$values_arr  = $additional_conds[$func_name][$column_name];

				$this->db->$func_name($column_name, $values_arr);
			}

			$this->db->from('users');

			if($this->db->count_all_results() != count($ids))
				return FALSE;

			$this->db->trans_start();

			$this->db->set('user_deleted_at', 'CURRENT_TIMESTAMP()', FALSE)
				     ->where_in('id', $ids)
		 		     ->update('users');

			$this->db->set('image_deleted_at', 'CURRENT_TIMESTAMP()', FALSE)
				     ->where_in('image_parent_id', $ids)
		 		     ->update('profiles');

			$this->db->trans_complete();

			return $this->db->trans_status();
		}




		public function restore(array $ids)
		{
			$this->db->trans_start();

			$this->db->set('user_deleted_at', NULL)
					 ->where_in("id", $ids)
					 ->update('users');

			$this->db->set('image_deleted_at', NULL)
					 ->where_in("image_parent_id", $ids)
					 ->update('profiles');

			$this->db->trans_complete();

			return $this->db->trans_status();
		}




		public function get_deleted(array $uri_params): array
        {
        	$this->trash_page  = 'trash/';
        	$this->delete_cond = ['users.user_deleted_at !=' => NULL];

        	extract($uri_params);

        	$sql_index = 'user_deleted_at';
			$sql_order = ['users.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/trash/users/page';

			if($orderby)
			{
				$base_url = "control/trash/users/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["users.user_{$orderby}", $order];
				$sql_index   = "user_{$orderby}";
				$sql_props  .= ", user_{$orderby}";
			}

			$total_rows_params = ['users USE INDEX(user_deleted_at)',
								  ['user_deleted_at !=' => NULL]];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('users.id')
					 		->from("users USE INDEX ($sql_index)")
					 		->where('user_deleted_at !=', NULL)
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

        	$this->db->select($this->columns)
        		     ->from('users USE INDEX(user_country)')
        		     ->join('countries', 'users.user_country = countries.country_iso_code', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('users.id', $ids);
        	else 
        		$this->db->where('users.user_deleted_at !=', NULL);

        	$this->db->order_by(...$sql_order);

        	$users = $this->db->get()->result_object();

        	return compact('users', 'pagination');
        }




        public function latest(int $limit)
        {
        	return $this->db->select($this->columns)
        			 		->from('users USE INDEX(PRIMARY, user_country)')
        			 		->join('countries', 'users.user_country = countries.country_iso_code', 'LEFT')
        			 		->where(['users.user_role' => 'member',
        			 				 'users.user_deleted_at' => NULL])
        			 		->order_by('id', 'DESC')
        			 		->limit($limit)
        			 		->get()->result_object();
        }

	}