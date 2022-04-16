<?php
    class Newspaper extends MY_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('newspaper_model');
        }

        public function index($id=NULL)
        {
            // get detail link
            if ($id) 
            {
                $id = (int)$id;
                $this->data['news'] = $this->newspaper_model->get($id,TRUE);
            }
            else 
            {
                $this->data['news'] = $this->newspaper_model->getNew();
                $id = NULL;
            }
            
            //save data when form submited
            $rules = $this->newspaper_model->rules;
            if (!$id) 
                $rules['newsUrl']['rules'] .= '|callback__uniqueUrl';
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()==TRUE)
            {
                $input_args = array('title','image','newsUrl', 'order', 'isHot', 'on_page');
                $data = $this->newspaper_model->array_from_post($input_args);
                $data['on_page'] = strtolower($data['on_page']);
                if (! in_array($data['on_page'], array_keys($this->newspaper_model->getPageShow()))) {
                    $this->session->set_flashdata('session_error','Trang hiển thị không hợp lệ');
                    redirect('/newspaper/index');
                }

                if (!$id) {
                    $data['createTime'] = date('Y-m-d H:i:s');
                    $data['createBy'] = intval($this->data['userdata']['id']);
                }
                if ($savedId = $this->newspaper_model->save($data,$id)) 
                    $this->session->set_flashdata('session_msg','Saved Success');
                else 
                    $this->session->set_flashdata('session_error','Can not save data');
                redirect('/newspaper/index');
            }
            
            //Fetch all link
            $this->data['listNews'] = $this->newspaper_model->get();

            //Load view
            $this->data['meta_title'] = 'Media about Us';
            $this->data['sub_view'] = 'admin/newspaper/index';
            $this->data['sub_js'] = 'admin/newspaper/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function delete($id=NULL)
        {
            $result = array('code'=>0, 'msg' => 'success');
            if ( ! $this->newspaper_model->delete($id))
            {
                $result['code'] = -1;
                $result['msg'] = 'Deleted error';
            }
            redirect('/newspaper/index');
        }

        public function _uniqueUrl()
        {
            $url = $this->input->post('newsUrl');
            $args = ['newsUrl' => $url];
            if ($this->newspaper_model->get_by($args, TRUE)) 
            {
                $this->form_validation->set_message('_uniqueUrl','Link bài viết đã tồn tại');
                return FALSE;
            }

            return TRUE;

        }

        public function getNextPosition($page='all')
        {
            echo $this->newspaper_model->getNextOrder($page);
        }
}