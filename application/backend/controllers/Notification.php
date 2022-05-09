<?php
require_once APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
class Notification extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notification_model');
        $this->load->model('user_model');

        //fetch breadcrumbs
        $this->data['breadcrumbs'] = array(
            // 'Danh sách sản phẩm' => base_url('products'),
            'Danh mục thông báo' => base_url('notification')
        );
    }

    public function index()
    {
        if ( ! $this->has_permission('view')) $this->not_permission();

        //Fetch category
        $authorName = ($this->input->get_post('authorName')) ? $this->input->get_post('authorName') : '' ;
        $keyword = ($this->input->get_post('keyword')) ? $this->input->get_post('keyword') : '' ;
        
        
        
        $this->data['filters']['authorName'] = $authorName;
        $this->data['filters']['keyword'] = $keyword;
        
        
        //Fetch all author
        $authorFilterId = NULL;
        $this->data['authors'] = $authors = $this->user_model->get_list_author();
        foreach ($authors as $key => $val) {
            if($val->name == $authorName)
            {
                $authorFilterId = $val->id;
            }
        }



        $this->data['notifications'] = array();
        $list_notification = $this->notification_model->get_list_notification(0, 10,$authorFilterId, $keyword);
        

        //fetch category for article
        foreach ($list_notification as $key => $val) {
            $item = $val;
            $this->data['notifications'][] = $item;
        }
        $this->data['meta_title'] = 'Notification';
        $this->data['sub_view'] = 'admin/notification/index';
        $this->data['sub_js'] = 'admin/notification/index-js';
        $this->load->view('admin/_layout_main',$this->data);
    }
    

    public function edit($id = NULL)
    {

        $type = ($this->input->get_post('type')) ? $this->input->get_post('type') : NULL;
        $sender = ($this->input->get_post('sender_type')) ? $this->input->get_post('sender_type') : NULL;
        $this->data['meta_title'] = 'Thêm thông báo mới';
        $this->data['breadcrumbs'] = array('Thông báo' => base_url('notification'));

        if($id)
        {
            if ( ! $this->has_permission('edit') && $id != $this->data['userdata']['id']) $this->not_permission();
            $this->data['notification'] = $this->notification_model->get($id);
            if(! $this->data['notification'] ) $this->data['errors'][] = 'Notification could not be found!';
            $this->data['meta_title'] = 'Nội dung thông báo';
            $this->data['breadcrumbs']['Sửa'] = base_url('notification/edit/' . $id);
        }
        else
        {
            if ( ! $this->has_permission('add')) $this->not_permission();
            $this->data['notification'] = $this->notification_model->get_new($type, $sender);
            $this->data['notification']->type = $type;
            $this->data['notification']->sender_type = $sender;
            $this->data['breadcrumbs']['Thêm'] = base_url('notification/edit/');
        }

        //validate form
        $rules = $this->notification_model->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->notification_model->array_from_post(array('title','content','type','status','sender_type', 'created_by'));
            if (!$data['title']) $data['title'] = $data['title'];
            if (!$id) {
                $data['created_by'] = $this->data['userdata']['id'];
                $data['created_time'] = date('Y-m-d H:i:s', time());
            }
            if ($id = $this->notification_model->save($data, $id)) {

                $this->session->set_flashdata('session_msg', 'Cập nhật thành công.');
            } else {
                $this->session->set_flashdata('session_error', 'Không thể cập nhật dữ liệu.');
            }
            redirect(base_url('notification'));
        }
        $this->data['notification_type'] = config_item('notification_type');
        $this->data['notification_sender'] = config_item('notification_sender');
        //Load view
        $this->data['sub_view'] = 'admin/notification/edit';
        $this->load->view('admin/_layout_main',$this->data);

    }

    public function delete($id = NULL)
    {
        $news = $this->notification_model->get($id,true);
        $post_id = $this->input->post('ids');
        if($id) {
            $post_id[] = $id;
        }
        if($this->notification_model->delete_list($post_id)) {

            //save history
            $_action = 'Deleted';
            foreach ($post_id as $key => $val) {
                $this->history_model->add_history(NULL,$_action,$val,'news');
            }

            $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
        }
        else {
            $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
        }
        redirect(base_url('notification'));
    }




}

?>