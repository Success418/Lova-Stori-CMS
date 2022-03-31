<?php

	function printr($iterable)
	{
		echo "<pre>
			".print_r($iterable, TRUE)."
		</pre>";
	}



	function redirect($to)
	{	
		header("location: {$to}");
		exit;
	}



	function array_keys_exist(array $keys, array $array)
	{
		return empty(array_diff($keys, array_keys($array)));
	}



	function get_form_message()
	{
		if(!empty($_SESSION['message']))
		{
			echo "
				<div class='content p-2'>
					<div class='ui fluid {$_SESSION['message']['type']} message'>
						<div class='header'>
							{$_SESSION['message']['title']}
						</div>
		  				{$_SESSION['message']['body']}
					</div>
				</div>";

			unset($_SESSION['message']);
		}
	}


	function get_step()
	{
		$step = $_GET['step'] ?? 1;

		if($step > 4)
			return NULL;

		return (int)$step;
	}



	function db_connect($array)
	{
		return new mysqli(...$array);
	}



	function get_session($sess_name)
	{
		return $_SESSION[$sess_name] ?? NULL;
	}



	function get_step_title()
	{
		switch(get_step())
		{
			case 1:
				return "Step 1 - Database";
				break;

			case 2:
				return "Step 2 - Site config";
				break;
			
			case 3:
				return "Step 3 - Maxmind Database";
				break;
				
			case 4:
				return "Step 4 - Admin credentials";
				break;
		}
	}