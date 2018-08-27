<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Pages_Model');
		$this->load->model('Article_Model');
	}
	public function index(){

		$about_us = $this->Pages_Model->getInfoById(1);
		$data['about_us'] = $about_us['description'];

		

		$this->load->view('home/index.html', $data);
	}

}
