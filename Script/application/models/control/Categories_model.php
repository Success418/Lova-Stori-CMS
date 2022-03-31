<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Categories_model extends Admin_Core_Model
	{


		protected $table 		  = 'categories';
		protected $columns_prefix = 'category';
		protected $delete_cond 	  = ['categories.category_deleted_at' => NULL];
		



		public function get($uri_params)
		{
			extract($uri_params);
			$sql_index = 'category_deleted_at';
			$sql_order = ['id', 'ASC'];
			$sql_props = 'id';
			$base_url = "control/{$this->trash_page}categories/page";

			if($orderby)
			{
				$base_url = "control/{$this->trash_page}categories/orderby/$orderby/order/$order/page";
				$sql_order   = ["categories.category_{$orderby}", $order];
				$sql_index   = "category_{$orderby}";
				$sql_props  .= ", category_{$orderby}";
			}

			$total_rows_params = ['categories USE INDEX(category_deleted_at)',
								  $this->delete_cond];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('id')
					 		->from("categories USE INDEX ($sql_index)")
					 		->where($this->delete_cond)
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();

			$ids = array_column($ids, 'id');

			$properties =  ["categories.id",
							"categories.category_title AS 'name'",
							"categories.category_order AS 'order'",
							"categories.category_description AS 'description'",
							"categories.category_visible AS 'visible'",
							"categories.category_created_at AS 'created_at'",
							"categories.category_deleted_at AS 'deleted_at'",
							"count(subcategories.id) AS subcategories_count"];
						
			$this->db->select($properties)
					 ->from('categories USE INDEX (PRIMARY)')
					 ->join('subcategories', 'categories.id = subcategories.subcategory_parent_id', 'LEFT');

			if(count($ids))
        		$this->db->where_in('categories.id', $ids);
        	else 
        		$this->db->where($this->delete_cond);
		 
			$this->db->group_by('1')
					 ->order_by(...$sql_order);

			$categories = $this->db->get()->result_object();
			
			$categories = array_combine(array_column($categories, 'id'), $categories);

			return compact('categories', 'pagination');
		}




		public function add(array $category_data)
		{
			$properties = ['category_title', 'category_slug', 'category_order', 'category_description'];

			$data = array_combine($properties, $category_data);

			return $this->db->insert('categories', $data);
		}




		public function update(int $id, array $category_data)
		{
			return $this->db->where('id', $id)
							->update('categories', $category_data);
		}




		public function get_names_and_ids()
		{
			$sql = "SELECT categories.category_title, categories.id AS category_id 
					FROM categories USE INDEX(PRIMARY)";

			$categories = $this->db->query($sql)->result_array();
			
			return (array)array_combine(array_column($categories, 'category_id'), $categories);
		}




		public function get_deleted(array $uri_params): array
        {
        	$this->trash_page  = 'trash/';
        	$this->delete_cond = ['categories.category_deleted_at !=' => NULL];
        	return $this->get($uri_params);
        }
	}