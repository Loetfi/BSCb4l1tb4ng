<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Auth extends CI_Controller {

		public function __construct()
		{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->load->model('auth_model','auth');
		}

		public function index()
		{ 
			// print_r($_SESSION);
			$ada = $this->session->userdata('username') ? redirect('','refresh') : '';
			$data = array(
				'title' => 'Login',
				'message'	=> $this->session->flashdata('message')
			);
			$this->load->view('template/header_auth', $data, FALSE);
			$this->load->view('auth/login', $data, FALSE);
			$this->load->view('template/footer_auth', $data, FALSE);
		} 

		public function proses()
		{ 
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

//die('oe');
			if ($this->form_validation->run()==TRUE) {

				$parameter = array(
					'username'	=> ($this->input->post('username') !== null ) ? $this->input->post('username') : 0,
					'password'	=> ($this->input->post('password') !== null ) ? $this->input->post('password') : 0
				);

				if ($this->session->userdata('referrer_url') !== null ) {
					$referer = $this->session->userdata('referrer_url');
				} else { 
					$referer = '/';
				}

				($this->auth->login($parameter)) ? redirect($referer,'refresh') : redirect('login','refresh');

			} else { 

				redirect('login','refresh');

			}

		}

	/*
	* for logout user
	*/

	public function logout()
	{ 
		$this->session->set_flashdata('message', 'Berhasil keluar dari sistem');
		$this->session->sess_destroy();
		redirect(site_url('login'),'refresh');
	}

	/*
	* register
	*/
	public function register()
	{
		$data = array(
			'username'		=> 'staffsjh1_1@admin.com',
			// 'username'		=> 'kasjh1_1@admin.com',
			'password'		=> sha1('password'),
			'status'		=> 1,
			'direct_boss'	=> 7,
			'login_access_id'	=> 1, // hak akses sistem
			'create_date'	=> date('Y-m-d H:i:s'),
			'name'			=> 'KA SJH 1.1'
		);
		$this->db->insert('login', $data);
	}


}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
