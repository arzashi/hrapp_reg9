<?php
if(!isset($_SESSION)){
    @session_start();
}

class Work_Header_model extends CI_Model {

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

    public function saveWorkHeader($data) {
        
		$insert_data = array('docNo' => $data['docNo'],'startdate' => $data['startdate'], 'enddate' => $data['enddate'], 'detail' => $data['detail'] ,'location' => $data['locationWork'], 'work_attachment' => $data['work_attachment'], 'work_standby' => $data['work_standby'], 'cartype_id' => $data['cartype_id'], 'car_detail1' => $data['car_detail1'],'sumWork' => $data['sumWork'], 'car_detail2' => $data['car_detail2'], 'create_by' => $data['create_by'], 'create_date' => $data['create_date']);
		
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
		
		$id = $this->db->insert('work_header', $insert_data);
		$insert_id = $this->db->insert_id();
		
		return  $insert_id;
    }
	
	public function updateWorkHeader($data) {
		$update_data = array('docNo' => $data['docNo'],'startdate' => $data['startdate'], 'enddate' => $data['enddate'], 'detail' => $data['detail'] ,'location' => $data['locationWork'], 'work_attachment' => $data['work_attachment'], 'work_standby' => $data['work_standby'], 'cartype_id' => $data['cartype_id'], 'car_detail1' => $data['car_detail1'],'sumWork' => $data['sumWork'], 'car_detail2' => $data['car_detail2'], 'upd_by' => $data['upd_by'], 'upd_date' => $data['upd_date']);
		
		$this->db->where('id', $data['work_id']);
        $this->db->update('work_header', $update_data);
        
        $this->db->affected_rows();

		return  $data['work_id'];
    }
	
	public function updateDocNo($id)
	{
		$update_data = array('docno' => $id);
		
		$this->db->where('id', $id);
        $this->db->update('work_header', $update_data);
        $this->db->affected_rows();
		
		return  $insert_id;
	}
	
	
	public function getWorkHeader($work_id) {
        $this->db->where("id", $work_id);
        return $this->db->get("work_header")->row();
    }
	
	public function getWorkHeaderByDocNo($docNo) {
		$sql = "SELECT header.* , car.Car_type_desc ".
				" FROM work_header header ".
				" LEFT JOIN car_type car ON header.cartype_id = car.id ".
				"WHERE header.docno = '{$docNo}'";
		
        $query = $this->db->query($sql);
        return $query->row();
    }
	
	public function deleteWorkHeader($work_id)
	{
		$this->db->where('id', $work_id);
		$this->db->delete('work_header'); 
	}
	
	public function getWorkByWorkReport($work_report_id)
	{
		$sql = "SELECT header.* FROM work_report_header report ".
				" JOIN work_header header ON report.work_header_id = header.id ".
				"WHERE report.id = '{$work_report_id}'";
		
        $query = $this->db->query($sql);
        return $query->row();
	}
	
