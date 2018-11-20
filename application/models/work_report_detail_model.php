<?php
if(!isset($_SESSION)){
    @session_start();
}

class Work_Report_Detail_model extends CI_Model {

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

	 
	public function saveWorkReportDetail($empcode , $header_id) {
        
		$insert_data = array('employee_id' => $empcode,'header_id' => $header_id);
		
		$id = $this->db->insert('work_report_detail', $insert_data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
    }
	
	public function getWorkReportDetail($work_id) {
        $sql = "SELECT  *
				 FROM   
					  work_report_detail detail
				 JOIN employee emp ON detail.employee_id = emp.code
				 WHERE 
					   header_id={$work_id}";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function deleteWorkReportDetailByHeader($header_id){
		$this->db->where('header_id', $header_id);
		$this->db->delete('work_report_detail'); 
	}
}

?>
