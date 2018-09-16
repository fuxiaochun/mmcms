<?php

class Certificate extends CI_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('SiteInfo_Model');
        $this->load->model('Certificate_Model');
    }
    public function index(){
        // 头部元信息
		$head = $this->SiteInfo_Model->getSiteInfo();
        $data['head'] = $head;

        $this->load->view('home/certificate.html', $data);
    }
    public function getCertificateByCode(){
        $data = [
            'status'=> 0,
            'message' => '数据获取失败',
            'data' => null
        ];
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if($code !== ''){
            $info = $this->Certificate_Model->getInfoByCertificete($code);
            if($info){
                $data['data'] = $info;
                $data['status'] = 1;
                $data['message'] = 'success';
            }else{
                $data['status'] = 0;
                $data['message'] = '该证书编号无效';
            }
        }else{
            $data['message'] = '请输入有效的证书编码';
        }
        echo json_encode($data);
    }
}