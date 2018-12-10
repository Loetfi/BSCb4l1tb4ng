<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$dotenv = new Dotenv\Dotenv(APPPATH."../");
$dotenv->load();

class Pengguna extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('branch_model');
	}

	public function index()
	{
		try {
			cekmethod('post');
			$urls = getenv("URL_BSC").'api/pengguna_reciever/receiver';
			// $urls = 'api/pengguna_reciever/receiver';
			$data = $this->input->post();
			$method='POST';
			
			$branchs = $this->branch_model->getAll();
			// 192.168.1.123 , 192.168.1.122 , 192.168.1.132
			// $branchs = array(['ip_address' => 'http://bsc1.awanesia.com']);
			foreach ($branchs as $branch) {
				$url =  $branch['ip_address'].'/index.php/api/pengguna_reciever/receiver';
				// $res[] =  'http://192.168.1.100/projekan/bsc/index.php/api/pengguna_reciever/receiver';
				$res[] = RestCurl::HitAPI($url , $data , $method);
			}

			print_r([$res, $data]);

			
			


		} catch (Exception $e) {
			
		}
		
	}

	

}

/* End of file Pengguna.php */
/* Location: ./application/controllers/api/Pengguna.php */