	public function findWorkByCondition($start_date , $end_date , $username )
	{
		$sql = "SELECT distinct header.* , emp.* , dept.d_name, concat(emp_prove.gender,emp_prove.name,'     ',emp_prove.surname) AS approve_user, ".
				" concat(emp_prove.position,'     ',emp_prove.level) AS approve_job FROM work_header header ".
				"JOIN employee emp ON emp.code = CAST(header.create_by  AS UNSIGNED) ".
				"JOIN work_detail detail on header.id = detail.header_id ".
				"LEFT JOIN employee emp_prove ON header.approve_user_3 = emp_prove.code ".
				"LEFT JOIN department dept ON dept.d_id = emp.div_code ".
				"WHERE 1=1 AND detail.employee_id = '{$username}' AND (header.approve_1 IS NULL OR header.approve_1 = 1) ";
		
		if($start_date != "")
			$sql .=	"AND STR_TO_DATE(header.startdate,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y')";
		
		if($end_date != "")
			$sql .=	"AND STR_TO_DATE(header.enddate,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findWorkForLevel8($username)
	{
		$sql = "SELECT header.* ,  emp.* , GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser ".	
				"FROM work_header header ".
				"JOIN work_detail detail ON detail.header_id = header.id ".
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"WHERE header.approve_1 IS NULL and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username}) ".
				"GROUP BY header.id";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findWorkForLevel9($username)
	{
		$sql = "SELECT header.* ,  emp.* , GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser ".	
				" , emp_standby.gender as standby_gender , emp_standby.name as standby_name , emp_standby.surname as standby_surname ".
				"FROM work_header header ".
				"JOIN work_detail detail ON detail.header_id = header.id ".
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"LEFT JOIN employee emp_standby ON header.work_standby = emp_standby.code ".
				"WHERE (header.approve_1 IS NULL OR header.approve_1 = 1) AND header.approve_2 IS NULL and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username}) ".
				"GROUP BY header.id";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findWorkForLevel10()
	{
		$sql = "SELECT header.* ,  emp.* , GROUP_CONCAT(CONCAT(detail.employee_id, ' ', emp.name, ' ', emp.surname , '   ', emp.position, ' ชั้น  ', emp.level , '<br/>')) as alluser ".	
				" , emp_standby.gender as standby_gender , emp_standby.name as standby_name , emp_standby.surname as standby_surname ".
				"FROM work_header header ".
				"JOIN work_detail detail ON detail.header_id = header.id ".
				"JOIN employee emp ON emp.code = detail.employee_id ".
				"LEFT JOIN employee emp_standby ON header.work_standby = emp_standby.code ".
				"WHERE (header.approve_1 IS NULL OR header.approve_1 = 1) AND (header.approve_2 IS NULL OR header.approve_2 = 1) AND header.approve_3 IS NULL ".
				"GROUP BY header.id";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function grantWork1($work_id,$approveValue,$reason,$username)
	{
		$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));

		$this->db->where('id', $work_id);
        $this->db->update('work_header', $update_data);
        
        $this->db->affected_rows();

		return  $work_id;
	}
	
	public function grantWork2($work_id,$approveValue,$reason,$username)
	{
		
		$work = $this->getWorkHeader($work_id);
		
		if($work->approve_1 === null )
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"),'approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}else
		{
			$update_data = array('approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}

		$this->db->where('id', $work_id);
        $this->db->update('work_header', $update_data);
        
        $this->db->affected_rows();

		return  $work_id;
	}
	
	public function grantWork3($work_id,$approveValue,$reason,$username)
	{
		$work = $this->getWorkHeader($work_id);
		
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
        $this->db->update('work_header', $update_data);
        
        $this->db->affected_rows();

		return  $work_id;
	}
	
	public function checkValidDocNo($docNo,$username)
	{
		$sql = "SELECT * FROM work_header header ".
				" JOIN employee emp ON emp.code = CAST(header.create_by  AS UNSIGNED) ".
				"WHERE emp.div_code = (SELECT div_code FROM employee WHERE code = '{$username}') AND header.docNo = '{$docNo}' ";
		
        $query = $this->db->query($sql);
        $result = $query->result();
		
		if(sizeof($result) > 0)
			return false;
		else
			return true;
	}
	
	
	public function getNotify($username)
	{
		$sql = "SELECT header.id , header.startdate, header.approve_3, detail.employee_id , 'work' AS description FROM work_header header ".
				"JOIN work_detail detail ON header.id = detail.header_id ".
				"WHERE (header.approve_1 IS NULL OR header.approve_1 = 1) AND (header.approve_2 IS NULL OR header.approve_2 = 1) AND (approve_3 is null or (approve_3 = 1 and STR_TO_DATE(header.startdate,'%d/%m/%Y') < CURDATE())) AND detail.employee_id = '{$username}' ";
		
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
}

?>
