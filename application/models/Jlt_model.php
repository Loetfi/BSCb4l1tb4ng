<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jlt_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function invoiceUnitBulanan($tahun='2018', $branchId=1){
		$where = '';
		if($branchId != '') $where .= " AND c.branch_id='$branchId' ";
		if($tahun === true) $where .= " AND YEAR(a.created_at) = '".$tahun."' ";
		
		try{
			$sql = "SELECT
				(Sum(a.`value`) / 100) AS terhitung,
				a.currency,
				YEAR (a.created_at) AS tahun,
				MONTH (a.created_at) AS bulan
			FROM
				issues a
			LEFT JOIN jobs_view b ON a.job_id = b.job_id
			LEFT JOIN ms_organization c ON c.id = b.org_id
			WHERE
				1=1
				".$where."	
			GROUP BY
				a.currency,
				YEAR (a.created_at),
				MONTH (a.created_at)
			ORDER BY MONTH (a.created_at) ASC
			";
			$resutl = $this->db->query($sql)->result_array();
		} catch (Exception $e) {
			$resutl = array();
		}
		return $resutl;
	}

	function invoiceSubUnitBulanan($tahun='2018', $branchId=1){
		$where = '';
		if($branchId != '') $where .= " AND c.branch_id='$branchId' ";
		if($tahun === true) $where .= " AND YEAR(a.created_at) = '".$tahun."' ";
		
		try{
			$sql = "SELECT
				b.org_id,
				(Sum(a.`value`) / 100) AS terhitung,
				a.currency,
				YEAR (a.created_at) AS tahun,
				MONTH (a.created_at) AS bulan
			FROM
				issues a
			LEFT JOIN jobs_view b ON a.job_id = b.job_id
			LEFT JOIN ms_organization c ON c.id = b.org_id
			WHERE
				1=1
				".$where."	
			GROUP BY
				b.org_id,
				a.currency,
				YEAR (a.created_at),
				MONTH (a.created_at)
			ORDER BY MONTH (a.created_at) ASC
			";
			$resutl = $this->db->query($sql)->result_array();
		} catch (Exception $e) {
			$resutl = array();
		}
		return $resutl;
	}
	
	function invoiceSubUnitTahunan($tahun='2018', $branchId=1){
		$where = '';
		if($branchId != '') $where .= " AND c.branch_id='$branchId' ";
		if($tahun === true) $where .= " AND YEAR(a.created_at) = '".$tahun."' ";
		
		try{
			$sql = "SELECT
				b.org_id,
				(Sum(a.`value`) / 100) AS terhitung,
				a.currency,
				YEAR (a.created_at) AS tahun
			FROM
				issues a
			LEFT JOIN jobs_view b ON a.job_id = b.job_id
			LEFT JOIN ms_organization c ON c.id = b.org_id
			WHERE
				1=1
				".$where."	
			GROUP BY
				b.org_id,
				a.currency,
				YEAR (a.created_at)
			";
			$resutl = $this->db->query($sql)->result_array();
		} catch (Exception $e) {
			$resutl = array();
		}
		return $resutl;
	}
	
	
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
