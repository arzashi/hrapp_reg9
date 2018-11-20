<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myservice extends CI_Controller {

	
    public function __construct() {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('department_model');//jay
        $this->load->model('leave_header_model');//jay
    }    
     
    public function activate()
    {        
             $sid = $_REQUEST['sid'];
             $header_id = $_REQUEST['uid'];                          
             $result = $this->leave_header_model->getActivate($sid,$header_id);                           
             if($result[0]->leave_id === null){
                   echo "Not Found";
             }else{
                
                //echo "ทำรายการเรียบร้อย.".$result[0]->leave_id."<br>";
                echo '<script language="javascript">';
                echo 'alert("ทำรายการเรียบร้อย.")';
                echo '</script>';
                echo "<script>window.close();</script>";
             }
    }

      

	
}


/* End of file Home.php */
/* Location: ./application/controllers/home.php */