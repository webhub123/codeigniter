<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class query_model extends CI_Model{


    public function __construct(){
        parent::__construct();
        $CI = &get_instance();

        $this->db2 = $CI->load->database('pmpi', TRUE);
    }


    
}


?>
