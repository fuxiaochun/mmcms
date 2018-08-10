<?php

class Home extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('SiteInfo_Model');
	}

	public function index(){
		$this->load->view('admin/index.html');
	}

	public function top(){
		$data['user'] = $this->session->userdata('user');
		$this->load->view('admin/top.html',$data);
	}

	public function left(){
		$this->load->view('admin/left.html');
	}

	public function main(){
		$info = $this->SiteInfo_Model->getSiteInfo();
		$data['info'] = $info;
		$data['user'] = $this->session->userdata('user');
		$this->load->view('admin/main.html',$data);
	}
}