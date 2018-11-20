<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)){
    @session_start();
}

class WorkReport_Service extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        $this->load->model('work_header_model');
        $this->load->model('work_report_header_model');
        $this->load->model('work_report_detail_model');
        $this->load->model('employee_model');
    }
	
	public function getWorkRequestByCode()
	{
		$data = $this->input->post();
				
		echo json_encode($this->work_header_model->getWorkHeaderByDocNo($data['code']));
	}
	
	public function saveWorkReport()
	{
		$data = $this->input->post();
		
		if ($data['work_report_id'] != "")
		{
			// Update
			$data['upd_date'] = date("Y-m-d H:i:s");
			$data['upd_by'] = $_SESSION["username"];
			$header_id = $this->work_report_header_model->updateWorkReportHeader($data);
			$this->work_report_detail_model->deleteWorkReportDetailByHeader($data['work_report_id']);
		}
		else
		{
			// Insert
			$data['create_date'] = date("Y-m-d H:i:s");
			$data['create_by'] = $_SESSION["username"];
			$header_id = $this->work_report_header_model->saveWorkReportHeader($data);
		}
		
		if(isset($data['empList']) && sizeof($data['empList']) > 0)
		{
			foreach ($data['empList'] as $emp)
			{
				$this->work_report_detail_model->saveWorkReportDetail($emp['code'] , $header_id);
			}
		}
		
		echo json_encode($header_id);
	}
	
	public function getWorkByWorkReport()
	{
		$data = $this->input->post();
		echo json_encode($this->work_header_model->getWorkByWorkReport($data['report_id']));
	}
	
	public function listWorkReport()
	{
		$data = $this->input->get();
		$isHR = ($_SESSION["MyJob_name"] == "งานทรัพยากรบุคคล") && ($data['method'] == 'HR');
		
		if ($isHR)
		{
			$records = $this->work_report_header_model->findWorkReportForHR($data['start_date'], $data['end_date'], $data['emp_code']);
		}else
		{
			$records = $this->work_report_header_model->findWorkReportByCondition($data['start_date'], $data['end_date'], (int)$_SESSION["username"]);
		}
		
		print_r(json_encode($records));
	}
	
	
	
	public function removeWorkReport()
	{
		$data = $this->input->get();
		$this->work_report_detail_model->deleteWorkReportDetailByHeader($data['work_id']);
		$this->work_report_header_model->deleteWorkReportHeader($data['work_id']);
		
		echo json_encode(0);
	}
	
	public function saveGrant1()
	{
		$data = $this->input->post();
		if(isset($data['grantList']) && sizeof($data['grantList']) > 0)
		{
			foreach ($data['grantList'] as $grant)
			{
				$this->work_report_header_model->grantReport1($grant['work_id'] , $grant['approveValue'] , $grant['reason'] , (int)$_SESSION["username"]);
			}
		}		
		
		echo json_encode(true);
	}
	
	public function saveGrant2()
	{
		$data = $this->input->post();
		if(isset($data['grantList']) && sizeof($data['grantList']) > 0)
		{
			foreach ($data['grantList'] as $grant)
			{
				$this->work_report_header_model->grantReport2($grant['work_id'] , $grant['approveValue'] , $grant['reason'] , (int)$_SESSION["username"]);
			}
		}		
		
		echo json_encode(true);
	}
	
	public function saveGrant3()
	{
		$data = $this->input->post();
		if(isset($data['grantList']) && sizeof($data['grantList']) > 0)
		{
			foreach ($data['grantList'] as $grant)
			{
				$this->work_report_header_model->grantReport3($grant['work_id'] , $grant['approveValue'] , $grant['reason'] , (int)$_SESSION["username"]);
			}
		}		
		
		echo json_encode(true);
	}
	
}
