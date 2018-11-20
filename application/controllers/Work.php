<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        $this->load->model('carType_model');
        $this->load->model('workType_model');
        $this->load->model('employee_model');
        $this->load->model('work_header_model');
        $this->load->model('work_detail_model');
        $this->load->model('work_report_header_model');
        $this->load->model('work_report_detail_model');
        $this->load->model('workTime_model');
        $this->load->model('department_model');//jay
    }
	
	public function request()
	{
		$work = $this->input->get();
		$data = array();
		
		if(isset($work['work_id']))
		{
			$data['header'] = $this->work_header_model->getWorkHeader($work['work_id']);
			$data['detail'] = $this->work_detail_model->getWorkDetail($work['work_id']);
		}
		
		$this->load->view('header');
		$this->load->view('work/work_request', $data);
        $this->load->view('footer');
	}
	
	public function report()
	{
		$this->load->view('header');
		$this->load->view('work/work_report');
        $this->load->view('footer');
	}
	
	public function grant_level1()
	{
		$records = $this->work_header_model->findWorkForLevel8((int)$_SESSION["username"]);
		
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
		$data['pendingWorks'] = $records;
		
		$this->load->view('header');
		$this->load->view('work/grant_level1', $data);
        $this->load->view('footer');
	}
	
	public function grant_level2()
	{
		$records = $this->work_header_model->findWorkForLevel9((int)$_SESSION["username"]);
		
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
		$data['pendingWorks'] = $records;
		
		$this->load->view('header');
		$this->load->view('work/grant_level2', $data);
        $this->load->view('footer');
	}
	
	public function grant_level3()
	{
		$records = $this->work_header_model->findWorkForLevel10();
		
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
		$data['pendingWorks'] = $records;
		
		$this->load->view('header');
		$this->load->view('work/grant_level3', $data);
        $this->load->view('footer');
	}
	
	public function workReport()
	{
		$work = $this->input->get();
		$data = array();
		
		if(isset($work['work_report_id']))
		{
			$data['header'] = $this->work_report_header_model->getWorkReportHeader($work['work_report_id']);
			$data['detail'] = $this->work_report_detail_model->getWorkReportDetail($work['work_report_id']);
		}
		
		$this->load->view('header');
		$this->load->view('work_report/work_report', $data);
        $this->load->view('footer');
	}
	
	public function workReportSummary()
	{
		$this->load->view('header');
		$this->load->view('work_report/work_report_summary');
        $this->load->view('footer');
	}
	
	public function approve_level1()
	{
		$records = $this->work_report_header_model->findWorkReportForLevel8((int)$_SESSION["username"]);
		$data['workReports'] = $records;
		
		$this->load->view('header');
		$this->load->view('work_report/approve_level1', $data);
        $this->load->view('footer');
	}
	
	public function approve_level2()
	{
		$records = $this->work_report_header_model->findWorkReportForLevel9((int)$_SESSION["username"]);
		$data['workReports'] = $records;
		
		$this->load->view('header');
		$this->load->view('work_report/approve_level2', $data);
        $this->load->view('footer');
	}
	
	public function approve_level3()
	{
		$records = $this->work_report_header_model->findWorkReportForLevel10((int)$_SESSION["username"]);
		$data['workReports'] = $records;
		
		$this->load->view('header');
		$this->load->view('work_report/approve_level3', $data);
        $this->load->view('footer');
	}
	public function summary()
	{
		$this->load->view('header');
		$this->load->view('work_report/work_summary');
        $this->load->view('footer');
	}
	
	
}
