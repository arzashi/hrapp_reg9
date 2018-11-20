<?php
if(!isset($_SESSION)){
    @session_start();
}

class Work_Report_Header_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->load->database();
    }

    /* ###################################################
     * 
     * 
     *      function for get data information
     * 
     * 
     * ###################################################
     */

    public function saveWorkReportHeader($data) {
        
		$insert_data = array('work_type_id' => $data['work_type_id'],'startdate' => $data['startdate'], 'enddate' => $data['enddate'], 'timework' => $data['timework'] ,'sumWorkReport' => $data['sumWorkReport'], 'work_header_id' => $data['work_header_id'], 'create_by' => $data['create_by'], 'create_date' => $data['create_date']);
		
		if($_SESSION["role"] == 1)
		{
			$insert_data['approve_1'] = "1";
			$insert_data['approve_user_1'] = $data['username'];
			$insert_data['approve_date_1'] = $data['create_date'];
		}
		else if($_SESSION["role"] == 2)
		{
			$insert_data['approve_1'] = "1";
			$insert_data['approve_2'] = "1";
			$insert_data['approve_user_1'] = $data['username'];
			$insert_data['approve_user_2'] = $data['username'];	
			$insert_data['approve_date_1'] = $data['create_date'];
			$insert_data['approve_date_2'] = $data['create_date'];	
		}
		else if($_SESSION["role"] == 3)
		{
			$insert_data['approve_1'] = "1";
			$insert_data['approve_2'] = "1";
			$insert_data['approve_3'] = "1";
			$insert_data['approve_user_1'] = $data['username'];
			$insert_data['approve_user_2'] = $data['username'];
			$insert_data['approve_user_3'] = $data['username'];
			$insert_data['approve_date_1'] = $data['create_date'];
			$insert_data['approve_date_2'] = $data['create_date'];
			$insert_data['approve_date_3'] = $data['create_date'];
		}
		
		$id = $this->db->insert('work_report_header', $insert_data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
    }
	
	public function updateWorkReportHeader($data) {
		$update_data = array('work_type_id' => $data['work_type_id'],'startdate' => $data['startdate'], 'enddate' => $data['enddate'], 'timework' => $data['timework'] ,'sumWorkReport' => $data['sumWorkReport'], 'work_header_id' => $data['work_header_id'], 'upd_by' => $data['upd_by'], 'upd_date' => $data['upd_date']);
		
		$this->db->where('id', $data['work_report_id']);
        $this->db->update('work_report_header', $update_data);
        
        $this->db->affected_rows();

		return  $data['work_report_id'];
    }
	
	
	public function getWorkReportHeader($work_report_id) {
        $this->db->where("id", $work_report_id);
        return $this->db->get("work_report_header")->row();
    }
	
	public function deleteWorkReportHeader($work_report_id)
	{
		$this->db->where('id', $work_report_id);
		$this->db->delete('work_report_header'); 
	}
	
	public function findWorkReportByCondition($start_date , $end_date , $username )
	{
		$sql = "SELECT distinct reportheader.* , emp.* , dept.d_name, concat(emp_prove.gender,emp_prove.name,'     ',emp_prove.surname) AS approve_user ".
				" , worktype.Work_type_code , worktype.Work_type_desc, header.docno, header.detail , header.location, ".
				" concat(emp_prove.position,'     ',emp_prove.level) AS approve_job FROM work_report_header reportheader ".
				"LEFT JOIN work_header header ON reportheader.work_header_id = header.id ".
				"JOIN work_type worktype ON reportheader.work_type_id = worktype.id ".
				"JOIN employee emp ON emp.code = CAST(reportheader.create_by  AS UNSIGNED) ".
				"JOIN work_report_detail detail on reportheader.id = detail.header_id ".
				"LEFT JOIN employee emp_prove ON reportheader.approve_user_3 = emp_prove.code ".
				"LEFT JOIN department dept ON dept.d_id = emp.div_code ".
				"WHERE 1=1 AND detail.employee_id = '{$username}' AND (reportheader.approve_1 IS NULL OR reportheader.approve_1 = 1) ";
		
		if($start_date != "")
			$sql .=	"AND STR_TO_DATE(reportheader.startdate,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y')";
		
		if($end_date != "")
			$sql .=	"AND STR_TO_DATE(reportheader.enddate,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
		
	public function findWorkReportForHR($start_date , $end_date ,$username)
	{
		$sql = "SELECT header.* ,  emp.*, GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser , worktype.Work_type_code , worktype.Work_type_desc , wheader.location , wheader.detail , wheader.docno ".	
				"FROM work_report_header header ".
				"JOIN work_report_detail detail ON detail.header_id = header.id ".
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"JOIN work_type worktype ON worktype.id = header.work_type_id " .
				"LEFT JOIN work_header wheader ON wheader.id = header.work_header_id " .
				"WHERE 1=1 AND (header.approve_3 IS NULL OR header.approve_3 = 1) ";
				
		if($start_date != "")
			$sql .=	" AND STR_TO_DATE(header.startdate,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y') ";
		
		if($end_date != "")
			$sql .=	" AND STR_TO_DATE(header.enddate,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		
		$sql .= "GROUP BY header.id";
		
		if($username != "")
			$sql .=	" Having GROUP_CONCAT(CONCAT(detail.employee_id)) like '%{$username}%' ";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findWorkReportForLevel8($username)
	{
		$sql = "SELECT header.* ,  emp.* , GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser , worktype.Work_type_code , worktype.Work_type_desc , wheader.location , wheader.detail " .	
				"FROM work_report_header header ".
				"JOIN work_report_detail detail ON detail.header_id = header.id ".
				"JOIN work_header wheader ON wheader.id = header.work_header_id " .
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"JOIN work_type worktype ON worktype.id = header.work_type_id " .
				"WHERE header.approve_1 IS NULL and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username}) ".
				"GROUP BY header.id";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findWorkReportForLevel9($username)
	{
		$sql = "SELECT header.* ,  emp.* , GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser , worktype.Work_type_code , worktype.Work_type_desc , wheader.location , wheader.detail ".	
				"FROM work_report_header header ".
				"JOIN work_report_detail detail ON detail.header_id = header.id ".
				"JOIN work_header wheader ON wheader.id = header.work_header_id " .
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"JOIN work_type worktype ON worktype.id = header.work_type_id " .
				"WHERE (header.approve_1 IS NULL OR header.approve_1 = 1) AND header.approve_2 IS NULL and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username}) ".
				"GROUP BY header.id";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findWorkReportForLevel10($username)
	{
		$sql = "SELECT header.* ,  emp.* , GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser , worktype.Work_type_code , worktype.Work_type_desc , wheader.location , wheader.detail ".	
				"FROM work_report_header header ".
				"JOIN work_report_detail detail ON detail.header_id = header.id ".
				"JOIN work_header wheader ON wheader.id = header.work_header_id " .
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"JOIN work_type worktype ON worktype.id = header.work_type_id " .
				"WHERE (header.approve_1 IS NULL OR header.approve_1 = 1) AND (header.approve_2 IS NULL OR header.approve_2 = 1) AND header.approve_3 IS NULL ".
				"GROUP BY header.id";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function grantReport1($work_id,$approveValue,$reason,$username)
	{
		$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));

		$this->db->where('id', $work_id);
        $this->db->update('work_report_header', $update_data);
        
        $this->db->affected_rows();

		return  $work_id;
	}
	
	public function grantReport2($work_id,$approveValue,$reason,$username)
	{
		
		$work = $this->getWorkReportHeader($work_id);
		
		if($work->approve_1 === null )
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"),'approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}else
		{
			$update_data = array('approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}

		$this->db->where('id', $work_id);
        $this->db->update('work_report_header', $update_data);
        
        $this->db->affected_rows();

		return  $work_id;
	}
	
	public function grantReport3($work_id,$approveValue,$reason,$username)
	{
		$work = $this->getWorkReportHeader($work_id);
		
		if($work->approve_1 === null )
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"),'approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"),'approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}elseif ($work->approve_2 === null )
		{
			$update_data = array('approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"),'approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}else
		{
			$update_data = array('approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}

		$this->db->where('id', $work_id);
        $this->db->update('work_report_header', $update_data);
        
        $this->db->affected_rows();

		return  $work_id;
	}
	
	
	public function findWorkReportForExport($start_date , $end_date , $department)
	{
		$sql = "SELECT header.* , detail.* , wty.* , wt.* ".
				"FROM work_report_header header ".
				"JOIN work_report_detail detail ON header.id = detail.header_id ".
				"JOIN work_header wh ON header.work_header_id = wh.id ".
				"JOIN work_type wty ON header.work_type_id = wty.id ".
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"LEFT JOIN work_time wt ON header.timework = wt.work_time_code ".
				"WHERE 1=1 AND header.approve_3 IS NOT NULL AND emp.div_code = '{$department}' ";
		
		if($start_date != "")
			$sql .=	"AND STR_TO_DATE(header.startdate,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y') ";
		
		if($end_date != "")
			$sql .=	"AND STR_TO_DATE(header.enddate,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		/*
		if($department == "55310")
			$sql .=	"AND LENGTH(emp.div_code) < 7 ";
		else
			$sql .=	"AND emp.div_code = '{$department}' ";
		*/
        $query = $this->db->query($sql);
        return $query->result();
	}
		
}

?>
