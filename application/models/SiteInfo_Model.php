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

	public function updateSiteInfo($data=[], $id){
		if(!empty($data)){
			$this->db->where('id', $id);
			$query = $this->db->update('site_info',$data);
		}
	}

	public function postData($data=[]){
		if(!empty($data)){
			foreach($data as $k=>$v){
				$post_data[$k] = $v;
			}
			$info = $this->getSiteInfo();
			if(empty($info)){
				$this->addSiteInfo($post_data);
			}else{
				$this->updateSiteInfo($post_data, $info['id']);
			}
		}
	}
}