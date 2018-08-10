<?php

class Certificate extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Certificate_Model');
	}
	public function index(){

		$cur_page = isset($_GET['p']) ? $_GET['p'] : 1;
		$search = isset($_GET['s']) ? $_GET['s'] : '';
		$pages_count = $this->Certificate_Model->getCount($search);
		$limit = 10;
		$start = $limit * ($cur_page - 1);
		$res = $this->Certificate_Model->getList($limit, $start, $search);
		$data['search'] = $search;
		$data['certificate'] = $res;

		$this->load->library('pagination');
		if($search){
			$config['base_url'] = base_url('/admin/certificate/index?s='.$search);
		}else{
			$config['base_url'] = base_url('/admin/certificate/index');
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

		$this->load->view('admin/certificate_list.html', $data);
	}

	public function add(){
		if(empty($_POST)){
			$this->load->view('admin/certificate_create.html');
		}else{
			$year = isset($_POST['year']) ? trim($_POST['year']) : date('Y');
			$certificate = isset($_POST['certificate']) ? strtoupper(trim($_POST['certificate'])) : '';
			$name = isset($_POST['name']) ? trim($_POST['name']) : '';
			$texture = isset($_POST['texture']) ? trim($_POST['texture']) : '';
			$size = isset($_POST['size']) ? trim($_POST['size']) : '';
			$weight = isset($_POST['weight']) ? trim($_POST['weight']) : '';
			$product_img = isset($_POST['product_img']) ? trim($_POST['product_img']) : '';
			
			// 判断证书是否已存在
			$hasCertificate = $this->Certificate_Model->getCountByCertificate($certificate);
			if($hasCertificate > 0){
				toast(base_url('admin/certificate/add'), 2, '证书编号'.$certificate.'已存在！');
				exit;
			}

			// 判断上传目录是否存在，不存在则创建。
			$certificate_images_dir = './certificate_imgs/';
			if(!file_exists($certificate_images_dir)){
				mkdir($certificate_images_dir);
				chmod($certificate_images_dir,0777);
			}
			$year_dir = $certificate_images_dir.$year;
			if(!file_exists($year_dir)){
				mkdir($year_dir);
				chmod($year_dir,0777);
			}

			// 上传图片
			$config['upload_path'] = $year_dir;
			$config['file_name'] = strtolower($certificate);
			$config['allowed_types'] = ['png','jpg','gif'];
			$config['max_size'] = 1024;

        	$this->load->library('upload', $config);
			if(!empty($_FILES) && $_FILES['product_img']['error'] !== 4){
				if ( ! $this->upload->do_upload('product_img')){
					$error = array('error' => $this->upload->display_errors());
					toast(base_url('admin/certificate/add'), 2, $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					if($data['upload_data']['is_image'] == 1){
						$product_img = $data['upload_data']['file_name'];
					}else{
						toast(base_url('admin/certificate/add'), 2, '请上传合法的图片！');
					}
				}
			}

			$post_data = [
				'year' => $year,
				'certificate' => $certificate,
				'name' => $name,
				'texture' => $texture,
				'size' => $size,
				'weight' => $weight,
				'product_img' => $product_img
			];
			function validate($arr){
				$status = true;
				foreach($arr as $k => $v){
					if($v === ''){
						$status = false;
						break;
					}
				}
				return $status;
			}
			if(validate($post_data)){
				if($this->Certificate_Model->add($post_data)){
					toast(base_url('admin/certificate'), 2, '创建成功！');
					return;
				}
				toast(base_url('admin/certificate/add'), 2, '创建失败!');

			}else{
				toast(base_url('admin/certificate/add'), 2, '表单数据不全，请完善后再提交!');
			}
		}
	}

	public function delete(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$info = $this->Certificate_Model->getInfoById($id);
		if($this->Certificate_Model->delete($id)){
			@unlink('./certificate_imgs/'.$info['year'].'/'.$info['product_img']);
			toast($_SERVER['HTTP_REFERER'], 2, '删除成功！');
		}else{
			toast($_SERVER['HTTP_REFERER'], 2, '删除失败！');
		}
	}

	public function update(){
		if(empty($_POST)){
			$id = isset($_GET['id']) ? $_GET['id'] : 0;
			$info = $this->Certificate_Model->getInfoById($id);
			$data['info'] = $info;
			$this->load->view('admin/certificate_update.html', $data);
		}else{
			$id = isset($_POST['id']) ? $_POST['id'] : '';
			$name = isset($_POST['name']) ? trim($_POST['name']) : '';
			$texture = isset($_POST['texture']) ? trim($_POST['texture']) : '';
			$size = isset($_POST['size']) ? trim($_POST['size']) : '';
			$weight = isset($_POST['weight']) ? trim($_POST['weight']) : '';
			$product_img = isset($_POST['product_img']) ? trim($_POST['product_img']) : '';
			
			// 通过ID拿年份和证书编号
			$info = $this->Certificate_Model->getInfoById($id);
			$year = $info['year'];
			$certificate = $info['certificate'];

			// 判断上传目录是否存在，不存在则创建。
			$certificate_images_dir = './certificate_imgs/';
			if(!file_exists($certificate_images_dir)){
				mkdir($certificate_images_dir);
				chmod($certificate_images_dir,0777);
			}
			$year_dir = $certificate_images_dir.$year;
			if(!file_exists($year_dir)){
				mkdir($year_dir);
				chmod($year_dir,0777);
			}

			// 上传图片
			$config['upload_path'] = $year_dir;
			$config['file_name'] = strtolower($certificate);
			$config['allowed_types'] = ['png','jpg','gif'];
			$config['max_size'] = 1024;
			$config['overwrite'] = true;

        	$this->load->library('upload', $config);
			if(!empty($_FILES) && $_FILES['product_img']['error'] !== 4){
				if ( ! $this->upload->do_upload('product_img')){
					$error = array('error' => $this->upload->display_errors());
					toast(base_url('admin/certificate/update'), 2, $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					if($data['upload_data']['is_image'] == 1){
						$product_img = $data['upload_data']['file_name'];
					}else{
						toast(base_url('admin/certificate/update'), 2, '请上传合法的图片！');
					}
				}
			}

			$post_data = [
				'id' => $id,
				'year' => $year,
				'certificate' => $certificate,
				'name' => $name,
				'texture' => $texture,
				'size' => $size,
				'weight' => $weight,
				'product_img' => $product_img
			];
			function validate($arr){
				$status = true;
				foreach($arr as $k => $v){
					if($v === ''){
						$status = false;
						break;
					}
				}
				return $status;
			}
			if(validate($post_data)){
				if($this->Certificate_Model->update($post_data)){
					toast(base_url('admin/certificate'), 2, '修改成功！');
					return;
				}
				toast(base_url('admin/certificate/update?id=').$id, 2, '修改失败!');

			}else{
				toast(base_url('admin/certificate/update?id=').$id, 2, '表单数据不全，请完善后再提交!');
			}
		}
	}
}