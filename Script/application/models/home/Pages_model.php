<?php

	

	defined('BASEPATH') OR exit('No direct script access allowed');



	class Pages_model extends Home_Core_Model

	{

		

		public function get_pages(): array

		{

			$columns = ['page_title AS title', 

						'page_slug AS slug',

						'page_in_menu AS in_menu',

						'page_in_footer AS in_footer'];



			return $this->db->select($columns)

						 	->from('pages USE INDEX(PRIMARY)')

						 	->group_start()

						 	->where(['page_visible' => 1, 

						 			 'page_deleted_at' => NULL])

						 	->group_end()

						 	->where_not_in('page_title', ['privacy policy',

						 								  'dmca',

						 								  'terms of use',

						 								  'about'])

						 	->get()->result_object();

		}









		public function get_page(string $slug)

		{

			$columns = ['pages.id',

						'pages.page_title AS title', 

						'pages.page_slug AS slug',

						'pages.page_body AS body',

						'pages.page_created_at AS date',

						'pages.page_summary AS summary',

						'pages.page_keywords AS keywords',

						'users.user_name AS author_username',

						'users.user_firstname AS author_firstname',

						'users.user_lastname AS author_lastname',

						'users.user_role AS author_role',

						"CONCAT(user_firstname, ' ', user_lastname) AS author_fullname",

						'users.user_email AS author_email',

						'users.user_phone AS author_phone',

						'users.user_country AS author_country',

						'users.user_facebook AS author_facebook',

						'users.user_twitter AS author_twitter',

						'users.user_linkedin AS author_linkedin',

						'users.user_dob AS author_dob',

						'users.user_about AS author_about',

						'users.user_country AS author_country',

						'users.user_address AS author_address',

						'profiles.image_name AS author_image',];



			return  $this->db->select($columns)

							 ->from('pages USE INDEX(page_slug, page_author_id)')

							 ->where(['pages.page_slug' => $slug,

									  'pages.page_deleted_at' => NULL,

									  'pages.page_visible' => 1])

							 ->join('users', 'users.id = pages.page_author_id', 'LEFT')

			        			    ->join('profiles', 'profiles.image_parent_id = pages.page_author_id', 'LEFT')

							 ->get()->row();

		}









		public function update_views(int $page_id)

        {

        	$this->db->set('page_views', 'page_views + 1', FALSE)

        			 ->where('id', $page_id)

        			 ->update('pages');

        }

	}