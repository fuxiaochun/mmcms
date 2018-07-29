<?php

class Pages_Model extends Base_Model{

    public function getPages($num, $limit){

        $this->db->limit($num, $limit);
        $query = $this->db->get('page');
        return $query->result_array();
    }

    public function getCount(){
        return $this->db->count_all('page');
    }

    public function add($data=[]){
		if(!empty($data)){
			$query = $this->db->insert('page',$data);
		}
    }
    

}

?>