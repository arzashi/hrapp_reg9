<?php

class Employee_model extends CI_Model {

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

     public function getEmployee($user_code) {//jay
       $sql = "SELECT * FROM employee WHERE is_delete = 0 and code = '{$user_code}'";
       $query= $this->db->query($sql);
       return $query->result();
    }
    
    public function getEmployeeInDiv($user_code) {
       $sql = "SELECT * FROM employee WHERE is_delete = 0 AND div_code = (SELECT div_code FROM employee WHERE code = '{$user_code}') AND CODE != '{$user_code}'";
       $query= $this->db->query($sql);
       return $query->result();
    }
	
	public function getEmployeeByCode($emp_code) {
        $this->db->where("code", $emp_code);
        return $this->db->get("employee")->row();
    }
	
	public function getJobs() {
       $sql = "SELECT DISTINCT job_name FROM employee ORDER BY job_name";
       $query= $this->db->query($sql);
       return $query->result();
    }
	
	public function getPositions() {
       $sql = "SELECT DISTINCT position FROM employee ORDER BY position";
       $query= $this->db->query($sql);
       return $query->result();
    }
	
	
    public function getEmployeeByCondition($emp_code, $name, $department, $position, $job_name , $work_date) {
		
		if($work_date != "")
			$sub_sql =	" AND wt.work_date = '{$work_date}' ";
		else
			$sub_sql = "";
		
       $sql = "SELECT * FROM employee emp " . 
			   "LEFT JOIN work_time_transaction work on emp.code = work.emp_code AND " . 
			   "work.worktime_id = (SELECT MIN(worktime_id) FROM work_time_transaction wt WHERE wt.emp_code = emp.code " . 
			   $sub_sql . " ) " .
			   "  WHERE 1=1 AND is_delete = 0 ";
	   
		if($emp_code != "")
			$sql .=	"AND emp.code like '%{$emp_code}%' ";
		
		if($name != "")
			$sql .=	"AND emp.name like '%{$name}%' ";
		
		if($department != "")
			$sql .=	"AND emp.div_code = '{$department}'";
			   
		if($position != "")
			$sql .=	"AND emp.position like '%{$position}%' ";
		
		if($job_name != "")
			$sql .=	"AND emp.job_name like '%{$job_name}%' ";
		
       $query= $this->db->query($sql);
        return $query->result();
    }
	
	public function deleteEmp($emp_code)
	{
		try { 
			$update_data = array('is_delete' => 1);
			
			$this->db->where('code', $emp_code);
			$this->db->update('employee', $update_data);

			$this->db->affected_rows();

			return  $emp_code;
		} catch (Exception $e) {
			throw new Exception('Delete error: ' . $e->getMessage());
		}
	}

	public function saveEmp($emp_code, $gender, $name, $surname, $position, $level, $job_name, $div_code, $start_work)
	{
		try { 
			$emp = $this->getEmployeeByCode($emp_code);
			if (is_null($emp) || sizeof($emp) == 0)
			{
				// Save
				$insert_data = array('code' => $emp_code,'gender' => $gender, 'name' => $name, 'surname' => $surname ,'position' => $position, 'level' => $level, 'job_name' => $job_name, 'div_code' => $div_code, 'start_work' => $start_work);
				
				$id = $this->db->insert('employee', $insert_data);
				
			}
			else
			{
				// Update
				$update_data = array('gender' => $gender, 'name' => $name, 'surname' => $surname ,'position' => $position, 'level' => $level, 'job_name' => $job_name, 'div_code' => $div_code, 'start_work' => $start_work);
		
				$this->db->where('code', $emp_code);
				$this->db->update('employee', $update_data);
				
				$this->db->affected_rows();
			}
		} catch (Exception $e) {
			throw new Exception('Save or update error: ' . $e->getMessage());
		}
	}
	
	public function getStandbyRow($user_code)
	{
		$standbyRow = 0;
		
		// For leave
		$sql = "select * from leave_header header ";
		$sql .= "JOIN leave_detail detail ON header.leave_id = detail.leave_id ";
		$sql .= " JOIN employee emp on header.username = emp.code WHERE leave_standby = {$user_code} ";
		$sql .=	" AND NOW() between STR_TO_DATE(detail.start_date,'%d/%m/%Y') AND STR_TO_DATE(detail.end_date,'%d/%m/%Y') ";
		$sql .= " order by emp.level ";
		
		$query= $this->db->query($sql);
		$records = $query->result();
		
		foreach ($records as $record)
		{
			if ((strpos($record->position, "หัวหน้างาน") !== false || strpos($record->position, "รก.หนง.") !== false) && $standbyRow < 1)
				$standbyRow = 1;
			else if ((strpos($record->position, "ผู้จัดการ") !== false || strpos($record->position, "ผู้อำนวยการกอง") !== false) && $standbyRow < 2)
				$standbyRow = 2;
			else if ((strpos($record->position, "ผู้อำนวยการการ") !== false || strpos($record->position, "ผอ.กปภ.ข.") !== false) && $standbyRow < 3)
				$standbyRow = 3;
		}
		
		// For work
		$sql = "select * from work_header header ";
		$sql .= " JOIN work_detail detail ON header.id = detail.header_id ";
		$sql .= " JOIN employee emp on header.create_by = emp.code WHERE work_standby = {$user_code} ";
		$sql .=	" AND NOW() between STR_TO_DATE(header.startdate,'%d/%m/%Y') AND STR_TO_DATE(header.enddate,'%d/%m/%Y') ";
		$sql .= " order by emp.level ";
		
		$query= $this->db->query($sql);
		$records = $query->result();
		
		foreach ($records as $record)
		{
			if ((strpos($record->position, "หัวหน้างาน") !== false || strpos($record->position, "รก.หนง.") !== false) && $standbyRow < 1)
				$standbyRow = 1;
			else if ((strpos($record->position, "ผู้จัดการ") !== false || strpos($record->position, "ผู้อำนวยการกอง") !== false) && $standbyRow < 2)
				$standbyRow = 2;
			else if ((strpos($record->position, "ผู้อำนวยการการ") !== false || strpos($record->position, "ผอ.กปภ.ข.") !== false) && $standbyRow < 3)
				$standbyRow = 3;
		}
		
		return $standbyRow;
	}
}

?>
