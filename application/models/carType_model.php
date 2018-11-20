<?php

class CarType_model extends CI_Model {

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

    public function getAllCarType() {
        $query = $this->db->get('Car_Type');

        return $query->result();
    }

}

?>
