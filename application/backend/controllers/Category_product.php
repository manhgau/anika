<?php
        class Category_product extends MY_Controller {
                public function __construct() 
                {
                    parent::__construct();
                    $this->load->model('category_product_model');
        
                    //fetch breadcrumbs
                    $this->data['breadcrumbs'] = array( 
                        // 'Danh sách sản phẩm' => base_url('products'),
                        'Danh mục sản phẩm' => base_url('category_product')
                    );
                }
        
                public function index() 
                {
                    if ( ! $this->has_permission('view')) $this->not_permission();
                    $this->data['category_product'] = $this->category_product_model->getList();

                    // print_r($this->data['category_product']);
                    // exit();

                    //load view template
                    $this->data['meta_title'] = 'Listing category';
                    $this->data['sub_view'] = 'admin/category_product/index';
                    $this->data['sub_js'] = 'admin/category_product/index-js';
                    $this->load->view('admin/_layout_main',$this->data);
                }
        
                public function edit($id = NULL) 
                {
                    $this->data['meta_title'] = 'Thêm danh mục ';
                    $_list_catgory = $this->category_product_model->get_by("status = 1");
                    $this->data['list_category'] = $_list_catgory;
                    
                    /*if($_list_catgory) {
                        foreach($_list_catgory as $_cat) {
                            $this->data['list_category'][$_cat->id] = $_cat->title;
                        }
                    }*/

                    if($id) {
                        if ( ! $this->has_permission('edit')) $this->not_permission();
                        $this->data['category_product'] = $this->category_product_model->get($id);
                        if(! $this->data['category_product'] ) {
                            $this->data['errors'][] = 'category_product could not be found!';
                            redirect(base_url('category_product'));
                        }
                        $action = 'update';
                        $this->data['meta_title'] = 'Edit category_product';
                    }
                    else {
                        if ( ! $this->has_permission('add')) $this->not_permission();
                        $this->data['category_product'] = $this->category_product_model->get_new();
                        $action = 'insert';
                    }
                    //   print_r($this->data['category_product']);
                    // exit();
                    //validate form
                    $rules = $this->category_product_model->rules;
                    $this->form_validation->set_rules($rules);
                    if($this->form_validation->run() == TRUE) {
                        $data = $this->category_product_model->array_from_post(array('title','description','status','meta_description','meta_keyword','meta_title','image'));
                       
                        $data['slugname'] = build_slug($data['title']);
                        if(!$data['meta_title']) $data['meta_title'] = $data['title'];
                        if(!$data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                        if(!$data['meta_description']) $data['meta_description'] = $data['title'];
                        if($save_id = $this->category_product_model->save($data,$id)) {
                            
                            //save history
                            if ( ! $id) $_action = 'Added';
                            else $_action = 'Updated';
                            $this->history_model->add_history(NULL,$_action,$save_id,'category_product');
                            
                            $this->session->set_flashdata('session_msg','Cập nhật danh mục thành công');
                        }
                        else {
                            $this->session->set_flashdata('session_error','Không thể cập nhật danh mục');
                        }
                        
                        redirect(base_url('category_product'));
                    }
                    //Load view
                    $this->data['meta_title'] = 'Thêm mới danh mục';
                    if($id) {
                        $this->data['meta_title'] = 'Sửa danh mục';
                    }
                    $this->data['sub_view'] = 'admin/category_product/edit';
                    $this->data['sub_js'] = 'admin/category_product/edit-js';
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
                        $this->category_product_model ->delete($id);
                        $this->history_model->add_history(NULL,'Deleted',$id,'category_product');
                    }
                    $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                    redirect(base_url('category_product'));
                }
        
                public function _unique_slug($str) 
                {
                    //Don't validate form if this slug already
                    $id = $this->uri->segment(3);
                    $this->db->where('slug',$this->input->post('slug'));
                    !$id || $this->db->where('id !=', $id);
                    $category_product = $this->category_product_model->get();
                    if(count($category_product)) {
                        $this->form_validation->set_message('_unique_slug','%s should be Unique');
                        return FALSE;
                    }
                    return TRUE;
                }

        

         }

?>