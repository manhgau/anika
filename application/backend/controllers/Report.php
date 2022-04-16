<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this->load->model('category_model');
	}

	function reportNewsSalary()
	{
		
	}

	public function viewerReport()
	{
		//load view template
        $this->data['meta_title'] = 'Thống kê Viewer';
        $this->data['sub_view'] = 'admin/report/viewer-report';
        // $this->data['sub_js'] = 'admin/news/viewer-js';
        $this->load->view('admin/_layout_main',$this->data);
	}
	

}