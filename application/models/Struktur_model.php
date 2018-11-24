<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "ms_organization";
	}
	
	function getAll(){
		// $this->db->select('*');
		// $this->db->from($this->table);
		// $resutl = $this->db->get()->result_array();
		// return $resutl;
		
		$sql = "
		SELECT 
			a.*,
			b.branch_name,
			c.org_name parent_name
		FROM ms_organization a
		LEFT JOIN ms_branch b 
			ON a.branch_id=b.branch_id
		LEFT JOIN ms_organization c
			ON a.parent_id=c.org_id and a.branch_id=c.branch_id
		";
		$resutl = $this->db->query($sql)->result_array();
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
			b.branch_name,
			b.ip_address,
			c.org_name parent_name
		FROM ms_organization a
		LEFT JOIN ms_branch b 
			ON a.branch_id=b.branch_id
		LEFT JOIN ms_organization c
			ON a.parent_id=c.org_id and a.branch_id=c.branch_id
		WHERE a.org_id = '".$id."'
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
        $sql = "select * from ".$this->table." WHERE parent_id = 0 ORDER BY org_name ASC";
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
	
	
	
	
	
	function getHead($branch = null){
		$where = '';
		if ($branch !== null)
			$where .= " AND branch_id = '".$branch."' ";
		
		$myData = array();
		
		$sql = $this->db->query("select * from ms_organization where parent_id = 0 ".$where." order by org_id asc ")->result_array();
		foreach($sql as $row){
			$data = array();
			$org_id = $row['org_id'];
			$parent_id = $row['parent_id'];
			$org_name = $row['org_name'];
			
			$getChild = $this->getChild($org_id, $branch);
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
	
	function getChild($org_id = array(), $branch = null){
		
		$where = '';
		if ($branch !== null)
			$where .= " AND branch_id = '".$branch."' ";
		
		$myData = array();
		$sql = $this->db->query("select * from ms_organization where parent_id = '".($org_id)."' order by org_id asc ")->result_array();
		if ($sql){
			$status = true;
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
			
		}
		else {
			$status = false;
		}
		
		return $return = array('data' => @$myData, 'status' => $status);
	}
	
	
	
}

/* End of file Auth_model.php */
/* Location: ./application/modules/backend/models/Auth_model.php */
