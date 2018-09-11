<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Pages_Model');
		$this->load->model('Article_Model');
	}
	public function index(){
		// 焦点图
		$focus = $this->Article_Model->getListByCid(1,1,0);
		$data['focus'] = $focus;

		// 关于我们
		$about_us = $this->Pages_Model->getInfoById(1);
		$data['about_us'] = $about_us['description'];

		// 作品欣赏
		$products = $this->Article_Model->getListByCid(3,4,0);
		$data['products'] = $products;

		// 作品欣赏
		$article = $this->Article_Model->getListByCid(2,4,0);
		$data['article'] = $article;	
		
		var_dump($data);

		$this->load->view('home/index.html', $data);
	}

}
