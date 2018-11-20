<?php
if(!isset($_SESSION)){
    @session_start();
}

class Work_Detail_model extends CI_Model {

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

	 
	public function saveWorkDetail($empcode , $header_id) {
        
		$insert_data = array('employee_id' => $empcode,'header_id' => $header_id);
		
		$id = $this->db->insert('work_detail', $insert_data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
    }
	
	public function getWorkDetail($work_id) {
        $sql = "SELECT  *
				 FROM   
					  work_detail detail
				 JOIN employee emp ON detail.employee_id = emp.code
				 WHERE 
					   header_id={$work_id}";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function deleteWorkDetailByHeader($header_id){
		$this->db->where('header_id', $header_id);
		$this->db->delete('work_detail'); 
	}
}

?>
