<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "target";
	}
	function getAll(){
		$sql = "SELECT
		t.target_id,
		t.org_id,
		t.`year`,
		t.`month`,
		t.amount,
		t.create_date,
		t.create_user,
		t.modify_date,
		t.modify_user,
		t.delete_date,
		t.delete_user,
		t.sts_deleted,
		o.org_name,
		o.description,
		o.code,
		o.branch_id,
		b.branch_name,
		b.ip_address
		from target t
		left join ms_organization o
			on t.org_id = o.org_id
		left join ms_branch b
			on b.branch_id = o.branch_id
		";
		$resutl = $this->db->query($sql)->result_array();
		return $resutl;
	}
	
	function insertTarget($post){
		$query = $this->db->insert($this->table, $post);
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function detail($id){
		$sql = "SELECT
		t.target_id,
		t.org_id,
		t.`year`,
		t.`month`,
		t.amount,
		t.create_date,
		t.create_user,
		t.modify_date,
		t.modify_user,
		t.delete_date,
		t.delete_user,
		t.sts_deleted,
		o.org_name,
		o.description,
		o.code,
		o.branch_id,
		b.branch_name,
		b.ip_address
		from target t
		left join ms_organization o
			on t.org_id = o.org_id
		left join ms_branch b
			on b.branch_id = o.branch_id
		where t.target_id = '".$id."'
		";
		$resutl = $this->db->query($sql)->row_array();
		return $resutl;
	}
	
	function updateTarget($dataUpdate, $dataWhere){
		$this->db->where($dataWhere);
		$query = $this->db->update($this->table, $dataUpdate);
		return $query;
	}
	
	
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
