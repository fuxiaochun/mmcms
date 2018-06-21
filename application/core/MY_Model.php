<?php

class MY_Model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
}

class Base_Model extends MY_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
}