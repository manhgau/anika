<?php
    class Backlink extends MY_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('back_link_model');
        }

        public function index($id=NULL)
        {
            
            // get detail link
            if ($id) 
            {
                $id = (int)$id;
                $this->data['link'] = $this->back_link_model->get($id,TRUE);
            }
            else 
            {
                $this->data['link'] = $this->back_link_model->getNew();
                $id = NULL;
            }
            
            //save data when form submited
            $rules = $this->back_link_model->rules;
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()==TRUE)
            {
                $input_args = array('keyword','link','status');
                $data = $this->back_link_model->array_from_post($input_args);
                if ( ! $data['status']) $data['status'] = 2;
                
                if ($saved_id = $this->back_link_model->save($data,$id))
                {
                    $this->session->set_flashdata('session_msg','Saved Success');
                }
                else {
                    $this->session->set_flashdata('session_error','Can not save data');
                }
                redirect(base_url('backlink'));
            }
            
            //Fetch all link
            $this->data['links'] = $this->back_link_model->get();
            //Load view
            $this->data['meta_title'] = 'Quản lý BackLink';
            $this->data['sub_view'] = 'admin/backlink/index';
            $this->data['sub_js'] = 'admin/backlink/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function delete($id=NULL)
        {
            $result = array('code'=>0, 'msg' => 'success');
            $ids = $this->input->get_post('ids');
            if ($id) $ids[]=(int)$id;
            if ( ! $this->back_link_model->delete($ids))
            {
                $result['code'] = -1;
                $result['msg'] = 'Deleted error';
            }
            echo json_encode($result);
        }
}