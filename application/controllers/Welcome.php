<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function  __construct() {                
		parent::__construct();    
        $CI = &get_instance();

        $this->load->model('user_model'); 
        date_default_timezone_set("Asia/Manila");
	}

	public function session_checker() {

		if($this->session->userdata('user_id')) {
			$result = $this->user_model->check_session();
			if($result->num_rows() > 0) {
 				return true;
			}else {
				return false;
			}
		}else {
			return false;	
		}	 
	}
	
	public function index() {

		$this->template('Home | ','','index');
		
	}


	public function save_register() {

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$res = $this->user_model->save_register($username,$password);

		$this->output->set_content_type('application/json');
		echo json_encode(array('status' => $res ));
	}


	public function template($title,$fullname,$view) {


		if($this->session_checker() == true) {

			redirect('/admin');

		}else { 

			$data['title'] = $title;
			$data['fullname'] = $fullname;


			$this->load->view('includes/header/header',$data);
			$this->load->view('includes/nav/nav',$data);
			$this->load->view($view);
			$this->load->view('includes/footer/footer');

		}
	}

	public function register() {

		$this->template('Register |',$this->session->userdata('fullname'),'register');

	}

	public function login() {

		$this->template('Login |',$this->session->userdata('fullname'),'login');

	}


	public function change_pass() {
	
		$query = $this->user_model->validate_pass();

		if($query == "valid") {

			$res = $this->user_model->update_pass();
			$status = "success";
		}else if($query == "invalid") {

			$status = "invalid";
		}

		$this->output->set_content_type('application/json');
		echo json_encode(array('status' =>$status));
	}


	public function log_checker() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()){

        	$result = $this->user_model->login();
        	if($result != true) {

        		$this->session->set_flashdata('error','Invalid username or password.');
				return redirect('/');	
        	}else {
				return redirect('/dashboard');	
        	}
        }else {
        	$this->session->set_flashdata('error','All fields are required.');
        	return redirect('/');
        }
	}

	public function log_out() {

		$unset_sessions = array("firstname","lastname","user_id","fullname","username","user_type");
		$this->session->unset_userdata($unset_sessions);

		return redirect('/');
	}




}
