<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "ms_branch";
	}
	function getAll(){
		$this->db->select('*');
		$this->db->from($this->table);
		$resutl = $this->db->get()->result_array();
		return $resutl;
	}
	
	function insertBranch($post){
		$query = $this->db->insert($this->table, $post);
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function detail($id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('branch_id', $id);
		$resutl = $this->db->get()->row_array();
		return $resutl;
	}
	
	function updateBranch($dataUpdate, $dataWhere){
		$this->db->where($dataWhere);
		$query = $this->db->update($this->table, $dataUpdate);
		return $query;
	}
	
	
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
