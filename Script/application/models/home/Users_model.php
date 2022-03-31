<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users_model extends CI_Model
	{


		public function __construct()
		{
			$this->load->database();
		}




		public function get_user(string $username)
		{
			$columns = ['users.id',
						'users.user_name AS username',
						'users.user_email AS email',
						'users.user_created_at AS date',
						'users.user_role AS role',
						'CONCAT(users.user_firstname, " ", users.user_lastname) AS realname',
						'IFNULL(users.user_dob, "N/A") AS dob',
						'IFNULL(users.user_phone, "N/A") AS phone',
						'IFNULL(users.user_address, "N/A") AS address',
						'IFNULL(profiles.image_name, "default.png") AS image',
						'users.user_about AS about',
						'IFNULL(users.user_country, "N/A") AS country',
						'users.user_facebook AS facebook',
						'users.user_twitter AS twitter',
						'users.user_linkedin AS linkedin',
						'users.user_pinterest AS pinterest',
						'users.user_youtube AS youtube',
						'IF(users.user_role REGEXP "^(main|administrator|moderator)$", 1, 0) AS has_admin_access',
						'contributors.points AS points',
						'COUNT(posts.id) AS posts_count'];

			return $this->db->select($columns, FALSE)
											->from('users USE INDEX(user_name)')
											->join('profiles', 'profiles.image_parent_id = users.id', 'LEFT')
											->join('contributors', 'contributors.user_id = users.id', 'LEFT')
											->join('posts', 'users.id = posts.post_author_id', 'LEFT')
											->where(['users.user_name' => $username,
													'users.user_deleted_at' => NULL,
													'users.user_active' => 1])
											->get()->row();
		}


	}