<?php

class SiteInfo_Model extends Base_Model{

	public function getSiteInfo(){
		$sql = "select * from site_info limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function addSiteInfo($data=[]){
		if(!empty($data)){
			$query = $this->db->insert('site_info',$data);
		}
	}

	public function updateSiteInfo($data=[]){
		if(!empty($data)){
			$query = $this->db->replace('site_info',$data);
		}
	}
}