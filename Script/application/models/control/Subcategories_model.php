<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Subcategories_model extends Admin_Core_Model
	{


		protected $table 	 		= 'subcategories';
		protected $columns_prefix   = 'subcategory';
		protected $delete_cond 	  	= ['subcategories.subcategory_deleted_at' => NULL];




		public function get($uri_params)
		{
			$subcategories = [];
			extract($uri_params);
			$sql_index = 'subcategory_deleted_at';
			$sql_order = ['id', 'ASC'];
			$sql_props = 'id';
			$base_url = "control/{$this->trash_page}subcategories/page";
			if($orderby)
			{
				$base_url = "control/{$this->trash_page}subcategories/orderby/$orderby/order/$order/page";
				$sql_order   = ["subcategories.subcategory_{$orderby}", $order];
				$sql_index   = "subcategory_{$orderby}";
				$sql_props  .= ", subcategory_{$orderby}";
			}
			$total_rows_params = ['subcategories USE INDEX(subcategory_deleted_at)',
								  $this->delete_cond];
			extract($this->pagination($page, $base_url, $total_rows_params));
			$ids = $this->db->select('id')
					 		->from("subcategories USE INDEX ($sql_index)")
					 		->where($this->delete_cond)
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();
			$ids = array_column($ids, 'id');
			$properties =  ["subcategories.id", 
							"subcategories.subcategory_title AS 'name'", 
							"subcategories.subcategory_order AS 'order'", 
							"subcategories.subcategory_description AS description", 
							"subcategories.subcategory_parent_id AS parent_id", 
							"subcategories.subcategory_visible AS visible", 
							"subcategories.subcategory_created_at AS 'created_at'", 
							"subcategories.subcategory_deleted_at AS 'deleted_at'", 
							"categories.category_title AS parent_name"];
			
			$this->db->select($properties)
				     ->from('subcategories USE INDEX (PRIMARY)')
				     ->join('categories', 'subcategories.subcategory_parent_id = categories.id', 'LEFT');
			if(count($ids))
        		$this->db->where_in('subcategories.id', $ids);
        	else 
        		$this->db->where($this->delete_cond);
		 
			$this->db->order_by(...$sql_order);
			$subcategories = $this->db->get()->result_object();
			$subcategories = array_combine(array_column($subcategories, 'id'), $subcategories);
			return compact('subcategories', 'pagination');
		}




		public function add(array $subcategory_data)
		{
			$properties = ['subcategory_title', 'subcategory_slug', 'subcategory_order', 
						   'subcategory_parent_id', 'subcategory_description'];
			$data = array_combine($properties, $subcategory_data);
			return $this->db->insert('subcategories', $data);
		}




		public function update(int $id, array $subcategory_data)
		{
			$new_name_exits = $this->db->where(['id !=' => $id, 
												'subcategory_title' => $subcategory_data['subcategory_title']])
									   ->from('subcategories')
									   ->count_all_results();
			if(!$new_name_exits)
				return $this->db->where('id', $id)->update('subcategories', $subcategory_data);
	
			return false;
		}




		public function get_names_ids_and_parent_ids()
		{
			$sql = "SELECT subcategory_title, id AS subcategory_id, subcategory_parent_id FROM subcategories USE INDEX(PRIMARY) WHERE subcategory_deleted_at IS NULL AND subcategory_visible = 1";
			$subcategories = $this->db->query($sql)->result_object();
			$subcategories_by_parent_id = [];
			foreach($subcategories as $subcategory)
			{
				$parent_id  = $subcategory->subcategory_parent_id;
				$subcategories_by_parent_id[$parent_id][] = $subcategory;
			}
			return $subcategories;
		}




		public function get_deleted(array $uri_params): array
        {
        	$this->trash_page  = 'trash/';
        	$this->delete_cond = ['subcategories.subcategory_deleted_at !=' => NULL];
        	return $this->get($uri_params);
        }
	}