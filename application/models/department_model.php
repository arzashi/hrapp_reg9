<?php

class Department_model extends CI_Model {

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

    public function getAllDepartment() {
        $query = $this->db->get('department');

        return $query->result();
    }
	
	
    public function getAllDepartmentWithXPath() {
        $this->db->where('x_path is NOT NULL', NULL, FALSE);
        $query = $this->db->get('department');

        return $query->result();
    }
	
    public function getDepartment($d_id) {
        $this->db->where('d_id', $d_id);

        return $this->db->get("department")->row();
    }
    
    public function getDepartment2($div_code) {//jay
       $sql = "SELECT * FROM department WHERE d_id = '{$div_code}'";
       $query= $this->db->query($sql);
       return $query->result();
    }

}

?>
