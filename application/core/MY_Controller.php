<?php

class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
}

#后台父控制器
class Admin_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();

		$this->load->library('session');

		// 权限验证
		if (!$this->session->user){
			$base_url = $this->config->item('base_url');
			redirect(base_url('admin/login'));
			exit;
		}
	}
}