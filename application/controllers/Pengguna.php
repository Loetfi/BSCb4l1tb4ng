<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('auth_model','auth');
    $this->load->model('pengguna_model');
    $this->load->model('branch_model');
    check_login('dashboard');
  }


  public function index(){

    $data = array(
     'title'      => 'Tambah Pengguna' ,
     'page'	     => 'master/pengguna/list',
     'url'	     => site_url('pengguna/data/'.@$this->session->userdata('branch_id')),
     'detail'     => site_url('pengguna/detail'),
     'edit'       => site_url('pengguna/edit'),
     'delete'     => site_url('pengguna/delete'),
     'message'    => $this->session->flashdata('message')
   ); 

    $this->load->view('template/header', $data, FALSE);
    $this->load->view('template/content', $data, FALSE);
    $this->load->view('template/footer', $data, FALSE);
  }

  public function data($branch_id)
  {
    $this->load->helper('backend');

    $this->load->model('pengguna_model','lists');
		// $this->cabang_model->get_datatables();

    $table          = 'login';
    	$column_order   = ['a.username' , 'a.name', 'a.branch_id']; //set column field database for datatable orderable
    	$column_search  = ['a.username' , 'a.name', 'a.branch_id'];
    	$orderin        = ['a.username' => 'desc']; // default order  # 'id_website' => 'asc'



    	$list 	= $this->lists->get_datatables($table , $column_order , $column_search , $orderin, $branch_id);

		// CRUDS Action Role
    	$detail 	= @urldecode($this->input->input_stream('detail'));
    	$update 	= @urldecode($this->input->input_stream('update'));
    	$delete 	= @urldecode($this->input->input_stream('delete'));  

    	$data 	= array();
    	$no 	= @$_POST['start'];
    	foreach ($list as $d) {

    		$no++;
    		$row 	= array();  

    		$ACTdetail 	 = $detail ? admsaction($detail  ,  @$d->login_id , 'info' , 'fa fa-eye' , 'Lihat') : false;
    		$ACTupdate   = $update ? admsaction($update  ,  @$d->login_id , 'success' , 'fa fa-pencil' , 'Ubah') : false;
    		$ACTdelete   = $delete ? anchor('#', '<i class="fa fa-trash"></i>', "class=\"btn btn-xs btn-danger ttipDatatables\" onclick=\"modal_delete('".$delete.'/'.@$d->CompanyId."');\" title=\"Hapus\"") : false; 

    		$row[]	= $d->login_id;
    		$row[]	= $d->name;
        $row[]  = $d->email;
        $row[]  = $d->branch_id; //$d->branch_id;
        $row[]	= branch_admin($d->branch_id , $d->branch_name); 
        $row[]	= btnStatus($d->status); 
        $row[]	= "<div class='btn-group'>".$ACTdetail." ".$ACTupdate." ".$ACTdelete ."</div>"; 

        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->lists->count_all($table , $branch_id),
        "recordsFiltered" => $this->lists->count_filtered($table , $column_order , $column_search , $orderin, $branch_id),
        "data" => $data,
      );
   		//output to json format 
      admsapi(200 , 1, 'sukses' , $output );  

    }

    public function edit(){

     $data = array(
      'title' => 'Ubah Pengguna' ,
      'page'    => 'master/pengguna/add'
    );

       // $data['tahun'] = $this->keg->getTahunKegiatan(); 

     $this->load->view('template/header', $data, FALSE);
     $this->load->view('template/content', $data, FALSE);
     $this->load->view('template/footer', $data, FALSE);
   }


   public function add(){

     $data = array(
      'title'     => 'Tambah Pengguna' ,
      'page'	    => 'master/pengguna/add',
      'branch'    => $this->branch_model->getAll()
    );


     $this->load->view('template/header', $data, FALSE);
     $this->load->view('template/content', $data, FALSE);
     $this->load->view('template/footer', $data, FALSE);
   }

   public function add_proses(){

    // print_r($_POST); die();

    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('branch', 'Branch', 'trim|required');
    $this->form_validation->set_rules('nama', 'Nama Pengguna', 'trim|required');

    if ($this->form_validation->run()==TRUE) {

      $parameter = array(
        'username'  => !empty($this->input->post('email')) ? $this->input->post('email') : 0,
        'email'  => !empty($this->input->post('email')) ? $this->input->post('email') : 0,
        'password'  => !empty($this->input->post('password')) ? $this->input->post('password') : 0,
        'branch_id'  => !empty($this->input->post('branch')) ? $this->input->post('branch') : 0,
        'name'  => !empty($this->input->post('nama')) ? $this->input->post('nama') : 0
      );
        // print_r($this->pengguna_model->create_user($parameter)); die();

      if ($this->pengguna_model->create_user($parameter)) {
        $this->session->set_flashdata('message', '<div class="alert alert-info"> Berhasil tambah pengguna </div>');
        redirect('pengguna','refresh');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-error"> Pengguna tidak berhasil disimpan. </div>');
        redirect('pengguna','refresh');
      }

    } else {
      redirect('pengguna','refresh');
    }


  }

}

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */
