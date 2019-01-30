<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class query_controller extends CI_Controller {


	public function  __construct() {
		parent::__construct();
        $CI = &get_instance();

        $this->load->model('query_model');
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

	public function template($title,$fullname,$logo,$view,$add_css) {

		if($this->session_checker() == true) {

			$data['title'] = $title;
			$data['fullname'] = $fullname;
			$data['logo_url'] = base_url('/public/src/images/'.$logo);
			$data['date'] = date('m/d/Y');

			$this->load->view('includes/header/header',$data);
			if($add_css == true) {
				$this->load->view('includes/header/additional_css',$data);
			}
			$this->load->view('includes/nav/nav',$data);

			$this->load->view($view);

			$this->load->view('includes/footer/footer');

		}else {
			redirect('/');
		}

	}

	public function query($list) {

		$fullname = $this->session->userdata('fullname');

		if($list == "phc") {

			$this->template('Philsteel Holding Corporation |',$fullname,'phc_logo.jpg','phc',true);

		}else if($list == "pmpi") {

			$this->template('Philmetal Products Inc. |',$fullname,'pmpi_logo.png','pmpi',true);

		}else if($list == "scp") {

			$this->template('Steel Corporation of the Philippines |',$fullname,'scp_logo.png','scp',true);

		}else if($list == "pspi") {

			$this->template('Premier Shelter Products Inc. |',$fullname,'pspi_logo.png','pspi',true);

		}else if($list == "managers") {

			$this->template('Managers |',$fullname,'manager_logo.jpg','managers',true);

		}else {
			redirect('/');
		}


	}


	public function query_list() {

    	$search_from = $this->input->post('search_from');
		$search_to = $this->input->post('search_to');
		$comp = $this->input->post('comp');

		$result = $this->query_model->query_list($search_from,$search_to,$comp);

		$output = $this->set_table_list($result['sql']);

		$this->output->set_content_type('application/json');
		echo json_encode(array('output' => $output,
							   'num_rows' => $result['non_limit']->num_rows()));

	}

  public function export_rpt($type,$date_from,$date_to) {


		$filename = $type."-".date("Y-m-d h:i:s").'.xls';

		$result = $this->query_model->query_list($date_from,$date_to,$type);

		$output = $this->set_table_list($result['sql']);


		if($output == false) {
			redirect('/');
		}

		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename =".$filename);
		echo $output;
	}



	public function set_table_list($result) {

		$output = '';
		$i = 0;
		$num_rows = 0;
		$num_rows = $result->num_rows();

		if($num_rows > 0) {

			$output .= '<table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="font-size:13px;">
                            <th class="column-title">Employee# </th>
                            <th class="column-title">Full Name </th>
                            <th class="column-title">Department </th>
                            <th class="column-title">Position</th>
                            <th class="column-title">Date</th>
                            <th class="column-title">Time In </th>
                            <th class="column-title">Counts </th>
                          </tr>
                        </thead><tbody>';

            foreach ($result->result() as $row) {

            	$class = ($i%2 == 0) ? 'even' : 'odd';

            	$output .= '
						<tr class="'.$class.' pointer" style="font-size:13px;">
                            <td>'.$row->emp_no.'</td>
                            <td>'.$row->FirstName.' '. $row->MiddleName.' '. $row->LastName. '</td>
                            <td>'.$row->department_name.'</td>
                            <td>'.$row->position_name.'</td>
                            <td>'.date('m/d/Y',strtotime($row->Date)).'</td>
                            <td>'.$row->time_in.'</td>
                            <td style="text-align:center">'.$row->late_counts.'</td>
                        </tr>
            	';

            	$i++;
            }

            $output .= '</tbody></table>';

		}else {
			$output .= '<center>No data.</center>';
		}


		return $output;

	}

	public function get_total_number() {


		$result = $this->query_model->get_total_number();


		$this->output->set_content_type('application/json');
		echo json_encode(array('phc' => $result['phc'],
							   'pmpi' => $result['pmpi'],
							   'scp' => $result['scp'],
							   'pspi' => $result['pspi'],
							   'mngr' => $result['mngr'],));

	}

}
