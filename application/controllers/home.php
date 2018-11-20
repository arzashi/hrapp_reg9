<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
    public function __construct() {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('department_model');//jay
    }
	
	
	public function index()
	{
		$this->load->view('header');
		$this->load->view('welcome_message');
                $this->load->view('footer');
	}
        
        public function logout()
	{          
	   //$this->session->unset_userdata('logged_in');
           @session_start();
	   session_destroy();
	   redirect(base_url(), 'refresh');
	 }         
      	
}


/* End of file Home.php */
/* Location: ./application/controllers/home.php */