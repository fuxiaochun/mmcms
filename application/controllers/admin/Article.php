<?php

class Article extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Article_Model');
		$this->load->model('Category_Model');
	}
	public function index(){

		$cur_page = isset($_GET['p']) ? $_GET['p'] : 1;
		$search = isset($_GET['s']) ? $_GET['s'] : '';
		$pages_count = $this->Article_Model->getCount($search);
		$limit = 10;
		$start = $limit * ($cur_page - 1);
		$res = $this->Article_Model->getList($limit, $start, $search);
		$data['search'] = $search;
		$data['article'] = $res;

		$this->load->library('pagination');
		if($search){
			$config['base_url'] = base_url('/admin/article/index?s='.$search);
		}else{
			$config['base_url'] = base_url('/admin/article/index');
		}
		$config['total_rows'] = $pages_count;
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = true;
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'p';
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['cur_tag_open'] = '<span>';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		$data['list_page'] = $this->pagination->create_links();

		$this->load->view('admin/article_list.html', $data);
	}

	public function create(){
		$cats = $this->Category_Model->getCategoryTree();
		$data['categorys'] = $cats;
		$this->load->view('admin/article_create.html', $data);
	}

	public function add(){
		var_dump($_FILES);die;
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
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
			if($this->Pages_Model->add($post_data)){
				toast(base_url('admin/article'), 2, '页面创建成功！');
				return;
			}
			toast(base_url('admin/article/create'), 2, '页面创建失败!');

		}else{
			toast(base_url('admin/article/create'), 2, '表单数据不全，请完善后再提交!');
		}
	}

	public function delete(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if($this->Pages_Model->delete($id)){
			toast($_SERVER['HTTP_REFERER'], 2, '删除成功！');
		}else{
			toast($_SERVER['HTTP_REFERER'], 2, '删除失败！');
		}
	}

	public function update(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$info = $this->Pages_Model->getInfoById($id);
		$data['info'] = $info;
		$this->load->view('admin/article_update.html', $data);
	}

	public function edit(){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$alias = isset($_POST['alias']) ? $_POST['alias'] : '';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';

		$post_data = [
			'id' => $id,
			'title' => $title,
			'alias' => $alias,
			'keywords' => $keywords,
			'description' => $description,
			'content' => $content
		];
		if($id && $title && $alias){
			if($this->Pages_Model->update($post_data)){
				toast(base_url('admin/article'), 2, '修改成功！');
				return;
			}
			toast(base_url('admin/article/update?id=').$id, 2, '修改失败!');

		}else{
			toast(base_url('admin/article/update?id=').$id, 2, '表单数据不全，请完善后再提交!');
		}
	}
}