<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "ms_organization";
	}
	
	function getAll($branchId='', $withoutParent=false){
		
		$where = '';
		if($branchId != '') $where .= " AND a.branch_id='$branchId' ";
		if($withoutParent === true) $where .= " AND a.parent_id > 0 ";
		
		try{
			$sql = "
			SELECT 
				a.*,
				a.id org_id,
				b.branch_name,
				c.org_name parent_name
			FROM ms_organization a
			LEFT JOIN ms_branch b 
				ON a.branch_id=b.branch_id
			LEFT JOIN ms_organization c
				ON a.parent_id=c.id and a.branch_id=c.branch_id
			WHERE
				1=1
				".$where."	
			ORDER BY code ASC 
			";
			$resutl = $this->db->query($sql)->result_array();
			
		} catch (Exception $e) {
			$resutl = array();
		}
		return $resutl;
	}
	
	function insertStruktur($post){
		$query = $this->db->insert($this->table, $post);
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function detail($id){
		$sql = "
		SELECT 
			a.*,
			a.id org_id,
			b.branch_name,
			b.ip_address,
			c.org_name parent_name
		FROM ms_organization a
		LEFT JOIN ms_branch b 
			ON a.branch_id=b.branch_id
		LEFT JOIN ms_organization c
			ON a.parent_id=c.id and a.branch_id=c.branch_id
		WHERE a.id = '".$id."'
		";
		$resutl = $this->db->query($sql)->row_array();
		return $resutl;
	}
	
	function updateStruktur($dataUpdate, $dataWhere){
		$this->db->where($dataWhere);
		$query = $this->db->update($this->table, $dataUpdate);
		return $query;
	}
	
	function logTarget($idKeg){
		$sql = "select  
			id_keg
			,id_target
			,tahun
			,status
			,cdate
			,cuser
			,mdate
			,muser
		from kegiatan_target 
		where id_keg = '$idKeg' 
		order by tahun desc, id_target desc
		";
		$resutl = $this->db->query($sql)->result_array();
		return $resutl;
	}
	
	function list_unit($where = array()){
        if (count($where) > 0) $this->db->where($where);
        
        $this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }
	function list_unit_all(){
		$allArr = array();
        $sql = "select a.*, a.id org_id from ".$this->table." a WHERE parent_id = 0 ORDER BY org_name ASC";
        $query = $this->db->query($sql)->result_array();
        $i=0;
		foreach($query as $row){
            $allArr['head'][$i] = $row;
            // echo $row['org_id'].'|'.$row['org_name'].'<br>';
            $where = array('parent_id' => $row['org_id']);
            $subUnit = $this->list_unit($where);
            $j=0;
            foreach($subUnit as $subRow){
                $allArr['child'][$i][$j] = $subRow;
                // echo '->->'.$subRow['org_id'].'|'.$subRow['org_name'].'<br>';
                $j++;
            }
            // echo '<hr>';
            $i++;
        }
        return @$allArr;
    }
	
	
	function getAllHeadOnly($branchId = null){
		$where = '';
		if($branchId != '') $where .= " AND a.branch_id='$branchId' ";
		
		try{
			$resutl = $this->db->query("
			select 
				a.*, 
				a.id org_id,
				b.branch_name,
				b.ip_address
			from ms_organization a 
			LEFT JOIN ms_branch b on a.branch_id = b.branch_id
			where parent_id = 0 
				".$where." 
			ORDER BY a.code ASC  ")->result_array();
		} catch (Exception $e) {
			$resutl = array();
		}
		return $resutl;
	}
	
	
	function getHead($branch = null, $editOrgId = null){
		$where = '';
		if ($branch !== null)
			$where .= " AND branch_id = '".$branch."' ";
		if ($editOrgId !== null)
			$where .= " AND a.id <> '".$editOrgId."' AND a.parent_id <> '".$editOrgId."' ";
		
		$myData = array();
		
		$sql = $this->db->query("select a.*, a.id org_id from ms_organization a where parent_id = 0 ".$where." order by id asc ")->result_array();
		foreach($sql as $row){
			$data = array();
			$org_id = $row['org_id'];
			$parent_id = $row['parent_id'];
			$org_name = $row['org_name'];
			
			$getChild = $this->getChild($org_id, $branch, $editOrgId);
			if ($getChild['status']){
				$data = $getChild['data'];
				$group = true;
			} else {
				$data = $row;
				$group = false;
			}
			
			$myData[] = array(
				'org_id' => $org_id,
				'name' => $org_name,
				'group'=> $group,
				'data' => $data
			);
		}
		return ($myData);
	}
	function getChild($org_id = array(), $branch = null, $editOrgId = null){
		
		$where = '';
		if ($branch !== null)
			$where .= " AND branch_id = '".$branch."' ";
		if ($editOrgId !== null)
			$where .= " AND a.id <> '".$editOrgId."' AND a.parent_id <> '".$editOrgId."' ";
		
		$myData = array();
		$sql = $this->db->query("select a.*, a.id org_id from ms_organization a where parent_id = '".($org_id)."' ".$where." order by id asc ")->result_array();
		if ($sql){
			$status = true;
			foreach($sql as $row){
				$data = array();
				$org_id = $row['org_id'];
				$parent_id = $row['parent_id'];
				$org_name = $row['org_name'];
				
				$getChild = $this->getChild($org_id, $branch, $editOrgId);
				if ($getChild['status']){
					$data = $getChild['data'];
					$group = true;
				} else {
					$data = $row;
					$group = false;
				}
				
				$myData[] = array(
					'org_id' => $parent_id,
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
	
	
	
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
