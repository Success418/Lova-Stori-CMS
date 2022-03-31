<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Payments_model extends Admin_Core_Model
	{
		protected $table  = 'payments';



    public function get(array $uri_params): array
    {
      extract($uri_params);

      $sql_index = 'primary';
			$sql_order = ['payments.id', 'ASC'];
			$sql_props = 'id';

			$base_url = "control/payments/page";

			if($orderby)
			{
				$base_url = "control/payments/orderby/{$orderby}/order/{$order}/page";

				$sql_order   = ["payments.{$orderby}", $order];
				$sql_index   = "{$orderby}";
				$sql_props  .= ", {$orderby}";
			}

      $total_rows = $this->db->select(['COUNT(payments.id) AS _count'])
                             ->from('payments')
                             ->join('users', 'users.id = payments.user_id', 'LEFT')
                             ->where('users.user_deleted_at =', NULL)
                             ->get()->row()->_count ?? 0;

			extract($this->pagination($page, $base_url, $total_rows));

			$payments = $this->db->select([
                    'payments.id',
                    'payments.user_id',
                    'payments.points AS points_to_exchange',
                    'payments.created_at',
                    'payments.paid',
                    'contributors.user_card_id_1',
                    'contributors.user_card_id_2',
                    'contributors.user_bank_account_number',
                    'contributors.user_bank_name',
                    'contributors.user_phone_number',
                    'contributors.user_firstname',
                    'contributors.user_lastname',
                    'contributors.points',
                    'contributors.exchanged_points',
                    'users.user_name',
                    'users.user_email',
                    'users.user_role',
                    'users.user_deleted_at'
                  ])
                  ->from("payments USE INDEX ($sql_index)")
                  ->join('users', 'users.id = payments.user_id', 'LEFT')
                  ->join('contributors', 'contributors.user_id = payments.user_id', 'LEFT')
                  ->where('users.user_deleted_at =', NULL)
                  ->order_by(...$sql_order)
                  ->limit($per_page, $offset)->get()->result_object();

      return compact('payments', 'pagination');
    }

	}