<?php
		
	if(empty($_POST))
	{
		header("location: //{$_SERVER['HTTP_HOST']}/install");
		exit;
	}

	session_start();

	require_once('helpers.php');

	$root 					= $_SERVER['DOCUMENT_ROOT'];
	$db_link 				= NULL;
	$_SESSION['message'] 	= [];
	$_post 					= [];


	foreach($_POST as $k => $v)
	{
		if( ! empty($v))
			$_post[$k] = htmlspecialchars(trim(strip_tags($v)));
	}


	switch(get_step())
	{
		case 1: // database connection

			if( ! array_keys_exist(['_hostname', '_username', 
								  '_password', '_database'], 
								 $_post))
			{
				$_SESSION['message'] = [
					'type'  => 'negative',
					'title' => "Error!",
					'body'  => "<div class='list'>
								    <li>Hostname : usually, it's either 'localhost' 
									    or '127.0.01'</li>
									<li>Username : the username you use to connect to your database</li>
									<li>Password : the password you use to connect to your database</li>
									<li>Database : your database's name</li>
								</div>"
				];

				redirect('/install');
			}

			extract($_post);


			$db_link = new mysqli($_hostname, $_username, 
								  $_password, $_database);

			if($db_link->connect_error)
			{
				$_SESSION['message'] = [
					'type'  => 'negative',
					'title' => "Error!",
					'body'  => $db_link->connect_error
				];

				redirect('/install');
			}

			
			$_SESSION['db_link_data'] = $_post;

			redirect('/install/?step=2');


			
		case 2: // site basic settings (name, title, description)

			if(empty($_SESSION['db_link_data']))
			{
				redirect('/install/?step=1');
			}

			$post_keys = ['_site_name', '_site_title', '_site_description'];

			if( ! array_keys_exist($post_keys, $_post))
			{
				$body = '';

				foreach($post_keys as $v)
				{
					if(empty($_post[$v]))
						$body . "<li>{{$v}} field is missing.</li>";
				}


				$_SESSION['message'] = [
					'type'  => 'negative',
					'title' => "Error!",
					'body'  => "<div class='list'>{$body}</div>"
				];

				redirect('/install/?step=2');
			}

			$_SESSION['site_config'] = $_post;

			redirect('/install/?step=3');

		case 3: // MaxMind GeoLite2-City Database

			if(empty($_SESSION['db_link_data'] || $_SESSION['site_config']))
			{
				redirect('/install/?step=1');
			}

			if(!isset($_post['_maxmind_database']))
			{
				$_SESSION['message'] = [
					'type'  => 'negative',
					'title' => "Error!",
					'body'  => "<div class='list'>Maxmind database link is missing</div>"
				];

				redirect('/install/?step=3');
			}

			$_SESSION['_maxmind_database'] = $_post['_maxmind_database'];

			redirect('/install/?step=4');


		case 4: // Admin credentials

			if(empty($_SESSION['db_link_data'] || $_SESSION['site_config'] || $_SESSION['_maxmind_database']))
			{
				redirect('/install/?step=1');
			}

			$post_keys = ['_user_name', '_user_email', '_user_pwd'];

			if( ! array_keys_exist($post_keys, $_post))
			{
				$body = '';

				foreach($post_keys as $v)
				{
					if(empty($_post[$v]))
						$body . "<li>{{$v}} field is missing.</li>";
				}


				$_SESSION['message'] = [
					'type'  => 'negative',
					'title' => "Error!",
					'body'  => "<div class='list'>{$body}</div>"
				];

				redirect('/install/?step=3');
			}
		    			/* -------- GetLite2-City ------- */
			if( ! file_exists("{$root}/application/GeoIP2-City.mmdb"))
		    {
			    if(!file_exists("{$root}/GeoLite2-City.tar.gz"))
				{
					copy($_SESSION['_maxmind_database'], "{$root}/GeoLite2-City.tar.gz");
				}
			         
			    $phar 	   = new PharData("{$root}/GeoLite2-City.tar.gz");
			    $file_name = $phar->getFilename();
			    
			    if(!$phar->extractTo($root, "{$file_name}/GeoLite2-City.mmdb"))
			    {
			    	$_SESSION['message'] = [
						'type'  => 'negative',
						'title' => "Error!",
						'body'  => "<div class='list'>Unable to extract 'GeoLite2-City' database.</div>"
					];

				    redirect('/install/?step=4');
			    }

			    rename("{$root}/{$file_name}/GeoLite2-City.mmdb",
				       "{$root}/application/GeoIP2-City.mmdb");
			    
			    rmdir("{$root}/{$file_name}");
			    
			    unlink("{$root}/GeoLite2-City.tar.gz");
			}



			/* -------- Database - Config & Data ------- */
			if(file_exists("{$root}/application/GeoIP2-City.mmdb"))
			{
				// Config
				$db_config_file = "{$root}/application/config/database.php";

				if( ! is_writable($db_config_file))
				{
					$_SESSION['message'] = [
						'type'  => 'negative',
						'title' => "Error!",
						'body'  => "<div class='list'>Unable to edit 'application/config/database.php' file, please make sure this file IS WRITABLE.</div>"
					];

				    redirect('/install/?step=4');
				}


				$content = '';

				$db_file_lines = array_map('htmlentities', 
										   file($db_config_file));
                
				$pattern = "/(?P<key>_(hostname|username|password|database))/i";
                
                
				foreach($db_file_lines as $line)
				{
					if(preg_match($pattern, $line, $matches))
					{
						$key = trim($matches['key']);

						$content .= str_ireplace(
										$key, 
										$_SESSION['db_link_data'][$key], 
										$line);

						continue;
					}

					$content .= "$line";
				}

				file_put_contents($db_config_file, 
								  html_entity_decode($content));


				// Data - Create tables & insert basic data

				$tables  = file("{$root}/install/database.sql");
				$content = '';
                
                
				foreach($tables as $table)
				{
					if(preg_match('/^([-]+)/', $table))
						continue;

					$content .= $table;
				}

				$queries = array_filter(array_map('trim', 
										explode(';', $content)));
                

				extract($_SESSION['db_link_data']);


				$db_link = new mysqli($_hostname, $_username, 
								  	  $_password, $_database);
                
                if($db_link->connect_error)
    			{
    				$_SESSION['message'] = [
    					'type'  => 'negative',
    					'title' => "Error!",
    					'body'  => $db_link->connect_error
    				];
    
    				redirect('/install/?step=3');
    			}
    			
    			
				foreach($queries as $query)
				{
					if(preg_match('/^INSERT IGNORE INTO `settings`/', $query))
					{
						$query = str_ireplace(
									array_keys($_SESSION['site_config']), 
									array_values($_SESSION['site_config']), 
									$query);
					}
					elseif(preg_match('/^INSERT IGNORE INTO `users`/', $query))
					{
						$_post['_user_pwd'] = password_hash($_post['_user_pwd'], PASSWORD_ARGON2I);

						$query = str_ireplace(array_keys($_post), 
											  array_values($_post), 
											  $query);
					}

					$db_link->query($query);
				}
				
				$_SESSION['stori_installation_done'] = TRUE;
				
				redirect("{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/control");
			}

			break;
	}