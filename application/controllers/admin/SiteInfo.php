<?php

class SiteInfo extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('SiteInfo_Model');
	}

	public function index(){
		$site_info = $this->SiteInfo_Model->getSiteInfo();
		$data['site_info'] = $site_info;
		$this->load->view('admin/siteinfo.html', $data);
	}

	public function add(){
		$domain = isset($_POST['domain']) ? $_POST['domain'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';

		$post_data = [
			'domain' => $domain,
			'name' => $name,
			'keywords' => $keywords,
			'description' => $description
		];
		if($domain && $name && $keywords && $description){
			$this->SiteInfo_Model->postData($post_data);
			toast(base_url('admin/siteinfo'), 2, '数据提交成功！');
		}else{
			toast(base_url('admin/siteinfo'), 2, '表单数据不全，请完善后再提交!');
		}
	}
}