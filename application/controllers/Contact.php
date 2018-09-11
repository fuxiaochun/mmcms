<?php

class Contact extends CI_Controller{
    public function __construct(){
		parent::__construct();
		$this->load->model('Pages_Model');
    }
    public function index(){
        $contact = $this->Pages_Model->getInfoById(2);
        $data['contact'] = $contact;

        $this->load->view('home/contact.html', $data);
    }
}