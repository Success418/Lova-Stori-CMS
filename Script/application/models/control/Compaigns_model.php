<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Compaigns_model extends Admin_Core_Model
	{
		protected $table	= 'compaigns';




    public function get(array $uri_params): array
    {
    	extract($uri_params);

    	$sql_index = 'primary';
			$sql_order = ['compaigns.id', 'ASC'];
			$sql_props = 'id';

			$base_url = "control/compaigns/page";

			if($orderby)
			{
				$base_url = "control/compaigns/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["compaigns.{$orderby}", $order];
				$sql_index   = "{$orderby}";
				$sql_props  .= ", {$orderby}";
			}

			$total_rows_params = ['compaigns USE INDEX(primary)'];

			extract($this->pagination($page, $base_url, $total_rows_params));

			$compaigns = $this->db->select(['compaigns.*', 'users.user_ad_balance', 'ads.price', 'users.id as user_id'])
									 		  ->from("compaigns USE INDEX ($sql_index)")
									 		  ->join('users', 'compaigns.user_id = users.id', 'LEFT')
									 		  ->join('ads', 'compaigns.ad_ref = ads.ref', 'LEFT')
									 		  ->order_by(...$sql_order)
											  ->limit($per_page, $offset)->get()->result_object();

    	return compact('compaigns', 'pagination');
    }





	}