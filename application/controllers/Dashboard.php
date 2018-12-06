<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('auth_model','auth');
		$this->load->model('Dashboard_model','dash');
		$this->load->model('Struktur_model','struktur');
		$this->load->model('Target_model','target');
	}


	public function index(){
		$data = array(
			'title' => 'Dashboard' ,
			'page'	=> 'dashboard'
		);
		
		// all struktur
		$allStruktur = array();
		$branchId = '1';
		$withoutParent = true;
		$struktur = $this->struktur->getAll($branchId, $withoutParent);
		foreach($struktur as $row){
			if ($row['sts_deleted'] == 0){
				$allStruktur[$row['id']] = $row;
				$categoriesStruktur[] = $row['code'].' '.$row['org_name'];
			}
		}
		
		// all target
		$allTarget = array();
		$tahun = 2019;
		$target = $this->target->getAll($tahun, $branchId);
		foreach($target as $row){
			if ($row['sts_deleted'] == 0){
				@$allTarget[$row['org_id']] += @$row['amount'];
				@$allTargetBulanan[$row['org_id']][$row['month']] = @$row['amount'];
			}
		}
		
		$dataTarget = array();
		foreach($allStruktur as $row){
			$org_id = $row['id'];
			$dataTarget[] = @$allTarget[$org_id];
		}
		
		$data['categoriesStruktur'] = $categoriesStruktur;
		$data['seriesDataTarget'] = array(
			'name' => 'target',
			'data' => $dataTarget,
		);
		
		
		// print_r($categoriesStruktur);
		// print_r($dataTarget);
		// die();
		
		// data getIssueGlobalTahunan
		// $getIssueGlobalTahunan = $this->dash->getIssueGlobalTahunan();
		
		
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
