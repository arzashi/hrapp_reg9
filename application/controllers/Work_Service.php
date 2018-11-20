<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)){
    @session_start();
}

class Work_Service extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        $this->load->model('work_header_model');
        $this->load->model('work_detail_model');
        $this->load->model('employee_model');
    }
	
	public function saveWork()
	{
		try {
			$data = $this->input->post();
		
			if ($data['work_id'] != "")
			{
				// Update
				$data['upd_date'] = date("Y-m-d H:i:s");
				$data['upd_by'] = $_SESSION["username"];
				$header_id = $this->work_header_model->updateWorkHeader($data);
				$this->work_detail_model->deleteWorkDetailByHeader($data['work_id']);
			}
			else
			{
				// Insert
				$data['create_date'] = date("Y-m-d H:i:s");
				$data['create_by'] = $_SESSION["username"];
				$header_id = $this->work_header_model->saveWorkHeader($data);
				$this->work_header_model->updateDocNo($header_id);
			}
			
			if(isset($data['empList']) && sizeof($data['empList']) > 0)
			{
				foreach ($data['empList'] as $emp)
				{
					$this->work_detail_model->saveWorkDetail($emp['code'] , $header_id);
				}
			}
			
			
			echo json_encode($header_id);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	
	public function getEmployeeByCode(){
		$data = $this->input->post();
		echo json_encode($this->employee_model->getEmployeeByCode($data['code']));
	}
	
	
	public function listWork()
	{
		$data = $this->input->get();
		$records = $this->work_header_model->findWorkByCondition($data['start_date'], $data['end_date'], (int)$_SESSION["username"]);
		foreach ($records as $record)
		{
			$record->attachment = "";
			if($record->work_attachment != ""){
				$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $record->work_attachment;
				if (file_exists($dirName)) {
					if ($handle = opendir($dirName)) {
						while (false !== ($entry = readdir($handle))) {

							if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

								$record->attachment .=  "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $record->work_attachment . "/" . $entry ."'>". $entry . "</a></p></div><br>";
							}
						}
						closedir($handle);
					}
				} 	
			}
		}
		print_r(json_encode($records));
	}
	
	public function removeWork()
	{
		$data = $this->input->get();
		$this->work_detail_model->deleteWorkDetailByHeader($data['work_id']);
		$this->work_header_model->deleteWorkHeader($data['work_id']);
		
		echo json_encode(0);
	}
	
	public function saveGrant1()
	{
		$data = $this->input->post();
		if(isset($data['grantList']) && sizeof($data['grantList']) > 0)
		{
			foreach ($data['grantList'] as $grant)
			{
				$this->work_header_model->grantWork1($grant['work_id'] , $grant['approveValue'] , $grant['reason'] , (int)$_SESSION["username"]);
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
				$this->work_header_model->grantWork2($grant['work_id'] , $grant['approveValue'] , $grant['reason'] , (int)$_SESSION["username"]);
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
				$this->work_header_model->grantWork3($grant['work_id'] , $grant['approveValue'] , $grant['reason'] , (int)$_SESSION["username"]);
			}
		}		
		
		echo json_encode(true);
	}
	
	public function checkDocNo()
	{
		$data = $this->input->post();
		echo json_encode($this->work_header_model->checkValidDocNo($data['docNo'] , (int)$_SESSION["username"]));
	}
	
}
