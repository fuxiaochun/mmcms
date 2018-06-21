<?php

class Manager extends Base_Model{

	public function getInfoByUser($user){
		$sql = "select user,password,captcha,level from manager where user='$user'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
}