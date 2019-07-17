<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "target";
	}
	function getAll($tahun='', $branchId='', $month=''){
		
		$where = '';
		if($tahun != '') $where .= " AND t.`year` = '$tahun' ";
		if($branchId != '') $where .= " AND o.branch_id='$branchId' ";
		if($month != '') $where .= " AND t.`month`='$month' ";
		
		try{
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
				on t.org_id = o.id
			left join ms_branch b
				on b.branch_id = o.branch_id
			where 
				1=1
				".$where."
			";
			$resutl = $this->db->query($sql)->result_array();
		} catch (Exception $e) {
			$resutl = array();
		}
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
			on t.org_id = o.id
		left join ms_branch b
			on b.branch_id = o.branch_id
		where t.target_id = '".$id."'
		";
		$resutl = $this->db->query($sql)->row_array();
		return $resutl;
	}
	
	function detailSearch($where){
		try{
			$this->db->select('*');
			$this->db->from('target');
			$this->db->where($where);
			
			$resutl = $this->db->get()->row_array();
		} catch (Exception $e) {
			$resutl = array();
		}
		return $resutl;
	}
	
	function updateTarget($dataUpdate, $dataWhere){
		$this->db->where($dataWhere);
		$query = $this->db->update($this->table, $dataUpdate);
		return $query;
	}
	
	function getTargetSatker($branchId='', $tahun='',$month=''){
		$whereTahunan = " AND t.`year`='".$tahun."' ";
		$whereBulanan = " AND t.`year`='".$tahun."' ";
		
		if ($branchId != 'All'){ 
			$whereTahunan .= " AND b.branch_id = '".$branchId."' ";
			$whereBulanan .= " AND b.branch_id = '".$branchId."' ";
		}
		if ($month != ''){
			$whereBulanan .= " AND t.`month` = '".$month."' ";
		}
		
		$sql = "
		SELECT 
			(SELECT sum(t.amount) amount 
				FROM target t 
				join ms_organization o on t.org_id = o.id 
				join ms_branch b on b.branch_id = o.branch_id
				WHERE 1=1 ".$whereTahunan."
			) TargetTahunIni,
			(SELECT sum(t.amount) amount 
				FROM target t 
				join ms_organization o on t.org_id = o.id 
				join ms_branch b on b.branch_id = o.branch_id
				WHERE 1=1 ".$whereBulanan."
			) TargetBulanIni
		";
		$resutl = $this->db->query($sql)->row_array();
		return $resutl;
	}
	
	function getTargetKp3Tahunan($branchId='', $tahun=''){
		$sql = "
		SELECT o.client_mapping, sum(t.amount) target
		FROM target t 
		JOIN ms_organization o ON t.org_id = o.id
		WHERE 1=1 AND o.branch_id = '".$branchId."' and t.`year` = '".$tahun."'
		GROUP BY o.client_mapping
		";
		$resutl = $this->db->query($sql)->result_array();
		return $resutl;
	}
	function getTargetKp3Bulan($branchId='', $tahun='', $bulan=''){
		$sql = "
		SELECT o.client_mapping, sum(t.amount) target
		FROM target t 
		JOIN ms_organization o ON t.org_id = o.id
		WHERE 1=1 AND o.branch_id = '".$branchId."' and t.`year` = '".$tahun."' and t.`month` = '".$bulan."'
		GROUP BY o.client_mapping
		";
		$resutl = $this->db->query($sql)->result_array();
		return $resutl;
	}
	
	function getTargetKp3Bulanan($branchId='', $tahun=''){
		if ($branchId == 'All'){
			$where = "";
		}
		else {
			$where = " AND o.branch_id = '".$branchId."' ";
		}
		$sql = "
		SELECT t.`month`, sum(t.amount) target
		FROM target t 
		JOIN ms_organization o ON t.org_id = o.id
		WHERE 1=1 ".$where." and t.`year` = '".$tahun."'
		GROUP BY t.`month`
		ORDER BY t.`month` ASC
		";
		
		$resutl = $this->db->query($sql)->result_array();
		return $resutl;
	}
	
	function getTargetBulanan($tahun=''){
		$sql = "
		SELECT 
			t.`month`, 
			sum(t.amount) target
		FROM target t 
		WHERE t.`year` = '".$tahun."'
		GROUP BY t.`month`
		";
		$resutl = $this->db->query($sql)->result_array();
		return $resutl;
	}
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
