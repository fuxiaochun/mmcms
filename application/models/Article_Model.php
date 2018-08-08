<?php

class Article_Model extends Base_Model{

    public function getList($num, $limit, $search){
        $search && $this->db->like('title', $search);
        $this->db->limit($num, $limit);
        $query = $this->db->get('article');
        return $query->result_array();
    }

    public function getCount($search){
        $search && $this->db->like('title', $search);
        return $this->db->count_all_results('article');
    }

    public function add($data=[]){
		if(!empty($data)){
			return $this->db->insert('article',$data);
		}
    }
    
    public function delete($id){
        if($id){
            $this->db->where('id', $id);
            return $this->db->delete('article');
        }
    }

    public function getInfoById($id){
        if($id){
            $this->db->where('id', $id);
            $query = $this->db->get('article');
            return $query -> row_array();
        }
    }

    public function update($data=[]){
		if(!empty($data)){
            $this->db->where('id',$data['id']);
			return $this->db->update('article',$data);
		}
    }

}

?>