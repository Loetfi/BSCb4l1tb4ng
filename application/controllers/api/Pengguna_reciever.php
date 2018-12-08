<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_reciever extends CI_Controller {

	public function receiver()
	{
		try {
			// cari id table login dahulu, jika tidak ada maka insert tidak dilakukan
			$this->load->model('pengguna_model');
			$id = $this->input->post('login_id') ? $this->input->post('login_id') : 1;
			// die();
			// print_r($this->pengguna_model->get_id($id)); die();

			if ($this->pengguna_model->get_id($id)==false) {

				$insert = array(
					'username' =>  $this->input->post('username'),
					'password' =>  sha1($this->input->post('password')),
					'status' =>  $this->input->post('status'),
					'create_date' =>  $this->input->post('create_date'),
					'modify_date' =>  $this->input->post('modify_date'),
					'name' =>  $this->input->post('name'),
					'email' =>  $this->input->post('email'),
					'branch_id' =>  $this->input->post('branch_id')
				);
				$this->db->insert('login', $insert);
				admsapi(200 , 1, 'Berhasil', []);

			} else {
				admsapi(400 , 0, 'Gagal insert pada server '.site_url().' , karena data sudah ada', []);
			}

		} catch (Exception $e) {
			
		}
		
	}

}

/* End of file Pengguna_reciever.php */
/* Location: ./application/controllers/api/Pengguna_reciever.php */
