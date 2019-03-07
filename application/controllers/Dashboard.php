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
	
    public function lemigas(){
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
	
}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
