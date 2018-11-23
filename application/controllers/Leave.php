<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('leaveType_model');
        $this->load->model('employee_model');
        $this->load->model('leave_header_model');
        $this->load->model('leave_detail_model');
        $this->load->model('workTime_model');        
        $this->load->model('department_model');//jay
    }
	
	public function request()
	{
		$leave = $this->input->get();
		$data = array();
		
		if(isset($leave['leave_id']))
		{
			$data['header'] = $this->leave_header_model->getLeaveHeader($leave['leave_id']);
			$data['detail'] = $this->leave_detail_model->getLeaveDetail($leave['leave_id']);
		}
		
		$current_year = date('Y');
		$holiday_year = $current_year;
		if((time()-(60*60*24)) >= strtotime($current_year . '-10-01 00:00:00'))
		{
			$holiday_year += 1;
		}
		$data["sick_sum"] = $this->leave_header_model->getSummaryLeaveByCondition( '01/10/' . ($holiday_year - 1) , '30/09/' . $holiday_year , (int)$_SESSION["username"] , false);
		$data["holiday_sum"] = $this->leave_header_model->getSummaryLeaveByCondition( '01/10/' . ($holiday_year - 1) , '30/09/' . $holiday_year , (int)$_SESSION["username"] , true);		
                
		$this->load->view('header');
		$this->load->view('leave/leave_request', $data);
                $this->load->view('footer');
	}
	
	
	public function report()
	{
		$this->load->view('header');
		$this->load->view('leave/leave_report');
                $this->load->view('footer');
	}
	
	
	public function grant_level1()
	{
		$records = $this->leave_header_model->findLeaveForLevel8((int)$_SESSION["username"]);
		
		foreach ($records as $record)
		{
			$record->attachment = "";
			if($record->leave_attachment != ""){
				$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $record->leave_attachment;
				if (file_exists($dirName)) {
					if ($handle = opendir($dirName)) {
						while (false !== ($entry = readdir($handle))) {

							if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

								$record->attachment .=  "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $record->leave_attachment . "/" . $entry ."'>". $entry . "</a></p></div><br>";
							}
						}
						closedir($handle);
					}
				} 	
			}
		}
		$data['pendingLeaves'] = $records;
		
		$this->load->view('header');
		$this->load->view('leave/grant_level1', $data);
                $this->load->view('footer');
	}
	
	
	public function grant_level2()
	{
		$records = $this->leave_header_model->findLeaveForLevel9((int)$_SESSION["username"]);
		
		foreach ($records as $record)
		{
			$record->attachment = "";
			if($record->leave_attachment != ""){
				$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $record->leave_attachment;
				if (file_exists($dirName)) {
					if ($handle = opendir($dirName)) {
						while (false !== ($entry = readdir($handle))) {

							if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

								$record->attachment .=  "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $record->leave_attachment . "/" . $entry ."'>". $entry . "</a></p></div><br>";
							}
						}
						closedir($handle);
					}
				} 	
			}
		}
		$data['pendingLeaves'] = $records;
		
		$this->load->view('header');
		$this->load->view('leave/grant_level2', $data);
                $this->load->view('footer');
	}
	
	
	public function grant_level3()
	{
		$records = $this->leave_header_model->findLeaveForLevel10();
		
		foreach ($records as $record)
		{
			$record->attachment = "";
			if($record->leave_attachment != ""){
				$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $record->leave_attachment;
				if (file_exists($dirName)) {
					if ($handle = opendir($dirName)) {
						while (false !== ($entry = readdir($handle))) {

							if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

								$record->attachment .=  "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $record->leave_attachment . "/" . $entry ."'>". $entry . "</a></p></div><br>";
							}
						}
						closedir($handle);
					}
				} 	
			}
		}
		$data['pendingLeaves'] = $records;
		
		$this->load->view('header');
		$this->load->view('leave/grant_level3', $data);
                $this->load->view('footer');
	}
        
        public function grant_service()//jay add
	{
            $leave = $this->input->get();
           
            //http://192.168.90.241:8090/hrapp/index.php/leave/grant_service?sid=9IummRLI2Ay_Itb-4AB8scKvE9yK1z9ghbR11Hvzh6w&id=1
	    //$records = $this->leave_header_model->findLeaveForLevel8((int)$_SESSION["username"]);
                $records = $this->leave_header_model->findLeaveForLevelForApprove($leave['sid'], $leave['uid'],$leave['grant_level']);
		
		foreach ($records as $record)
		{
			$record->attachment = "";
			if($record->leave_attachment != ""){
				$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $record->leave_attachment;
				if (file_exists($dirName)) {
					if ($handle = opendir($dirName)) {
						while (false !== ($entry = readdir($handle))) {

							if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

								$record->attachment .=  "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $record->leave_attachment . "/" . $entry ."'>". $entry . "</a></p></div><br>";
							}
						}
						closedir($handle);
					}
				} 	
			}
		}
		$data['pendingLeaves'] = $records;
		
		$this->load->view('header_mobile');
		$this->load->view('leave/grant_service', $data);
                $this->load->view('footer');
	}
	
	
	public function summary()
	{
		$this->load->view('header');
		$this->load->view('leave/leave_summary');
                $this->load->view('footer');
	}
}
