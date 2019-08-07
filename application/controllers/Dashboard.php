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

		// if (!$_POST) {
			// check_login('dashboard');	
		// }
		
		$this->pembagi = 1000000000;
		$this->pengaliDolar = 14250;
		// $this->pembagi = 1;
		$this->satuan = ' M';
		$this->thisYear = date('Y');
		$this->lastYear = date('Y')-1;
		$this->thisSession = $this->session->all_userdata();
	}



	

	public function index_awal(){
		$this->load->library('form_validation');
		$this->load->model('auth_model','auth');
		$this->load->model('Dashboard_model','dash');
		$this->load->model('Struktur_model','struktur');
		$this->load->model('Target_model','target');
		$this->load->model('Jlt_model','jlt');

		$this->load->model('dashboard/kontrak_model','kontrak');
		check_login('dashboard');
		
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
	function index($selectedYear = ""){ if (!$_POST) { check_login('dashboard'); }
		if ($this->thisSession['branch_name'] == 'Administrator'){
			if ($selectedYear == "" || $selectedYear == date('Y')){
				$selectedYear = date('Y');
				$this->thisYear = date('Y');
				$this->lastYear = date('Y') - 1;
				$titleDate = date('d F Y');
			} else {
				$this->thisYear = $selectedYear;
				$this->lastYear = $selectedYear - 1;
				$titleDate = $selectedYear;
			}
			$data['selectedYear'] = $selectedYear;
			
			$data = array(
				'title' => 'Dashboard Kinerja BLU' ,
				'page'	=> 'dashboard_bsc',
			);
			
			$data['getRekap_form_a'] = $this->getRekap_form_a('All', $selectedYear);
			$data['getGrafik']['p3gl'] = $this->getGrafik_form_a('p3gl', $selectedYear);
			$data['getGrafik']['p3tek'] = $this->getGrafik_form_a('p3tek', $selectedYear);
			$data['getGrafik']['tekmira'] = $this->getGrafik_form_a('tekmira', $selectedYear);
			$data['getGrafik']['lemigas'] = $this->getGrafik_form_a('lemigas', $selectedYear);
			
			$unit = array(); $target = array(); $realisasi = array(); $sr = array();
			foreach($data['getRekap_form_a']['dataSatker'] as $row){
				$unit[] = $row['Unit Kerja'];
				$target[] = floatval(str_replace(' M','',$row['Target']));
				$realisasi[] = floatval(str_replace(' M','',$row['Realisasi']));
				$sr[] = floatval(number_format(floatval(str_replace(' M','',$row['Realisasi'])) / floatval(str_replace(' M','',$row['Target'])) * 100,2));
			}
			
			$data['unit'] = $unit;
			$data['target'] = $target;
			$data['realisasi'] = $realisasi;
			$data['sr'] = $sr;
			
			$this->load->view('template/header', $data, FALSE);
			$this->load->view('template/content', $data, FALSE);
			$this->load->view('template/footer', $data, FALSE);
		}
		else {
			$satKer = strtolower($this->thisSession['branch_name']);
			redirect('dashboard/form_b/'.$satKer.'/'.$selectedYear);
		}
	}
	
	public function lemigas(){
		$this->load->library('form_validation');
		$this->load->model('auth_model','auth');
		$this->load->model('Dashboard_model','dash');
		$this->load->model('Struktur_model','struktur');
		$this->load->model('Target_model','target');
		$this->load->model('Jlt_model','jlt');

		$this->load->model('dashboard/kontrak_model','kontrak');
		check_login('dashboard');
		$data = array(
			'title' => 'Dashboard Lemigas' ,
			'page'	=> 'dashboard_lemigas',

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
		


        ##########################################
		$arrNamaBulan = array();
		$arrNamaSeries = array();
		$highLevel = $this->dash->highLevel();
		foreach($highLevel as $row){

			$namaBulan = date('M',strtotime($row['bulan'].'/15/2019'));
			if(!in_array($namaBulan, $arrNamaBulan))
				$arrNamaBulan[] = $namaBulan;



			if (strtolower($row['jenis']) == 'realisasi'){
				if(!in_array($row['tahun'], $arrNamaSeries))
					$arrNamaSeries[] = $row['tahun'];

				$dataSeries[$row['tahun']][] = floatval(number_format($row['nilai'],2));
			}
			else if (strtolower($row['jenis']) == 'target'){
				if(!in_array(ucfirst($row['jenis']), $arrNamaSeries))
					$arrNamaSeries[] = 'Target';
				$dataSeries['Target'][] = floatval(number_format($row['nilai'],2));
			}
		}

		foreach($arrNamaSeries as $row){
			$namaSeries = $row;
			$data['seriesGlobalBulanan'][] = array(
				'name' => $namaSeries,
				'data' => $dataSeries[$namaSeries],
			);
		}
		$data['CategoriesGlobalBulanan'] = $arrNamaBulan;


		$data['CategoriesGlobalKp3'] = ['BLM-1','BLM-3', 'BLM-4', 'BLM-5', 'BLM-6', 'BLM-7', 'BLM-8', 'BLM-9', 'BLM-10'];
		$data['SeriesGlobalKp3'] = array(
			array(
				'name' => 'Target',
				'data' => [8 ,3.16 ,1.3 ,30 ,60.83 ,22.16 ,34.35 ,27.33 ,0.2]
			),
			array(
				'name' => 'Kontrak',
				'data' => [0 ,0.1276 ,0 ,5.764274575 ,4.021498029 ,1.136854154 ,4.304551298 ,7.58624295 ,0]
			),
			array(
				'name' => 'LHU',
				'data' => [0 ,0.0631 ,0 ,0.469845725 ,3.655962543 ,1.612311249 ,1.399855866 ,0.7438965 ,0]
			),
			array(
				'name' => 'INV',
				'data' => [0.511268646,0.096 ,0 ,0.780030479 ,4.273126543 ,1.957855749 ,4.303947181 ,0.8715678 ,0]
			),
			array(
				'name' => 'Terbayar',
				'data' => [0.511268646,0.0329 ,0 ,0.492263569 ,3.124429908 ,2.759134743 ,3.249917315 ,0.6219923 ,0 ]
			),
		);

        // print_r($data['CategoriesGlobalKp3']);
        // print_r($data['SeriesGlobalKp3']);
        // print_r($dataSeries);
        // die();

		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	public function form_a($selectedYear = ""){ if (!$_POST) { check_login('dashboard'); }
		$satKer = 'All';
		if ($selectedYear == "" || $selectedYear == date('Y')){
			$selectedYear = date('Y');
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
			$titleDate = date('d F Y');
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
			$titleDate = $selectedYear;
		}
		$data['selectedYear'] = $selectedYear;
		
		if ($this->thisSession['branch_name'] == "Administrator"){}
		else {
			$satKer = strtolower($this->thisSession['branch_name']);
			redirect('dashboard/form_b/'.$satKer.'/'.$selectedYear);
		}
		
		$data['title'] = 'Realisasi Penerimaan VS Target PNBP BLU ('.date('d F Y').')-Form A';
		$data['page'] = 'form_a';
		
		$rawTarget = $this->target->getTargetBulanan($this->thisYear);
		foreach($rawTarget as $row)
			$thisTarget[$row['month']] = number_format($row['target']/$this->pembagi,2).$this->satuan;
		$data['thisTarget'] = $thisTarget;
		
		for($i=1; $i<=12; $i++)
			$bulanan[] = date('M', strtotime($i.'/20/2019'));
		$data['bulanan'] = $bulanan;
		
		$data['getRekap_form_a'] = $this->getRekap_form_a($satKer, $selectedYear);
		$data['getGrafik_form_a'] = $this->getGrafik_form_a($satKer, $selectedYear);
		$data['getRekap_form_c'] = $this->getRekap_form_c($satKer, $selectedYear);
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		$data['thisYear'] = $this->thisYear;
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	public function form_b($satKer = 'p3tek', $selectedYear=""){ if (!$_POST) { check_login('dashboard'); }
		$satKer = strtolower($satKer);
		if ($selectedYear == "" || $selectedYear == date('Y')){
			$selectedYear = date('Y');
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
			$titleDate = date('d F Y');
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
			$titleDate = $selectedYear;
		}
		$data['selectedYear'] = $selectedYear;
		
		if ($this->thisSession['branch_name'] == "Administrator"){}
		else if ($satKer != strtolower($this->thisSession['branch_name'])){
			$satKer = strtolower($this->thisSession['branch_name']);
			redirect('dashboard/form_b/'.$satKer.'/'.$selectedYear);
		}
		
		
		$data['title'] = 'Kurva S '.strtoupper($satKer).' ('.$titleDate.')-Form B';
		$data['page'] = 'form_b';
		$data['satKer'] = $satKer;
		
		for($i=1; $i<=12; $i++) 
			$bulanan[] = date('M', strtotime($i.'/20/2019'));
		$data['bulanan'] = $bulanan;
		
		$data['getRekap_form_a'] = $this->getRekap_form_a($satKer, $selectedYear);
		$data['getGrafik_form_a'] = $this->getGrafik_form_a($satKer, $selectedYear);
		$data['getRekap_form_b'] = $this->getRekap_form_b($satKer, $selectedYear);
		$data['getRekap_form_c'] = $this->getRekap_form_c($satKer, $selectedYear);
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		if ($satKer == "p3tek"){ $branchId = '4'; }
		else if ($satKer == "p3gl"){ $branchId = '2'; }
		else if ($satKer == "tekmira"){ $branchId = '3'; }
		else if ($satKer == "lemigas"){ $branchId = '1'; }
		$data['targetAll'] = $this->getTargetKp3Tahunan($branchId, $this->thisYear);
		
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);

	}
	public function form_c($satKer = 'p3tek', $selectedYear=""){ if (!$_POST) { check_login('dashboard'); }
		$satKer = strtolower($satKer);
		if ($selectedYear == ""){
			$selectedYear = date('Y');
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
			$titleDate = date('d F Y');
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
			$titleDate = $selectedYear;
		}
		$data['selectedYear'] = $selectedYear;
		
		if ($this->thisSession['branch_name'] == "Administrator"){}
		else if ($satKer != strtolower($this->thisSession['branch_name'])){
			$satKer = strtolower($this->thisSession['branch_name']);
			redirect('dashboard/form_c/'.$satKer.'/'.$selectedYear);
		}
		
		$data['title'] = 'Table Detail '.strtoupper($satKer).' ('.$titleDate.')-Form C';
		$data['page'] = 'form_c';
		$data['satKer'] = $satKer;
		
		
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		for($i=1; $i<=12; $i++) 
			$bulanan[] = date('M', strtotime($i.'/20/2019'));
		$data['bulanan'] = $bulanan;
		
		$data['getRekap_form_a'] = $this->getRekap_form_a($satKer, $selectedYear);
		$data['getGrafik_form_a'] = $this->getGrafik_form_a($satKer, $selectedYear);
		$data['getRekap_form_c'] = $this->getRekap_form_c($satKer, $selectedYear);
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		if ($satKer == "p3tek"){ $branchId = '4'; }
		else if ($satKer == "p3gl"){ $branchId = '2'; }
		else if ($satKer == "tekmira"){ $branchId = '3'; }
		else if ($satKer == "lemigas"){ $branchId = '1'; }
		$data['thisTargetAll'] = $this->getTargetKp3Tahunan($branchId, $selectedYear);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);

	}
	
	function getDataSatker(){
		// http://localhost:55/04.Project/ESDM/BSCb4l1tb4ng/index.php/dashboard/getDataSatker
		// $rekap = $this->getRekap_form_a('tekmira');
		// print_r($rekap);
		// echo "\n # getRekap_form_a ############################################";
		// $rekap = $this->getGrafik_form_a('tekmira');
		// print_r($rekap);
		// echo "\n # getGrafik_form_a ############################################";
		$thisKey = '5.03.00';
		$thisYear = '2019';
		$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_detail_kontrak/?_start=0&_count=50&_filter=kontrak_host_kode%3D%3D'.$thisKey.'%26%26kontrak_tanggal%3E%3D'.$thisYear.'-01-01%26%26kontrak_tanggal%3C'.($thisYear + 1).'-01-01&_expand=yes&_view=json';
		$responRow 	= $this->getDataLemigas($url);
		print_r($responRow);
		// $rekap = $this->getRekap_form_c('tekmira');
		// print_r($rekap);
		// echo "\n # getRekap_form_c ############################################";
		die();
		
	}
	
	function getRekap_form_a($satKer = 'All', $selectedYear=""){
		if ($selectedYear == ""){
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
		}
		$realisasi 		= 0;
		$kontrakSatker 	= 0;
		$targetSatker 	= 1;
		$targetBulan  	= 1;
		$pembagi 		= $this->pembagi;
		$satuan  		= $this->satuan;
		
		if ($satKer == 'All' || $satKer == 'p3tek'){ $branchId = '4';
			$getTargetSatker = $this->target->getTargetSatker($branchId, $this->thisYear, date('m'));
			$targetSatker = @$getTargetSatker['TargetTahunIni'];
			$targetBulan = @$getTargetSatker['TargetBulanIni'];
			
			// kontrak
			$url 				= 'http://35.188.21.29/json/agreement?year='.$this->thisYear.'&group=organization&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$kontrakSatker 		+= @$dataRow['value_casted'];
			
			$url 				= 'http://35.188.21.29/json/payment?year='.$this->thisYear.'&group=organization&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$realisasiSatker 	= @$dataRow['value_casted'];
			$dataSatker[] = array(
				'Unit Kerja'		=> 'P3TEK',
				'Target'			=> number_format($targetSatker/$pembagi,2).$satuan,
				'Target Bulan Ini'	=> number_format($targetBulan/$pembagi,2).$satuan,
				'Target (%)'		=> number_format($targetBulan/$targetSatker * 100,2),
				'Realisasi'			=> number_format($realisasiSatker/$pembagi,2).$satuan,
				'Realisasi(%)'		=> number_format($realisasiSatker/$targetSatker * 100,2),
				'Sisa'				=> number_format(($targetSatker - $realisasiSatker)/$pembagi,2).$satuan,
				'Sisa(%)'			=> number_format((100 -($realisasiSatker/$targetSatker * 100)),2),
			);
			@$realisasi += $realisasiSatker;	
		}
		
		if ($satKer == 'All' || $satKer == 'tekmira'){ $branchId = '3';
			$getTargetSatker = $this->target->getTargetSatker($branchId, $this->thisYear, date('m'));
			$targetSatker = @$getTargetSatker['TargetTahunIni'];
			$targetBulan = @$getTargetSatker['TargetBulanIni'];
			
			// realisasi
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/realisasi_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				@$realisasiSatker += floatval(str_replace('.','',$row['realisasi']));
			}
			
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/terkontrak_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			// print_r($dataRow); die();
			foreach($dataRow as $row){
				@$kontrakSatker += floatval(str_replace('.','',$row['realisasiKontrak']));
			}
			
			
			$dataSatker[] = array(
				'Unit Kerja'		=> 'Tekmira',
				'Target'			=> number_format($targetSatker/$pembagi,2).$satuan,
				'Target Bulan Ini'	=> number_format($targetBulan/$pembagi,2).$satuan,
				'Target (%)'		=> number_format($targetBulan/$targetSatker * 100,2),
				'Realisasi'			=> number_format($realisasiSatker/$pembagi,2).$satuan,
				'Realisasi(%)'		=> number_format($realisasiSatker/$targetSatker * 100,2),
				'Sisa'				=> number_format(($targetSatker - $realisasiSatker)/$pembagi,2).$satuan,
				'Sisa(%)'			=> number_format((100 -($realisasiSatker/$targetSatker * 100)),2),
			);
			@$realisasi += $realisasiSatker;	
		}
		
		if ($satKer == 'All' || $satKer == 'p3gl'){ $branchId = '2';
			$getTargetSatker = $this->target->getTargetSatker($branchId, $this->thisYear, date('m'));
			$targetSatker = @$getTargetSatker['TargetTahunIni'];
			$targetBulan = @$getTargetSatker['TargetBulanIni'];
			
			// kontrak
			$url 				= 'http://34.66.44.99/json/agreement?year='.$this->thisYear.'&group=organization&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$kontrakSatker 		+= @$dataRow['value_casted'];
			
			$url 				= 'http://34.66.44.99/json/payment?year='.$this->thisYear.'&group=organization&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$realisasiSatker 	= @$dataRow['value_casted'];
			$dataSatker[] = array(
				'Unit Kerja'		=> 'P3GL',
				'Target'			=> number_format($targetSatker/$pembagi,2).$satuan,
				'Target Bulan Ini'	=> number_format($targetBulan/$pembagi,2).$satuan,
				'Target (%)'		=> number_format($targetBulan/$targetSatker * 100,2),
				'Realisasi'			=> number_format($realisasiSatker/$pembagi,2).$satuan,
				'Realisasi(%)'		=> number_format($realisasiSatker/$targetSatker * 100,2),
				'Sisa'				=> number_format(($targetSatker - $realisasiSatker)/$pembagi,2).$satuan,
				'Sisa(%)'			=> number_format((100 -($realisasiSatker/$targetSatker * 100)),2),
			);
			@$realisasi += $realisasiSatker;
		}
		
		if ($satKer == 'All' || $satKer == 'lemigas'){ $branchId = '1';
			$getTargetSatker = $this->target->getTargetSatker($branchId, $this->thisYear, date('m'));
			$targetSatker = @$getTargetSatker['TargetTahunIni'];
			$targetBulan = @$getTargetSatker['TargetBulanIni'];
			
			## kontrak
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_rekap_kontrak_bulan/?_start=0&_count=50&_filter=tahun%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$dataRow 	= $this->getDataLemigas($url);
			/* // print_r($responRow); die();
			[host_kode] => 5.03.00
            [host_nama] => Bidang Penyelenggara dan Sarana Penelitian dan Pengembangan
            [tahun] => 2019
            [bulan] => 1
            [nilai] => 71400000.00
            [kontrak_currency] => 2
			*/
			foreach($dataRow as $row){
				$nilai = $row['nilai'];
				if ($row['kontrak_currency'] == 1)
					$nilai = @$row['nilai'] * $this->pengaliDolar;
				@$kontrakSatker += @$nilai;
			}
			
			$realisasiSatker = 0;
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_invoice_penerimaan_bulan/?_start=0&_count=50&_filter=tahun_bayar%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$responRow 	= $this->getDataLemigas($url);
			/*
			// print_r($responRow); die();
			[host_kode] => 5.01.00
            [unit_name] => Bagian Tata Usaha
            [tahun_bayar] => 2019
            [bulan_bayar] => 1
            [inv_nilai] => 137708417.00
            [inv_currency] => 2
			*/
			foreach($responRow as $dataRow){
				$debit = $dataRow['inv_nilai'];
				if ($dataRow['inv_currency'] == 1) 
					$debit = $debit * $this->pengaliDolar;
				$realisasiSatker 	+= @$debit;
				
				// $realisasiSatker 	+= @$dataRow['kredit'];
			}
			$dataSatker[] = array(
				'Unit Kerja'		=> 'Lemigas',
				'Target'			=> number_format($targetSatker/$pembagi,2).$satuan,
				'Target Bulan Ini'	=> number_format($targetBulan/$pembagi,2).$satuan,
				'Target (%)'		=> number_format($targetBulan/$targetSatker * 100,2),
				'Realisasi'			=> number_format($realisasiSatker/$pembagi,2).$satuan,
				'Realisasi(%)'		=> number_format($realisasiSatker/$targetSatker * 100,2),
				'Sisa'				=> number_format(($targetSatker - $realisasiSatker)/$pembagi,2).$satuan,
				'Sisa(%)'			=> number_format((100 -($realisasiSatker/$targetSatker * 100)),2),
			);
			@$realisasi += $realisasiSatker;
		}
		
		if ($satKer == 'All') { 
			$branchId = 'All';
			$getTargetSatker = $this->target->getTargetSatker($branchId, $this->thisYear, date('m'));
			$targetTahunan = @$getTargetSatker['TargetTahunIni'];
			$targetBulanIni = @$getTargetSatker['TargetBulanIni'];
		} else {
			$targetTahunan = $targetSatker;
			$targetBulanIni = $targetBulan;
		}
		
		$persenTarget = number_format(@$targetBulanIni/$targetTahunan * 100,2);
		$persenBulanIni = number_format(@$realisasi/$targetTahunan * 100,2);
		$dataReturn = array(
			'target' 			=> number_format($targetTahunan/$pembagi,2).$satuan,
			'targetBulanIni' 	=> number_format($targetBulanIni/$pembagi,2).$satuan,
			'persenTarget'		=> $persenTarget.' %',
			'realisasi' 		=> number_format(@$realisasi/$pembagi,2).$satuan,
			'persenRealisasi'	=> $persenBulanIni.' %',
			'dataSatker'		=> @$dataSatker,
			'kontrakSatker'		=> number_format(@$kontrakSatker/$pembagi,2).$satuan,
		);
		return @$dataReturn;
	}
	function getGrafik_form_a($satKer = 'All', $selectedYear=""){
		if ($selectedYear == ""){
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
		}
		$AkumulasiRealiasi = null;
		$AkumulasiRealiasiTahunLalu = null;
		
		$targetBulanIni = array();
		$targetBulanan = array();
		$data = array();
		$dataSeries = array();
		if ($satKer == 'All' || $satKer == 'p3tek'){ $branchId = '4';
			## kontrak
			$url 				= 'http://35.188.21.29/json/agreement?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$KontrakSatker[$bulan] = @$row;
			}
			
			## Pencapaian this year
			$url 				= 'http://35.188.21.29/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/forma/grafik.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$dataSatker[$bulan] = @$row;
			}
			## Pencapaian last year
			$url 				= 'http://35.188.21.29/json/payment?year='.$this->lastYear.'&group=group&time=monthly&source=organization';
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/forma/grafik.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$dataLastYear[$bulan] = @$row;
			}
			
			for($i=1; $i<=12; $i++){
				if (@$dataSatker[$i]['target'] > 0) 			{ @$data['target'][$i-1] 				+= @$dataSatker[$i]['target'];            } else { @$data['target'][$i-1]				+= null; }
				if (@$dataSatker[$i]['potensi'] > 0)			{ @$data['potensi'][$i-1] 				+= @$dataSatker[$i]['potensi'];           } else { @$data['potensi'][$i-1]				+= null; }
				if (@$dataSatker[$i]['value_casted'] > 0)		{ @$data['realisasi'][$i-1] 			+= @$dataSatker[$i]['value_casted'];      } else { @$data['realisasi'][$i-1]			+= null; }
				if (@$KontrakSatker[$i]['value_casted'] > 0)	{ @$data['nilaiKontrak'][$i-1] 			+= @$KontrakSatker[$i]['value_casted'];   } else { @$data['nilaiKontrak'][$i-1]			+= null; }
				if (@$dataLastYear[$i]['value_casted'] > 0)		{ @$data['realiasiTahunLalu'][$i-1] 	+= @$dataLastYear[$i]['value_casted'];    } else { @$data['realiasiTahunLalu'][$i-1]	+= null; }
				
				$AkumulasiRealiasi += @$dataSatker[$i]['value_casted'];
				if ($i <= (int)date('m'))
				@$data['AkumulasiRealiasi'][$i-1] 	+= $AkumulasiRealiasi;
				
				$AkumulasiRealiasiTahunLalu += @$dataLastYear[$i]['value_casted'];
				@$data['AkumulasiRealiasiTahunLalu'][$i-1] 	+= $AkumulasiRealiasiTahunLalu;
			}
		}
		
		if ($satKer == 'All' || $satKer == 'tekmira'){ $branchId = '3';
			## p3tek
			
			## kontrak
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/terkontrak_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['bulan'];
				$nilai = $row['realisasiKontrak'];
				@$KontrakSatker[$bulan]['value_casted'] += @$nilai;
			}
			// print_r(@$KontrakSatker);
			
			
			## Pencapaian this year
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/realisasi_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)$row['bulan'];
				$debit = $row['realisasi'];
				@$dataSatker[$bulan]['realisasi'] += $debit;
			}
			// print_r(@$dataSatker);
			
			## Pencapaian last year
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/realisasi_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->lastYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			if ($dataRow){
				foreach($dataRow as $row){
					$bulan = (int)$row['bulan'];
					$debit = $row['realisasi'];
					@$dataSatkerLalu[$bulan]['realisasi'] += $debit;
				}
			}
			
			// print_r(@$dataSatkerLalu); die();
			
			for($i=1; $i<=12; $i++){
				if (@$dataSatker[$i]['target'] > 0) 			{ @$data['target'][$i-1] 				+= @$dataSatker[$i]['target'];            } else { @$data['target'][$i-1]				+= null; }
				if (@$dataSatker[$i]['potensi'] > 0)			{ @$data['potensi'][$i-1] 				+= @$dataSatker[$i]['potensi'];           } else { @$data['potensi'][$i-1]				+= null; }
				if (@$dataSatker[$i]['realisasi'] > 0)			{ @$data['realisasi'][$i-1] 			+= @$dataSatker[$i]['realisasi'];         } else { @$data['realisasi'][$i-1]			+= null; }
				if (@$dataSatker[$i]['realisasiKontrak'] > 0)	{ @$data['nilaiKontrak'][$i-1] 			+= @$dataSatker[$i]['realisasiKontrak'];  } else { @$data['nilaiKontrak'][$i-1]			+= null; }
				if (@$dataSatkerLalu[$i]['realisasi'] > 0)		{ @$data['realiasiTahunLalu'][$i-1] 	+= @$dataSatkerLalu[$i]['realisasi'];     } else { @$data['realiasiTahunLalu'][$i-1]	+= null; }
				
				$AkumulasiRealiasi += @$dataSatker[$i]['realisasi'];
				if ($i <= (int)date('m'))
				@$data['AkumulasiRealiasi'][$i-1] 	+= $AkumulasiRealiasi;
				
				$AkumulasiRealiasiTahunLalu += @$dataSatkerLalu[$i]['realisasi'];
				@$data['AkumulasiRealiasiTahunLalu'][$i-1] 	+= $AkumulasiRealiasiTahunLalu;
			}
		}
		
		if ($satKer == 'All' || $satKer == 'p3gl'){ $branchId = '2';
			## kontrak
			$url 				= 'http://34.66.44.99/json/agreement?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$KontrakSatker[$bulan] = @$row;
			}
			
			## Pencapaian this year
			$url 				= 'http://34.66.44.99/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/forma/grafik.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$dataSatker[$bulan] = @$row;
			}
			## Pencapaian last year
			$url 				= 'http://34.66.44.99/json/payment?year='.$this->lastYear.'&group=group&time=monthly&source=organization';
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/forma/grafik.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$dataLastYear[$bulan] = @$row;
			}
			
			for($i=1; $i<=12; $i++){
				if (@$dataSatker[$i]['target'] > 0) 			{ @$data['target'][$i-1] 				+= @$dataSatker[$i]['target'];            } else { @$data['target'][$i-1]				+= null; }
				if (@$dataSatker[$i]['potensi'] > 0)			{ @$data['potensi'][$i-1] 				+= @$dataSatker[$i]['potensi'];           } else { @$data['potensi'][$i-1]				+= null; }
				if (@$dataSatker[$i]['value_casted'] > 0)		{ @$data['realisasi'][$i-1] 			+= @$dataSatker[$i]['value_casted'];      } else { @$data['realisasi'][$i-1]			+= null; }
				if (@$KontrakSatker[$i]['value_casted'] > 0)	{ @$data['nilaiKontrak'][$i-1] 			+= @$KontrakSatker[$i]['value_casted'];   } else { @$data['nilaiKontrak'][$i-1]			+= null; }
				if (@$dataLastYear[$i]['value_casted'] > 0)		{ @$data['realiasiTahunLalu'][$i-1] 	+= @$dataLastYear[$i]['value_casted'];    } else { @$data['realiasiTahunLalu'][$i-1]	+= null; }
				
				$AkumulasiRealiasi += @$dataSatker[$i]['value_casted'];
				if ($i <= (int)date('m'))
				@$data['AkumulasiRealiasi'][$i-1] 	+= $AkumulasiRealiasi;
				
				$AkumulasiRealiasiTahunLalu += @$dataLastYear[$i]['value_casted'];
				@$data['AkumulasiRealiasiTahunLalu'][$i-1] 	+= $AkumulasiRealiasiTahunLalu;
			}
		}
		
		if ($satKer == 'All' || $satKer == 'lemigas'){ $branchId = '1';
			## kontrak
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_rekap_kontrak_bulan/?_start=0&_count=50&_filter=tahun%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$responRow 	= $this->getDataLemigas($url);
			/* // print_r($responRow); die();
			[host_kode] => 5.03.00
            [host_nama] => Bidang Penyelenggara dan Sarana Penelitian dan Pengembangan
            [tahun] => 2019
            [bulan] => 1
            [nilai] => 71400000.00
            [kontrak_currency] => 2
			*/
			foreach($responRow as $row){
				$bulan = (int)@$row['bulan'];
				$nilai = $row['nilai'];
				if ($row['kontrak_currency'] == 1)
					$nilai = @$row['nilai'] * $this->pengaliDolar;
				@$KontrakSatker[$bulan]['value_casted'] += @$nilai;
			}
			
			## Pencapaian this year
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_invoice_penerimaan_bulan/?_start=0&_count=50&_filter=tahun_bayar%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$responRow 	= $this->getDataLemigas($url);
			/* // print_r($responRow); die();
			[host_kode] => 5.01.00
            [unit_name] => Bagian Tata Usaha
            [tahun_bayar] => 2019
            [bulan_bayar] => 1
            [inv_nilai] => 137708417.00
            [inv_currency] => 2
			*/
			foreach($responRow as $row){
				$bulan = (int)$row['bulan_bayar'];
				$debit = $row['inv_nilai'];
				if ($row['inv_currency'] == 1) 
					$debit = $debit * $this->pengaliDolar;
				
				@$dataSatker[$bulan]['kredit'] += $debit;
			}
			
			## Pencapaian last year
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_invoice_penerimaan_bulan/?_start=0&_count=50&_filter=tahun_bayar%3D%3D'.$this->lastYear.'&_expand=yes&_view=json';
			$responRow 	= $this->getDataLemigas($url);
			foreach($responRow as $row){
				$bulan = (int)$row['bulan_bayar'];
				$debit = $row['inv_nilai'];
				if ($row['inv_currency'] == 1) 
					$debit = $debit * $this->pengaliDolar;
				
				@$dataSatkerLalu[$bulan]['kredit'] += $debit;
			}
			
			for($i=1; $i<=12; $i++){
				if (@$dataSatker[$i]['target'] > 0) 			{ @$data['target'][$i-1] 				+= @$dataSatker[$i]['target'];            } else { @$data['target'][$i-1]				= null; }
				if (@$dataSatker[$i]['potensi'] > 0)			{ @$data['potensi'][$i-1] 				+= @$dataSatker[$i]['potensi'];           } else { @$data['potensi'][$i-1]				= null; }
				if (@$dataSatker[$i]['kredit'] > 0)				{ @$data['realisasi'][$i-1] 			+= @$dataSatker[$i]['kredit'];            } else { @$data['realisasi'][$i-1]			= null; }
				if (@$KontrakSatker[$i]['value_casted'] > 0)	{ @$data['nilaiKontrak'][$i-1] 			+= @$KontrakSatker[$i]['value_casted'];   } else { @$data['nilaiKontrak'][$i-1]			= null; }
				if (@$dataSatkerLalu[$i]['kredit'] > 0)			{ @$data['realiasiTahunLalu'][$i-1] 	+= @$dataSatkerLalu[$i]['kredit'];        } else { @$data['realiasiTahunLalu'][$i-1]	= null; }
				
				$AkumulasiRealiasi += @$dataSatker[$i]['kredit'];
				if ($i <= (int)date('m'))
				@$data['AkumulasiRealiasi'][$i-1] 	+= $AkumulasiRealiasi;
				
				$AkumulasiRealiasiTahunLalu += @$dataSatkerLalu[$i]['kredit'];
				@$data['AkumulasiRealiasiTahunLalu'][$i-1] 	+= $AkumulasiRealiasiTahunLalu;
			}
			// print_r(@$data['AkumulasiRealiasi']); 
			// print_r(@$data['AkumulasiRealiasiTahunLalu']); 
			// die();
		}
		
		
		## olah grafik
		$dataSeries[] = array( 'name' => 'potensi', 'data' => @$data['potensi'] );
		$dataSeries[] = array( 'name' => 'realisasi', 'data' => @$data['realisasi'] );
		$dataSeries[] = array( 'name' => 'Akumulasi Realiasi', 'data' => @$data['AkumulasiRealiasi'] );
		$dataSeries[] = array( 'name' => 'realiasi TahunLalu', 'data' => @$data['realiasiTahunLalu'] );
		$dataSeries[] = array( 'name' => 'realiasi Akumulasi Lalu', 'data' => @$data['AkumulasiRealiasiTahunLalu'] );
		
		
		$dataReturn = array(
			'table' => @$data,
			// 'dataSeries' => @$dataSeries,
			'targetBulanIni' => @$targetBulanIni,
			'targetBulanan' => @$targetBulanan,
			// 'dataRow' => @$dataRow,
		);
		
		if ($satKer != 'All'){
			$targetBulanIni = $this->getTargetKp3Bulan($branchId, $this->thisYear, date('m'));
			$dataReturn['targetBulanIni'] = $targetBulanIni;
			
			$targetBulanan = $this->getTargetKp3Bulanan($branchId, $this->thisYear);
			$dataReturn['targetBulanan'] = $targetBulanan;
			
			for($i=1; $i<=12; $i++){
				// $thisTarget[] = floatval($targetBulanan[$i]);
				
				@$thisTargetAkumulasi += floatval($targetBulanan[$i]);
				$thisTarget[] = $thisTargetAkumulasi;
			}
			$dataSeries[] = array( 'name' => 'target', 'data' => $thisTarget );
			
		} else {
			$targetBulanan = $this->getTargetKp3Bulanan($satKer, $this->thisYear);
			$dataReturn['targetBulanan'] = floatval($targetBulanan);
		}
		$dataReturn['dataSeries'] = @$dataSeries;
		
		
		return $dataReturn;
	}
	function getRekap_form_b($satker, $selectedYear=""){
		if ($selectedYear == ""){
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
		}
		$dataReturn = array();
		$pembagi = $this->pembagi;
		$satuan = $this->satuan;
		
		if ($satker == "p3tek"){ $branchId = '4';
			$targetAll = $this->getTargetKp3Tahunan($branchId, $this->thisYear);
			
			$url 				= 'http://35.188.21.29/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			
			$arrKp3 = array();
			foreach($dataRow as $row){
				$kp3 = strtoupper(@$row['name']);
				if(!in_array($kp3, $arrKp3))
					$arrKp3[] = $kp3;
				
				@$realisasi[$kp3] += @$row['value_casted'];
			}
			for($i=0; $i<count($arrKp3); $i++){
				$kp3 = @$arrKp3[$i];
				$realisasiKp3 = @$realisasi[$kp3];
				
				$dataReturn[] = array(
					'Unit Kerja'		=> @$kp3,
					'Target'			=> number_format(@$targetAll[$kp3]/$pembagi,2).$satuan,
					'Target Bulan Ini'	=> @$targetBulanIni[$kp3],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
			}
		}
		else if ($satker == "p3gl"){ $branchId = '2';
			$targetAll = $this->getTargetKp3Tahunan($branchId, $this->thisYear);
			
			$url 				= 'http://34.66.44.99/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			
			$arrKp3 = array();
			foreach($dataRow as $row){
				$kp3 = strtoupper(@$row['name']);
				if(!in_array($kp3, $arrKp3))
					$arrKp3[] = $kp3;
				
				@$realisasi[$kp3] += @$row['value_casted'];
			}
			for($i=0; $i<count($arrKp3); $i++){
				$kp3 = @$arrKp3[$i];
				$realisasiKp3 = @$realisasi[$kp3];
				
				$dataReturn[] = array(
					'Unit Kerja'		=> @$kp3,
					'Target'			=> number_format(@$targetAll[$kp3]/$pembagi,2).$satuan,
					'Target Bulan Ini'	=> @$targetBulanIni[$kp3],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
			}
		}
		else if ($satker == "tekmira"){ $branchId = '3';
			$arrKp3 = array();
			$targetAll = $this->getTargetKp3Tahunan($branchId, $this->thisYear);
			// $dataReturn['targetAll'] = $targetAll;
			// print_r($targetAll);
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/realisasi_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
            foreach($dataRow as $row){
                $kp3 = strtoupper($row['kp3']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
				}
                @$realisasiKp3[$kp3] 	+= floatval(str_replace('.','',@$row['realisasi']));
            }
            for($i=0; $i<count($arrKp3); $i++){
                $kp3 = $arrKp3[$i];
                $dataReturn[] = array(
					'Unit Kerja'		=> $kp3,
					'Target'			=> number_format(@$targetAll[$kp3]/$pembagi,2).$satuan,
					'Target Bulan Ini'	=> @$row['targetBulanIni'],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3[$kp3]/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
                
            }
			// print_r($realisasiKp3);  print_r($dataRow);  die();
            
			// foreach($dataRow as $row){
				// $realisasiKp3 	= floatval(str_replace('.','',@$row['realisasi']));
				// $dataReturn[] = array(
					// 'Unit Kerja'		=> $row['kp3'],
					// 'Target'			=> number_format(@$targetAll[$row['kp3']]/$pembagi,2).$satuan,
					// 'Target Bulan Ini'	=> @$row['targetBulanIni'],
					// 'Target (%)'		=> null,
					// 'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					// 'Realisasi(%)'		=> null,
					// 'Sisa'				=> null,
					// 'Sisa(%)'			=> null,
				// );
			// }
			// print_r($targetAll); 
			// print_r($dataReturn); 
			// die();
		}
		else if ($satker == "lemigas"){ $branchId = '1';
			$targetAll = $this->getTargetKp3Tahunan($branchId, $this->thisYear);
			
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_invoice_penerimaan_bulan/?_start=0&_count=50&_filter=tahun_bayar%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$dataRow 	= $this->getDataLemigas($url);
			$arrKp3 = array();
			foreach($dataRow as $row){
				$unit_kode = $row['host_kode'];
				$exp = explode('.',$unit_kode);
				if ($exp[2] == '00'){
					$thisKp3[''.$exp[0].$exp[1].''] = $row['unit_name'];
				}
				$row['unit_nama'] = @$thisKp3[''.$exp[0].$exp[1].''];
				$dataOlah[] = $row;
			}
			foreach($dataOlah as $row){
				$kp3 = strtoupper(@$row['unit_nama']);
				if(!in_array($kp3, $arrKp3))
					$arrKp3[] = $kp3;
				
				$debit = $row['inv_nilai'];
				if ($row['inv_currency'] == 1) 
					$debit = $debit * $this->pengaliDolar;
				
				@$realisasi[$kp3] += @$debit;
			}
			for($i=0; $i<count($arrKp3); $i++){
				$kp3 = @$arrKp3[$i];
				$realisasiKp3 = @$realisasi[$kp3];
				
				$dataReturn[] = array(
					'Unit Kerja'		=> @$kp3,
					'Target'			=> number_format(@$targetAll[$kp3]/$pembagi,2).$satuan,
					'Target Bulan Ini'	=> @$targetBulanIni[$kp3],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
			}
			// print_r($dataReturn); die();
		}
		return @$dataReturn;
	}
	function getRekap_form_c($satker = 'All', $selectedYear=""){
		if ($selectedYear == ""){
			$this->thisYear = date('Y');
			$this->lastYear = date('Y') - 1;
		} else {
			$this->thisYear = $selectedYear;
			$this->lastYear = $selectedYear - 1;
		}
		$arrOrgId = array();
		$dataReturn = array();
		$pembagi = $this->pembagi;
		$satuan = $this->satuan;
		$totalTerkontrak = 0;
		$totalInv = 0;
		$totalRealisasi = 0;
		
		if ($satker == 'All' || $satker == "tekmira"){ $branchId = '3';
			$arrKp3 = array();
			## penerimaan
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/realisasi_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['kp3']);
				$bulan = (int)$row['bulan'];
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['kp3'];
				}
				
				$nilai = $row['realisasi'];
				
				$dataTable[$kp3][$bulan]['kp3'] 					= $row['kp3'];
				@$dataTable[$kp3][$bulan]['realisasi'] 				+= $nilai;
				@$dataTable[$kp3][$bulan]['bulan']					= $row['bulan'];
				@$dataTable[$kp3][$bulan]['realisasiKontrak']		= null;
				@$dataTable[$kp3][$bulan]['invoice']				= null;
				
				@$tableRekap[$kp3]['realisasi'] 	+= $nilai;
				
				$totalRealisasi += $nilai;
			}
			// print_r($dataTable); print_r($tableRekap); die();
			
			## kontrak
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/terkontrak_kp3_tahunan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['kp3']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
				}
				
				$nilai = floatval(str_replace('.','',@$row['terkontrak']));
				@$KontrakSatker[$kp3] += @$nilai;
			}
			// print_r($KontrakSatker); die();
			
			## invoice
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/realisasi_kp3_bulanan';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['kp3']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
				}
				
				$nilai = $row['realisasi'];
				@$InvSatker[$kp3] += @$nilai;
			}
			
			
			for($i=0; $i<count($arrKp3); $i++){
				$kp3 = strtoupper($arrKp3[$i]);
				$tableRekap[$kp3]['terkontrak'] 	= @$KontrakSatker[$kp3] == 0 ? 1 : @$KontrakSatker[$kp3];
				$tableRekap[$kp3]['inv'] 			= @$InvSatker[$kp3] == 0 ? 1 : @$InvSatker[$kp3];
				
				@$totalTerkontrak += @$KontrakSatker[$kp3];
				@$totalInv += @$InvSatker[$kp3];
			}
			
			// print_r($responRow);
			/* 
			## https://layanan.tekmira.esdm.go.id/emonev/restapi/tabel_rekap_target
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/tabel_kiri';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			// print_r($responRow);
			// die();
			
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/tabel_rekap';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $key => $val){
				@$totalTerkontrak += $val['realisasiKontrak'];
				@$totalInv += $val['invoice'];
				@$totalRealisasi += $val['realisasi'];
			}
			
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['kp3']);
				if(!in_array($kp3, $arrKp3))
					$arrKp3[] = $kp3;
				
				@$tableRekap[$kp3]['terkontrak'] 	+= $row['realisasiKontrak'];
				@$tableRekap[$kp3]['inv'] 			+= $row['invoice'];
				@$tableRekap[$kp3]['realisasi'] 	+= $row['realisasi'];
			}
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['kp3']);
				$bulan = (int)$row['bulan'];
				if(!in_array($kp3, $arrKp3))
					$arrKp3[] = $kp3;
				
				$dataTable[$kp3][$bulan] = $row;
			} */
			$dataReturn = array(
				'tableRekap' 		=> $tableRekap,
				'dataTable' 		=> $dataTable,
				'arrKp3' 			=> $arrKp3,
				'arrOrgId' 			=> @$arrOrgId,
				'totalTerkontrak' 	=> @$totalTerkontrak,
				'totalInv' 			=> @$totalInv,
				'totalRealisasi' 	=> @$totalRealisasi,
				// 'dataRow' 	=> @$dataRow,
			);
		}
		if ($satker == 'All' || $satker == "p3tek"){ $branchId = '4';
			$arrKp3 = array();
			## rekap kontrak
			$url 				= 'http://35.188.21.29/json/agreement?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$tableRekap[$kp3]['terkontrak'] = @$row['value_casted'];
				$totalTerkontrak += @$row['value_casted'];
			}
			
			## rekap invoice
			$url 				= 'http://35.188.21.29/json/issue?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$tableRekap[$kp3]['inv'] = @$row['value_casted'];
				$totalInv += @$row['value_casted'];
			}
			## rekap realisasi
			$url 				= 'http://35.188.21.29/json/payment?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$tableRekap[$kp3]['realisasi'] = @$row['value_casted'];
				$totalRealisasi += @$row['value_casted'];
			}
			
			$url 				= 'http://35.188.21.29/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				$bulan = (int)$row['month'];
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$dataTable[$kp3][$bulan] = array(
					'kp3' => $row['name'],
					'realisasi' => $row['value_casted'],
					'bulan' => $row['month'],
					'realisasiKontrak' => null,
					'invoice' => null,
				);
			}
			$dataReturn = array(
				'tableRekap' => @$tableRekap,
				'dataTable' => $dataTable,
				'arrKp3' 	=> $arrKp3,
				'arrOrgId' 	=> @$arrOrgId,
				'totalTerkontrak' 	=> @$totalTerkontrak,
				'totalInv' 			=> @$totalInv,
				'totalRealisasi' 	=> @$totalRealisasi,
			);
		}
		if ($satker == 'All' || $satker == "p3gl"){ $branchId = '2';
			$arrKp3 = array();
			## rekap kontrak
			$url 				= 'http://34.66.44.99/json/agreement?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$tableRekap[$kp3]['terkontrak'] = @$row['value_casted'];
				$totalTerkontrak += @$row['value_casted'];
			}
			
			## rekap invoice
			$url 				= 'http://34.66.44.99/json/issue?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$tableRekap[$kp3]['inv'] = @$row['value_casted'];
				$totalInv += @$row['value_casted'];
			}
			## rekap realisasi
			$url 				= 'http://34.66.44.99/json/payment?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$tableRekap[$kp3]['realisasi'] = @$row['value_casted'];
				$totalRealisasi += @$row['value_casted'];
			}
			
			$url 				= 'http://34.66.44.99/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow			= $responRow['data'];
			foreach($dataRow as $row){
				$kp3 = strtoupper($row['name']);
				$bulan = (int)$row['month'];
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['organization_id'];
				}
				
				$dataTable[$kp3][$bulan] = array(
					'kp3' => $row['name'],
					'realisasi' => $row['value_casted'],
					'bulan' => $row['month'],
					'realisasiKontrak' => null,
					'invoice' => null,
				);
			}
			$dataReturn = array(
				'tableRekap' => @$tableRekap,
				'dataTable' => $dataTable,
				'arrKp3' 	=> $arrKp3,
				'arrOrgId' 	=> @$arrOrgId,
				'totalTerkontrak' 	=> @$totalTerkontrak,
				'totalInv' 			=> @$totalInv,
				'totalRealisasi' 	=> @$totalRealisasi,
			);
		}
		if ($satker == 'All' || $satker == 'lemigas'){ $branchId = '1';
			
			$arrKp3 = array();
			
			## penerimaan
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_invoice_penerimaan_bulan/?_start=0&_count=50&_filter=tahun_bayar%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$dataRow 	= $this->getDataLemigas($url);
			/* // print_r($dataRow); die();
			[host_kode] => 5.01.00
            [unit_name] => Bagian Tata Usaha
            [tahun_bayar] => 2019
            [bulan_bayar] => 1
            [inv_nilai] => 137708417.00
            [inv_currency] => 2
			*/
			$arrKp3 = array();
			foreach($dataRow as $row){
				$unit_kode = $row['host_kode'];
				$exp = explode('.',$unit_kode);
				if ($exp[2] == '00'){
					$thisKp3[''.$exp[0].$exp[1].''] = $row['unit_name'];
				}
				$row['unit_nama'] = @$thisKp3[''.$exp[0].$exp[1].''];
				$row['orgId'] = $row['host_kode'];
				$dataOlah[] = $row;
			}
			foreach($dataOlah as $row){
				$kp3 = strtoupper($row['unit_nama']);
				$bulan = (int)$row['bulan_bayar'];
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
					$arrOrgId[$kp3] = $row['orgId'];
				}
				
				$nilai = $row['inv_nilai'];
				if ($row['inv_currency'] == 1)
					$nilai = @$row['inv_nilai'] * $this->pengaliDolar;
				
				$dataTable[$kp3][$bulan]['kp3'] 					= $row['unit_nama'];
				@$dataTable[$kp3][$bulan]['realisasi'] 				+= $nilai;
				@$dataTable[$kp3][$bulan]['bulan']					= $row['bulan_bayar'];
				@$dataTable[$kp3][$bulan]['realisasiKontrak']		= null;
				@$dataTable[$kp3][$bulan]['invoice']				= null;
				
				@$tableRekap[$kp3]['realisasi'] 	+= $nilai;
				
				$totalRealisasi += $nilai;
			}
			
			## kontrak
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_rekap_kontrak_bulan/?_start=0&_count=50&_filter=tahun%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$dataRow 	= $this->getDataLemigas($url);
			/* // print_r($responRow); die();
			[host_kode] => 5.03.00
            [host_nama] => Bidang Penyelenggara dan Sarana Penelitian dan Pengembangan
            [tahun] => 2019
            [bulan] => 1
            [nilai] => 71400000.00
            [kontrak_currency] => 2
			*/
			foreach($dataRow as $row){
				$host_kode = $row['host_kode'];
				$exp = explode('.',$host_kode);
				if ($exp[2] == '00'){
					$thisKp3[''.$exp[0].$exp[1].''] = $row['host_nama'];
				}
				$kp3 = strtoupper(@$thisKp3[''.$exp[0].$exp[1].'']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
				}
				
				$nilai = $row['nilai'];
				if ($row['kontrak_currency'] == 1)
					$nilai = @$row['nilai'] * $this->pengaliDolar;
				@$KontrakSatker[$kp3] += @$nilai;
			}
			
			## inv
			$url 				= 'http://bsc.lemigas.esdm.go.id:443/api/v_ws_invoice_terbit_bulan?_where=(tahun,eq,'.$this->thisYear.')&_sort=host_kode,bulan';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$dataRow	 		= json_decode($responsedet['response'],true);
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_invoice_terbit_bulan/?_start=0&_count=50&_filter=tahun%3D%3D'.$this->thisYear.'&_expand=yes&_view=json';
			$dataRow 	= $this->getDataLemigas($url);
			/*
			// print_r($dataRow); die();
			[host_kode] => 5.01.00
            [unit_name] => Bagian Tata Usaha
            [tahun] => 2019
            [bulan] => 1
            [inv_nilai] => 137708417.00
            [inv_currency] => 2
            [status] => 3
			*/
			foreach($dataRow as $row){
				$host_kode = $row['host_kode'];
				$exp = explode('.',$host_kode);
				if ($exp[2] == '00'){
					$thisKp3[''.$exp[0].$exp[1].''] = $row['unit_name'];
				}
				$kp3 = strtoupper(@$thisKp3[''.$exp[0].$exp[1].'']);
				if(!in_array($kp3, $arrKp3)){
					$arrKp3[] = $kp3;
				}
				
				$nilai = $row['inv_nilai'];
				if ($row['inv_currency'] == 1)
					$nilai = @$row['inv_nilai'] * $this->pengaliDolar;
				@$InvSatker[$kp3] += @$nilai;
			}
			// print_r(@$arrKp3);
			// print_r(@$KontrakSatker);
			// print_r($InvSatker);
			// die();
			for($i=0; $i<count($arrKp3); $i++){
				$kp3 = strtoupper($arrKp3[$i]);
				$tableRekap[$kp3]['terkontrak'] 	= @$KontrakSatker[$kp3] == 0 ? 1 : @$KontrakSatker[$kp3];
				$tableRekap[$kp3]['inv'] 			= @$InvSatker[$kp3] == 0 ? 1 : @$InvSatker[$kp3];
				
				@$totalTerkontrak += @$KontrakSatker[$kp3];
				@$totalInv += @$InvSatker[$kp3];
			}
			
			
			$dataReturn = array(
				'tableRekap' => @$tableRekap,
				'dataTable' => $dataTable,
				'arrKp3' 	=> $arrKp3,
				'arrOrgId' 	=> @$arrOrgId,
				'totalTerkontrak' 	=> @$totalTerkontrak,
				'totalInv' 			=> @$totalInv,
				'totalRealisasi' 	=> @$totalRealisasi,
			);
			// print_r($arrOrgId); 
			// die();
		}
		
		$dataReturn['targetAll'] = array();
		if ($satker != 'All'){
			$targetAll = $this->getTargetKp3Tahunan($branchId, $this->thisYear);
			$dataReturn['targetAll'] = $targetAll;
			
			$targetAllBulanan = $this->target->getTargetAllKp3Bulanan($branchId, $this->thisYear);
			foreach($targetAllBulanan as $row){
				$thisRows[$row['client_mapping']][$row['month']] = $row['target'];
			}
			$dataReturn['targetAllBulanan'] = $thisRows;
		}
		return $dataReturn;
	}

	function getTargetKp3Tahunan($branchId='', $tahun=''){
		$targetAll = array();
		$dataTarget = $this->target->getTargetKp3Tahunan($branchId, $tahun);
		foreach($dataTarget as $row){
			$targetAll[$row['client_mapping']] = $row['target'];
		}
		return $targetAll;
	}
	function getTargetKp3Bulan($branchId='', $tahun='', $bulan=''){
		$targetAll = array();
		$dataTarget = $this->target->getTargetKp3Bulan($branchId, $tahun, $bulan);
		foreach($dataTarget as $row){
			$targetAll[$row['client_mapping']] = $row['target'];
		}
		return $targetAll;
	}
	function getTargetKp3Bulanan($branchId='', $tahun=''){
		$targetAll = array();
		$dataTarget = $this->target->getTargetKp3Bulanan($branchId, $tahun);
		foreach($dataTarget as $row){
			$targetAll[$row['month']] = $row['target'];
		}
		return $targetAll;
	}
	
	
	public function detailTerkontrak(){
		$rows = array();
		$thisKey = @$_POST['thisKey'] ?: 0;
		$thisYear = @$_POST['thisYear'] ?: 0;
		$satker = $_POST['thisSatker'] ?: 0;
		if ($satker == "p3gl"){
			## rekap kontrak
			$url 				= 'http://34.66.44.99/json/organization_agreement?organization_id='.$thisKey.'&year='.$this->thisYear;
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			foreach($responRow as $row){
				$rows[] = array(
					'judul'			=> $row['agreement_title'],
					'noKontrak'		=> $row['agreement_number'],
					'pelanggan'		=> $row['client_name'],
					'nilaiKontrak'	=> number_format($row['agreement_value_casted'],2),
				);
				@$total += $row['agreement_value_casted'];
			}
		}
		else if ($satker == "p3tek"){
			## rekap kontrak
			$url 				= 'http://35.188.21.29/json/organization_agreement?organization_id='.$thisKey.'&year='.$this->thisYear;
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			foreach($responRow as $row){
				$rows[] = array(
					'judul'			=> $row['agreement_title'],
					'noKontrak'		=> $row['agreement_number'],
					'pelanggan'		=> $row['client_name'],
					'nilaiKontrak'	=> number_format($row['agreement_value_casted'],2),
				);
				@$total += $row['agreement_value_casted'];
			}
		}
		else if ($satker == "tekmira"){
			
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/tabel_detail_kontrak';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$allData 			= @$responRow['data'];
			foreach($allData as $row){
				if ($row['kp3'] == $thisKey && floatval($row['nilaiKontrak']) > 0){
					$rows[] = array(
						'judul'			=> @$row['agreement_title'],
						'noKontrak'		=> $row['no_kontrak'],
						'pelanggan'		=> $row['nama_pelanggan'],
						'nilaiKontrak'	=> number_format($row['nilaiKontrak'],2),
					);
					@$total += $row['nilaiKontrak'];
				}
			}
		}
		else if ($satker == "lemigas"){
			## rekap kontrak
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_detail_kontrak/?_start=0&_count=50&_filter=kontrak_host_kode%3D%3D'.$thisKey.'%26%26kontrak_tanggal%3E%3D'.$thisYear.'-01-01%26%26kontrak_tanggal%3C'.($thisYear + 1).'-01-01&_expand=yes&_view=json';
			$responRow 	= $this->getDataLemigas($url);
			foreach($responRow as $row){
				$nilai = $row['kontrak_nilai'];
				if ($row['kontrak_currency'] == 1)
					$nilai = $nilai * $this->pengaliDolar;
				
				$rows[] = array(
					'judul'			=> $row['kontrak_nama'],
					'noKontrak'		=> $row['kontrak_no'],
					'pelanggan'		=> $row['cust_nama'],
					'nilaiKontrak'	=> number_format($nilai,2),
				);
				@$total += $nilai;
			}
		}
		$return = array(
			'data' => @$rows,
			'responRow' => @$allData,
			'total' => number_format(@$total,2),
		);
		header('Content-Type: application/json');
		echo json_encode($return);
	}
	public function detailInvoice(){
		$rows = array();
		$thisKey = @$_POST['thisKey'] ?: 0;
		$thisYear = @$_POST['thisYear'] ?: 0;
		$satker = $_POST['thisSatker'] ?: 0;
		if ($satker == "p3gl"){
			## rekap kontrak
			$url 				= 'http://34.66.44.99/json/organization_issue?organization_id='.$thisKey.'&year='.$this->thisYear;
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			foreach($responRow as $row){
				$rows[] = array(
					'judul'			=> $row['agreement_title'],
					'noKontrak'		=> $row['agreement_number'],
					'pelanggan'		=> $row['client_name'],
					'nilaiInvoice'	=> number_format($row['issue_value_casted'],2),
				);
				@$total += $row['issue_value_casted'];
			}
		}
		else if ($satker == "p3tek"){
			## rekap kontrak
			$url 				= 'http://35.188.21.29/json/organization_issue?organization_id='.$thisKey.'&year='.$this->thisYear;
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			foreach($responRow as $row){
				$rows[] = array(
					'judul'			=> $row['agreement_title'],
					'noKontrak'		=> $row['agreement_number'],
					'pelanggan'		=> $row['client_name'],
					'nilaiInvoice'	=> number_format($row['issue_value_casted'],2),
				);
				@$total += $row['issue_value_casted'];
			}
		}
		else if ($satker == "lemigas"){
			$statusInv = 2;
			## rekap invoice
			// $url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_detail_invoice/?_start=0&_count=50&_filter=kontrak_host_kode%3D%3D'.$thisKey.'%26%26kontrak_tanggal%3E%3D'.$thisYear.'-01-01%26%26kontrak_tanggal%3C'.($thisYear + 1).'-01-01&_expand=yes&_view=json';
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_detail_invoice/?_start=0&_count=50&_filter=status%3D%3D'.$statusInv.'%26%26host_kode%3D%3D'.$thisKey.'%26%26inv_tgl%3E%3D'.$thisYear.'-01-01%26%26inv_tgl%3C'.($thisYear + 1).'-01-01&_expand=yes&_view=json';
			$allData 	= $this->getDataLemigas($url);
			foreach($allData as $row){
				$nilai = $row['inv_nilai'];
				if ($row['inv_currency'] == 1)
					$nilai = $nilai * $this->pengaliDolar;
				$rows[] = array(
					'judul'			=> $row['kontrak_nama'],
					'noKontrak'		=> $row['kontrak_no'],
					'pelanggan'		=> $row['cust_nama'],
					'nilaiInvoice'	=> number_format($nilai,2),
				);
				@$total += $nilai;
			}
			$statusInv = 3;
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_detail_invoice/?_start=0&_count=50&_filter=status%3D%3D'.$statusInv.'%26%26host_kode%3D%3D'.$thisKey.'%26%26inv_tgl%3E%3D'.$thisYear.'-01-01%26%26inv_tgl%3C'.($thisYear + 1).'-01-01&_expand=yes&_view=json';
			$allData 	= $this->getDataLemigas($url);
			foreach($allData as $row){
				$nilai = $row['inv_nilai'];
				if ($row['inv_currency'] == 1)
					$nilai = $nilai * $this->pengaliDolar;
				$rows[] = array(
					'judul'			=> $row['kontrak_nama'],
					'noKontrak'		=> $row['kontrak_no'],
					'pelanggan'		=> $row['cust_nama'],
					'nilaiInvoice'	=> number_format($nilai,2),
				);
				@$total += $nilai;
			}
		}
		$return = array(
			'data' => @$rows,
			'responRow' => @$allData,
			'total' => number_format(@$total,2),
			'url'  => $url
		);
		header('Content-Type: application/json');
		echo json_encode($return);
	}
	public function detailRealisasi(){
		$rows = array();
		$thisKey = @$_POST['thisKey'] ?: 0;
		$thisYear = @$_POST['thisYear'] ?: 0;
		$satker = $_POST['thisSatker'] ?: 0;
		if ($satker == "p3gl"){
			$url 				= 'http://34.66.44.99/json/deviation?organization_id='.$thisKey.'&year='.$this->thisYear;
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			foreach($responRow as $row){
				if ($row['payment_value_casted'] > 0)
				$rows[] = array(
					'judul'			=> $row['agreement_title'],
					'noKontrak'		=> $row['agreement_number'],
					'pelanggan'		=> $row['client_name'],
					'nilaiRealisasi'=> number_format($row['payment_value_casted'],2),
				);
				@$total += $row['payment_value_casted'];
			}
		}
		else if ($satker == "p3tek"){
			$url 				= 'http://35.188.21.29/json/organization_payment?organization_id='.$thisKey.'&year='.$this->thisYear;
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			foreach($responRow as $row){
				if ($row['payment_value_casted'] > 0)
				$rows[] = array(
					'judul'			=> $row['agreement_title'],
					'noKontrak'		=> $row['agreement_number'],
					'pelanggan'		=> $row['client_name'],
					'nilaiRealisasi'=> number_format($row['payment_value_casted'],2),
				);
				@$total += $row['payment_value_casted'];
			}
		}
		else if ($satker == 'tekmira'){
			// $thisKey
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/tabel_detail_realisasi';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$allData 			= @$responRow['data'];
			foreach($allData as $row){
				if ($row['kp3'] == $thisKey && floatval($row['realisasiKontrak']) > 0){
					$rows[] = array(
						'judul'			=> @$row['agreement_title'],
						'noKontrak'		=> $row['no_kontrak'],
						'pelanggan'		=> $row['nama_pelanggan'],
						'nilaiRealisasi'=> number_format($row['realisasiKontrak'],2),
					);
					@$total += $row['realisasiKontrak'];
				}
			}
		}
		else if ($satker == 'lemigas'){
			// $thisKey
			$statusInv = 3;
			$url 		= 'http://bsc.lemigas.esdm.go.id/api/webservice_bsc/v_ws_detail_invoice/?_start=0&_count=50&_filter=status%3D%3D'.$statusInv.'%26%26host_kode%3D%3D'.$thisKey.'%26%26inv_tgl_bayar%3E%3D'.$thisYear.'-01-01%26%26inv_tgl_bayar%3C'.($thisYear + 1).'-01-01&_expand=yes&_view=json';
			$allData 	= $this->getDataLemigas($url);
			foreach($allData as $row){
				$nilai = $row['inv_nilai'];
				if ($row['inv_currency'] == 1)
					$nilai = $nilai * $this->pengaliDolar;
				$rows[] = array(
					'judul'			=> @$row['kontrak_nama'],
					'noKontrak'		=> $row['kontrak_no'],
					'pelanggan'		=> $row['cust_nama'],
					'nilaiRealisasi'=> number_format($nilai,2),
				);
				@$total += $nilai;
			}
		}
		$return = array(
			'data' => @$rows,
			'responRow' => @$allData,
			'total' => number_format(@$total,2),
			'url'  => $url
		);
		header('Content-Type: application/json');
		echo json_encode($return);
	}
	
	
	public function getDataLemigas($url){
		
		$thisRow = $this->lemigasOnly($url);
		@$arrHasil = $thisRow[0];
		@$nextPage = $thisRow[1];
		while(@$nextPage != ''){
			$thisRow = $this->lemigasOnly($nextPage);
			$arrHasil = array_merge($arrHasil, $thisRow[0]);
			$nextPage = $thisRow[1];
		}
		return ($arrHasil);
	}
	public function lemigasOnly($url, $arrHasil=array()){
		$thisRow = array();
		$return = array();
		$awal = array();
		$method 			= 'GET';
		$responsedet 		= ngeCurl($url, array(), $method);
		$responRow	 		= json_decode($responsedet['response'],true);
		$awal = $responRow['restify'];
		if (@$awal['rows']){
			foreach($awal['rows'] as $row){
				$newArray = array();
				foreach($row['values'] as $key=>$val){
					$newArray = array_merge($newArray,array($key => $val['value']));
				}
				$thisRow[] = $newArray;
			}
			$return = array_merge($arrHasil, $thisRow);
			$nextPage = @$awal['nextPage']['href'];
		}
		
		return array($return, @$nextPage);
	}
	
	public function raw_rekap(){
        $satker = 'tekmira';
        $tekmira = $this->getRekap_form_c($satker);
        foreach($tekmira['tableRekap'] as $kp3 => $val){
            $dataInsert[] = array(
                'tgl' => date('Y-m-d'),
                'satker' => $satker,
                'kp3' => $kp3,
                'terkontrak' => @$val['terkontrak'] == '1' ? '0' : @$val['terkontrak'],
                'inv' => @$val['inv'] == '1' ? '0' : @$val['inv'],
                'realisasi' => @$val['realisasi'] == '1' ? '0' : @$val['realisasi'],
            );
        }
        
        $satker = 'p3tek';
        $p3tek = $this->getRekap_form_c($satker);
        foreach($p3tek['tableRekap'] as $kp3 => $val){
            $dataInsert[] = array(
                'tgl' => date('Y-m-d'),
                'satker' => $satker,
                'kp3' => $kp3,
                'terkontrak' => @$val['terkontrak'] == '1' ? '0' : @$val['terkontrak'],
                'inv' => @$val['inv'] == '1' ? '0' : @$val['inv'],
                'realisasi' => @$val['realisasi'] == '1' ? '0' : @$val['realisasi'],
            );
        }
        
        $satker = 'p3gl';
        $p3gl = $this->getRekap_form_c($satker);
        foreach($p3gl['tableRekap'] as $kp3 => $val){
            $dataInsert[] = array(
                'tgl' => date('Y-m-d'),
                'satker' => $satker,
                'kp3' => $kp3,
                'terkontrak' => @$val['terkontrak'] == '1' ? '0' : @$val['terkontrak'],
                'inv' => @$val['inv'] == '1' ? '0' : @$val['inv'],
                'realisasi' => @$val['realisasi'] == '1' ? '0' : @$val['realisasi'],
            );
        }
        
        $satker = 'lemigas';
        $lemigas = $this->getRekap_form_c($satker);
        foreach($lemigas['tableRekap'] as $kp3 => $val){
            $dataInsert[] = array(
                'tgl' => date('Y-m-d'),
                'satker' => $satker,
                'kp3' => $kp3,
                'terkontrak' => @$val['terkontrak'] == '1' ? '0' : @$val['terkontrak'],
                'inv' => @$val['inv'] == '1' ? '0' : @$val['inv'],
                'realisasi' => @$val['realisasi'] == '1' ? '0' : @$val['realisasi'],
            );
        }
        
        $raw_rekap = $this->dash->raw_rekap($dataInsert);
        print_r($raw_rekap); 
    }
    
    function getNotif($tgl=''){
		$this->load->library('email');
		$this->load->helper('sending');
        
        $tgl = ($tgl == "" ? date('Y-m-d') : $tgl);
		$getNotif = $this->dash->getNotif($tgl);
		
		// print_r($getNotif); die;
        if (count($getNotif) > 0){
            $tgl = date('d F Y', strtotime($tgl));
            
            $table = '<table width="100%" border="1">
                <tr>
                    <th>No</th>
                    <th>Satker</th>
                    <th>KP3</th>
                    <th>Penambah Terkontrak</th>
                    <th>Penambah Invoice</th>
                    <th>Penambah Realiasi</th>
                </tr>
            <tbody>'; 
            $no = 0;
            foreach($getNotif as $row){
                $no++;
                $table .= '<tr>
                    <td>'.$no.'</td>
                    <td>'.$row['satker'].'</td>
                    <td>'.$row['kp3'].'</td>
                    <td align="right">'.number_format($row['selisih_terkontrak'],2).'</td>
                    <td align="right">'.number_format($row['selisih_inv'],2).'</td>
                    <td align="right">'.number_format($row['selisih_realisasi'],2).'</td>
                </tr>';
            }
            $table .= '</tbody></table>';
            $message = '<html><body>';
            $message .= '<p>Berikut Update Progress</p>';
            $message .= $table;
            $message .= '</body></html>';

			$res = Notification::sending('Update Progres BSC BALITBANG ESDM, Tanggal '.$tgl ,$message,'suvi.7888@gmail.com');

			// print_r($res); die;

            // $cek = $this->email->send();
            if($res){
                echo 'Your mail has been sent successfully.';
            } else{
                echo 'Unable to send email. Please try again.';
            }
        }
        // print_r($getNotif);
    }
}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
