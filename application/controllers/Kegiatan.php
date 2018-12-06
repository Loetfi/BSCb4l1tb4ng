<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('auth_model','auth');
		check_login('dashboard');
	}


	public function index(){
		$data = array(
			'title' => 'Master Kegiatan' ,
			'page'	=> 'master/kegiatan'
		);
		
		$data['tahun'] = $this->keg->getTahunKegiatan();
		$data['getAllKegiatan'] = $this->keg->getAllKegiatan();
		// print_r($data['getAllKegiatan']); die();
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function add(){
		$data = array(
			'title' => 'Tambah Master Kegiatan' ,
			'page'	=> 'master/kegiatan_add'
		);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	function addProcess(){
		$nama_keg = @$_POST['nama_keg'];
		$tahun_target = @$_POST['tahun_target'];
		$bulan_target = @$_POST['bulan_target'];
		$status = 'Aktif';
		$cdate = time();
		$cuser = 1;
		
		$arr = array(
			'nama_keg' => $nama_keg,
			'tahun' => $tahun_target,
			'status' => $status,
			'cdate' => $cdate,
			'cuser' => $cuser,

		);
		if($this->keg->insertKegiatan($arr)) {
			$id_keg = $this->db->insert_id();
			
			$arrTarget = array(
				'id_keg' => $id_keg,
				'id_target' => $bulan_target,
				'tahun' => $tahun_target,
				'status' => 'Aktif',
				'cdate' => $cdate,
				'cuser' => $cuser,
			);
			
			$this->keg->insertKegiatanTarget($arrTarget);
			
			$data = array(
				'status' => 1,
				'message' => 'Berhasil',
				'data' => array(
					'id_keg' => $id_keg,
				)
			);
			
			$namaFolder = 'Kegiatan_'.$id_keg;
			mkdir("uploads/".$namaFolder, 0755, true);
		}
		else {
			$data = array(
				'status' => 0,
				'message' => 'Gagal Insert Kegiatan',
				'data' => array()
			);
		}
		
		
		
		echo json_encode($data);
	}
	
	function detail($idKeg){
		$data = array(
			'title' => 'Detail Master Kegiatan' ,
			'page'	=> 'master/kegiatan_detail'
		);
		
		$data['detail'] = $this->keg->detail($idKeg);
		$data['logTarget'] = $this->keg->logTarget($idKeg);
		
		$idxLog = 0;
		$arrIdLog = array();
		$logKegiatan = $this->keg->logKegiatan($idKeg);
		foreach($logKegiatan as $row){
			$id_log = $row['id_log'];
			if(!in_array($id_log, $arrIdLog))
				$arrIdLog[] = $id_log;
			
			$tanggal = date('d M Y', strtotime($row['tanggal']));
			$waktu = date('H:i:s', strtotime($row['tanggal']));
			
			$file_nameasli = explode(';',$row['file_asli']);
			$file_pendukung = explode(';',$row['file_pendukung']);
			for($i=0; $i<count($file_pendukung) -1; $i++){ 
				$namaFile = $file_pendukung[$i]; 
				$namaFileAsli = $file_nameasli[$i]; 
				
				$file[$i]['namaFile'] = $namaFile;
				$file[$i]['namaFileAsli'] = $namaFileAsli;
			}
			
			$allLogKegiatan[$idxLog] = $row;
			$allLogKegiatan[$idxLog]['tanggal'] = $tanggal;
			$allLogKegiatan[$idxLog]['waktu'] = $waktu;
			$allLogKegiatan[$idxLog]['file'] = $file;
			$idxLog++;
		}
		$data['allLogKegiatan'] = @$allLogKegiatan;
		// print_r($allLogKegiatan); die();
		
		$idxLog = 0;
		$arrIdLog = array();
		$logAnggota = $this->keg->logAnggota($idKeg);
		foreach($logAnggota as $row){
			$id_log = $row['id_log'];
			$allLogAnggota[$id_log][] = array(
				'jabatan' => $row['jabatan'],
				'nama_peserta' => $row['nama_peserta'],
			);
		}
		$data['allLogAnggota'] = @$allLogAnggota;
		// print_r($allLogAnggota); die();
		
		// die();
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function addLog($idKeg){
		$data = array(
			'title' => 'Tambah Log Kegiatan' ,
			'page'	=> 'master/kegiatan_log'
		);
		
		$data['detail'] = $this->keg->detail($idKeg);
		$data['logTarget'] = $this->keg->logTarget($idKeg);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}
	
	function addLogProcess(){
		$cdate = time();
		
		$id_keg = @$_POST['id_keg'];
		$judul_kegiatan = @$_POST['judul_kegiatan'];
		$hasil_kegiatan = @$_POST['hasil_kegiatan'];
		$lokasi = @$_POST['lokasi'];
		$tanggal = @$_POST['tanggal'];
		$waktu = @$_POST['waktu'];
		$YmdHis = date('Y-m-d H:i:s', strtotime($tanggal.' '.$waktu));
		
		$namaFolder = 'Kegiatan_'.$id_keg;
		
		## UNTUK UPLOAD FILE 
		$config = array();
		$config['upload_path'] = './uploads/'.$namaFolder;
		$config['allowed_types'] = '*';
		$config['max_size']      = '0';
		$config['overwrite']     = true;
		
		$files = $_FILES;
		for($i=0; $i < count($files['uploadfile']['name']); $i++){
			if ($files['uploadfile']['error'][$i] == 0){
				$_FILES['userfile']['name']= $files['uploadfile']['name'][$i];
				$_FILES['userfile']['type']= $files['uploadfile']['type'][$i];
				$_FILES['userfile']['tmp_name']= $files['uploadfile']['tmp_name'][$i];
				$_FILES['userfile']['error']= $files['uploadfile']['error'][$i];
				$_FILES['userfile']['size']= $files['uploadfile']['size'][$i];
				
				$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
				$cekPhoto = $_FILES['userfile']['tmp_name'];
				
				## random text
				$seed = str_split('abcdefghijklmnopqrstuvwxyz'
					.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
				 .'0123456789'); // and any other characters
				shuffle($seed);
				$rand = '';
				foreach (array_rand($seed, 10) as $k){
					$rand .= $seed[$k];
				}
				$file_name= $cdate.'_'.$rand;
				$config['file_name'] = $file_name;
				$uploadFileName = $config['file_name'].".".$ext;
				$this->load->library('upload', $config);
				
				$this->upload->initialize($config);
				if (!$this->upload->do_upload()){
					$salah = $this->upload->display_errors();
					print_r($salah);
				} else {
					@$file_pendukung .= $uploadFileName.';';
					@$file_nameasli .= $_FILES['userfile']['name'].';';
				}
			}
		}
		
		
		$asd = '';
		$dataInsert = array(
			'id_keg' => $id_keg,
			'tanggal' => $YmdHis,
			'lokasi' => $lokasi,
			'judul_kegiatan' => $judul_kegiatan,
			'hasil_kegiatan' => $hasil_kegiatan,
			'file_pendukung' => $file_pendukung,
			'file_asli' => $file_nameasli,
			'status' => 'Done',
			'cdate' => $cdate,
		);
		if($this->keg->insertKegiatanLog($dataInsert)) {
			
			// insert anggota
			$id_log = $this->db->insert_id();
			$nama_peserta = @$_POST['nama_peserta'];
			$jabatan = @$_POST['jabatan'];
			for($i=0; $i<count($nama_peserta); $i++){
				$kegiatan_anggota = array(
					'id_log' => $id_log,
					'nama_peserta' => @$nama_peserta[$i],
					'jabatan' => @$jabatan[$i],
					'status' => 'Done',
					'cdate' => $cdate,
				);
				if ($nama_peserta[$i] != '' && $jabatan[$i] != '')
					$this->keg->insertKegiatanAnggota($kegiatan_anggota);
			}
			
			// update kegiatan
			$this->db->update('kegiatan', array('mdate' => $cdate), array('id_keg' => $id_keg));
		}
		
		redirect('kegiatan/detail/'.$id_keg,'refresh');
	}
	
	function edit($idKeg){
		$data = array(
			'title' => 'Edit Kegiatan' ,
			'page'	=> 'master/kegiatan_edit'
		);
		
		$data['detail'] = $this->keg->detail($idKeg);
		$data['logTarget'] = $this->keg->logTarget($idKeg);
		
		$this->load->view('template/header', $data, FALSE);
		$this->load->view('template/content', $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
		
	}
	
	function getHead(){
		$myData = array();
		
		$sql = $this->db->query("select * from ms_organization where parent_id = 0 order by org_id asc ")->result_array();
		foreach($sql as $row){
			$data = array();
			$org_id = $row['org_id'];
			$parent_id = $row['parent_id'];
			$org_name = $row['org_name'];
			
			$getChild = $this->getChild($org_id);
			if ($getChild['status']){
				$data = $getChild['data'];
				$group = true;
			} else {
				$data = $row;
				$group = false;
			}
			
			$myData[] = array(
				'name' => $org_name,
				'group'=> $group,
				'data' => $data
			);
		}
		// echo '<pre>';
		return ($myData);
	}
	
	function getChild($org_id){
		$myData = array();
		$sql = $this->db->query("select * from ms_organization where parent_id = '".($org_id)."' order by org_id asc ")->result_array();
		if ($sql){
			$status = true;
			foreach($sql as $row){
				$data = array();
				$org_id = $row['org_id'];
				$parent_id = $row['parent_id'];
				$org_name = $row['org_name'];
				
				// $data[] = $org_id.'|'.$parent_id.'|'.$org_name;
				
				$getChild = $this->getChild($org_id);
				if ($getChild['status']){
					$data = $getChild['data'];
					$group = true;
				} else {
					$data = $row;
					$group = false;
				}
				
				$myData[] = array(
					'name' => $org_name,
					'group'=> $group,
					'data' => $data
				);
				
			}
			
		}
		else {
			$status = false;
		}
		
		return $return = array('data' => @$myData, 'status' => $status);
	}
	
	function cobaTampil(){
		echo '<pre>';
		$dataOrg = $this->getHead();
		
		echo '<select>';
		echo '<option>pilih</option>';
		foreach($dataOrg as $rowHead){
			if ($rowHead['group']){
				$this->cobaTampilChild(array($rowHead['name']), $rowHead['data']);
			}
			else {
				echo '<option value="'.$rowHead['data']['org_id'].'">'.$rowHead['name'].' -> '.$rowHead['name'].'</option>';
			}
		}
		echo '</select>';
		echo '</body></html>';
		
	}
	
	function cobaTampilChild($name, $data){
		$head = '';
		foreach($name as $row){
			$head .= $row.' -> ';
			$nameParent[] = $row;
		}
		
		foreach($data as $row){
			if ($row['group']){
				$nameParent[] = $row['name'];
				$this->cobaTampilChild($nameParent, $row['data']);
			}
			else{
				echo '<option value="'.$row['data']['org_id'].'">'.$head.$row['name'].'</option>';
			}
		}
	}
	
}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
