<?php
    class Category extends MY_Controller {

        public function __construct() 
        {
            parent::__construct();
            $this->load->model('category_model');

            //fetch breadcrumbs
            $this->data['breadcrumbs'] = array( 
                'Tin tức' => base_url('news'),
                'Chuyên mục' => base_url('category')
            );
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $this->data['categories'] = $this->category_model->get_tree_categories();

            //load view template
            $this->data['meta_title'] = 'Listing category';
            $this->data['sub_view'] = 'admin/category/index';
            $this->data['sub_js'] = 'admin/category/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Add new category';
            $this->data['list_category'][0] = ' Select Parent ';
            $_list_catgory = $this->category_model->get_by("status = 1");
            $this->data['list_category'] = $_list_catgory;
            
            /*if($_list_catgory) {
                foreach($_list_catgory as $_cat) {
                    $this->data['list_category'][$_cat->id] = $_cat->title;
                }
            }*/
            
            if($id) {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['category'] = $this->category_model->get($id);
                if(! count($this->data['category']) ) {
                    $this->data['errors'][] = 'category could not be found!';
                    redirect(base_url('category'));
                }
                $action = 'update';
                $this->data['meta_title'] = 'Edit category';
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['category'] = $this->category_model->get_new();
                $action = 'insert';
            }
            //validate form
            $rules = $this->category_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->category_model->array_from_post(array('title','description','status','parent_id','meta_description','meta_keyword','meta_title'));
                if($data['parent_id'] == 0) {
                    $data['level'] = 1;
                } else {
                    $_parent_cat = $this->category_model->get($data['parent_id']);
                    $data['level'] = $_parent_cat->level+1;
                }
                $data['slugname'] = build_slug($data['title']);
                if(!$data['meta_title']) $data['meta_title'] = $data['title'];
                if(!$data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if(!$data['meta_description']) $data['meta_description'] = $data['title'];
                if($save_id = $this->category_model->save($data,$id)) {
                    
                    //save history
                    if ( ! $id) $_action = 'Added';
                    else $_action = 'Updated';
                    $this->history_model->add_history(NULL,$_action,$save_id,'category');
                    
                    $this->session->set_flashdata('session_msg','Cập nhật chuyên mục thành công');
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật chuyên mục');
                }
                redirect(base_url('category'));
            }
            //Load view
            $this->data['meta_title'] = 'Thêm mới chuyên mục';
            if($id) {
                $this->data['meta_title'] = 'Sửa chuyên mục';
            }
            $this->data['sub_view'] = 'admin/category/edit';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL)
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            foreach ($post_id as $key => $val) {
                $this->category_model->delete($id);
                $this->history_model->add_history(NULL,'Deleted',$id,'category');
            }
            $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            redirect(base_url('category'));
        }

        public function _unique_slug($str) 
        {
            //Don't validate form if this slug already
            $id = $this->uri->segment(3);
            $this->db->where('slug',$this->input->post('slug'));
            !$id || $this->db->where('id !=', $id);
            $category = $this->category_model->get();
            if(count($category)) {
                $this->form_validation->set_message('_unique_slug','%s should be Unique');
                return FALSE;
            }
            return TRUE;
        }
}