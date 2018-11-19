<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function login($parameter)
	{  
		/* cari data pengguna */
		$username = $parameter['username'];
		$password = sha1($parameter['password']); // encrypt type sha1

		$get_user = $this->db->select('*')->from('login')->where('username',$username)->where('password',$password)->get()->row_array();

		if (isset($get_user['username'])) {
			/*add login data*/
			$array = array(
				'login_id'	=> $get_user['login_id'],
				'username'	=> $get_user['username'],
				'password'	=> $get_user['password'],
				'direct_boss'	=> $get_user['direct_boss'],
				'login_access_id'	=> $get_user['login_access_id'],
				'name'	=> $get_user['name'],
				'id_flow'	=> $get_user['id_flow']
			); 
			$this->session->set_userdata( $array );
			/*end*/

			return true;
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Pengguna tidak ditemukan</div>');
			return false;  //
		} 
	}
	

	/*
	* untuk daftar
	*/

	public function register()
	{
		$data = array(
			// 'username'		=> 'staffsjh11@admin.com',
			'username'		=> 'migas@admin.com',
			'password'		=> sha1('password'),
			'status'		=> 1,
			'direct_boss'	=> 1,
			'login_access'	=> 1, // hak akses sistem
			'create_date'	=> date('Y-m-d H:i:s'),
			'name'			=> 'Migas'
		);
		$this->db->insert('login', $data);
	}

}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
