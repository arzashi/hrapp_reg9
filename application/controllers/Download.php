<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('carType_model');
        $this->load->model('workType_model');
        $this->load->model('employee_model');
        $this->load->model('work_header_model');
        $this->load->model('work_detail_model');
        $this->load->model('work_report_header_model');
        $this->load->model('work_report_detail_model');
        $this->load->model('leave_header_model');
        $this->load->model('leave_detail_model');
    }
	
	public function leave_download()
	{
		$data = $this->input->get();
		$isHR = ($_SESSION["MyJob_name"] == "งานทรัพยากรบุคคล") && ($data['method'] == 'HR');
		
		if ($isHR)
			$emp_code = $data['emp_code'];
		else
			$emp_code = (int)$_SESSION["username"];
		
		$records = $this->leave_header_model->findLeaveByCondition($data['start_date'], $data['end_date'],$emp_code ,$isHR);
		$return_data = array();
		$return_data['records'] = $records;
		
		$this->load->view('download/leave_download', $return_data);
	}
	
	public function work_download()
	{
		$data = $this->input->get();
		$emp_code = (int)$_SESSION["username"];
				
		$records = $this->work_header_model->findWorkByCondition($data['start_date'], $data['end_date'],$emp_code);
		$return_data = array();
		$return_data['records'] = $records;
		
		$this->load->view('download/work_download', $return_data);
	}
	
	public function workreport_download()
	{
		$data = $this->input->get();
		$isHR = ($_SESSION["MyJob_name"] == "งานทรัพยากรบุคคล") && ($data['method'] == 'HR');
		
		if ($isHR)
			$emp_code = $data['emp_code'];
		else
			$emp_code = (int)$_SESSION["username"];
		
		/* $emp_code = "9981"; */
		
		$records = $this->work_report_header_model->findWorkReportByCondition($data['start_date'], $data['end_date'],$emp_code);
		$return_data = array();
		$return_data['records'] = $records;
		
		$this->load->view('download/work_report_download', $return_data);
	}
	
}
