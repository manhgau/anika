<?php
    class Page extends MY_Controller {

        public function __construct() 
        {
            parent::__construct();
            $this->load->model('page_model');
            
            $this->data['breadcrumbs']['Trang'] = base_url('page');
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();     
            //fetch all pages
            $this->data['meta_title'] = 'Danh sách trang';
            $this->data['pages'] = $this->page_model->get_with_parent();

            //load view template
            $this->data['sub_view'] = 'admin/page/index';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Thêm trang mới';

            //Fetch a page or set a new one
            if($id) {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['page'] = $this->page_model->get($id);
                if(! count($this->data['page']) ) $this->data['errors'][] = 'page could not be found!';
                $this->data['meta_title'] = 'Sửa trang';
                $this->data['breacrumbs']['Edit page'] = base_url('page/edit/' . $id);
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['breadcrumbs']['Add new page'] = base_url('page/edit');
                $this->data['page'] = $this->page_model->get_new();
            }

            //Fetch list pages no parent
            $this->data['page_no_parent'] = $this->page_model->get_no_parent();

            //validate form        
            $rules = $this->page_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->page_model->array_from_post(array('title','order','content','parent_id','meta_title','meta_keyword','meta_description'));
                
                $data['slug'] = build_slug($data['title']);            
                
                if(!$data['meta_title']) $data['meta_title'] = $data['title'];
                if(!$data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if(!$data['meta_description']) $data['meta_description'] = $data['title'];
                if($saved_id = $this->page_model->save($data,$id)) {
                    //save history
                    if ($id) $_action = 'Updated';
                    else $_action = 'Added';
                    $this->history_model->add_history(NULL,$_action,$saved_id,'page');
                    $this->session->set_flashdata('session_msg','Cập nhật trang thành công');
                }
                else {
                    $this->session->set_flashdata('session_error','Lỗi! không thể cập nhật trang');
                }
                redirect(base_url('page'));
            }

            //Load view
            $this->data['sub_view'] = 'admin/page/edit';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $this->page_model->delete($id);
            //save history
            $_action = 'Deleted';
            $this->history_model->add_history(NULL,$_action,$id,'page');
            
            redirect('page');
        }

        public function _unique_slug($str) 
        {
            //Don't validate form if this slug already
            $id = $this->uri->segment(4);
            $this->db->where('slug',$this->input->post('slug'));
            !$id || $this->db->where('id !=', $id);
            $page = $this->page_model->get();
            if(count($page)) {
                $this->form_validation->set_message('_unique_slug','%s should be Unique');
                return FALSE;
            }
            return TRUE;
        }
}