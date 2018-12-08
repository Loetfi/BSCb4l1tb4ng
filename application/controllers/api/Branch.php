<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('branch_model','branch');
	}
	
	function addProcess(){
		try{
			cekmethod('post');
			
			$dataInsert = array(
				'branch_id'	=> @$this->input->post('branch_id'),
				'ip_address'	=> @$this->input->post('ip_address'),
				'branch_name'	=> @$this->input->post('branch_name'),
				'address'		=> @$this->input->post('address'),
				'phone'			=> @$this->input->post('phone'),
				'sts_deleted'	=> @$this->input->post('sts_deleted'),
				'create_date'	=> @$this->input->post('create_date'),
				'create_user'	=> @$this->input->post('create_user'),
			);
			
			if($this->branch->insertBranch($dataInsert)) {
				$data = array(
					'status' => 1,
					'message' => 'Berhasil',
					'data' => array(
						'branch_id' => $branch_id,
					)
				);
				
				admsapi(200 , 1, 'Berhasil', $data);
				
			} else {
				$data = array(
					'status' => 0,
					'message' => 'Gagal Insert',
					'data' => array()
				);
				admsapi(400 , 0, 'Some Error', []);
			}
			
		} catch (Exception $e) {
			
		}
	}
	
	function editProcess(){
		$mdate = time();
		$branch_id = @$this->input->post('branch_id');
		$dataUpdate = array(
			'ip_address'	=> @$this->input->post('ip_address'),
			'branch_name'	=> @$this->input->post('branch_name'),
			'address'		=> @$this->input->post('address'),
			'phone'			=> @$this->input->post('phone'),
			'sts_deleted'	=> @$this->input->post('sts_deleted'),
			'modify_date'	=> $mdate,
			'modify_user'	=> 1,
		);
		if (@$this->input->post('sts_deleted') == 1){
			$dataUpdate('delete_date') = $mdate;
			$dataUpdate('delete_user') = 1;
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