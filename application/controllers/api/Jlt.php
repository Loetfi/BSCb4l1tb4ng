<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jlt extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('target_model','target');
		$this->load->model('struktur_model','struktur');
		$this->load->model('jlt_model');
	}
	
	
}