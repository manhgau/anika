<?php
    class Faq extends MY_Controller {

        public function __construct() 
        {
            parent::__construct();
            $this->load->model('faq_model');
            
            $this->data['breadcrumbs']['Q&A'] = base_url('faq');
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();     
            //fetch all faqs
            $this->data['meta_title'] = 'Danh sách Q&A';
            $this->data['faqs'] = $this->faq_model->get();

            //load view template
            $this->data['sub_view'] = 'admin/faq/index';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Thêm mới';

            //Fetch a faq or set a new one
            if($id) {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['faq'] = $this->faq_model->get($id);
                if(! $this->data['faq'] ) $this->data['errors'][] = 'faq could not be found!';
                $this->data['meta_title'] = 'Sửa';
                $this->data['breacrumbs']['Edit faq'] = base_url('faq/edit/' . $id);
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['breadcrumbs']['Add new faq'] = base_url('faq/edit');
                $this->data['faq'] = $this->faq_model->get_new();
            }

            //validate form        
            $rules = $this->faq_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->faq_model->array_from_post(array('question','order','answer', 'status'));
                if($saved_id = $this->faq_model->save($data,$id)) {
                    //save history
                    $_action = ($id) ? 'Updated' : 'Added';
                    $this->session->set_flashdata('session_msg','Cập nhật thành công');
                }
                else {
                    $this->session->set_flashdata('session_error','Lỗi! không thể cập nhật');
                }
                redirect(base_url('faq'));
            }

            //Load view
            $this->data['sub_view'] = 'admin/faq/edit';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $this->faq_model->delete($id);
            //save history
            $_action = 'Deleted';
            redirect('faq');
        }
}