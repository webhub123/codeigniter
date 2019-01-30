<?php

//for log in view
    echo form_open('/login',['method' => 'post']); 
        //entry
    echo form_close();       
//for log in view

// sql trans begin & rollback

    $pmpi_sds->trans_begin(); 
    
        $pmpi_sds->where('time',$time)
                ->update('sq_hdr',array('code' => $new_sq));

    if($pmpi_sds->trans_status() === FALSE){
        $db_error = "";
        $db_error = $pmpi_sds->error();
        $pmpi_sds->trans_rollback();
        return $db_error;
    }else{  

        $pmpi_sds->trans_commit();
        return true;
    }

// sql trans begin & rollback

//str replace for searching
    $search = str_replace("'", "\'",$this->input->post('search'));
//str replace for searching

//controller autocomplete

    $result = $this->sales_quotation_model->ac_rfe_apprv_sq();

    $list = array();

    foreach ($result->result() as $row) {

        $list[] = array(
            'item_name' => $row->cat
        );
    }

    $this->output->set_content_type('application/json');
    echo json_encode($list);
    		

//controller autocomplete

//imploding arrays to query

    $time = implode("','",$id_list);

    $this->db3->query("DELETE FROM table_name 
              WHERE column_name IN ('".$time."') ");

//imploding arrays to query


//uploading files

    $upload_path = './public/uploads/req_esti_img/'; 
    $counts = count($_FILES["files"]["name"]);
	$files_upload = array();

    for($x = 0; $x < $counts; $x++) { 

        $files_tmp = $_FILES['files']['tmp_name'][$x];
        $files_ext = strtolower(pathinfo($_FILES['files']['name'][$x],PATHINFO_EXTENSION));

        $randname = "file_".rand(1000,1000000) . "." . $files_ext;

        move_uploaded_file($files_tmp,$upload_path.$randname);
        $files_upload[] = $randname;

    }
    $serialized = serialize($files_upload);	

//uplaoding files