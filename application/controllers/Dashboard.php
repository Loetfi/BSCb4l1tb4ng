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
		$this->load->model('Jlt_model','jlt');

		$this->load->model('dashboard/kontrak_model','kontrak');
		check_login('dashboard');
	}


	public function index(){
		$data = array(
			'title' => 'Dashboard' ,
			'page'	=> 'dashboard',

			// kontrak get 
			'jumlah_kontrak'	=> $this->kontrak->jumlah()
		);
		
		$branchId = 1;
		$tahun = 2019;
		$bulan = 12;
		
		// all struktur
		$allStruktur = array();
		$withoutParent = false;
		$struktur = $this->struktur->getAllHeadOnly($branchId);
		foreach($struktur as $row){
			if ($row['sts_deleted'] == 0){
				$allStruktur[$row['id']] = $row;
				$categoriesStruktur[] = $row['code'].' '.$row['org_name'];
				$categoriesStrukturCode[$row['id']] = 'BLM-'.$row['code'];
			}
		}
		
		#########################################################################################################
		#########################################################################################################
		
		## all Agreement org Tahunan
		$allAgrement = array();
		$agreement = $this->jlt->agreementSubUnitTahunan('2018', $branchId);
		foreach($agreement as $row){
			$allAgrement[$row['org_id']] = $row;
		}
		
		## all invoice org Tahunan
		$allInvoice = array();
		$inv = $this->jlt->invoiceSubUnitTahunan('2018', $branchId);
		foreach($inv as $row){
			$allInvoice[$row['org_id']] = $row;
		}
		
		## all payment org Tahunan
		$allPayment = array();
		$payment = $this->jlt->paymentSubUnitTahunan('2018', $branchId);
		foreach($payment as $row){
			$allPayment[$row['org_id']] = $row;
		}
		
		// all target
		$allTarget = array();
		$targetOrgBulanan = array();
		$target = $this->target->getAll($tahun, $branchId);
		foreach($target as $row){
			if ($row['sts_deleted'] == 0){
				@$allTarget[$row['org_id']] += @$row['amount'];
				@$targetBulanan[$row['month']] += @$row['amount'];
				@$targetOrgBulanan[$row['org_id']][$row['month']] = @$row['amount'];
			}
		}
		$data['targetOrgBulanan'] = $targetOrgBulanan;
		
		$dataTarget = array();
		$dataInvoiceOrg = array();
		foreach($allStruktur as $row){
			$org_id = $row['id'];
			$dataTarget[] = @$allTarget[$org_id];
			$dataTargetOrg[$org_id] = @$allTarget[$org_id];
			
			$dataInvoice[] = @$allInvoice[$org_id]['terhitung'] > 0 ? floatval(@$allInvoice[$org_id]['terhitung']) : null;
			$dataInvoiceOrg[$org_id] = @$allInvoice[$org_id]['terhitung'] > 0 ? floatval(@$allInvoice[$org_id]['terhitung']) : null;
			
			$dataAgreement[] = @$allAgrement[$org_id]['terhitung'] > 0 ? floatval(@$allAgrement[$org_id]['terhitung']) : null;
			$dataAgreementOrg[$org_id] = @$allAgrement[$org_id]['terhitung'] > 0 ? floatval(@$allAgrement[$org_id]['terhitung']) : null;
			
			$dataPayment[] = @$allPayment[$org_id]['terhitung'] > 0 ? floatval(@$allPayment[$org_id]['terhitung']) : null;
			$dataPaymentOrg[$org_id] = @$allPayment[$org_id]['terhitung'] > 0 ? floatval(@$allPayment[$org_id]['terhitung']) : null;
		}
		
		$data['categoriesStruktur'] = @$categoriesStruktur;
		$data['seriesReport'][] = array(
			'name' => 'target',
			'data' => $dataTarget,
		);
		$data['seriesReport'][] = array(
			'name' => 'Invoice',
			'data' => $dataInvoice,
		);
		$data['seriesReport'][] = array(
			'name' => 'Agreement',
			'data' => $dataAgreement,
		);
		$data['seriesReport'][] = array(
			'name' => 'Payment',
			'data' => $dataPayment,
		);
		
		$data['dataInvoiceOrg'] = @$dataInvoiceOrg;
		$data['dataAgreementOrg'] = @$dataAgreementOrg;
		$data['dataPaymentOrg'] = @$dataPaymentOrg;
		#########################################################################################################
		#########################################################################################################
		
		
		## all Agreement bulanan
		$allInvoiceBulanan = array();
		$agreement = $this->jlt->agreementUnitBulanan('2018', $branchId);
		foreach($agreement as $row){
			$allAgrementBulanan[$row['bulan']] = @$row['terhitung'] > 0 ? floatval(@$row['terhitung']) : null;
		}
		
		## all invoice bulanan
		$allInvoiceBulanan = array();
		$inv = $this->jlt->invoiceUnitBulanan('2018', $branchId);
		foreach($inv as $row){
			$allInvoiceBulanan[$row['bulan']] = @$row['terhitung'] > 0 ? floatval(@$row['terhitung']) : null;
		}
		
		## all payment bulanan
		$allInvoiceBulanan = array();
		$payment = $this->jlt->paymentUnitBulanan('2018', $branchId);
		foreach($payment as $row){
			$allPaymentBulanan[$row['bulan']] = @$row['terhitung'] > 0 ? floatval(@$row['terhitung']) : null;
		}
		
		## target
		for($i=1; $i<=12; $i++){
			$categoriesBulanan[] = date('M',strtotime($tahun.'/'.$i.'/01'));
			$invoiceBulanan[] = @$allInvoiceBulanan[$i];
			$agreementBulanan[] = @$allAgrementBulanan[$i];
			$paymentBulanan[] = @$allPaymentBulanan[$i];
		}
		ksort($targetBulanan);
		$allTargetBulanan = array();
		foreach($targetBulanan as $row){
			@$nilaiTargetAll += $row;
			$allTargetBulanan[] = $nilaiTargetAll;
			$allPenerimaanBulanan[] = $row;
		}
		
		$data['categoriesBulanan'] = $categoriesBulanan;
		$data['seriesDataTargetBulanan'][] = array(
			'name' => 'target',
			'data' => $allTargetBulanan,
		);
		$data['seriesDataTargetBulanan'][] = array(
			'name' => 'Payment',
			'data' => $paymentBulanan,
		);
		$data['seriesDataTargetBulanan'][] = array(
			'name' => 'Invoice',
			'data' => $invoiceBulanan,
		);
		$data['seriesDataTargetBulanan'][] = array(
			'name' => 'Agreement',
			'data' => $agreementBulanan,
		);
		
		
		
		
		
		
		## target bulan ini
		$targetBulanIni = array();
		$thisBulanIni = $this->target->getAll($tahun,$branchId,$bulan);
		foreach($thisBulanIni as $row){
			$targetBulanIni[$row['org_id']] = $row['amount'];
		}
		
		foreach($allStruktur as $row){
			$org_id = $row['org_id'];
			$blmOrg[] = 'BLM-'.$row['code'];
			$targetOrg[] = @$dataTargetOrg[$org_id];
			$targetBulanOrg[] = @$targetBulanIni[$org_id];
			$invoiceBulananOrg[] = @$allInvoice[$org_id]['terhitung'] > 0 ? floatval(@$allInvoice[$org_id]['terhitung']) : null;
			$agreementBulananOrg[] = @$allAgrement[$org_id]['terhitung'] > 0 ? floatval(@$allAgrement[$org_id]['terhitung']) : null;
		}
		$data['allStruktur'] = @$allStruktur;
		$data['dataTargetOrg'] = @$dataTargetOrg;
		$data['targetBulanIni'] = @$targetBulanIni;
		
		
		#########################################################################################################
		#########################################################################################################
		
		## agreement org bulanan
		$allAgrementOrgBulanan = array();
		$agreement = $this->jlt->agreementSubUnitBulanan('2018', $branchId);
		foreach($agreement as $row){
			$org_id = $row['org_id'];
			$allAgrementOrgBulanan[$org_id][$row['bulan']] = $row['terhitung'];
		}
		$data['allAgrementOrgBulanan'] = $allAgrementOrgBulanan;
		
		## invoice org bulanan
		$allInvoiceOrgBulanan = array();
		$inv = $this->jlt->invoiceSubUnitBulanan('2018', $branchId);
		foreach($inv as $row){
			$org_id = $row['org_id'];
			$allInvoiceOrgBulanan[$org_id][$row['bulan']] = $row['terhitung'];
		}
		$data['allInvoiceOrgBulanan'] = $allInvoiceOrgBulanan;
		
		## payment org bulanan
		$allInvoiceOrgBulanan = array();
		$payment = $this->jlt->paymentSubUnitBulanan('2018', $branchId);
		foreach($payment as $row){
			$org_id = $row['org_id'];
			$allPaymentOrgBulanan[$org_id][$row['bulan']] = $row['terhitung'];
		}
		$data['allPaymentOrgBulanan'] = $allPaymentOrgBulanan;
		
		## invoice 
		// print_r($categoriesStruktur);
		// print_r($categoriesBulanan);
		// print_r($allTargetBulanan);
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
