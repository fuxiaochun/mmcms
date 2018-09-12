<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('SiteInfo_Model');
		$this->load->model('Pages_Model');
		$this->load->model('Article_Model');
	}
	public function index(){
		// 头部元信息
		$head = $this->SiteInfo_Model->getSiteInfo();
		$data['head'] = $head;

		// 焦点图
		$focus = $this->Article_Model->getListByCid(1,1,0);
		$data['focus'] = $focus;

		// 关于我们
		$about_us = $this->Pages_Model->getInfoById(1);
		$data['about_us'] = $about_us['description'];

		// 作品欣赏
		$products = $this->Article_Model->getListByCid(3,4,0);
		$data['products'] = $products;

		// 文章资讯
		$article = $this->Article_Model->getListByCid(2,4,0);
		$data['article'] = $article;	
		
		$this->load->view('home/index.html', $data);
	}

}
