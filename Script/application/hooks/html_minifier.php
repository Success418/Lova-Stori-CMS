<?php  

    defined('BASEPATH') OR exit('No direct script access allowed');
 
    function minify_html()
    {
        $CI =& get_instance();
        $buffer = $CI->output->get_output();
        
        $buffer = preg_replace("/(\n|\r|\t)+/", "", $buffer);
        
        $CI->output->set_output($buffer);
        $CI->output->_display();
    }