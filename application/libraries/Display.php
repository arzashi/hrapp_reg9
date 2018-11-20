<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_Display {

    public $data;
    public $CI;

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function __get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function __construct() {
        $this->CI =& get_instance();
        $data['base_url']=  base_url();
        $data['site_url']= site_url();
		$this->v_data = $data;//array(""=>$data);      
      // $this->footer = array
    }

    public function Render() {
         $this->CI->load->view("header",$this->v_data);
         $this->html;
         $this->CI->load->view("footer",$this->v_data);
    }
    

}

?>
