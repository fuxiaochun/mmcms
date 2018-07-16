<?php

class Home extends Admin_Controller{

	public function index(){
		$this->load->view('admin/index.html');
	}

	public function top(){
		$this->load->view('admin/top.html');
	}

	public function left(){
		$this->load->view('admin/left.html');
	}

	public function main(){
		$this->load->view('admin/main.html');
	}
}