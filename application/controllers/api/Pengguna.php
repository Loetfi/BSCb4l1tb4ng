<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('branch_model');
	}

	public function index()
	{
		try {
			cekmethod('get');
			$urls = 'http://localhost/projekan/bsc/index.php/api/pengguna_reciever/receiver';
			$data = array('username' => 'oke','login_id'=>25);
			$method='POST';
			
			$branchs = $this->branch_model->getAll();
			// 192.168.1.123 , 192.168.1.122 , 192.168.1.132
			$branchs = array(['ip_address' => 'http://bsc1.awanesia.com']);
			foreach ($branchs as $branch) {
				$res[] =  $branch['ip_address'].'/index.php/api/pengguna_receiver/receiver';
				// $res[] =  'http://192.168.1.100/projekan/bsc/index.php/api/pengguna_reciever/receiver';
				// $res[] = RestCurl::HitAPI($url , $data , $method);
			}

			print_r($res);

			
			


		} catch (Exception $e) {
			
		}
		
	}

	

}

/* End of file Pengguna.php */
/* Location: ./application/controllers/api/Pengguna.php */
