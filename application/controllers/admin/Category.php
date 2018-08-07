<?php

class Category extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Category_Model');
	}
	public function index(){

		$cur_page = isset($_GET['p']) ? $_GET['p'] : 1;
		$search = isset($_GET['s']) ? $_GET['s'] : '';
		$pages_count = $this->Category_Model->getCount($search);
		$limit = 10;
		$start = $limit * ($cur_page - 1);
		$res = $this->Category_Model->getList($limit, $start, $search);
		$data['search'] = $search;
		$data['category'] = $res;

		$this->load->library('pagination');
		if($search){
			$config['base_url'] = base_url('/admin/category/index?s='.$search);
		}else{
			$config['base_url'] = base_url('/admin/category/index');
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

		$this->load->view('admin/category_list.html', $data);
	}

	public function create(){
		$cats = $this->Category_Model->getCategoryTree();
		$data['categorys'] = $cats;
		$this->load->view('admin/category_create.html', $data);
	}

	public function add(){
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$pid = isset($_POST['pid']) ? $_POST['pid'] : 0;
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';

		$post_data = [
			'name' => $name,
			'pid' => $pid,
			'keywords' => $keywords,
			'description' => $description,
		];
		if(!empty($name)){
			if($this->Category_Model->add($post_data)){
				toast(base_url('admin/category'), 2, '创建成功！');
				return;
			}
			toast(base_url('admin/category/create'), 2, '创建失败!');

		}else{
			toast(base_url('admin/category/create'), 2, '表单数据不全，请完善后再提交!');
		}
	}

	public function delete(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if($this->Category_Model->delete($id)){
			toast($_SERVER['HTTP_REFERER'], 2, '删除成功！');
		}else{
			toast($_SERVER['HTTP_REFERER'], 2, '删除失败！');
		}
	}

	public function update(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$info = $this->Category_Model->getInfoById($id);
		$data['info'] = $info;
		$this->load->view('admin/category_update.html', $data);
	}

	public function edit(){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$pid = isset($_POST['pid']) ? $_POST['pid'] : 0;
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';

		$post_data = [
			'id' => $id,
			'name' => $name,
			'pid' => $pid,
			'keywords' => $keywords,
			'description' => $description
		];
		if($id && $name){
			if($this->Category_Model->update($post_data)){
				toast(base_url('admin/category'), 2, '修改成功！');
				return;
			}
			toast(base_url('admin/category/update?id=').$id, 2, '修改失败!');

		}else{
			toast(base_url('admin/category/update?id=').$id, 2, '表单数据不全，请完善后再提交!');
		}
	}
}