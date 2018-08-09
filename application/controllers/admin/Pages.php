<?php

class Pages extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Pages_Model');
	}
	public function index(){

		$cur_page = isset($_GET['p']) ? $_GET['p'] : 1;
		$search = isset($_GET['s']) ? $_GET['s'] : '';
		$pages_count = $this->Pages_Model->getCount($search);
		$limit = 10;
		$start = $limit * ($cur_page - 1);
		$res = $this->Pages_Model->getPages($limit, $start, $search);
		$data['search'] = $search;
		$data['pages'] = $res;

		$this->load->library('pagination');
		if($search){
			$config['base_url'] = base_url('/admin/pages/index?s='.$search);
		}else{
			$config['base_url'] = base_url('/admin/pages/index');
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

		$this->load->view('admin/pages_list.html', $data);
	}

	public function add(){
		if(empty($_POST)){
			$this->load->view('admin/pages_create.html');
		}else{
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
				if($this->Pages_Model->add($post_data)){
					toast(base_url('admin/pages'), 2, '页面创建成功！');
					return;
				}
				toast(base_url('admin/pages/create'), 2, '页面创建失败!');

			}else{
				toast(base_url('admin/pages/create'), 2, '表单数据不全，请完善后再提交!');
			}
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
		if(empty($_POST)){
			$id = isset($_GET['id']) ? $_GET['id'] : 0;
			$info = $this->Pages_Model->getInfoById($id);
			$data['info'] = $info;
			$this->load->view('admin/pages_update.html', $data);
		}else{
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
					toast(base_url('admin/pages'), 2, '修改成功！');
					return;
				}
				toast(base_url('admin/pages/update?id=').$id, 2, '修改失败!');

			}else{
				toast(base_url('admin/pages/update?id=').$id, 2, '表单数据不全，请完善后再提交!');
			}
		}
	}

}