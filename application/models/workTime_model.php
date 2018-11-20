<?php

class WorkTime_model extends CI_Model {

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

    public function getAllWorkTime() {
        $query = $this->db->get('Work_Time');

        return $query->result();
    }

}

?>
