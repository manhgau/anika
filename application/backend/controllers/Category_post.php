<?php
        class Category_post extends MY_Controller {
                public function __construct() 
                {
                    parent::__construct();
                    $this->load->model('category_post_model');
        
                    //fetch breadcrumbs
                    $this->data['breadcrumbs'] = array( 
                        // 'Danh sách sản phẩm' => base_url('products'),
                        'Danh mục bài viết' => base_url('category_post')
                    );
                }
        
                public function index() 
                {
                    if ( ! $this->has_permission('view')) $this->not_permission();
                    $this->data['category_post'] = $this->category_post_model->getList();

                    // print_r($this->data['category_post']);
                    // exit();

                    //load view template
                    $this->data['meta_title'] = 'Listing category';
                    $this->data['sub_view'] = 'admin/category_post/index';
                    $this->data['sub_js'] = 'admin/category_post/index-js';
                    $this->load->view('admin/_layout_main',$this->data);
                }
        
                public function edit($id = NULL) 
                {
                    $this->data['meta_title'] = 'Thêm danh mục ';
                    $_list_catgory = $this->category_post_model->getList();
                    $this->data['list_category'] = $_list_catgory;
                    if($id) {
                        if ( ! $this->has_permission('edit')) $this->not_permission();
                        $this->data['category_post'] = $this->category_post_model->get($id);
                        if(! $this->data['category_post'] ) {
                            $this->data['errors'][] = 'category_post could not be found!';
                            redirect(base_url('category_post'));
                        }
                    }
                    else {
                        if ( ! $this->has_permission('add')) $this->not_permission();
                        $this->data['category_post'] = $this->category_post_model->get_new();
                        $action = 'insert';
                    }

                    $rules = $this->category_post_model->rules;
                    // print_r($rules);
                    // exit();
                    $this->form_validation->set_rules($rules);
                    if($this->form_validation->run() == TRUE) {                   
                        $data = $this->category_post_model->array_from_post(array('name'));
                        if(!$data['name']) $data['name'] = $data['title'];
                        if($save_id = $this->category_post_model->save($data,$id)) {
                           
                            $this->session->set_flashdata('session_msg','Cập nhật danh mục thành công');
                        }
                        else {
                            $this->session->set_flashdata('session_error','Không thể cập nhật danh mục');
                        }
                        // print_r($data);
                        // exit(); 
                        redirect(base_url('category_post'));
                    }
                    
                    //Load view
                    $this->data['meta_title'] = 'Thêm mới danh mục';
                    if($id) {
                        $this->data['meta_title'] = 'Sửa danh mục';
                    }
                    $this->data['sub_view'] = 'admin/category_post/edit';
                    $this->data['sub_js'] = 'admin/category_post/edit-js';
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
                        $this->category_post_model ->delete($id);
                        $this->history_model->add_history(NULL,'Deleted',$id,'category_post');
                    }
                    $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                    redirect(base_url('category_post'));
                }
        
                // public function _unique_slug($str) 
                // {
                //     //Don't validate form if this slug already
                //     $id = $this->uri->segment(3);
                //     $this->db->where('slug',$this->input->post('slug'));
                //     !$id || $this->db->where('id !=', $id);
                //     $category_post = $this->category_post_model->get();
                //     if(count($category_post)) {
                //         $this->form_validation->set_message('_unique_slug','%s should be Unique');
                //         return FALSE;
                //     }
                //     return TRUE;
                // }

        

         }

?>