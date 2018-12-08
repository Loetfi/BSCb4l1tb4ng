<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('branch_model','branch');
	}
	
	public function index(){
		$data = array(
			'title' 	=> 'Master Unit Kerja' ,
			'page'		=> 'master/branch/branch',
			'thisUrl'	=> $this->thisUrl
		);
		$data['getAll'] = $this->branch->getAll();
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function add(){
		$data = array(
			'title' => 'Tambah Master Unit Kerja' ,
			'page'	=> 'master/branch/add',
			'thisUrl'	=> $this->thisUrl
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
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
		
		$allBranch = $this->branch->getAll();
		
		if($this->branch->insertBranch($dataInsert)) {
			$branch_id = $this->db->insert_id();
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'branch_id' => $branch_id,
				)
			);
			
			## hit ke api masing2 branch
			foreach($allBranch as $row){
				$url = $row['ip_address'].'/index.php/api/branch/addProcess';
				$dataInsert['branch_id'] = $branch_id;
				$data = $dataInsert;
				## hit
				RestCurl::HitAPI($url , $data , 'POST');
			}
			
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
			'title' 	=> 'Detail Master Unit Kerja',
			'page'		=> 'master/branch/detail',
			'thisUrl'	=> $this->thisUrl,
			'detail'	=> $this->branch->detail($id),
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function edit($id){
		$data = array(
			'title' 	=> 'Edit Master Unit Kerja',
			'page'		=> 'master/branch/edit',
			'thisUrl'	=> $this->thisUrl,
			'detail'	=> $this->branch->detail($id),
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
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