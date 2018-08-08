<?php

class Login extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function index(){
		if($this->session->userdata('user')){
			redirect($this->config->item('base_url').'/admin/home');
			exit;
		}
		$this->load->view('admin/login');
	}

	public function check(){
		$user = isset($_POST['user']) ? $_POST['user'] : '';
		$password = isset($_POST['pwd']) ? $_POST['pwd'] : '';
		$captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
		$this->load->model('Manager');

		$user_info = $this->Manager->getInfoByUser($user);

		if (empty($user_info)) {
			echo '0';
			return;
		}

		if ($user_info['user'] == $user && $user_info['password'] == md5($password) && $user_info['captcha'] == $captcha) {
			$this->session->set_userdata('user',$user_info['user']);
			echo '1';
		}else{
			echo '0';
		}
	}

	public function logout(){
		$this->session->unset_userdata('user');
		if($this->session->userdata('user')){
			echo '0';
		}else{
			echo '1';
		}
	}
}