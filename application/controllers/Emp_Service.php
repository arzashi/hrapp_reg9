<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)){
    @session_start();
}

class Emp_Service extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('department_model');		
        $this->load->model('workTimeTransaction_model');
        $this->load->model('leave_header_model');
        $this->load->model('work_report_header_model');	
        $this->load->model('work_header_model');	
    }
	
	
	public function getEmployeeByCondition()
	{
		$data = $this->input->post();	
		$result = $this->employee_model->getEmployeeByCondition($data['emp_code'] , $data['name'], $data['department'] , $data['position'] , $data['job_name'], $data['work_date']);
		echo json_encode($result);
	}
	
	public function saveEmployee()
	{
		try { 
			$data = $this->input->post();
			if(isset($data['deleteList']) && sizeof($data['deleteList']) > 0)
			{
				foreach ($data['deleteList'] as $deleteEmp)
				{
					$this->employee_model->deleteEmp($deleteEmp['code']);
				}
			}	

			if(isset($data['saveList']) && sizeof($data['saveList']) > 0)
			{
				foreach ($data['saveList'] as $saveEmp)
				{
					$this->employee_model->saveEmp($saveEmp['code'],$saveEmp['gender'],$saveEmp['name'],$saveEmp['surname'],$saveEmp['position'],$saveEmp['level'],$saveEmp['job_name'],$saveEmp['div_code'],$saveEmp['start_work']);
				}
			}		
			echo json_encode(true);
		} catch (Exception $e) {
			echo json_encode(false);
		}
	}
	
	
	public function saveWorktime()
	{
		try { 
			$data = $this->input->post();
			if(isset($data['saveList']) && sizeof($data['saveList']) > 0)
			{
				foreach ($data['saveList'] as $saveEmp)
				{
					$this->workTimeTransaction_model->saveWorktime($saveEmp['emp_code'],$saveEmp['work_time'],$saveEmp['work_date'], (int)$_SESSION["username"],$data['is_holiday']);
				}
			}		
			echo json_encode(true);
		} catch (Exception $e) {
			echo json_encode(false);
		}
	}
	
	public function generateTextFile()
	{
		$data = $this->input->post();
		
		$dept = $this->department_model->getDepartment($data['department']);
		
		$my_file = 'asset/export/' . $data['file_type'] . '_' . str_replace('/', '', $data['start_date']) . '_' 
					. str_replace('/', '', $data['end_date']) . '.txt';
		$handle = fopen($my_file, 'wb') or die('Cannot open file:  '.$my_file);
		$context = '';
		
		if (isset($data['file_type']) && $data['file_type'] == "ZHTMIF03")
		{
			$results = $this->leave_header_model->findLeaveForExport($data['start_date'] , $data['end_date'], $data['department']);
			foreach ($results as $result)
			{
				$start_time = '     ';
				$end_time = '     ';
				
				if($result->leave_time > 0)
				{
					$worktime = explode("-", $result->work_time_desc);
					$start_time = str_replace('.', ':', $worktime[0]);
					$end_time = str_replace('.', ':', $worktime[1]);
				}
				
				$context .= $dept->x_path . $data['file_type'] . '\\' . $data['file_type'] . "\t" . 
							str_pad($result->username, 8, "0", STR_PAD_LEFT) . "\t" . $result->Leave_type_code . "\t" . 
							str_replace('/', '.', $result->start_date) . "\t" . str_replace('/', '.', $result->end_date) . "\t" . 
							$start_time . "\t" . $end_time . "\t" . " " . "\t" . "\r\n";
			}
		}
		else if(isset($data['file_type']) && $data['file_type'] == "ZHTMIF04")
		{
			$results = $this->work_report_header_model->findWorkReportForExport($data['start_date'] , $data['end_date'], $data['department']);
			foreach ($results as $result)
			{
				$start_time = '     ';
				$end_time = '     ';
				
				if($result->timework > 0)
				{
					$worktime = explode("-", $result->work_time_desc);
					$start_time = str_replace('.', ':', $worktime[0]);
					$end_time = str_replace('.', ':', $worktime[1]);
				}
				
				$context .= $dept->x_path . $data['file_type'] . '\\' . $data['file_type'] . "\t" . 
							str_pad($result->employee_id, 8, "0", STR_PAD_LEFT) . "\t" . $result->Work_type_code . "\t" . 
							str_replace('/', '.', $result->startdate) . "\t" . str_replace('/', '.', $result->enddate) . "\t" . 
							$start_time . "\t" . $end_time . "\t" . " " . "\t" . "\r\n";
			}
		}
		else if(isset($data['file_type']) && $data['file_type'] == "ZHTMIF05")
		{
			$results = $this->workTimeTransaction_model->findTimeTableForExport($data['start_date'] , $data['end_date'], $data['department']);
			foreach ($results as $result)
			{
				$start_time = '     ';
				$end_time = '     ';
				
				if($result->work_time != "")
				{
					$worktime = explode("-", $result->work_time);
					$start_time = str_replace('.', ':', $worktime[0]);
					$end_time = str_replace('.', ':', $worktime[1]);
					
					$context .= $dept->x_path . $data['file_type'] . '\\' . $data['file_type'] . "\t" . "P10" .
							"\t" . "0001" . "\t" . str_replace('/', '.', $result->work_date) . "\t" . $start_time .
							"\t              \t" . str_pad($result->emp_code, 8, "0", STR_PAD_LEFT) . "\t" . 
							str_pad($result->emp_code, 8, "0", STR_PAD_LEFT) . "\t \t\r\n";
					$context .= $dept->x_path . $data['file_type'] . '\\' . $data['file_type'] . "\t" . "P20" .
							"\t" . "0001" . "\t" . str_replace('/', '.', $result->work_date) . "\t" . $end_time .
							"\t              \t" . str_pad($result->emp_code, 8, "0", STR_PAD_LEFT) . "\t" . 
							str_pad($result->emp_code, 8, "0", STR_PAD_LEFT) . "\t \t\r\n";
				}
				
			}
			
			
		}
		
		
		fwrite($handle, $context);
		
		echo json_encode($my_file);
	}
	
	public function getNotify()
	{
		$work_result = $this->work_header_model->getNotify((int)$_SESSION["username"]);
		$leave_result = $this->leave_header_model->getNotify((int)$_SESSION["username"]);
		$result = array_merge($work_result, $leave_result);
		echo json_encode($result);
	}
	
}
