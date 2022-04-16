<?php
class History extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if($this->data['userdata']['level'] > 1)
        {
            $this->data['meta_title'] = 'Lịch sử';
            $this->not_permission();
        }
        $this->load->model('history_model');
    }
    
    public function index()
    {
        $month = (int)$this->input->get('month');
        $year = (int)$this->input->get('year');
        if($month < 10) $this->data['month'] = $month = '0'.$month;
        if ( ! (int)$month) $month = date('m',time());
        if ( ! $year) $year = date('Y',time());
        
        $this->data['month'] = (int)$month;
        $this->data['year'] = (int)$year;
        $this->data['histories'] = $this->history_model->get_history_by_month($month,$year);
        foreach ($this->data['histories'] as $key => $val) {
            if($val->item_table=='news') $_news_ids[] = $val->item_id;
        }
        $this->load->model('news_model');
        if (isset($_news_ids)) {
            $_news_ids = array_unique($_news_ids);
            $this->data['news'] = $this->news_model->news_history_by_id($_news_ids);
        }

        $this->data['users'] = $this->user_model->get_list_author();
        
        //Load view
        $this->data['meta_title'] = 'Logs: tháng ' . $month . ' năm ' . $year;
        $this->data['sub_view'] = 'admin/history/index';
        $this->data['sub_js'] = 'admin/history/index-js';
        $this->load->view('admin/_layout_main',$this->data);
    }
    
}