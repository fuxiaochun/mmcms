<?php

class Production extends CI_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('SiteInfo_Model');
        $this->load->model('Category_Model');
		$this->load->model('Article_Model');
    }
    
    public function index(){

        // 头部元信息
		$head = $this->SiteInfo_Model->getSiteInfo();
        $data['head'] = $head;

        $category_id = 3;
        
        // 分类信息
        $cats = $this->Category_Model->getInfoById($category_id);
		$data['category'] = $cats;

        // 文章列表
        $cur_page = $this->uri->segment(3,1);
		$pages_count = $this->Article_Model->getCountByCid($category_id);
		$limit = 12;
		$start = $limit * ($cur_page - 1);
		$res = $this->Article_Model->getListByCid($category_id, $limit, $start);
		$data['production'] = $res;

		$this->load->library('pagination');
		$config['base_url'] = base_url('/production/');
		$config['total_rows'] = $pages_count;
		$config['per_page'] = $limit;
        $config['use_page_numbers'] = true;
        $config['prefix'] = 'p/';
		// $config['page_query_string'] = true;
		// $config['query_string_segment'] = 'p';
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['cur_tag_open'] = '<span>';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
        $data['list_page'] = $this->pagination->create_links();
                
        $this->load->view('home/production-list.html', $data);
    }

    public function info(){
        // 头部元信息
		$head = $this->SiteInfo_Model->getSiteInfo();
        $data['head'] = $head;

        $category_id = 3;
        
        // 分类信息
        $cats = $this->Category_Model->getInfoById($category_id);
        $data['category'] = $cats;
        
        // 文章详情
        $id = $this->uri->segment(2,0);
        if(!$id){
            $this->redirect('/production/');
            exit;
        }
        $article = $this->Article_Model->getInfoById($id);
        $data['production'] = $article;

        $this->load->view('home/production-info.html', $data);
    }
}