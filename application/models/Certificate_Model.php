<?php

class Certificate_Model extends Base_Model{

    public function getList($num, $limit, $search){
        $search && $this->db->like('certificate', $search);
        $this->db->limit($num, $limit);
        $query = $this->db->get('certificate');
        return $query->result_array();
    }

    public function getCount($search){
        $search && $this->db->like('certificate', $search);
        return $this->db->count_all_results('certificate');
    }

    public function add($data=[]){
		if(!empty($data)){
			return $this->db->insert('certificate',$data);
		}
    }
    
    public function delete($id){
        if($id){
            $this->db->where('id', $id);
            return $this->db->delete('certificate');
        }
    }

    public function getInfoById($id){
        if($id){
            $this->db->where('id', $id);
            $query = $this->db->get('certificate');
            return $query -> row_array();
        }
	}
	
	public function getCountByCertificate($id){
        if($id){
            $this->db->where('certificate', $id);
            return $this->db->count_all_results('certificate');
        }
    }

    public function update($data=[]){
		if(!empty($data)){
            $this->db->where('id',$data['id']);
			return $this->db->update('certificate',$data);
		}
    }

}

?>