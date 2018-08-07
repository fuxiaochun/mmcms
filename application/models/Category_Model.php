<?php

class Category_Model extends Base_Model{

    public function getPages($num, $limit, $search){
        $search && $this->db->like('name', $search);
        $this->db->limit($num, $limit);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    public function getCount($search){
        $search && $this->db->like('name', $search);
        return $this->db->count_all_results('category');
    }

    public function add($data=[]){
		if(!empty($data)){
			return $this->db->insert('category',$data);
		}
    }
    
    public function delete($id){
        if($id){
            $this->db->where('id', $id);
            return $this->db->delete('category');
        }
    }

    public function getInfoById($id){
        if($id){
            $this->db->where('id', $id);
            $query = $this->db->get('category');
            return $query -> row_array();
        }
    }

    public function update($data=[]){
		if(!empty($data)){
            $this->db->where('id',$data['id']);
			return $this->db->update('category',$data);
		}
    }

}

?>