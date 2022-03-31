<?php

	defined('BASEPATH') OR exit('No direct script access allowed');


	function printr($string)
	{	
		echo "<pre>".print_r($string, true)."</pre>";
	}




	/**
	* Check if a session exists
	*-------------------------------------------------
	* @param $session_name : a session name
	* @return bool : TRUE on success, FALSE on failure
	*/
	function session_exists(string $session_name): bool
	{
		return isset($_SESSION[$session_name]);
	}




	


	/**
	* Check if a couple of sessions exists either concomitantly
	* or individually
	*-----------------------------------------------------------------
	* @param $sessions_names : an array of sessions names to check for
	* @param $or : whether to check for a simultaneous existance (TRUE)
	* or an individual existance (FALSE)
	*        Default value : FALSE
	* @return bool : TRUE on success, FALSE on failure
	*/
	function sessions_exist(array $sessions_names, $or = FALSE): bool
	{
		$sessions_set  = 	array_filter($sessions_names, function($session_name){
								return isset($_SESSION[$session_name]);
						  	});

		return  ($or) 
				? count($sessions_set)
				: (count($sessions_names) === count($sessions_set));
	}











	/**
	* Generate a CSRF token using CI security class
	*-----------------------------------------------
	* @return string : token
	*/
	function get_csrf_token(): string
	{
		$CI =& get_instance();

		return $CI->security->get_csrf_hash();
	}




	/**
	* Encrypt a string based on the encryption 
	* key found in config.php file
	*------------------------------------------
	* @param $str : the string to encrypt
	* @return string : the encrypted string
	*/
	function encrypt($str)
	{
		$CI =& get_instance();

		return $CI->encryption->encrypt($str);
	}






	/**
	* Decrypt an encypted string based on the encryption 
	* key found in config.php file
	*---------------------------------------------------
	* @param $cipher_str : the encrypted string
	* @return string : the decrypted string
	*/
	function decrypt($cipher_str)
	{
		$CI =& get_instance();

		return $CI->encryption->decrypt($cipher_str);
	}






	/**
	* Format iso_date format to '{time} ago'
	*---------------------------------------------------
	* @param $iso_date
	* @return string: 'n(seconds|minutes|hours|...) ago'
	*/
	function get_time_ago_in_words($iso_date)
	{
		$date    = new DateTime($iso_date);
		$formats = ['y'=>'tahun', 'm'=>'bulan', 'd'=>'hari', 'h'=>'jam', 'i'=>'menit', 's'=>'detik'];

		foreach($formats as $abv_format => $full_format)
		{	
			if($diff = (new DateTime(date("Y-m-d H:i:s")))->diff($date)->format("%$abv_format"))
			{
				$diff = "$diff ".($diff === "1" ? $full_format : "{$full_format}")." yg lalu";
				break;
			}
		}

		return (@$diff === '0') ? '1 detik yg lalu' : @$diff;
	}






	/**
	* Check if $array has the required $keys (as keys)
	*--------------------------------------------------------------------
	* @param $keys : an array of required keys
	* @param $array : the array where the required keys should be checked
	* @return bool (TRUE on success & FALSE on failure)
	*/
	function array_keys_exist(array $keys, array $array)
	{
		return empty(array_diff($keys, array_keys($array)));
	}




	function get_token($length, $url_encode = TRUE)
	{
		$CI =& get_instance();

		$token = base64_encode($CI->security->get_random_bytes($length));

		return $url_encode ? urlencode($token) : $token;
	}


	/*function get_config_item($item_name, $index = NULL)
	{
		$CI =& get_instance();

		$CI->load->config($item_name);

		return $CI->config->item($item_name)[$index]
			   ?? $CI->config->item($item_name);
	}*/



	/**
	* Compile scss content to css content
	* --------------------------------------------------------------
	* the configuration can be either done via a config file withing 
	* 'Config' directory or passed directly as paramater
	* @return NULL;
	*/
	function compileScss()
	{		
		$CI = get_instance();

		$CI->load->library('Scss_Compiler');
		$CI->load->config('scss');

		require(APPPATH.'libraries/leafo/scss.inc.php');

		$Scss_Compiler = new Scss_Compiler();

		if(!is_null($CI->config->item('scss')))
		{
			$scss_configs = array_filter($CI->config->item('scss'));

			foreach($scss_configs as $scss_config)
			{
				$Scss_Compiler->init(...array_values($scss_config))
					  		  ->compileScss();
			}
		}

        //print_r($Scss_Compiler->getError());
	}



	function get_html_pagination($pagination, $inverted = false)
	{
		return $pagination 
			   ? '<div class="ui pagination menu '. ($inverted ? 'inverted' : '') .'">'. $pagination .'</div>' 
			   : "&nbsp;";
	}


	function session_get($dotted_keys, $default_value = null)
	{
		$dot = new \Adbar\Dot($_SESSION ?? []);

		return $dot->get($dotted_keys, $default_value);
	}

	
	function get_form_response($flash_session_name)
	{
		if(!session_exists($flash_session_name) || 
		   !array_keys_exist(['type', 'response'], $_SESSION[$flash_session_name]))
			return false;

		$output = '';
		$type   = $_SESSION[$flash_session_name]['type'];

		if(is_array($_SESSION[$flash_session_name]['response']))
		{
			$mb = 'style="margin-bottom: 1rem !important;"';

			foreach($_SESSION[$flash_session_name]['response'] as $message)
			{
				$output .= 	'<div class="ui fluid '. $type .' small message" '. $mb .'>
								<i class="close icon"></i>
								'. $message .'
							</div>';
			}
		}
		else
		{
			$output = 	'<div class="ui fluid '. $type .' small message">
							<i class="close icon"></i>
							'. $_SESSION[$flash_session_name]['response'] .'
						</div>';
		}

		return $output;
	}


	function getStyle()
	{
		$CI =& get_instance();

		return get_cookie('style') 
					?? $CI->settings['site_style'] 
					?? 'light';
	}

	function styleIsDark()
	{
		return getStyle() !== 'light';
	}


	function user_role()
	{
		return $_SESSION['user_role'] ?? NULL;
	}


	function has_admin_access()
	{
		return is_logged_in()
			   && preg_match('/^(main|administrator|moderator)$/i', user_role());
	}


	
	function can_create_posts($user_role)
	{
		if($user_role === 'member')
			return false;
		
		$CI =& get_instance();

		$permissions = get_permissions($CI);

		return $permissions->$user_role->posts->add ?? null;
	}



	function is_logged_in()
	{
		return sessions_exist(['user_id', 'user_name', 
							   'user_email', 'user_role']);
	}
		

	function is_admin()
	{
		return is_logged_in()
			   && (user_role() === 'administrator');
	}


	function is_moderator()
	{
		return is_logged_in()
			   && (user_role() === 'moderator');
	}


	function is_author()
	{
		return is_logged_in()
			   && (user_role() === 'author');
	}

	function is_member()
	{
		return is_logged_in()
			   && (user_role() === 'member');
	}


	function is_main()
	{
		return is_logged_in()
			   && (user_role() === 'main');
	}


	function match($string, $pattern, $default = NULL)
	{
		preg_match("/^(?P<match>$pattern)$/i", $string, $matches);

		return $matches['match'] ?? $default;
	}


	function get_auto_increment($table_name)
	{
		$CI =& get_instance();

		return $CI->db->query("SHOW TABLE STATUS LIKE ?", [$table_name])->row()->Auto_increment ?? null;
	}


	function check_permission($closure = NULL)
	{
		if(!has_admin_access()) show_404();

		if(user_role() === 'main')
			return TRUE;

		# ----------------------------------- #

		$CI =& get_instance();

		$permissions = get_permissions($CI);

		if(!$permissions) show_404();

		$user_role  = user_role();
		$controller = $CI->router->class;
		$method 	= $CI->router->method;
		$response   = @$permissions->$user_role->$controller->$method ?? FALSE;

		if(is_callable($closure))
			return call_user_func($closure, $response);

		return $response;
	}




	function get_permissions($CI_instance)
	{		
		return json_decode($CI_instance->settings['site_permissions']);
	}




	function has_permission($controller, $method = 'index')
	{
		if(user_role() === 'main')
			return TRUE;

		$base = @$_ENV['perms']->{$_SESSION['user_role']}->$controller;

		if(is_array($method))
		{
			list($condition, $methods) = $method;

			$methods_set  = array_filter($methods, function($method) use($base){
								settype($base, 'array');
								return isset($base[$method]) && $base[$method];
							});

			return  ($condition === 'or')
					? count($methods_set)
					: (count((array)$methods) === count($methods_set));
		}

		return @$_ENV['perms']->{$_SESSION['user_role']}->$controller->$method
			   ?? FALSE;
	}




	function round_int(int $int)
	{
		if($int >= 1000)
			$int = round(($int / 1000), 1).'k';

		return $int;
	}


    function init_increase_val(&$object, $property)
	{
		if(isset($object->$property))
			$object->$property += 1;
		else
			$object->$property = 1;
	}
	
	
	function get_ad_units($type = NULL)
	{
		$CI =& get_instance();
		
		$ad_units = '';

		if($type === 'rectangle')
		{
			if($CI->settings['site_728x90_unit_ad'])
			{
				$ad_units .= '<div class="ad-units ad-728x90 my-4 center aligned">'.base64_decode($CI->settings['site_728x90_unit_ad']).'</div>';
			}

			if($CI->settings['site_468x60_unit_ad'])
			{
				$ad_units .= '<div class="ad-units ad-468x60 my-4 center aligned">'.base64_decode($CI->settings['site_468x60_unit_ad']).'</div>';
			}

			if($CI->settings['site_320x100_unit_ad'])
			{
				$ad_units .= '<div class="ad-units ad-320x100 my-4 center aligned">'.base64_decode($CI->settings['site_320x100_unit_ad']).'</div>';
			}
		}
		elseif($type === 'square')
		{
			if($CI->settings['site_250x250_unit_ad'])
			{
				$ad_units .= '<div class="ad-units ad-250x250 my-4 center aligned">'.base64_decode($CI->settings['site_250x250_unit_ad']).'</div>';
			}
		}
		elseif($type === 'feed')
		{
			if($CI->settings['site_in_feed_ad'])
			{
				$ad_units .= '<div class="ui fluid card"><div class="ad-units ad-in-feed center aligned">'.base64_decode($CI->settings['site_in_feed_ad']).'</div></div>';
			}
		}
		elseif($type === 'article')
		{
			if($CI->settings['site_in_article_ad'])
			{
				$ad_units .= '<div class="ad-units ad-in-article center aligned">'.base64_decode($CI->settings['site_in_article_ad']).'</div>';
			}
		}
		elseif($type === 'link')
		{
			if($CI->settings['site_link_ad'])
			{
				$ad_units .= '<div class="ad-units ad-link center aligned">'.base64_decode($CI->settings['site_link_ad']).'</div>';
			}
		}

		return $ad_units;
	}


	function url_title($str, $separator = '-', $lowercase = FALSE)
	{
		$converTable = [
	    '&amp;' => 'and',   '@' => 'at',    '©' => 'c', '®' => 'r', 'À' => 'a',
	    'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'Å' => 'a', 'Æ' => 'ae','Ç' => 'c',
	    'È' => 'e', 'É' => 'e', 'Ë' => 'e', 'Ì' => 'i', 'Í' => 'i', 'Î' => 'i',
	    'Ï' => 'i', 'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Õ' => 'o', 'Ö' => 'o',
	    'Ø' => 'o', 'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'Ý' => 'y',
	    'ß' => 'ss','à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', 'å' => 'a',
	    'æ' => 'ae','ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
	    'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ò' => 'o', 'ó' => 'o',
	    'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u',
	    'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'þ' => 'p', 'ÿ' => 'y', 'Ā' => 'a',
	    'ā' => 'a', 'Ă' => 'a', 'ă' => 'a', 'Ą' => 'a', 'ą' => 'a', 'Ć' => 'c',
	    'ć' => 'c', 'Ĉ' => 'c', 'ĉ' => 'c', 'Ċ' => 'c', 'ċ' => 'c', 'Č' => 'c',
	    'č' => 'c', 'Ď' => 'd', 'ď' => 'd', 'Đ' => 'd', 'đ' => 'd', 'Ē' => 'e',
	    'ē' => 'e', 'Ĕ' => 'e', 'ĕ' => 'e', 'Ė' => 'e', 'ė' => 'e', 'Ę' => 'e',
	    'ę' => 'e', 'Ě' => 'e', 'ě' => 'e', 'Ĝ' => 'g', 'ĝ' => 'g', 'Ğ' => 'g',
	    'ğ' => 'g', 'Ġ' => 'g', 'ġ' => 'g', 'Ģ' => 'g', 'ģ' => 'g', 'Ĥ' => 'h',
	    'ĥ' => 'h', 'Ħ' => 'h', 'ħ' => 'h', 'Ĩ' => 'i', 'ĩ' => 'i', 'Ī' => 'i',
	    'ī' => 'i', 'Ĭ' => 'i', 'ĭ' => 'i', 'Į' => 'i', 'į' => 'i', 'İ' => 'i',
	    'ı' => 'i', 'Ĳ' => 'ij','ĳ' => 'ij','Ĵ' => 'j', 'ĵ' => 'j', 'Ķ' => 'k',
	    'ķ' => 'k', 'ĸ' => 'k', 'Ĺ' => 'l', 'ĺ' => 'l', 'Ļ' => 'l', 'ļ' => 'l',
	    'Ľ' => 'l', 'ľ' => 'l', 'Ŀ' => 'l', 'ŀ' => 'l', 'Ł' => 'l', 'ł' => 'l',
	    'Ń' => 'n', 'ń' => 'n', 'Ņ' => 'n', 'ņ' => 'n', 'Ň' => 'n', 'ň' => 'n',
	    'ŉ' => 'n', 'Ŋ' => 'n', 'ŋ' => 'n', 'Ō' => 'o', 'ō' => 'o', 'Ŏ' => 'o',
	    'ŏ' => 'o', 'Ő' => 'o', 'ő' => 'o', 'Œ' => 'oe','œ' => 'oe','Ŕ' => 'r',
	    'ŕ' => 'r', 'Ŗ' => 'r', 'ŗ' => 'r', 'Ř' => 'r', 'ř' => 'r', 'Ś' => 's',
	    'ś' => 's', 'Ŝ' => 's', 'ŝ' => 's', 'Ş' => 's', 'ş' => 's', 'Š' => 's',
	    'š' => 's', 'Ţ' => 't', 'ţ' => 't', 'Ť' => 't', 'ť' => 't', 'Ŧ' => 't',
	    'ŧ' => 't', 'Ũ' => 'u', 'ũ' => 'u', 'Ū' => 'u', 'ū' => 'u', 'Ŭ' => 'u',
	    'ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'Ű' => 'u', 'ű' => 'u', 'Ų' => 'u',
	    'ų' => 'u', 'Ŵ' => 'w', 'ŵ' => 'w', 'Ŷ' => 'y', 'ŷ' => 'y', 'Ÿ' => 'y',
	    'Ź' => 'z', 'ź' => 'z', 'Ż' => 'z', 'ż' => 'z', 'Ž' => 'z', 'ž' => 'z',
	    'ſ' => 'z', 'Ə' => 'e', 'ƒ' => 'f', 'Ơ' => 'o', 'ơ' => 'o', 'Ư' => 'u',
	    'ư' => 'u', 'Ǎ' => 'a', 'ǎ' => 'a', 'Ǐ' => 'i', 'ǐ' => 'i', 'Ǒ' => 'o',
	    'ǒ' => 'o', 'Ǔ' => 'u', 'ǔ' => 'u', 'Ǖ' => 'u', 'ǖ' => 'u', 'Ǘ' => 'u',
	    'ǘ' => 'u', 'Ǚ' => 'u', 'ǚ' => 'u', 'Ǜ' => 'u', 'ǜ' => 'u', 'Ǻ' => 'a',
	    'ǻ' => 'a', 'Ǽ' => 'ae','ǽ' => 'ae','Ǿ' => 'o', 'ǿ' => 'o', 'ə' => 'e',
	    'Ё' => 'jo','Є' => 'e', 'І' => 'i', 'Ї' => 'i', 'А' => 'a', 'Б' => 'b',
	    'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ж' => 'zh','З' => 'z',
	    'И' => 'i', 'Й' => 'j', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n',
	    'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
	    'Ф' => 'f', 'Х' => 'h', 'Ц' => 'c', 'Ч' => 'ch','Ш' => 'sh','Щ' => 'sch',
	    'Ъ' => '-', 'Ы' => 'y', 'Ь' => '-', 'Э' => 'je','Ю' => 'ju','Я' => 'ja',
	    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
	    'ж' => 'zh','з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l',
	    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
	    'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
	    'ш' => 'sh','щ' => 'sch','ъ' => '-','ы' => 'y', 'ь' => '-', 'э' => 'je',
	    'ю' => 'ju','я' => 'ja','ё' => 'jo','є' => 'e', 'і' => 'i', 'ї' => 'i',
	    'Ґ' => 'g', 'ґ' => 'g', 'א' => 'a', 'ב' => 'b', 'ג' => 'g', 'ד' => 'd',
	    'ה' => 'h', 'ו' => 'v', 'ז' => 'z', 'ח' => 'h', 'ט' => 't', 'י' => 'i',
	    'ך' => 'k', 'כ' => 'k', 'ל' => 'l', 'ם' => 'm', 'מ' => 'm', 'ן' => 'n',
	    'נ' => 'n', 'ס' => 's', 'ע' => 'e', 'ף' => 'p', 'פ' => 'p', 'ץ' => 'C',
	    'צ' => 'c', 'ק' => 'q', 'ר' => 'r', 'ש' => 'w', 'ת' => 't', '™' => 'tm',
		];

		$str = strtr($str, $converTable);
		
		if ($separator === 'dash')
		{
			$separator = '-';
		}
		elseif ($separator === 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
			'&.+?;'			=> '',
			'[^\w\d _-]'		=> '',
			'\s+'			=> $separator,
			'('.$q_separator.')+'	=> $separator
		);

		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}


	function site_in_maintenance()
	{
		return file_exists(FCPATH.'.maintenance');
	}


	function maintenance_access_allowed()
	{
		if(site_in_maintenance())
		{
			if($allowed_ip_addresses = json_decode(file_get_contents(FCPATH.'.maintenance'), TRUE))
				return in_array($_SERVER['REMOTE_ADDR'], $allowed_ip_addresses);

			return false;
		}

		return true;
	}


	function maintenance_allowed_ips()
	{
		if(site_in_maintenance())
		{
			if($allowed_ip_addresses = json_decode(file_get_contents(FCPATH.'.maintenance'), TRUE))
				return $allowed_ip_addresses;
		}

		return [];
	}


	function get_verification_code()
	{
		$code = mt_rand(111111, 999999);

		$CI = get_instance();

		$CI->load->library('session');

		$CI->session->set_tempdata('contributor_verification_code', $code, 3600);

		return $code;
	}


	function number_shortener($number)
	{
		if($number > 1000)
		{
			return number_format($number / 1000, 2).'K';
		}

		return $number;
	}
	
	
    function watermark_img($img_name = null)
	{
		if(!$img_name) return;

		$CI =& get_instance();

		$CI->load->library('image_lib');
						
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/images/{$img_name}";
		$config['wm_overlay_path'] = './assets/images/watermark.png';
		$config['wm_type'] = 'overlay';
		$config['padding'] = '20';
		$config['wm_opacity'] = '100';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'right';
		$config['wm_hor_offset'] = '20';
		$config['wm_vrt_offset'] = '20';

		$CI->image_lib->initialize($config);

		$CI->image_lib->watermark();
	}



	function ad_banner_img($img = null, $default = 'ad-placeholder.webp')
	{
		if(is_null($img))
		{	
			return base_url("assets/images/{$default}?v=".time());
		}

		return base_url("uploads/banners/{$img}");
	}


	function ad_banner_link($link = null)
	{
		if(is_null($link))
		{
			if(is_member())
			{
				return base_url('/advertiser');
			}
			else
			{
				return 'javascript:void(0)';
			}
		}

		return $link;
	}


	function ad_banner_class($link = null)
	{
		if(is_null($link))
		{
			if(!is_logged_in())
			{
				return 'sign-in-form-toggler';
			}
		}
	}