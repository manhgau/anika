<?php
class Dashboard extends MY_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->model('option_model');
        $this->load->model('video_model');
    }

    public function index() 
    {
        redirect('realnews/index');
        
        //get report news
        $this->data['newsReport'] = array(
            'myNews' => $this->news_model->reportNewsByUser($this->data['userdata']['id']),
            'myNewsPending' => $this->news_model->reportNewsByUser($this->data['userdata']['id'],2),
            'myNewsTrash' => $this->news_model->reportNewsByUser($this->data['userdata']['id'],3),
            'myNewsWritting' => $this->news_model->reportNewsByUser($this->data['userdata']['id'],4),
            'myNewsReturn' => $this->news_model->reportNewsByUser($this->data['userdata']['id'],5),
            'myNewsApproved' => $this->news_model->reportNewsByUser($this->data['userdata']['id'],1)
        );

        //Load view
        $this->data['meta_title'] = 'Bảng điều khiển';
        $this->data['sub_view'] = 'admin/dashboard/index';
        $this->data['sub_js'] = 'admin/dashboard/index-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function modal() 
    {
        $this->load->view('admin/_layout_modal',$this->data);
    }

    function check() 
    {
        echo get_image_thumb('2016_09_14/download-1473843275.jpg');
    }

    public function newsletter() 
    {
        $this->load->model('portfolio_model');
        $this->load->model('memtor_model');
        $this->data['portfolios'] = $this->portfolio_model->get();
        $this->data['mentors'] = $this->memtor_model->get();

        //Load View
        $this->data['meta_title'] = 'Newsletter Subcribers';
        $this->data['sub_view'] = 'admin/dashboard/newsletter';
        $this->data['sub_js'] = 'admin/dashboard/newsletter-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function newsletterList()
    {
        $from_date = $this->input->get_post('from_date');
        $to_date = $this->input->get_post('to_date');
        $where = [];
        if ($from_date) 
            $where['DATE(created_time) >='] = $from_date;
        $where = [];
        if ($to_date) 
            $where['DATE(created_time) <='] = $to_date;

        $data['list'] = $this->db->order_by('id', 'desc')->get_where('newsletter', $where)->result();

        echo $this->load->view('admin/dashboard/newsletter-list', $data, TRUE);
    }
}