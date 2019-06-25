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

		if (!$_POST) {
			check_login('dashboard');	
		}
		
		$this->pembagi = 1000000000;
		// $this->pembagi = 1;
		$this->satuan = ' M';
		$this->thisYear = date('Y');
		$this->lastYear = date('Y')-1;
	}



	

	public function index(){
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
	
	public function form_a(){
		$data['title'] = 'Realisasi Penerimaan VS Target PNBP BLU ('.date('d F Y').')-Form A';
		$data['page'] = 'form_a';
		
		for($i=1; $i<=12; $i++) 
			$bulanan[] = date('M', strtotime($i.'/20/2019'));
		$data['bulanan'] = $bulanan;
		
		$data['getRekap_form_a'] = $this->getRekap_form_a();
		$data['getGrafik_form_a'] = $this->getGrafik_form_a();
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	public function form_b($satKer = 'p3tek'){
		$data['title'] = 'Kurva S '.strtoupper($satKer).' ('.date('d F Y').')-Form B';
		$data['page'] = 'form_b';
		$data['satKer'] = $satKer;
		
		for($i=1; $i<=12; $i++) 
			$bulanan[] = date('M', strtotime($i.'/20/2019'));
		$data['bulanan'] = $bulanan;
		
		$data['getRekap_form_a'] = $this->getRekap_form_a($satKer);
		$data['getGrafik_form_a'] = $this->getGrafik_form_a($satKer);
		$data['getRekap_form_b'] = $this->getRekap_form_b($satKer);
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);

	}
	public function form_c($satKer = 'p3tek'){
		$data['title'] = 'Table Detail '.strtoupper($satKer).' ('.date('d F Y').')-Form C';
		$data['page'] = 'form_c';
		$data['satKer'] = $satKer;
		
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		for($i=1; $i<=12; $i++) 
			$bulanan[] = date('M', strtotime($i.'/20/2019'));
		$data['bulanan'] = $bulanan;
		
		$data['getRekap_form_a'] = $this->getRekap_form_a($satKer);
		$data['getGrafik_form_a'] = $this->getGrafik_form_a($satKer);
		$data['getRekap_form_c'] = $this->getRekap_form_c($satKer);
		$data['pembagi'] = $this->pembagi;
		$data['satuan'] = $this->satuan;
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);

	}
	
	function getDataSatker(){
		// http://localhost:55/04.Project/ESDM/BSCb4l1tb4ng/index.php/dashboard/getDataSatker
		$rekap = $this->detailTerkontrak('lemigas');
		print_r($rekap);
		echo "\n";
		echo "#############################################";
		die();
		
		$rekap = $this->getRekap_form_a('p3tek');
		print_r($rekap);
		echo "\n";
		echo "#############################################";
	}
	
	function getRekap_form_a($satKer = 'All'){
		$realisasi 		= 0;
		$kontrakSatker 	= 0;
		$targetSatker 	= 1;
		$targetBulan  	= 1;
		$pembagi 		= $this->pembagi;
		$satuan  		= $this->satuan;
		
		if ($satKer == 'All' || $satKer == 'p3tek'){
			## p3tek
			$targetSatker = 1980000000;
			$targetBulan =   400000000;
			$url 				= 'http://suvisanusi.com/bscp3tek/forma/rekap.php?tahun='.$this->thisYear;
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/forma/rekap.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$realisasiSatker 	= @$dataRow['realisasi'];
			$dataSatker[] = array(
				'Unit Kerja'		=> 'BLE',
				'Target'			=> number_format($targetSatker/$pembagi,2).$satuan,
				'Target Bulan Ini'	=> number_format($targetBulan/$pembagi,2).$satuan,
				'Target (%)'		=> number_format($targetBulan/$targetSatker * 100,2),
				'Realisasi'			=> number_format($realisasiSatker/$pembagi,2).$satuan,
				'Realisasi(%)'		=> number_format($realisasiSatker/$targetBulan * 100,2),
				'Sisa'				=> number_format(($targetBulan - $realisasiSatker)/$pembagi,2).$satuan,
				'Sisa(%)'			=> number_format((100 -($realisasiSatker/$targetBulan * 100)),2),
			);
			@$realisasi += $realisasiSatker;	
		}
		
		if ($satKer == 'All' || $satKer == 'lemigas'){
			## BLM
			$targetSatker = 187333000000;
			$targetBulan =   27000000000;
			
			// kontrak
			$url 				= 'http://34.80.224.123/json/agreement?year='.$this->thisYear.'&group=organization&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$kontrakSatker 		= @$dataRow['value_casted'];
			
			$url 				= 'http://34.80.224.123/json/payment?year='.$this->thisYear.'&group=organization&time=yearly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			$realisasiSatker 	= @$dataRow['value_casted'];
			$dataSatker[] = array(
				'Unit Kerja'		=> 'BLM',
				'Target'			=> number_format($targetSatker/$pembagi,2).$satuan,
				'Target Bulan Ini'	=> number_format($targetBulan/$pembagi,2).$satuan,
				'Target (%)'		=> number_format($targetBulan/$targetSatker * 100,2),
				'Realisasi'			=> number_format($realisasiSatker/$pembagi,2).$satuan,
				'Realisasi(%)'		=> number_format($realisasiSatker/$targetBulan * 100,2),
				'Sisa'				=> number_format(($targetBulan - $realisasiSatker)/$pembagi,2).$satuan,
				'Sisa(%)'			=> number_format((100 -($realisasiSatker/$targetBulan * 100)),2),
			);
			@$realisasi += $realisasiSatker;
		}
		
		if ($satKer == 'All'){
			$targetTahunan = 30564000000;
			$targetBulanIni = 6000000000;
		} else {
			$targetTahunan = @$targetSatker;
			$targetBulanIni = @$targetBulan;
		}
		$persenTarget = number_format(@$targetBulanIni/$targetTahunan * 100,2);
		$persenBulanIni = number_format(@$realisasi/$targetBulanIni * 100,2);
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
	function getGrafik_form_a($satKer = 'All'){
		$AkumulasiRealiasi = null;
		$AkumulasiRealiasiTahunLalu = null;
		
		$data = array();
		$dataSeries = array();
		if ($satKer == 'All' || $satKer == 'p3tek'){
			## p3tek
			$url 				= 'http://suvisanusi.com/bscp3tek/forma/grafik.php?tahun='.$this->thisYear;
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/forma/grafik.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)$row['bulan'];
				$dataSatker[$bulan] = $row;
			}
			for($i=1; $i<=12; $i++){
				if (@$dataSatker[$i]['target'] > 0) 			{ @$data['target'][$i-1] 				+= @$dataSatker[$i]['target'];            } else { @$data['target'][$i-1]				+= null; }
				if (@$dataSatker[$i]['potensi'] > 0)			{ @$data['potensi'][$i-1] 				+= @$dataSatker[$i]['potensi'];           } else { @$data['potensi'][$i-1]				+= null; }
				if (@$dataSatker[$i]['realisasi'] > 0)			{ @$data['realisasi'][$i-1] 			+= @$dataSatker[$i]['realisasi'];         } else { @$data['realisasi'][$i-1]			+= null; }
				if (@$dataSatker[$i]['nilaiKontrak'] > 0)		{ @$data['nilaiKontrak'][$i-1] 			+= @$dataSatker[$i]['nilaiKontrak'];      } else { @$data['nilaiKontrak'][$i-1]			+= null; }
				if (@$dataSatker[$i]['realiasiTahunLalu'] > 0)	{ @$data['realiasiTahunLalu'][$i-1] 	+= @$dataSatker[$i]['realiasiTahunLalu']; } else { @$data['realiasiTahunLalu'][$i-1]	+= null; }
				
				$AkumulasiRealiasi += @$dataSatker[$i]['realisasi'];
				@$data['AkumulasiRealiasi'][$i-1] 	+= $AkumulasiRealiasi;
				
				$AkumulasiRealiasiTahunLalu += @$dataSatker[$i]['realiasiTahunLalu'];
				@$data['AkumulasiRealiasiTahunLalu'][$i-1] 	+= $AkumulasiRealiasiTahunLalu;
			}
		}
		
		if ($satKer == 'All' || $satKer == 'lemigas'){
			## kontrak
			$url 				= 'http://34.80.224.123/json/agreement?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$bulan = (int)@$row['month'];
				$KontrakSatker[$bulan] = @$row;
			}
			
			## Pencapaian this year
			$url 				= 'http://34.80.224.123/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
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
			$url 				= 'http://34.80.224.123/json/payment?year='.$this->lastYear.'&group=group&time=monthly&source=organization';
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
				@$data['AkumulasiRealiasi'][$i-1] 	+= $AkumulasiRealiasi;
				
				$AkumulasiRealiasiTahunLalu += @$dataLastYear[$i]['value_casted'];
				@$data['AkumulasiRealiasiTahunLalu'][$i-1] 	+= $AkumulasiRealiasiTahunLalu;
			}
		}
		
		
		## olah grafik
		$dataSeries[] = array( 'name' => 'target', 'data' => @$data['target'] );
		$dataSeries[] = array( 'name' => 'potensi', 'data' => @$data['potensi'] );
		$dataSeries[] = array( 'name' => 'realisasi', 'data' => @$data['realisasi'], 'type' => 'column' );
		$dataSeries[] = array( 'name' => 'Akumulasi Realiasi', 'data' => @$data['AkumulasiRealiasi'] );
		$dataSeries[] = array( 'name' => 'realiasi TahunLalu', 'data' => @$data['realiasiTahunLalu'] );
		$dataSeries[] = array( 'name' => 'realiasi Akumulasi Lalu', 'data' => @$data['AkumulasiRealiasiTahunLalu'] );
		
		$dataReturn = array(
			'table' => @$data,
			'dataSeries' => @$dataSeries,
			// 'dataRow' => @$dataRow,
		);
		return $dataReturn;
	}
	function getRekap_form_b($satker){
		$dataReturn = array();
		$pembagi = $this->pembagi;
		$satuan = $this->satuan;
		
		if ($satker == "p3tek"){
			$url 				= 'http://suvisanusi.com/bscp3tek/formb/table.php?tahun='.$this->thisYear;
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/formb/table.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$realisasiKp3 	= @$row['realisasi'];
				$dataReturn[] = array(
					'Unit Kerja'		=> $row['kp3'],
					'Target'			=> $row['target'],
					'Target Bulan Ini'	=> $row['targetBulanIni'],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
			}
		}
		else if ($satker == "lemigas"){
			$url 				= 'http://34.80.224.123/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/formb/table.php?tahun=2019';
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
					'Target'			=> @$target[$kp3],
					'Target Bulan Ini'	=> @$targetBulanIni[$kp3],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
			}
		}
		else if ($satker == "tekmira"){
			$url 				= 'https://layanan.tekmira.esdm.go.id/emonev/restapi/tabel_kiri';
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/formb/table.php?tahun=2019';
			$method 			= 'POST';
			$responsedet 		= ngeCurl($url, array('tahun' => $this->thisYear), $method);
			// $responsedet['response'] = str_replace('{"kp3":"PEMANFAATAN ASET","target":"700000000","targetBulanIni":0,"realisasi":"261.468.000"}','',$responsedet['response']);
			// $responsedet['response'] = str_replace('},]}','}]}',$responsedet['response']);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			foreach($dataRow as $row){
				$realisasiKp3 	= str_replace('.','',@$row['realisasi']);
				$dataReturn[] = array(
					'Unit Kerja'		=> $row['kp3'],
					'Target'			=> number_format($row['target']/$pembagi,2).$satuan,
					'Target Bulan Ini'	=> $row['targetBulanIni'],
					'Target (%)'		=> null,
					'Realisasi'			=> number_format($realisasiKp3/$pembagi,2).$satuan,
					'Realisasi(%)'		=> null,
					'Sisa'				=> null,
					'Sisa(%)'			=> null,
				);
			}
		}
		return $dataReturn;
	}
	function getRekap_form_c($satker){
		$arrOrgId = array();
		$dataReturn = array();
		$pembagi = $this->pembagi;
		$satuan = $this->satuan;
		
		if ($satker == "p3tek"){
			$arrKp3 = array();
			$url 				= 'http://suvisanusi.com/bscp3tek/formc/table.php?tahun='.$this->thisYear;
			// $url 				= 'http://localhost:55/04.Project/ESDM/BSC_API/bscp3tek/formc/table.php?tahun=2019';
			$method 			= 'GET';
			$responsedet 		= ngeCurl($url, array(), $method);
			$responRow	 		= json_decode($responsedet['response'],true);
			$dataRow 			= @$responRow['data'];
			
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
			}
			$dataReturn = array(
				'tableRekap' => $tableRekap,
				'dataTable' => $dataTable,
				'arrKp3' 	=> $arrKp3,
				'arrOrgId' 	=> @$arrOrgId,
			);
		}
		else if ($satker == "lemigas"){
			$arrKp3 = array();
			## rekap kontrak
			$url 				= 'http://34.80.224.123/json/agreement?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
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
			}
			
			## rekap invoice
			$url 				= 'http://34.80.224.123/json/issue?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
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
			}
			## rekap invoice
			$url 				= 'http://34.80.224.123/json/payment?year='.$this->thisYear.'&group=group&time=yearly&source=organization';
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
			}
			
			$url 				= 'http://34.80.224.123/json/payment?year='.$this->thisYear.'&group=group&time=monthly&source=organization';
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
			);
		}
		return $dataReturn;
	}


	public function detailTerkontrak(){
		$rows = array();
		$thisKey = @$_POST['thisKey'] ?: 0;
		$thisYear = @$_POST['thisYear'] ?: 0;
		$satker = $_POST['thisSatker'] ?: 0;
		if ($satker == "lemigas"){
			## rekap kontrak
			$url 				= 'http://34.80.224.123/json/income?organization_id='.$thisKey.'&year='.$this->thisYear;
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
			}
		} else {
			
		}
		$return = array(
			'data' => @$rows
		);
		header('Content-Type: application/json');
		echo json_encode($return);
	}
	
	public function detailRealisasi(){
		$rows = array();
		$thisKey = @$_POST['thisKey'] ?: 0;
		$thisYear = @$_POST['thisYear'] ?: 0;
		$satker = $_POST['thisSatker'] ?: 0;
		if ($satker == "lemigas"){
			$url 				= 'http://34.80.224.123/json/income?organization_id='.$thisKey.'&year='.$this->thisYear;
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
			}
		} else {
			
		}
		$return = array(
			'data' => @$rows
		);
		header('Content-Type: application/json');
		echo json_encode($return);
	}
	
	
}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
