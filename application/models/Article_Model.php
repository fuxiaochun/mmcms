<?php

class Article_Model extends Base_Model{

    public function getList($num, $limit, $search){
        $this->db->select('a.id,a.title,c.name as category,a.recommend');
        $this->db->from('article as a');
        $this->db->join('category as c','c.id=a.category_id','left');
        $search && $this->db->like('a.title', $search);
        $this->db->where('a.del<>',1);
        $this->db->limit($num, $limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCount($search){
        $search && $this->db->like('title', $search);
        $this->db->where('del<>',1);
        return $this->db->count_all_results('article');
    }

    public function add($data=[]){
		if(!empty($data)){
			return $this->db->insert('article',$data);
		}
    }
    
    public function delete($id){
        if($id){
            $data = ['del'=>1];
            $this->db->where('id', $id);
            return $this->db->update('article',$data);
        }
    }

    public function getInfoById($id){
        if($id){
            $this->db->where('id', $id);
            $this->db->where('del<>', 1);
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