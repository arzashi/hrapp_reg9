<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpManage extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('department_model');
        $this->load->model('workTime_model');
    }
	
	public function manage()
	{
		$this->load->view('header');
		$this->load->view('emp_manage/emp_manage');
        $this->load->view('footer');
	}
	
	public function work_time()
	{
		$this->load->view('header');
		$this->load->view('emp_manage/work_time');
        $this->load->view('footer');
	}
	
	public function export_sap()
	{
		$this->load->view('header');
		$this->load->view('emp_manage/export_sap');
        $this->load->view('footer');
	}
	
}
