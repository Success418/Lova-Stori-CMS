<?php

	defined('BASEPATH') OR exit('No direct script access allowed');


	class Dashboard extends CI_Controller
	{
		private $non_unique_traffic_per_day = [];
		private $unique_traffic_per_day 	= [];
		private $non_unique_traffic_count	= 0;
		private $traffic_per_country 		= [];
		private $traffic_chart_days			= [];
		private $top_traffic_locations		= [];
		private $analytics_data				= [];




		function __construct()
		{
			Parent::__construct();

			$this->load->model(['control/posts_model', 
							   	'control/users_model', 
							   	'control/comments_model', 
								'control/subscribers_model', 
								'control/categories_model'])
					   ->library(['session', 'user_agent'])
					   ->helper(['date', 'cookie', 'language'])
					   ->config('countries_iso_codes');

			if(!has_admin_access())
				redirect(base_url('control/sign_in'));

			$lang = get_cookie('lang') ?? 'indonesia';

            $this->config->set_item('language', $lang);

            $this->lang->load(['ext_lang', 'ui_lang']);
            
            $this->set_settings();

            $_ENV['perms'] = json_decode($this->settings['site_permissions']);
		}




		public function index()
		{
			$this->set_traffic_data();

			$this->set_analytics_data();

			$posts_count 		= $this->posts_model->count_all_non_deleted();
			$users_count 		= $this->users_model->count_all_non_deleted(
								  					  ['users.user_role' => 'member']);
			$latest_users 		= $this->users_model->latest(20);
			$latest_subscribers = $this->subscribers_model->latest(20);
			$popular_posts 		= $this->posts_model->popular(20);
			$robots 			= $this->robots();
			$browsers 			= $this->browsers();
			$screen_sizes 		= $this->screen_sizes();
			$operating_systems  = $this->operating_systems();
			$subscribers_count 	= $this->subscribers_model->count_all_non_deleted();
			$comments_count 	= $this->comments_model->count_all_non_deleted();

			$non_unique_traffic_per_day = array_values($this->non_unique_traffic_per_day);
			$unique_traffic_per_day 	= array_values($this->unique_traffic_per_day);
			$non_unique_traffic_count 	= $this->non_unique_traffic_count;
			$traffic_per_country 		= $this->traffic_per_country;
			$traffic_chart_days 		= $this->traffic_chart_days;
			$top_traffic_locations 		= $this->top_traffic_locations;

			$this->load->view('control/dashboard', compact(
										       'non_unique_traffic_per_day', 
										       'unique_traffic_per_day', 
											   'non_unique_traffic_count', 
											   'traffic_per_country', 
											   'traffic_chart_days',
											   'top_traffic_locations',
											   'posts_count',
											   'users_count',
											   'latest_users',
											   'latest_subscribers',
											   'popular_posts',
											   'subscribers_count',
											   'comments_count',
											   'robots',
											   'browsers',
											   'screen_sizes',
											   'operating_systems'));
		}




		public function set_traffic_data()
		{
			$year_month = date('Ym');

			$days_of_month = range(1, date('t'));

			$countries_iso_codes = $this->config->item('countries_iso_codes');

			// SET TRAFFIC CHART DAYS
			$this->traffic_chart_days = $days_of_month;

			$traffic = $this->analytics_model->get_month_traffic_data($year_month);

			if(!empty($traffic))
			{
				$traffic_days = array_column($traffic, 'traffic_day');

				foreach($days_of_month as $current_day)
				{
					// SET INITIAL NON-UNIQUE & UNIQUE DAILY TRAFFIC
					$this->non_unique_traffic_per_day[$current_day]  = 0;
					$this->unique_traffic_per_day[$current_day] 	 = 0;

					$day_index = array_search($current_day, $traffic_days);

					if($day_index !== FALSE)
					{
						$traffic_array = explode('|', $traffic[$day_index]->traffic_iso_codes);

						// SET NON-UNIQUE DAILY TRAFFIC
						$this->non_unique_traffic_per_day[$current_day]    = count($traffic_array);

						// SET UNIQUE DAILY TRAFFIC
						$this->unique_traffic_per_day[$current_day] = count(array_unique($traffic_array));
					}
				}
			}

			if(!empty($traffic_iso_codes = $this->analytics_model->get_all_traffic_data()))
			{
				$_traffic_iso_codes = array_column($traffic_iso_codes, 'traffic_iso_codes');
				$_traffic_iso_codes = explode('|', implode('|', $_traffic_iso_codes));

				$traffic_per_country = array_count_values($_traffic_iso_codes);

				$missing_iso_codes = array_diff($countries_iso_codes, array_keys($traffic_per_country));
				
				$null_values 	   = array_fill(1, count($missing_iso_codes), 0);

				$missing_iso_codes = array_combine(array_values($missing_iso_codes), $null_values);

				$this->traffic_per_country = array_merge($traffic_per_country, $missing_iso_codes);

				arsort($this->traffic_per_country);

				// SET UNIQUE DAI
				$this->top_traffic_locations = array_slice($this->traffic_per_country, 0, 5);
                
				// SET TOTAL WEBSITE TRAFFIC
				$this->non_unique_traffic_count = count($_traffic_iso_codes);
			}
			else
			{
				$null_values 	     = array_fill(1, count($countries_iso_codes), 0);
				$countries_iso_codes = array_combine(array_values($countries_iso_codes), $null_values);

				$this->traffic_per_country = $countries_iso_codes;
			}
		}




		public function set_analytics_data()
		{
			$this->analytics_data = $this->analytics_model->analytics_data();
		}




		public function refresh_items_count()
		{
			$table_name = $this->input->post('table_name', TRUE);

			if(!$table_name) show_404();

			$model_name = "{$table_name}_model";
			$condition  = ($table_name === 'users')
						  ? ['users.user_role' => 'member']
						  : [];

			$count = $this->{$model_name}->count_all_non_deleted($condition);

			$this->output
		         ->set_content_type('application/json')
		         ->set_output(json_encode(['count' => $count]));
		}




		public function refresh_traffic_data()
		{
			$this->set_traffic_data();

			$non_unique_traffic = $this->non_unique_traffic_count;
			$unique_visits 		= array_values($this->unique_traffic_per_day);
			$non_unique_visits  = array_values($this->non_unique_traffic_per_day);
			
			$traffic_data = compact('non_unique_visits', 
									'unique_visits', 
									'non_unique_traffic');

			$this->output
		         ->set_content_type('application/json')
		         ->set_output(json_encode($traffic_data));
		}




		public function traffic_by_month()
		{
			$month = $this->input->post('month');

			if(!preg_match('/^([1-9]|1[0-2])$/', $month))
				show_404();

			$year_month = date('Ym', strtotime(date('Y')."-{$month}"));

			$days_of_month = range(1, days_in_month($month, date('Y')));

			$countries_iso_codes = $this->config->item('countries_iso_codes');

			// SET TRAFFIC CHART DAYS
			$this->traffic_chart_days = $days_of_month;

			$traffic = $this->analytics_model->get_month_traffic_data($year_month);

			if(!empty($traffic))
			{
				$traffic_days = array_column($traffic, 'traffic_day');

				foreach($days_of_month as $current_day)
				{
					// SET INITIAL NON-UNIQUE & UNIQUE DAILY TRAFFIC
					$this->non_unique_traffic_per_day[$current_day]  = 0;
					$this->unique_traffic_per_day[$current_day] 	 = 0;

					$day_index = array_search($current_day, $traffic_days);

					if($day_index !== FALSE)
					{
						$traffic_array = explode('|', $traffic[$day_index]->traffic_iso_codes);

						// SET NON-UNIQUE DAILY TRAFFIC
						$this->non_unique_traffic_per_day[$current_day]    = count($traffic_array);

						// SET UNIQUE DAILY TRAFFIC
						$this->unique_traffic_per_day[$current_day] = count(array_unique($traffic_array));
					}
				}
			}

			if(!empty($traffic_iso_codes = $this->analytics_model->get_all_traffic_data()))
			{
				$_traffic_iso_codes = array_column($traffic_iso_codes, 'traffic_iso_codes');

				$_traffic_iso_codes = explode('|', implode('|', $_traffic_iso_codes));

				// SET TOTAL WEBSITE TRAFFIC
				$this->non_unique_traffic_count = count($_traffic_iso_codes);
			}


			$non_unique_visits  = array_values($this->non_unique_traffic_per_day);
			$unique_visits 		= array_values($this->unique_traffic_per_day);
			$non_unique_traffic = $this->non_unique_traffic_count;
			$traffic_chart_days = $this->traffic_chart_days;

			$traffic_data = compact('non_unique_visits', 
									'unique_visits', 
									'non_unique_traffic',
									'traffic_chart_days');

			$this->output
		         ->set_content_type('application/json')
		         ->set_output(json_encode($traffic_data));
		}




		public function recent_users_subscribers()
		{
			$table = $this->input->post('table', TRUE);
			
			if(!preg_match('/^(users|subscribers)$/i', $table))
				show_404();

			$model = "{$table}_model";

			$items = $this->$model->latest(20);

			$this->output
		         ->set_content_type('application/json')
		         ->set_output(json_encode($items));
		}




		private function set_settings()
        {
            $this->load->library('session')
                       ->model('control/settings_model')
                       ->driver('cache', ['adapter' => 'apc', 'backup' => 'file'])
                       ->config('main_perms');

            if (!$settings = $this->cache->get('settings'))
            {
                $settings = $this->settings_model->get_settings();

                $this->cache->save('settings', $settings, 31536000);
            }

            $main_perms  = ['main' => $this->config->item('main_perms')];
            $perms       = json_decode($settings['site_permissions'], TRUE);

            $settings['site_permissions'] = json_encode(array_merge($main_perms, (array)$perms));

            $this->settings = $settings;
        }




        public function popular_posts()
        {
			$posts = $this->posts_model->popular(20);

			$this->output
		         ->set_content_type('application/json')
		         ->set_output(json_encode($posts));
        }




        private function robots()
        {
        	if($robots = json_decode($this->analytics_data->robots, TRUE))
        		return array_combine(array_keys($robots), 
        							 $this->ints_2_percents($robots));

            return [];
        }




        private function screen_sizes()
        {
        	if($ss = json_decode($this->analytics_data->screen_sizes, TRUE))
        		return array_combine(array_keys($ss), 
        							 $this->ints_2_percents($ss));

        	return [];
        }




        private function operating_systems()
        {
        	if($os = json_decode($this->analytics_data->operating_systems, TRUE))
    	    	return array_combine(array_keys($os), 
    				 			     $this->ints_2_percents($os));

        	return [];
        }




        private function browsers()
        {
        	if($browsers = json_decode($this->analytics_data->browsers, TRUE))
        		return array_combine(array_keys($browsers), 
        							 $this->ints_2_percents($browsers));

        	return [];
        }




        private function ints_2_percents(array $ints): array
        {
        	$sum 	  = array_sum($ints);
        	$percents = [];

        	foreach($ints as $int)
        		$percents[] = $int ? round(($int/$sum)*100, 1) : 0;

        	return $percents;
        }

	}