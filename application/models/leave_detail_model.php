<?php

class Leave_Detail_model extends CI_Model {

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

    public function saveLeaveDetail($header_id,$startdate,$enddate,$time,$sum) {
        
		$data = array('leave_id' => $header_id, 'start_date' => $startdate, 'end_date' => $enddate, 'leave_time' => $time, 'sum_leave' => $sum);
		$id = $this->db->insert('leave_detail', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
    }
	
	public function deleteLeaveDetailByHeader($leave_id){
		$this->db->where('leave_id', $leave_id);
		$this->db->delete('leave_detail'); 
	}
	
	public function getLeaveDetail($leave_id) {
        $sql = "SELECT  *
				  FROM   
					  leave_detail
				 WHERE 
					   leave_id={$leave_id}";
        $query = $this->db->query($sql);
        return $query->result();
    }

}

?>
