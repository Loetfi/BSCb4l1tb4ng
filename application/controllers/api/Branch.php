<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('branch_model','branch');
	}
	
	function addProcess(){
		$cdate = time();
		$dataInsert = array(
			'ip_address'	=> @$_POST['ip_address'],
			'branch_name'	=> @$_POST['branch_name'],
			'address'		=> @$_POST['address'],
			'phone'			=> @$_POST['phone'],
			'sts_deleted'	=> @$_POST['sts_deleted'],
			'create_date'	=> $cdate,
			'create_user'	=> 1,
		);
		
		if($this->branch->insertBranch($dataInsert)) {
			$branch_id = $this->db->insert_id();
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'branch_id' => $branch_id,
				)
			);
		} else {
			$data = array(
				'status' => 0,
				'message' => 'Gagal Insert',
				'data' => array()
			);
		}
		echo json_encode($data);
	}
	
	function editProcess(){
		$mdate = time();
		$branch_id = @$_POST['branch_id'];
		$dataUpdate = array(
			'ip_address'	=> @$_POST['ip_address'],
			'branch_name'	=> @$_POST['branch_name'],
			'address'		=> @$_POST['address'],
			'phone'			=> @$_POST['phone'],
			'sts_deleted'	=> @$_POST['sts_deleted'],
			'modify_date'	=> $mdate,
			'modify_user'	=> 1,
		);
		if (@$_POST['sts_deleted'] == 1){
			$dataUpdate['delete_date'] = $mdate;
			$dataUpdate['delete_user'] = 1;
		}
		
		if($this->branch->updateBranch($dataUpdate, array('branch_id'=> $branch_id))) {
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'branch_id' => $branch_id,
				)
			);
		} else {
			$data = array(
				'status' => 0,
				'message' => 'Gagal Update',
				'data' => array()
			);
		}
		echo json_encode($data);
	}
	
	
}