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

	public function add(){
		if(empty($_POST)){
			$cats = $this->Category_Model->getCategoryTree();
			$data['categorys'] = $cats;
			$this->load->view('admin/article_create.html', $data);
		}else{
			$title = isset($_POST['title']) ? $_POST['title'] : '';
			$focus_img = isset($_POST['focus_img']) ? $_POST['focus_img'] : '';
			$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
			$outlink = isset($_POST['outlink']) ? $_POST['outlink'] : '';
			$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
			$summary = isset($_POST['summary']) ? $_POST['summary'] : '';
			$author = isset($_POST['author']) ? $_POST['author'] : '';
			$origin = isset($_POST['origin']) ? $_POST['origin'] : '';
			$recommend = isset($_POST['recommend']) ? $_POST['recommend'] : 0;
			$content = isset($_POST['content']) ? $_POST['content'] : '';

			// 判断上传目录是否存在，不存在则创建。
			$uploads = './uploads/';
			if(!file_exists($uploads)){
				mkdir($uploads);
				chmod($uploads,0777);
			}

			// 上传图片
			$config['upload_path'] = $uploads;
			$config['file_name'] = time().mt_rand(100000,1000000);
			$config['allowed_types'] = ['png','jpg','gif'];
			$config['max_size'] = 1024;

        	$this->load->library('upload', $config);
			if(!empty($_FILES) && $_FILES['focus_img']['error'] !== 4){
				if ( ! $this->upload->do_upload('focus_img')){
					$error = array('error' => $this->upload->display_errors());
					toast(base_url('admin/article/add'), 2, $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					if($data['upload_data']['is_image'] == 1){
						$focus_img = $data['upload_data']['file_name'];
					}else{
						toast(base_url('admin/article/add'), 2, '请上传合法的图片！');
					}
				}
			}

			$post_data = [
				'title' => $title,
				'category_id' => $category_id,
				'focus_img' => $focus_img,
				'outlink' => $outlink,
				'keywords' => $keywords,
				'summary' => $summary,
				'author' => $author,
				'origin' => $origin,
				'recommend' => $recommend,
				'content' => $content,
			];
			if($title && $category_id && $content){
				if($this->Article_Model->add($post_data)){
					toast(base_url('admin/article'), 2, '创建成功！');
					return;
				}
				toast(base_url('admin/article/add'), 2, '创建失败!');

			}else{
				toast(base_url('admin/article/add'), 2, '表单数据不全，请完善后再提交!');
			}
		}
	}

	public function delete(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if($this->Article_Model->delete($id)){
			toast($_SERVER['HTTP_REFERER'], 2, '删除成功！');
		}else{
			toast($_SERVER['HTTP_REFERER'], 2, '删除失败！');
		}
	}

	public function update(){
		if(empty($_POST)){
			$id = isset($_GET['id']) ? $_GET['id'] : 0;
			$info = $this->Article_Model->getInfoById($id);
			$cats = $this->Category_Model->getCategoryTree();
			$data['categorys'] = $cats;
			$data['info'] = $info;
			$this->load->view('admin/article_update.html', $data);
		}else{
			$id = isset($_POST['id']) ? $_POST['id'] : '';
			$title = isset($_POST['title']) ? $_POST['title'] : '';
			$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
			$focus_img = isset($_POST['focus_img']) ? $_POST['focus_img'] : '';
			$outlink = isset($_POST['outlink']) ? $_POST['outlink'] : '';
			$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
			$summary = isset($_POST['summary']) ? $_POST['summary'] : '';
			$author = isset($_POST['author']) ? $_POST['author'] : '';
			$origin = isset($_POST['origin']) ? $_POST['origin'] : '';
			$recommend = isset($_POST['recommend']) ? $_POST['recommend'] : 0;
			$content = isset($_POST['content']) ? $_POST['content'] : '';

			// 判断上传目录是否存在，不存在则创建。
			$uploads = './uploads/';
			if(!file_exists($uploads)){
				mkdir($uploads);
				chmod($uploads,0777);
			}

			// 上传图片
			$config['upload_path'] = $uploads;
			$config['file_name'] = time().mt_rand(100000,1000000);
			$config['allowed_types'] = ['png','jpg','gif'];
			$config['max_size'] = 1024;

        	$this->load->library('upload', $config);
			if(!empty($_FILES) && $_FILES['focus_img']['error'] !== 4){
				if ( ! $this->upload->do_upload('focus_img')){
					$error = array('error' => $this->upload->display_errors());
					toast(base_url('admin/article/add'), 2, $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					if($data['upload_data']['is_image'] == 1){
						$focus_img = $data['upload_data']['file_name'];
					}else{
						toast(base_url('admin/article/add'), 2, '请上传合法的图片！');
					}
				}
			}

			$post_data = [
				'id' => $id,
				'title' => $title,
				'category_id' => $category_id,
				'focus_img' => $focus_img,
				'outlink' => $outlink,
				'keywords' => $keywords,
				'summary' => $summary,
				'author' => $author,
				'origin' => $origin,
				'recommend' => $recommend,
				'content' => $content,
			];
			if($id && $title && $category_id){
				if($this->Article_Model->update($post_data)){
					toast(base_url('admin/article'), 2, '修改成功！');
					return;
				}
				toast(base_url('admin/article/update?id=').$id, 2, '修改失败!');

			}else{
				toast(base_url('admin/article/update?id=').$id, 2, '表单数据不全，请完善后再提交!');
			}
		}
	}
}