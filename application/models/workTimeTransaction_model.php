<?php

class workTimeTransaction_model extends CI_Model {

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

	public function getWorkTimeByCondition($work_date,$emp_code) {
        $this->db->where("emp_code", $emp_code);
        $this->db->where("work_date", $work_date);
        return $this->db->get("work_time_transaction")->row();
    }
	
	public function saveWorktime($emp_code, $work_time, $work_date, $username, $is_holiday)
	{
		try { 
			$emp = $this->getWorkTimeByCondition($work_date,$emp_code);
			if ($emp == null)
			{
				// Save
				$insert_data = array('emp_code' => $emp_code,'work_time' => $work_time, 'work_date' => $work_date, 'is_holiday' => $is_holiday, 'create_by' =>$username, 'create_date' => date("Y-m-d H:i:s"));
				
				$id = $this->db->insert('work_time_transaction', $insert_data);
				
			}
			else
			{
				// Update
				$update_data = array('work_time' => $work_time, 'is_holiday' => $is_holiday, 'create_by' => $username, 'create_date' => date("Y-m-d H:i:s"));
		
				$this->db->where('emp_code', $emp_code);
				$this->db->where('work_date', $work_date);
				$this->db->update('work_time_transaction', $update_data);
				
				$this->db->affected_rows();
			}
		} catch (Exception $e) {
			throw new Exception('Save or update error: ' . $e->getMessage());
		}
	}
	
	
	public function findTimeTableForExport($start_date , $end_date , $department)
	{
		$sql = "SELECT wtt.* ".
				"FROM work_time_transaction wtt  ".
				"JOIN employee emp ON emp.code = wtt.emp_code ".
				"WHERE 1=1 AND LENGTH(wtt.work_time) > 0 AND emp.div_code = '{$department}' ";
		
		if($start_date != "" && $end_date == "")
			$sql .=	"AND STR_TO_DATE(wtt.work_date,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y') ";
		else if($start_date == "" && $end_date != "")
			$sql .=	"AND STR_TO_DATE(wtt.work_date,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		else if($start_date != "" && $end_date != "")
			$sql .=	"AND STR_TO_DATE(wtt.work_date,'%d/%m/%Y') between STR_TO_DATE('{$start_date}','%d/%m/%Y') AND STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		/*
		if($department == "55310")
			$sql .=	"AND LENGTH(emp.div_code) < 7 ";
		else
			$sql .=	"AND emp.div_code = '{$department}' ";
		*/
        $query = $this->db->query($sql);
        return $query->result();
	}

	public function findHolidayTimeTableForExport($start_date , $end_date , $department)
	{
		$sql = "SELECT wtt.* ".
				"FROM work_time_transaction wtt  ".
				"JOIN employee emp ON emp.code = wtt.emp_code ".
				"WHERE 1=1 AND LENGTH(wtt.work_time) > 0 AND is_holiday = 1 ";
		
		if($start_date != "" && $end_date == "")
			$sql .=	"AND STR_TO_DATE(wtt.work_date,'%d/%m/%Y') >= STR_TO_DATE('{$start_date}','%d/%m/%Y') ";
		else if($start_date == "" && $end_date != "")
			$sql .=	"AND STR_TO_DATE(wtt.work_date,'%d/%m/%Y') <= STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		else if($start_date != "" && $end_date != "")
			$sql .=	"AND STR_TO_DATE(wtt.work_date,'%d/%m/%Y') between STR_TO_DATE('{$start_date}','%d/%m/%Y') AND STR_TO_DATE('{$end_date}','%d/%m/%Y') ";
		
		if($department == "55310")
			$sql .=	"AND LENGTH(emp.div_code) < 7 ";
		else
			$sql .=	"AND emp.div_code = '{$department}' ";
		
        $query = $this->db->query($sql);
        return $query->result();
	}
	
}

?>
