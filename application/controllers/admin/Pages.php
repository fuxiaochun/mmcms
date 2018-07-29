<?php

class Pages extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Pages_Model');
	}
	public function index(){

		$pages_count = $this->Pages_Model->getCount();
		var_dump($_REQUEST);
		$cur_page = isset($_GET['p']) ? $_GET['p'] : 1;
		$limit = 1;
		$start = $limit * ($cur_page - 1);
		$res = $this->Pages_Model->getPages($limit, $start);
		$data['pages'] = $res;

		$this->load->library('pagination');
		$config['base_url'] = base_url('/admin/pages/index');
		$config['total_rows'] = $pages_count;
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = true;
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'p';
		$config['cur_tag_open'] = '<span>';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		$data['list_page'] = $this->pagination->create_links();

		$this->load->view('admin/pages_list.html', $data);
	}

	public function create(){
		$this->load->view('admin/pages_create.html');
	}

	public function add(){
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';

		$post_data = [
			'title' => $title,
			'alias' => $alias,
			'keywords' => $keywords,
			'description' => $description,
			'content' => $content
		];
		if($title && $alias){
			$this->Pages_Model->add($post_data);
			toast(base_url('admin/pages'), 2, '页面创建成功！');
		}else{
			toast(base_url('admin/pages/create'), 2, '表单数据不全，请完善后再提交!');
		}
	}
}