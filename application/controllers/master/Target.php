<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('target_model','target');
		$this->load->model('branch_model','branch');
		$this->load->model('struktur_model','struktur');
		$this->thisUrl = $this->uri->segment(1).'/'.$this->uri->segment(2);
	}
	
	public function index(){
		$data = array(
			'title' 	=> 'Master Target' ,
			'page'		=> 'master/target/target',
			'thisUrl'	=> $this->thisUrl
		);
		$data['getAll'] = $this->target->getAll();
		// print_r($data['getAll']); die();
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function add(){
		$data = array(
			'title' 	=> 'Tambah Master Target' ,
			'page'		=> 'master/target/add',
			'thisUrl'	=> $this->thisUrl,
			'org'		=> $this->struktur->getAllHeadOnly(),
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function addProcess(){
		$return = true;
		$cdate = time();
		
		for($i=1; $i<=12; $i++){
			
			$where = array(
				'org_id'		=> @$_POST['org_id'],
				'year'			=> @$_POST['year'],
				'month'			=> @$i,
			);
			$detail = $this->target->detailSearch($where);
			if ($detail){
				$dataUpdate = array(
					'org_id'		=> @$detail['org_id'],
					'year'			=> @$_POST['year'],
					'month'			=> @$i,
					'amount'		=> @$_POST['amount_'.$i],
					'sts_deleted'	=> @$_POST['sts_deleted'],
					'modify_date'	=> $cdate,
					'modify_user'	=> 1,
				);
				$cekInsert = $this->target->updateTarget($dataUpdate, $where);
				
			} else {
				$dataInsert = array(
					'org_id'		=> @$_POST['org_id'],
					'year'			=> @$_POST['year'],
					'month'			=> @$i,
					'amount'		=> @$_POST['amount_'.$i],
					'sts_deleted'	=> @$_POST['sts_deleted'],
					'create_date'	=> $cdate,
					'create_user'	=> 1,
				);
				$cekInsert = $this->target->insertTarget($dataInsert);
				
			}
			
			
			if (!$cekInsert) $return = false;
		}
		
		if($return) {
			// $target_id = $this->db->insert_id();
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array()
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
	
	function detail($id){
		$data = array(
			'title' 	=> 'Detail Master target',
			'page'		=> 'master/target/detail',
			'thisUrl'	=> $this->thisUrl,
			'detail'	=> $this->target->detail($id),
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function edit($id){
		$data = array(
			'title' 	=> 'Edit Master Target',
			'page'		=> 'master/target/edit',
			'thisUrl'	=> $this->thisUrl,
			'detail'	=> $this->target->detail($id),
			'org'		=> $this->struktur->getAllHeadOnly(),
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function editProcess(){
		$mdate = time();
		$target_id = @$_POST['target_id'];
		$dataUpdate = array(
			'org_id'		=> @$_POST['org_id'],
			'year'			=> @$_POST['year'],
			'month'			=> @$_POST['month'],
			'amount'		=> @$_POST['amount'],
			'sts_deleted'	=> @$_POST['sts_deleted'],
			'modify_date'	=> $mdate,
			'modify_user'	=> 1,
		);
		if (@$_POST['sts_deleted'] == 1){
			$dataUpdate['delete_date'] = $mdate;
			$dataUpdate['delete_user'] = 1;
		}
		
		if($this->target->updateTarget($dataUpdate, array('target_id'=> $target_id))) {
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'target_id' => $target_id,
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