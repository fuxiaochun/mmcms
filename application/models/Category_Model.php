<?php

class Category_Model extends Base_Model{

    public function getList($num, $limit, $search){
        $search && $this->db->like('name', $search);
        $this->db->order_by('id','ASC');
        $this->db->limit($num, $limit);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    public function getCount($search){
        $search && $this->db->like('name', $search);
        return $this->db->count_all_results('category');
    }

    public function getCategoryTree(){
        $this->db->order_by('id','ASC');
        $query = $this->db->get('category');
        $res = $query->result_array();
        return $this->makeTree($res);
    }

    public function makeTree($res, $pid=0, $level=1){
        static $tree = [];
        foreach($res as $k => $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $tree[] = $v;
                $this->makeTree($res, $v['id'], $level+1);
            }
        }
        return $tree;
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