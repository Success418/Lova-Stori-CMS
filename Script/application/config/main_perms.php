<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');


	$config['main_perms'] = [
		'posts' => [
	            'index' => 1,
	            'add' => 1,
	            'delete' => 1,
	            'update' => 1,
	            'update_visibility' => 1,
	            'update_pin' => 1,
	        	'update_recommendation' => 1],
                     
	    'pages' => [
	            'index' => 1,
	            'add' => 1,
	            'delete' => 1,
	            'update_visibility' => 1,
	            'update' => 1],

	    'users' => [
	            'index' => 1,
	            'add' => 1,
	            'delete' => 1,
	            'update_blocked' => 1,
	            'update_active' => 1,
	            'update_role' => 1,
	            'update' => 1],

	    'categories' => [
	            'index' => 1,
	            'add' => 1,
	            'delete' => 1,
	            'update_visibility' => 1,
	            'update' => 1],

	    'subcategories' => [
	            'index' => 1,
	            'add' => 1,
	            'delete' => 1,
	            'update_visibility' => 1,
	            'update' => 1],

	    'comments' => [
	            'index' => 1,
	            'add' => 1,
	            'delete' => 1,
	            'update_visibility' => 1],

	    'newsletter' => [
	            'index' => 1,
	            'add' => 1],

	    'profile' => [
	            'index' => 1,
	            'update' => 1],

	    'settings' => [
	            'index' => 1,
	            'update' => 1],

	    'trash' => [
	            'index' => 1,
	            'delete' => 1,
	            'update' => 1]
		];