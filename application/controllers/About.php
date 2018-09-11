<?php

class About extends CI_Controller{
    public function __construct(){
		parent::__construct();
		$this->load->model('Pages_Model');
    }
    public function index(){
        $about_us = $this->Pages_Model->getInfoById(1);
        $data['about'] = $about_us;

        $this->load->view('home/about.html', $data);
    }
}