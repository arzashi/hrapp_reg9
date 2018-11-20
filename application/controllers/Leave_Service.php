<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)){
    @session_start();
}

class Leave_Service extends CI_Controller {
    
	public function __construct() {
        parent::__construct();
        $this->load->model('leave_header_model');
        $this->load->model('leave_detail_model');        
        $this->load->model('leaveType_model'); 
    }
    
    public function randHash()//jay
    {
        $bytes = openssl_random_pseudo_bytes(32);
        //$hash = base64_encode($bytes); 
        $hash = $this->base64url_encode($bytes); 
	return $hash;
    }
    
    function base64url_encode( $data ){
        return rtrim( strtr( base64_encode( $data ), '+/', '-_'), '=');
    }
    
    function encodeTH($data){
        $date = iconv("TIS-620","UTF-8",$data);
        //$date = iconv("UTF-8","TIS-620",$data);
        return $date;
    }

    
    public function sendMail($htmlBody,$to)//jay
    {
       //***jay                
                //Send Mail OK
             
                $this->load->library("phpmailer");
                $this->phpmailer->CharSet = "utf-8";          
                $this->phpmailer->SetFrom('adminpwa9@pwa.co.th', 'ระบบแจ้งเตือนอัตโนมัติ HRAPP PWA9 V.1'); 
                //$this->phpmailer->AddReplyTo("replyto@example.com","replyto");  
                $this->phpmailer->Subject = "ระบบแจ้งเตือนการขออนุมัติวันลา อัตโนมัติ HRAPP PWA9 V.1"; 
                $this->phpmailer->MsgHTML($htmlBody);
                $this->phpmailer->AddAddress($to,"ผู้มีอำนาจอนุมัติ");
		
                if(!$this->phpmailer->Send()) {
                        echo $this->phpmailer->ErrorInfo; 
                } 
    }
    
    public function sendNotification($title,$body,$header_id,$sid2,$code)//jay
    {
          //Notification on mobile OK             
                  $stream_options = array(
                  'http' => array(
                     'method'  => 'GET',
                     //'header'=>'Content-Type: text/xml; charset=utf-8'
                      ),
                  );
                   $context  = stream_context_create($stream_options);                   
                   $url="http://192.168.90.241:8090/firebase/push_notification.php?service=pushForUserID&title=".$this->encodeTH($title)."&body=".$body."&code=10326";                                      
                   
                   $response = file_get_contents($url, null, $context);
                   //echo print_r($response);
                  
		
                   //add Notification
                   $context  = stream_context_create($stream_options); 
                   $topic = $title;
                   $detail = $body;
                   $table_name = 'leave_header';
                   $table_id = $header_id;
                   $sid = $sid2;
                   //$create_date = date("Y-m-d H:i:s");
                   //$approve_code = $code;
                   $url="http://192.168.90.241:8090/firebase/push_notification.php?service=addNotification&topic=".$topic."&detail=".$detail."&table_name=".$table_name."&table_id=".$table_id."&sid=".$sid."&code=".$code;                  
                   
                   $response = file_get_contents($url, null, $context);
                   
                   //echo print_r($response);
    }
	
