<?php
        class Business_setting extends MY_Controller {
                public function __construct() 
                {
                    parent::__construct();
                    $this->load->model('business_setting_model');
        
                    //fetch breadcrumbs
                    $this->data['breadcrumbs'] = array( 
                        // 'Danh sách sản phẩm' => base_url('products'),
                        'Lĩnh vực kinh doanh' => base_url('business_setting')
                    );
                }
        
                public function index() 
                {
                    if ( ! $this->has_permission('view')) $this->not_permission();
                    $this->data['business_setting'] = $this->business_setting_model->getList();

                    // print_r($this->data['business_setting']);
                    // exit();

                    //load view template
                    $this->data['meta_title'] = 'Listing category';
                    $this->data['sub_view'] = 'admin/business_setting/index';
                    $this->data['sub_js'] = 'admin/business_setting/index-js';
                    $this->load->view('admin/_layout_main',$this->data);
                }
        
                public function edit($id = NULL) 
                {
                    $this->data['meta_title'] = 'Thêm danh mục ';
                    $_list_catgory = $this->business_setting_model->getList();
                    $this->data['list_category'] = $_list_catgory;
                    if($id) {
                        if ( ! $this->has_permission('edit')) $this->not_permission();
                        $this->data['business_setting'] = $this->business_setting_model->get($id);
                        if(! $this->data['business_setting'] ) {
                            $this->data['errors'][] = 'business_setting could not be found!';
                            redirect(base_url('business_setting'));
                        }
                    }
                    else {
                        if ( ! $this->has_permission('add')) $this->not_permission();
                        $this->data['business_setting'] = $this->business_setting_model->get_new();
                        $action = 'insert';
                    }

                    $rules = $this->business_setting_model->rules;
                    // print_r($rules);
                    // exit();
                    $this->form_validation->set_rules($rules);
                    if($this->form_validation->run() == TRUE) {                   
                        $data = $this->business_setting_model->array_from_post(array('name','status','image'));
                        if(!$data['name']) $data['name'] = $data['title'];
                        if($save_id = $this->business_setting_model->save($data,$id)) {
                           
                            $this->session->set_flashdata('session_msg','Cập nhật danh mục thành công');
                        }
                        else {
                            $this->session->set_flashdata('session_error','Không thể cập nhật danh mục');
                        }
                        // print_r($data);
                        // exit(); 
                        redirect(base_url('business_setting'));
                    }
                    
                    //Load view
                    $this->data['meta_title'] = 'Thêm mới danh mục';
                    if($id) {
                        $this->data['meta_title'] = 'Sửa danh mục';
                    }
                    $this->data['sub_view'] = 'admin/business_setting/edit';
                    $this->data['sub_js'] = 'admin/business_setting/edit-js';
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
                        $this->business_setting_model ->delete($id);
                        $this->history_model->add_history(NULL,'Deleted',$id,'business_setting');
                    }
                    $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                    redirect(base_url('business_setting'));
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