<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Categories_model extends Home_Core_Model
	{
		protected $table 		  = 'categories';
		protected $columns_prefix = 'category';
		protected $delete_cond 	  = ['categories.category_deleted_at' => NULL];




		public function get_names_and_ids()
		{
			$sql = "SELECT categories.category_title, categories.id AS category_id 
					FROM categories USE INDEX(PRIMARY) WHERE category_deleted_at IS NULL AND category_visible = 1";

			$categories = $this->db->query($sql)->result_array();

			return (array)array_combine(array_column($categories, 'category_id'), $categories);
		}

	}