	public function saveLeave()
	{
		$data = $this->input->post();
		
		if ($data['leave_id'] != "")
		{
			// Update
			$data['upd_date'] = date("Y-m-d H:i:s");
			$data['upd_by'] = $_SESSION["username"];
			$header_id = $this->leave_header_model->updateLeaveHeader($data);
			$this->leave_detail_model->deleteLeaveDetailByHeader($data['leave_id']);
		}
		else
		{
			// Insert
                        $sid = $this->randHash();
			$data['create_date'] = date("Y-m-d H:i:s");                        
			$data['create_by'] = $_SESSION["username"];
                        $data['sid'] = $sid;
			$header_id = $this->leave_header_model->saveLeaveHeader($data);
		}
		
		$startdate_1 = $this->input->post("startLeave1");
		$enddate_1 = $this->input->post("endLeave1");
		$time_1 = $this->input->post("timeLeave1");
		$sum_1 = $this->input->post("sumLeave1");
		$detail_1 = $this->leave_detail_model->saveLeaveDetail($header_id,$startdate_1,$enddate_1,$time_1,$sum_1);
		
		
		if ($this->input->post("startLeave2") != "" && $this->input->post("sumLeave2") != "")
		{
			$startdate_2 = $this->input->post("startLeave2");
			$enddate_2 = $this->input->post("endLeave2");
			$time_2 = $this->input->post("timeLeave2");
			$sum_2 = $this->input->post("sumLeave2");
			$detail_2 = $this->leave_detail_model->saveLeaveDetail($header_id,$startdate_2,$enddate_2,$time_2,$sum_2);
		}
                
                //jay
               $leaveHeader = $this->leave_header_model->getLeaveHeaderByJay($header_id);
               $leaveDetail = $this->leave_detail_model->getLeaveDetail($header_id);
               $leaveTypeHeader = $this->leaveType_model->getLeaveType($leaveHeader[0]->leave_type);
               
               
                $result = $this->leave_header_model->findAppoveUser($_SESSION['username']);
                if($result[0]->jobName === '0'){
                    $result[0]->jobName="";
                    $result[0]->level="";
                }
                
                  
                            //$result[0]->code
                            //$result[0]->fullname
                            //$result[0]->positionName ." ".$result[0]->level 
                            //$result[0]->jobName
                            //$result[0]->departmentName
                             
                
                $htmlBody= "ระบบแจ้งเตือนอัตโนมัติ HrApp PWA9 <br><hr>"
                            ."เรียน คุณ".$result[0]->name."<br>"
                            ."พนักงาน รหัส ".$_SESSION['username']."<br>"
                            ."ชื่อ ".$_SESSION['MyName']." ".$_SESSION['MySurname']."<br>"                        
                            ."ตำแหน่ง ".$_SESSION['Myposition']." ".$_SESSION['Mylevel']."<br>"
                            .$_SESSION['MyJob_name']."<br>"
                            .$_SESSION['Mydep_name']."<br><hr>"
                            ."&emsp;&emsp;มีความประสงค์ ขอ". $leaveTypeHeader[0]->Leave_type_desc ."<br>ตั้งแต่วันที่ ".$leaveDetail[0]->start_date." ถึงวันที่ ".$leaveDetail[0]->end_date." รวมทั้งสิ้น ".$leaveDetail[0]->sum_leave ." วัน <br>"
                            ."หากท่านเห็นสมควร อนุมัติ โปรดยืนยันการอนุมัติ โดย <a href='http://192.168.90.241:8090/hrapp/index.php/leave/grant_service?sid=".$sid."&uid=".$header_id."&grant_level=1'>click</a> link นี้ เพื่อโปรดพิจารณาดำเนินการต่อไป <br><hr>"
                            //."Approve click here.<br>"
                            //."<a hrcf='http://192.168.90.241:8090/hrapp/index.php/myservice/activate?sid=".$sid."&uid=".$header_id."'>click</a><br>"
                            
                            ."--- END ---" ;
                
                //$activate = "http://192.168.90.241:8090/hrapp/index.php/myservice/activate?";
                $activate = "http://192.168.90.241:8090/hrapp/index.php/leave/grant_service?";
                $this->sendMail($htmlBody,$result[0]->email);                
                $this->sendNotification("PWA9_HRAPP_Alert",$activate,$header_id,$sid,$result[0]->code);
                
                echo json_encode($header_id);
	}
	
	public function deleteAttachment()
	{
		$data = $this->input->post();
		
		$dir_file = dirname(@$_SERVER['SCRIPT_FILENAME']) . "/asset/upload/files/" . $data['org'] . '/' . $data['user_id'] . "/" . $data['timeStamp']. "/" . $data['fileName'];
		try {
			if (!unlink($dir_file))
			{
			  echo json_encode("Error deleting $file");
			}
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
		}
		
		echo json_encode(true);
		
	}
	
