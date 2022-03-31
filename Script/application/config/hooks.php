<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// compress output
$hook['display_override'][] = [
    'class' => '',
    'function' => 'minify_html','compress',
    'filename' => 'html_minifier.php','compress.php',
    'filepath' => 'hooks'
];