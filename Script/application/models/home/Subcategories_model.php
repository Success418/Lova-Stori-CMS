<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Subcategories_model extends Home_Core_Model
	{
		

		public function __construct()
		{
			$this->load->database();
		}
		



		public function get_by_category_id(array $categories, int $limit = 3): array
		{
			$categories_ids = implode(', ', $categories);

			$sql = "
				SELECT *
				FROM (
						SELECT 
							_subcategories.id, 
							_subcategories.subcategory_title AS name, 
							/*_subcategories.subcategory_parent_id AS parent_id,*/
							@num_row := IF(@curr_subcategory_parent_id = subcategory_parent_id, 
	                            @num_row + 1, 1) AS num_row, 
	            			@curr_subcategory_parent_id := subcategory_parent_id AS curr_subcategory_parent_id
	            		FROM subcategories AS _subcategories
			                /*LEFT JOIN categories AS _categories
			                     ON _categories.id = _subcategories.subcategory_parent_id */
			            WHERE
			                subcategory_visible = 1
			                /*AND category_title IS NOT NULL*/
			                AND subcategory_deleted_at IS NULL
			            	AND subcategory_parent_id IN({$categories_ids}) 
			            ORDER BY _subcategories.id ASC, _subcategories.subcategory_parent_id DESC
		        	)
				AS posts 
				WHERE num_row < {$limit}+1";

				$this->db->simple_query("SET @num_row = 0, 
											 @curr_subcategory_parent_id = 0");

				return $this->db->query($sql)->result_object();
		}




		public function get_names_ids_and_parent_ids()
		{
			$sql = "SELECT subcategory_title, id AS subcategory_id, subcategory_parent_id FROM subcategories USE INDEX(PRIMARY) WHERE subcategory_deleted_at IS NULL AND subcategory_visible = 1";

			$subcategories = $this->db->query($sql)->result_object();

			/*$subcategories_by_parent_id = [];

			foreach($subcategories as $subcategory)
			{
				$parent_id  = $subcategory->subcategory_parent_id;

				$subcategories_by_parent_id[$parent_id][] = $subcategory;
			}*/

			return $subcategories;
		}




	}