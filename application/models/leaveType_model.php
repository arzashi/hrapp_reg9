<?php

class LeaveType_model extends CI_Model {

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

    public function getAllLeaveType() {
        $query = $this->db->get('Leave_Type');

        return $query->result();
    }
    
     
    
    public function getLeaveType($leave_type) {
        $sql = "SELECT * FROM leave_type WHERE id={$leave_type}";
        $query = $this->db->query($sql);
        return $query->result();
    }

}

?>
