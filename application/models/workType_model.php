<?php

class WorkType_model extends CI_Model {

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

    public function getAllWorkType() {
        $query = $this->db->get('Work_Type');

        return $query->result();
    }

}

?>
