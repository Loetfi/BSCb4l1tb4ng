<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diff extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('auth_model','auth');
		
		$this->load->model('Dashboard_model','dash');
		
		if (!$_POST) { check_login('dashboard'); }
	}


	public function index(){
		$data = array(
			'title' => 'Difference Value Date' ,
			'page'	=> 'difference'
		);
		$data['script_file'] = 'script_diff';
		
		$tgl = @$_GET['tgl'];
		$tgl = ($tgl == "" ? date('Y-m-d') : $tgl);
		$data['tgl'] = $tgl;
		
		$getNotif = $this->dash->getNotif($tgl);
		$data['getNotif'] = $getNotif;
		
		$data['tanggal'] = date('d M Y', strtotime($tgl));
		
		/* 
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
		*/
		
		$this->load->view('template/header-content', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	
}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
