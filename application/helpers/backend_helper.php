<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function branch_admin($branch_id= null , $branch_name = null)
{
	return $branch_id > 0 ? $branch_name : 'Administrator';
}

function role_access($id_flow = null , $sub_sector = null)
{
	$ci =& get_instance();
	
	if ($ci->session->userdata('id_flow') == 3) { // user biasa
		$no_edit = FALSE;
	} elseif ($ci->session->userdata('id_flow') == 2 AND $ci->session->userdata('sub_sector') == $sub_sector ) {
		$no_edit = TRUE;
	} elseif ($ci->session->userdata('id_flow') == 1) {
		$no_edit = TRUE;
	} else {
		$no_edit = FALSE;
	}

	return $no_edit;
	// print_r($ci->session->all_userdata());
}

function check_login($referrer_url)
{
	$ci =& get_instance();
	if (isset($_GET['nologin'])) {
		return true;
		exit;
	} else {
    	$ci->session->set_userdata('referrer_url', $referrer_url);  //Set session for the referrer url
    	if ($ci->session->userdata('login_id')) {
    		return true; exit;
    	} else {
    		redirect('auth','refresh');
    	}
    }
    return false;

}


function admsaction($link='' , $id = '' , $color = '' , $fa = '' , $nama = '')
{
	return $return = '<a href="'.$link.'/'.$id.'" class="btn btn-xs btn-'.$color.' ttipDatatables" data-provide="tooltip" data-placement="top" title="'.$nama.'" data-original-title="'.$nama.'" ><i class="'.$fa.'"></i></a>';
}

function admsapi($statusHeader,$status , $message, $data )
{
	$ci =& get_instance(); 
	$ci->output->set_header('Access-Control-Allow-Origin: *');
	$ci->output->set_header('Access-Control-Allow-Methods: POST, GET'); 
	$ci->output->set_header('Access-Control-Allow-Headers: Origin');
	$ci->output->set_content_type('application/json');
	$ci->output->set_status_header($statusHeader);
	$ci->output->set_output(json_encode(array ('status' => $status , 'message' =>  $message , 'data' => $data)));
	$ci->output->_display();
	exit();
} 


function btnPrivileges($value= 0 )
{
	$ret = $value == 1 ? '<a class="btn btn-info btn-xs"><i class="fa fa-check"></i></a>' : '<a class="btn btn-warning btn-xs"><i class="fa fa-remove"></i></a>';
	return $ret;
}

function btnStatus($value= 0 )
{
	$ret = $value == 1 ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '<span class="label label-danger"><i class="fa fa-remove"></i></span>';
	return $ret;
} 

/* End of file Adms_helper.php */
/* Location: ./application/helpers/Adms_helper.php */
