<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model{
    
    public function __construct(){       
        parent::__construct();        
        $CI = &get_instance();

        // $this->db2 = $CI->load->database('pmpi', TRUE);
    }


    public function save_register($username,$password) {

        $data = array(
            'username' => $username,
            'password' => password_hash($password,PASSWORD_DEFAULT,array("cost" => 10)),
            'created_date' => date('Y-m-d h:i:s'),
        );


        try{

            $this->db->insert('users',$data);

            return true;
        }catch(Exception $e) {
            return 'error '.$e;
        }

    }

    public function check_session() {

        $id = $this->session->userdata('user_id');
        $firstname = $this->session->userdata('firstname');
        $lastname = $this->session->userdata('lastname');

        $query = $this->db->get_where('users',array('id' => $id));

        return $query;

    } 


    public function validate_pass() {

        $id = $this->session->userdata('user_id');

        $query = $this->db->from('user_accounts_tbl')
                 ->where('users',$id)
                 ->get();
        
        $p_curr_pass = $this->input->post('current');

        foreach ($query->result() as $row) {
            if(password_verify($p_curr_pass,$row->user_password)) {
                return "valid";
            }else {
                return "invalid";
            }
        }

    }

    public function update_pass() {

        $id = $this->session->userdata('user_id');
        $new_pass = $this->input->post('new_pass');

        $data = array(

            'password' => password_hash($new_pass,PASSWORD_DEFAULT,array("cost" => 10)),

            );

        $this->db6->where('id',$id)
                 ->update('users',$data);

        return "success";
        


    }

    public function login() { 

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $query = "SELECT * FROM users WHERE username = ?";
        $query = $this->db->query($query, array($username));
        $res = $query->result();  
        $row = $query->num_rows();
        if($row > 0) {
            foreach ($query->result() as $res) {

                if (password_verify($password,$res->user_password)) {   
                    $data = array(
                            'id' => $res->user_ID,     
                            );
                    
                    $this->session->set_userdata($data);
                    return true;

                } else {
                    return false;
                }
            }
        }
        else{
            return false;
        }
            
    }


}


?>