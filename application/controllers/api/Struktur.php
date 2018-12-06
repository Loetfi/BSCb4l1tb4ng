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
		$parent_id = @$_GET['parent_id'];
		$childOnly = @$_GET['childOnly'];
		$edited = @$_GET['edited'];
		// die($edited);
		
		$dataOrg = $this->struktur->getHead(@$branch);
		
		foreach($dataOrg as $rowHead){
			if ($rowHead['group']){
				if ($childOnly){}
				else if ($edited){
					if ($parent_id==@$rowHead['org_id'])
						echo '<option value="'.@$rowHead['org_id'].'" '.($parent_id==@$rowHead['org_id']?'selected':'').'>'.@$rowHead['name'].'</option>';
				}
				else 
					echo '<option value="'.@$rowHead['org_id'].'" '.($parent_id==@$rowHead['org_id']?'selected':'').'>'.@$rowHead['name'].'</option>';
				
				$this->getChildComboOrg(array($rowHead['name']), $rowHead['data']);
			}
			else {
				if ($edited){
					if ($parent_id==@$rowHead['org_id'])
						echo '<option value="'.$rowHead['org_id'].'" '.($parent_id==$rowHead['org_id']?'selected':'').'>'.$rowHead['name'].' -> '.$rowHead['name'].'</option>';
				}
				else 
					echo '<option value="'.$rowHead['org_id'].'" '.($parent_id==$rowHead['org_id']?'selected':'').'>'.$rowHead['name'].' -> '.$rowHead['name'].'</option>';
			}
		}
		
	}
	
	function getChildComboOrg($name, $data){
		$parent_id = @$_GET['parent_id'];
		$childOnly = @$_GET['childOnly'];
		$edited = @$_GET['edited'];
		$head = '';
		foreach($name as $row){
			$head .= $row.' -> ';
			$nameParent[] = $row;
		}
		
		foreach($data as $row){
			if ($row['group']){
				if ($childOnly){}
				else if ($edited)
					if ($parent_id==$row['data']['org_id'])
						echo '<option value="'.$row['data']['org_id'].'" '.($parent_id==$row['data']['org_id']?'selected':'').'>'.$head.$row['name'].'</option>';
				else 
					echo '<option value="'.$row['data']['org_id'].'" '.($parent_id==$row['data']['org_id']?'selected':'').'>'.$head.$row['name'].'</option>';
				
				$nameParent[] = $row['name'];
				$this->getChildComboOrg($nameParent, $row['data']);
			}
			else{
				if ($edited){
					if ($parent_id==$row['data']['org_id'])
						echo '<option value="'.$row['data']['org_id'].'" '.($parent_id==$row['data']['org_id']?'selected':'').'>'.$head.$row['name'].'</option>';
				}
				else 
					echo '<option value="'.$row['data']['org_id'].'" '.($parent_id==$row['data']['org_id']?'selected':'').'>'.$head.$row['name'].'</option>';
			}
		}
	}
	
	
	
}