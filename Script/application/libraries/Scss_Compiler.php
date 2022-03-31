<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	use Leafo\ScssPhp\Compiler;

	/**
	*  @example
	// $init_params = [
	//		"base_path/resources/assets/sass/style.scss",
	//  	"base_path/public/css/my_style.css"
	//  ]
	// $Scss_Compiler = new Scss_Compiler();
	// $Scss_Compiler->init(...$init_params)
	// 				 ->compileScss();
	// printr($Scss_Compiler->getError());
	*/

	class Scss_Compiler
	{
		private $css_file_path;
		private $scss_file_name;
		private $scss_file_dir;
		private $valid_paths 	 = false;
		private $output_formats  = ['Compressed', 'Compact', 'Nested', 'Expanded'];
		private $output_format 	 = 'Expanded';
		private $errors 		 = [];



		public function init($scss_file_path, $css_file_path, $output_format = null)
		{
			$css_dir = pathinfo($css_file_path, PATHINFO_DIRNAME);

			$d = is_dir($css_dir);
			$r = is_readable($scss_file_path);

			if($r && $d)
			{
				$this->scss_file_name = pathinfo($scss_file_path, PATHINFO_BASENAME);
				$this->scss_file_dir  = rtrim($scss_file_path, $this->scss_file_name);
				$this->css_file_path  = $css_file_path;
				$this->valid_paths 	  = true;

				if(in_array($output_format, $this->output_formats))
					$this->output_format = $output_format;
			}
			else
			{
				$this->errors['scss'] = !$r ? 'Scss file is not readable or doesn\'t exists' : '';
				$this->errors['css']  = !$d ? 'Css directory doesn\'t exists or is not writable' : '';
			}

			return $this;
		}



		public function compileScss()
		{
			if($this->valid_paths)
			{
				$format = $this->output_format;

				if(!file_exists("$this->css_file_path"))
					file_put_contents("$this->css_file_path", '');

				$scss_lmt = stat("$this->scss_file_dir/$this->scss_file_name")['mtime'];
				$css_lmt  = stat("$this->css_file_path")['mtime'];

				// if the last modification time of scss file ($scss_lmt) is different than the css file one ($css_lmt), then, update css file content and change it's modification time so they be the same ($scss_lmt === $css_lmt);

				if($scss_lmt != $css_lmt)
				{
					$scss = new Compiler();
					$scss->setImportPaths($this->scss_file_dir);
					$scss->setFormatter("Leafo\ScssPhp\Formatter\\{$format}");

					$css = @$scss->compile("@import '{$this->scss_file_name}'");

					file_put_contents($this->css_file_path, $css);
					touch($this->css_file_path, $scss_lmt);
				}
			}
			else
			{
				$this->errors['paths'] = 'Something is wrong in your paths';
			}
		}


		public function getError()
		{
			return $this->errors;
		}


		public function __construct($scss_file_path = '', $css_file_path = '', $output_format = null)
		{
			if(!empty($scss_file_path && $css_file_path))
				$this->init($scss_file_path, $css_file_path, $output_format);
		}

	}