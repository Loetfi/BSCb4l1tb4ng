<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function webCurl($url, $dataArray = array(), $method='GET' ){
	$ci =& get_instance();

	$dataPost = http_build_query($dataArray);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_PORT => "",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 60,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded"
		),

		CURLOPT_URL => $url,
		CURLOPT_POSTFIELDS => $dataPost,
		CURLOPT_CUSTOMREQUEST => $method,

	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	return array(
		'response' => $response,
		'err' => $err,
	);
}

function linkservice($services){
	$BACKEND   = ('BACKEND' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/adms/' : ''; 
	$ACCOUNT = ('ACCOUNT' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/akun/' : '';  
	$NOTIF     = ('NOTIF' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/notif/' : '';  
	$TAKSASI   =  ('TAKSASI' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/taksasi/' : '';  
	$FRONTEND   = ('FRONTEND' == strtoupper($services)) ? $return = 'https://ibid.co.id/' : ''; 
	$HANDOVER   = ('HANDOVER' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/handover/' : ''; 
	$STOCK     = ('STOCK' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/stok/' : ''; 
	$MASTER   = ('MASTER' == strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/masterdata/' : ''; 
	$FINANCE   = ('FINANCE' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/finance/' : ''; 
	$NPL      = ('NPL' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/service/npl/' : ''; 
	$CMS    = ('CMS' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/dapur/' : '';  

	$AMSSCHEDULE    = ('AMSSCHEDULE' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/serviceams/schedule/api/' : ''; 
	$AMSSTOCK    = ('AMSSTOCK' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/serviceams/stock/api/' : ''; 
	$AMSAUTOBID    = ('AMSAUTOBID' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/serviceams/autobid/api/' : '';
	$AMSLOT    = ('AMSLOT' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/serviceams/lot/api/' : ''; 
	$IMG_PATH = ('IMGS' === strtoupper($services)) ? $return = 'http://img.ibid.astra.co.id/uploads/upload360/' : '';
    $AMSLOT2    = ('AMSLOT2' === strtoupper($services)) ? $return = 'https://ibid.co.id/backend/serviceams/lot/' : '';
	
	return $return;
}