	public function listLeave()
	{
		$data = $this->input->get();
		$isHR = ($_SESSION["MyJob_name"] == "งานทรัพยากรบุคคล") && ($data['method'] == 'HR');
		
		if ($isHR)
			$emp_code = $data['emp_code'];
		else
			$emp_code = (int)$_SESSION["username"];
		
		$records = $this->leave_header_model->findLeaveByCondition($data['start_date'], $data['end_date'],$emp_code ,$isHR);
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
	
		print_r(json_encode($records));
	}
	
	public function removeLeave()
	{
		$data = $this->input->get();
		$this->leave_detail_model->deleteLeaveDetailByHeader($data['leave_id']);
		$this->leave_header_model->deleteLeaveHeader($data['leave_id']);
		
		echo json_encode(0);
	}
        
        public function saveGrant()//jay add
	{
		$data = $this->input->post();
		if(isset($data['grantList']) && sizeof($data['grantList']) > 0)
		{
			foreach ($data['grantList'] as $grant)
			{
                                //(int)$_SESSION["username"]
                                if(1==1)
                                    $this->leave_header_model->grantLeave1($grant['leave_id'] , $grant['approveValue'] , $grant['reason'] , $grant['sumleave'], (int)$_SESSION["username"]);
                                else if(1==1)
                                    $this->leave_header_model->grantLeave2($grant['leave_id'] , $grant['approveValue'] , $grant['reason'] , $grant['sumleave'], (int)$_SESSION["username"]);
                                else
                                    $this->leave_header_model->grantLeave3($grant['leave_id'] , $grant['approveValue'] , $grant['reason'] , $grant['sumleave'], (int)$_SESSION["username"]);
			}
		}		
		
		echo json_encode(true);
	}
        
	
	public function saveGrant1()
	{
		$data = $this->input->post();
		if(isset($data['grantList']) && sizeof($data['grantList']) > 0)
		{
			foreach ($data['grantList'] as $grant)
			{
				$this->leave_header_model->grantLeave1($grant['leave_id'] , $grant['approveValue'] , $grant['reason'] , $grant['sumleave'], (int)$_SESSION["username"]);
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
				$this->leave_header_model->grantLeave2($grant['leave_id'] , $grant['approveValue'] , $grant['reason'] , $grant['sumleave'], (int)$_SESSION["username"]);
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
				$this->leave_header_model->grantLeave3($grant['leave_id'] , $grant['approveValue'] , $grant['reason'] , $grant['sumleave'], (int)$_SESSION["username"]);
			}
		}		
		
		echo json_encode(true);
	}
	
	public function getLeaveSummary()
	{
		$current_year = date('Y');
		$holiday_year = $current_year;
		
		/*
		$sick_year = $current_year;
		if((time()-(60*60*24)) >= strtotime($current_year . '-07-01 00:00:00'))
		{
			$sick_year += 1;
		}
		*/
		if((time()-(60*60*24)) >= strtotime($current_year . '-10-01 00:00:00'))
		{
			$holiday_year += 1;
		}
		
		$data = array();
		$data["sick_year"] = '01 ต.ค.  ' . ($holiday_year - 1) . ' ถึง  30 ก.ย. ' . $holiday_year;
		$data["holiday_year"] = '01 ต.ค.  ' . ($holiday_year - 1) . ' ถึง   30 ก.ย. ' . $holiday_year;
		$data["sick_sum"] = $this->leave_header_model->getSummaryLeaveByCondition( '01/10/' . ($holiday_year - 1) , '30/09/' . $holiday_year , (int)$_SESSION["username"] , false);
		$data["holiday_sum"] = $this->leave_header_model->getSummaryLeaveByCondition( '01/10/' . ($holiday_year - 1) , '30/09/' . $holiday_year , (int)$_SESSION["username"] , true);
		
		echo json_encode($data);
	}
	
}
