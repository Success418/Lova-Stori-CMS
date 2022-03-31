<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Subscribers_model extends Admin_Core_Model
	{
		protected $columns_prefix   = 'subscriber';
		protected $table 			= 'subscribers';
		protected $columns 			= [
			'subscribers.id',
			'subscribers.subscriber_email AS email',
			'subscribers.subscriber_country AS country',
			'subscribers.subscriber_created_at AS created_at',
			'countries.country_fr_name AS country_FR', 
			'countries.country_en_name AS country_EN', 
			'countries.country_de_name AS country_DE', 
			'countries.country_es_name AS country_ES'
		];




		public function __construct()
        {
        	Parent::__construct();
        }




        public function get($uri_params)
		{
			extract($uri_params);

			$sql_index = 'PRIMARY';
			$sql_order = ['subscribers.id', 'ASC'];
			$sql_props = 'id';

			$base_url = 'control/newsletter/subscribers/page';

			if($orderby)
			{
				$base_url = "control/newsletter/subscribers/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["subscribers.subscriber_{$orderby}", $order];
				$sql_index   = "subscriber_{$orderby}";
				$sql_props  .= ", subscriber_{$orderby}";
			}

			$total_rows_params = $this->db->count_all_results('subscribers');

			extract($this->pagination($page, $base_url, $total_rows_params));

			$ids = $this->db->select('subscribers.id')
					 		->from("subscribers USE INDEX ($sql_index)")
					 		->order_by(...$sql_order)
							->limit($per_page, $offset)->get()->result_object();


			$ids = array_column($ids, 'id');

        	$this->db->select($this->columns)
        		     ->from('subscribers USE INDEX(subscriber_country)')
        		     ->join('countries', 'subscribers.subscriber_country = countries.country_iso_code', 'LEFT');

        	if(count($ids))
        		$this->db->where_in('subscribers.id', $ids);

        	$this->db->order_by(...$sql_order);

        	$subscribers = $this->db->get()->result_object();

        	return compact('subscribers', 'pagination');
		}




		public function latest(int $limit)
        {
        	return $this->db->select($this->columns)
        			 		->from('subscribers USE INDEX(PRIMARY, subscriber_country)')
        			 		->join('countries', 'subscribers.subscriber_country = countries.country_iso_code', 'LEFT')
        			 		->order_by('id', 'DESC')
        			 		->limit($limit)
        			 		->get()->result_object();
        }




        public function emails()
        {
        	$emails = $this->db->select('subscribers.subscriber_email AS email')
        			 		   ->from('subscribers USE INDEX(PRIMARY)')
        			 		   ->get()->result_array();

        	return  $emails
        			? array_column($emails, 'email')
        			: NULL;
        }
	}