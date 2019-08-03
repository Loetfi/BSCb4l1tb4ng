<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "target";
        $this->bsc_only = $this->load->database('bsc_only', TRUE);
	}

	function getIssueGlobalTahunan($tahun='', $branch_id=''){
		$where = "";
		if($tahun != '') $where .= " AND year(issues.created_at) = '$tahun' ";
		if ($branch_id != '') $where .= " AND ms_organization.branch_id = '$branch_id' ";
		
		try {
			$sql = "SELECT
				ms_organization.branch_id,
				ms_organization.`code`,
				ms_organization.org_name,
				sum(issues.`value`) jumlah,
				issues.currency,
				year(issues.created_at) tahun
			FROM
				issues
			WHERE 
				1=1
				".$where."
			INNER JOIN repots ON issues.report_id = repots.id
			INNER JOIN jobs ON repots.job_id = jobs.id
			INNER JOIN agreements ON jobs.agreement_id = agreements.id
			INNER JOIN participates ON agreements.id=participates.participate_id 
			INNER JOIN ms_organization ON ms_organization.id = participates.organization_id
			GROUP BY 
				ms_organization.branch_id,
				ms_organization.`code`,
				ms_organization.org_name,
				issues.currency,
				year(issues.created_at)
			";
			$resutl = $this->db->query($sql)->result_array();
		} catch (Exception $e) {
			$resutl = array();
		}
		
		return $resutl;
	}
	
    function highLevel(){
        $sql = "select * 
            from global_report_1 
            where (instansi = 'lemigas' AND tahun='".date('Y')."' AND (jenis='target' OR jenis='realisasi'))
            OR  (instansi = 'lemigas' AND tahun='". (date('Y')-1) ."' AND jenis='realisasi')
            OR  (instansi = 'lemigas' AND tahun='". (date('Y')-2) ."' AND jenis='realisasi')
            ORDER BY tahun, jenis, bulan
        ";
        $query = $this->bsc_only->query($sql);
		return $query->result_array();
    }
	
	function form_a(){
        $sql = "select * 
            from global_report_1 
            where (instansi = 'lemigas' AND tahun='".date('Y')."' AND (jenis='target' OR jenis='realisasi'))
            OR  (instansi = 'lemigas' AND tahun='". (date('Y')-1) ."' AND jenis='realisasi')
            ORDER BY tahun, jenis, bulan
        ";
        $query = $this->bsc_only->query($sql);
		return $query->result_array();
    }
	
    function raw_rekap($dataInsert){
        $this->db->insert_batch('raw_rekap', $dataInsert);
    }
    
    function getNotif($tgl = ""){
        $tgl = ($tgl == "" ? date('Y-m-d') : $tgl);
        $sql = "SELECT *
        FROM selisih_harian
        WHERE tgl = '".$tgl."'
        AND (
            selisih_terkontrak > 0
            OR selisih_inv > 0
            OR selisih_realisasi > 0
        )";
        $query = $this->db->query($sql);
		return $query->result_array();
    }
    /*
CREATE VIEW selisih_harian AS 
SELECT 
	A.*,
	(IFNULL(A.terkontrak, 0) - IFNULL(B.terkontrak, 0)) selisih_terkontrak,
	(IFNULL(A.inv, 0) - IFNULL(B.inv, 0)) selisih_inv,
	(IFNULL(A.realisasi, 0) - IFNULL(B.realisasi, 0)) selisih_realisasi
FROM raw_rekap A
LEFT JOIN raw_rekap B
	ON (A.tgl + 0) = (B.tgl +1)
	AND A.satker = B.satker 
	AND A.kp3 = B.kp3
ORDER BY tgl DESC, satker ASC, kp3 ASC
    */
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
