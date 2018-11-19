<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('struktur_model','struktur');
		$this->load->model('branch_model','branch');
		$this->thisUrl = $this->uri->segment(1).'/'.$this->uri->segment(2);
	}
	
	function getComboOrg(){
		
		$branch = @$_GET['branch_id'];
		
		$dataOrg = $this->struktur->getHead(@$branch);
		
		foreach($dataOrg as $rowHead){
			if ($rowHead['group']){
				$this->getChildComboOrg(array($rowHead['name']), $rowHead['data']);
			}
			else {
				echo '<option value="'.$rowHead['data']['org_id'].'">'.$rowHead['name'].' -> '.$rowHead['name'].'</option>';
			}
		}
		
	}
	
	function getChildComboOrg($name, $data){
		$head = '';
		foreach($name as $row){
			$head .= $row.' -> ';
			$nameParent[] = $row;
		}
		
		foreach($data as $row){
			if ($row['group']){
				$nameParent[] = $row['name'];
				$this->getChildComboOrg($nameParent, $row['data']);
			}
			else{
				echo '<option value="'.$row['data']['org_id'].'">'.$head.$row['name'].'</option>';
			}
		}
	}
	
	
	
}