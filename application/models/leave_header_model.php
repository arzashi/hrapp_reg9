<?php
if(!isset($_SESSION)){
    @session_start();
}

class Leave_Header_model extends CI_Model {

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

    public function saveLeaveHeader($data) {
        
		$insert_data = array('username' => $data['username'], 'leave_type' => $data['leave_type'], 'leave_attachment' => $data['leave_attachment'], 'leave_standby' => $data['leave_standby'], 'create_by' => $data['create_by'], 'create_date' => $data['create_date'],'sid' => $data['sid']);
		
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
		
		$id = $this->db->insert('leave_header', $insert_data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
    }
	
	public function updateLeaveHeader($data) {
		
		$update_data = array('username' => $data['username'], 'leave_type' => $data['leave_type'], 'leave_attachment' => $data['leave_attachment'], 'leave_standby' => $data['leave_standby'], 'upd_by' => $data['upd_by'], 'upd_date' => $data['upd_date']);
		
		$this->db->where('leave_id', $data['leave_id']);
        $this->db->update('leave_header', $update_data);
        
        $this->db->affected_rows();

		return  $data['leave_id'];
    }
	
	public function getLeaveHeader($leave_id) {
        $this->db->where("leave_id", $leave_id);
        return $this->db->get("leave_header")->row();
    }

	public function findLeaveByCondition($start_date , $end_date , $username , $isHR)
	{
		$sql = "SELECT header.* , detail.* , type.* , emp.* , dept.d_name, ".
				" concat(emp_prove.gender,emp_prove.name,'     ',emp_prove.surname) AS approve_user, ".
				" concat(emp_prove.position,'     ',emp_prove.level) AS approve_job FROM leave_header header ".
				"JOIN (SELECT DISTINCT leave_id , MIN(STR_TO_DATE(start_date, '%d/%m/%Y')) AS  start_date, MAX(STR_TO_DATE(end_date, '%d/%m/%Y')) AS end_date ".
				", SUM(sum_leave) AS sum_leave ".
				"FROM leave_detail ".
				"GROUP BY leave_id ) detail ON header.leave_id = detail.leave_id ".
				"JOIN leave_type type ON header.leave_type = type.id ".
				"LEFT JOIN employee emp ON emp.code = header.username ".
				"LEFT JOIN employee emp_prove ON header.approve_user_3 = emp_prove.code ".
				"LEFT JOIN department dept ON dept.d_id = emp.div_code ".
				"WHERE 1=1 AND (header.approve_3 != '0' OR header.approve_3 IS NULL) ";
		if ($isHR == true)
			$sql .=	"AND (header.approve_1 = '1' AND header.approve_2 = '1' AND header.approve_3 = '1') ";
		
		if ($username != "")
			$sql .=	"AND header.username = '{$username}' ";
		
		if($start_date != "")
			$sql .=	"AND start_date >= STR_TO_DATE('{$start_date}','%d/%m/%Y')";
		
		if($end_date != "")
			$sql .=	"AND end_date <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";

        $query = $this->db->query($sql);
        return $query->result();
		
	}
		
	public function findLeaveForLevel8($username)
	{
		$sql = "SELECT * FROM leave_header header ".
				"JOIN (SELECT DISTINCT leave_id , MIN(STR_TO_DATE(start_date, '%d/%m/%Y')) AS  start_date, MAX(STR_TO_DATE(end_date, '%d/%m/%Y')) AS end_date ".
				", SUM(sum_leave) AS sum_leave ".
				"FROM leave_detail ".
				"GROUP BY leave_id ) detail ON header.leave_id = detail.leave_id ".
				"JOIN leave_type type ON header.leave_type = type.id ".
				"JOIN employee emp ON emp.code = header.username ".
				"WHERE header.approve_1 IS NULL and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username})";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
        
        public function findLeaveForLevelForApprove($token,$id,$grant_level="1")//jay add
	{
		$sql = "SELECT * FROM leave_header header ".
				"JOIN (SELECT DISTINCT leave_id , MIN(STR_TO_DATE(start_date, '%d/%m/%Y')) AS  start_date, MAX(STR_TO_DATE(end_date, '%d/%m/%Y')) AS end_date ".
				", SUM(sum_leave) AS sum_leave ".
				"FROM leave_detail ".
				"GROUP BY leave_id ) detail ON header.leave_id = detail.leave_id ".
				"JOIN leave_type type ON header.leave_type = type.id ".
				"JOIN employee emp ON emp.code = header.username ".                                
				"WHERE header.approve_".$grant_level." IS NULL ".
                                //"and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username}) ".
                                "AND header.sid='{$token}' ".
                                "AND header.leave_id='{$id}' ";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
        
	
	public function findLeaveForLevel9($username)
	{
		$sql = "SELECT header.* , detail.* , type.Leave_type_code , type.Leave_type_desc , emp.* " . 
				" , emp_standby.gender as standby_gender , emp_standby.name as standby_name , emp_standby.surname as standby_surname  FROM leave_header header ".
				"JOIN (SELECT DISTINCT leave_id , MIN(STR_TO_DATE(start_date, '%d/%m/%Y')) AS  start_date, MAX(STR_TO_DATE(end_date, '%d/%m/%Y')) AS end_date ".
				", SUM(sum_leave) AS sum_leave ".
				"FROM leave_detail ".
				"GROUP BY leave_id ) detail ON header.leave_id = detail.leave_id ".
				"JOIN leave_type type ON header.leave_type = type.id ".
				"JOIN employee emp ON emp.code = header.username ".
				"LEFT JOIN employee emp_standby ON header.leave_standby = emp_standby.code ".
				"WHERE header.approve_1 IS NULL OR header.approve_2 IS NULL and emp.div_code = (SELECT div_code FROM employee WHERE code = {$username})";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function findLeaveForLevel10()
	{
		$sql = "SELECT header.* , detail.* , type.Leave_type_code , type.Leave_type_desc , emp.* " . 
				" , emp_standby.gender as standby_gender , emp_standby.name as standby_name , emp_standby.surname as standby_surname  FROM leave_header header ".
				"JOIN (SELECT DISTINCT leave_id , MIN(STR_TO_DATE(start_date, '%d/%m/%Y')) AS  start_date, MAX(STR_TO_DATE(end_date, '%d/%m/%Y')) AS end_date ".
				", SUM(sum_leave) AS sum_leave ".
				"FROM leave_detail ".
				"GROUP BY leave_id ) detail ON header.leave_id = detail.leave_id ".
				"JOIN leave_type type ON header.leave_type = type.id ".
				"JOIN employee emp ON emp.code = header.username ".
				"LEFT JOIN employee emp_standby ON header.leave_standby = emp_standby.code ".
				"WHERE header.approve_3 IS NULL";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function grantLeave1($leave_id,$approveValue,$reason,$sumleave,$username)
	{
		if ($sumleave >=4)
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d H:i:s"),'approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d H:i:s"),'approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d H:i:s"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}
		else
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d H:i:s"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}

		$this->db->where('leave_id', $leave_id);
                $this->db->update('leave_header', $update_data);
        
                $this->db->affected_rows();

		return  $leave_id;
	}
	
	public function grantLeave2($leave_id,$approveValue,$reason,$sumleave,$username)
	{
		$leave = $this->getLeaveHeader($leave_id);
		
		if($leave->approve_1 === null )
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"),'approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}else
		{
			$update_data = array('approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"),'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}
		
		if($leave->leave_standby === null)
		{
			$update_data->approve_3 = $approveValue;
			$update_data->reject_3 = $reason;
			$update_data->approve_user_3 = $username;
			$update_data->approve_date_3 = date("Y-m-d");
		}

		$this->db->where('leave_id', $leave_id);
        $this->db->update('leave_header', $update_data);
        
        $this->db->affected_rows();

		return  $leave_id;
	}
	
	public function grantLeave3($leave_id,$approveValue,$reason,$sumleave,$username)
	{
		$leave = $this->getLeaveHeader($leave_id);
		
		if($leave->approve_1 === null )
		{
			$update_data = array('approve_1' => $approveValue, 'reject_1' => $reason, 'approve_user_1' => $username, 'approve_date_1' => date("Y-m-d"),'approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"),'approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));
		}elseif ($leave->approve_2 === null )
		{
			$update_data = array('approve_2' => $approveValue, 'reject_2' => $reason, 'approve_user_2' => $username, 'approve_date_2' => date("Y-m-d"),'approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}else
		{
			$update_data = array('approve_3' => $approveValue, 'reject_3' => $reason, 'approve_user_3' => $username, 'approve_date_3' => date("Y-m-d"), 'upd_by' => $username, 'upd_date' => date("Y-m-d H:i:s"));	
		}

		$this->db->where('leave_id', $leave_id);
        $this->db->update('leave_header', $update_data);
        
        $this->db->affected_rows();

		return  $leave_id;
	}
	
	public function deleteLeaveHeader($leave_id)
	{
		$this->db->where('leave_id', $leave_id);
		$this->db->delete('leave_header'); 
	}
	
	public function findLeaveForExport($start_date , $end_date , $department)
	{
		$sql = "SELECT header.* , detail.* , lt.* , wt.* ".
				"FROM leave_header header  ".
				"JOIN leave_detail detail ON header.leave_id = detail.leave_id ".
				"JOIN leave_type lt ON header.leave_type = lt.id ".
				"JOIN employee emp ON emp.code = header.username ".
				"LEFT JOIN work_time wt ON detail.leave_time = wt.work_time_code ".
				"WHERE 1=1 AND header.approve_3 IS NOT NULL AND emp.div_code = '{$department}' ";
		
		if($start_date != "")
			$sql .=	"AND STR_TO_DATE(detail.start_date,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y') ";
		
		if($end_date != "")
			$sql .=	"AND STR_TO_DATE(detail.end_date,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		/*
		if($department == "55310")
			$sql .=	"AND LENGTH(emp.div_code) < 7 ";
		else
			$sql .=	"AND emp.div_code = '{$department}' ";
		*/
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	public function getSummaryLeaveByCondition($start_date , $end_date , $username , $isHoliday)
	{
		$sql = "SELECT SUM(detail.sum_leave) AS sum_leave  FROM leave_header header ".
				" JOIN leave_detail detail ON header.leave_id = detail.leave_id ".
				" WHERE 1=1 AND (header.approve_1 = '1' AND header.approve_2 = '1' AND header.approve_3 = '1') ";
		
		if ($isHoliday == false)
			$sql .=	" AND header.leave_type in (1,2,3) ";
		else 
			$sql .=	" AND header.leave_type in (4) ";
		
		if ($username != "")
			$sql .=	"AND header.username = '{$username}' ";
		
		if($start_date != "")
			$sql .=	" AND STR_TO_DATE(detail.start_date,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y') ";
		
		if($end_date != "")
			$sql .=	" AND STR_TO_DATE(detail.end_date,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		
        $query = $this->db->query($sql);
        $result = $query->result();
		
		if(sizeOf($result) > 0 && $result[0]->sum_leave != null)
			return $result[0]->sum_leave;
		else
			return 0 ;
		
	}
		
	public function getNotify($username)
	{
		$sql = "SELECT header.leave_id , detail.start_date, header.approve_3, header.username , 'leave' AS description FROM leave_header header ".
				"JOIN leave_detail detail ON header.leave_id = detail.leave_id ".
				"WHERE (header.approve_1 IS NULL OR header.approve_1 = 1) AND (header.approve_2 IS NULL OR header.approve_2 = 1) AND (approve_3 is null or (approve_3 = 1 and STR_TO_DATE(detail.start_date,'%d/%m/%Y') < CURDATE())) AND header.username = '{$username}' ";
		
		
        $query = $this->db->query($sql);
        return $query->result();
	}
        
        //***jay
        //หาหัวหน้างานของผู้ขอลา
        public function findAppoveUser($userCode){
            $email = 'chatreek@pwa.co.th';
            $condition = '';
            $jobName = '';
            $position = '';
            $division = '';
            $level = '';
            $ba = '';
            
            //กรณี 1 พนักงานทั่วไป
            //กรณี 2 หัวหน้า แต่งตั้ง รก. พักร้อน
            //กรณี 3 ผอ.กอง แต่งตั้ง รก. พักร้อน
            
            $sql = "select job_name,div_code,level,position FROM employee
                    where 1
                    and code = '{$userCode}' 
                    ";		
		
            $query = $this->db->query($sql);
            $result = $query->result();  
            
            if(sizeOf($result) > 0){
                $jobName = $result[0]->job_name;
                $position = trim($result[0]->position);
                $division = trim($result[0]->div_code);
                $level = $result[0]->level;               
            }
            
            if(stripos($position, "หัวหน้างาน") === 0)
                $condition = " AND position like '%ผู้อำนวยการ%' AND div_code = '{$division}'";                                          
            else if(stripos($position, "ผู้อำนวยการ") === 0)                                
                $condition = " AND position like '%ผู้อำนวยการการ%' AND div_code = left('{$division}',5)";
            else
                $condition = " AND position like '%หัวหน้างาน%' AND job_name = '{$jobName}'";
            
            
            $sql = "select code
                        ,email
                        ,concat(gender,'',name,' ',surname) as fullname
                        ,concat(name,' ',surname) as name
                        -- ,concat(position,' ',level) as positionName
                        ,position as positionName
                        ,level as level
                        ,job_name as jobName    
                        ,d_name as departmentName
                    FROM employee
                    inner join department on div_code = d_id
                    where 1
                    and is_delete = '0'
                    {$condition}";		
		
            $query = $this->db->query($sql);
            
            return $query->result();           
            
        }
        
        //ยืนยันการอนุมัติ
        public function getActivate($sid,$header_id)
	{
		$sql = "SELECT header.leave_id 
                            ,detail.start_date
                            ,header.approve_3
                            ,header.username 
                            ,'leave' AS description
                            ,header.approve_1
                            ,header.approve_2
                            ,header.approve_3
                        FROM leave_header header 
			JOIN leave_detail detail ON header.leave_id = detail.leave_id 
		        WHERE 1 
                        and (header.approve_1 IS NULL OR header.approve_1 = 1) 
                        AND (header.approve_2 IS NULL OR header.approve_2 = 1) 
                        AND (approve_3 is null or (approve_3 = 1 and STR_TO_DATE(detail.start_date,'%d/%m/%Y') < CURDATE())) 
                        AND header.leave_id = {$header_id}
                        AND header.sid = '{$sid}'";
		
		
        $query = $this->db->query($sql);
        return $query->result();
	}
        
        public function getLeaveHeaderByJay($leave_id) {        
        
            $sql = "SELECT  *  FROM leave_header WHERE leave_id={$leave_id}";
            $query = $this->db->query($sql);
        return $query->result();
    }
	
}

?>
