<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('struktur_model','struktur');
		$this->load->model('branch_model','branch');
		$this->thisUrl = $this->uri->segment(1).'/'.$this->uri->segment(2);
	}
	
	public function index(){
		$data = array(
			'title' 	=> 'Master Struktur Organisasi' ,
			'page'		=> 'master/struktur/struktur',
			'thisUrl'	=> $this->thisUrl
		);
		$data['getAll'] = $this->struktur->getAll();
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function add(){
		$data = array(
			'title' => 'Tambah Master Struktur Organisasi' ,
			'page'	=> 'master/struktur/add',
			'thisUrl'	=> $this->thisUrl,
		);
		$data['branchAll'] = $this->branch->getAll();
		$data['parent_id'] = $this->struktur->list_unit_all();
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function addProcess(){
		$cdate = time();
		$dataInsert = array(
			'parent_id'		=> @$_POST['parent_id'],
			'branch_id'		=> @$_POST['branch_id'],
			'type'			=> @$_POST['type'],
			'code'			=> @$_POST['code'],
			'org_name'		=> @$_POST['org_name'],
			'description'	=> @$_POST['description'],
			'sts_deleted'	=> @$_POST['sts_deleted'],
			'create_date'	=> $cdate,
			'create_user'	=> 1,
		);
		
		if($this->struktur->insertStruktur($dataInsert)) {
			$struktur_id = $this->db->insert_id();
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'struktur_id' => $struktur_id,
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
	
	function detail($id){
		$data = array(
			'title' 	=> 'Detail Master struktur',
			'page'		=> 'master/struktur/detail',
			'thisUrl'	=> $this->thisUrl,
			'detail'	=> $this->struktur->detail($id),
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function edit($id){
		$data = array(
			'title' 	=> 'Edit Master struktur',
			'page'		=> 'master/struktur/edit',
			'thisUrl'	=> $this->thisUrl,
			'detail'	=> $this->struktur->detail($id),
		);
		$data['branchAll'] = $this->branch->getAll();
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function editProcess(){
		$mdate = time();
		$org_id = @$_POST['org_id'];
		$dataUpdate = array(
			'parent_id'		=> @$_POST['parent_id'],
			'branch_id'		=> @$_POST['branch_id'],
			'type'			=> @$_POST['type'],
			'code'			=> @$_POST['code'],
			'org_name'		=> @$_POST['org_name'],
			'description'	=> @$_POST['description'],
			'sts_deleted'	=> @$_POST['sts_deleted'],
			'modify_date'	=> $mdate,
			'modify_user'	=> 1,
		);
		if (@$_POST['sts_deleted'] == 1){
			$dataUpdate['delete_date'] = $mdate;
			$dataUpdate['delete_user'] = 1;
		}
		
		if($this->struktur->updateStruktur($dataUpdate, array('org_id'=> $org_id))) {
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'org_id' => $org_id,
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