<?php
        class Setting_bussiness extends MY_Controller {
                public function __construct() 
                {
                    parent::__construct();
                    $this->load->model('setting_bussiness_model');
        
                    //fetch breadcrumbs
                    $this->data['breadcrumbs'] = array( 
                        // 'Danh sách sản phẩm' => base_url('products'),
                        'Lĩnh vực kinh doanh' => base_url('setting_bussiness')
                    );
                }
        
                public function index() 
                {
                    if ( ! $this->has_permission('view')) $this->not_permission();
                    $this->data['setting_bussiness'] = $this->setting_bussiness_model->getList();

                    // print_r($this->data['setting_bussiness']);
                    // exit();

                    //load view template
                    $this->data['meta_title'] = 'Lĩnh vực kinh doanh';
                    $this->data['sub_view'] = 'admin/setting_bussiness/index';
                    $this->data['sub_js'] = 'admin/setting_bussiness/index-js';
                    $this->load->view('admin/_layout_main',$this->data);
                }
        
                public function edit($id = NULL) 
                {
                    $this->data['meta_title'] = 'Thêm danh mục ';
                    $_list_catgory = $this->setting_bussiness_model->getList();
                    $this->data['list_category'] = $_list_catgory;
                    if($id) {
                        if ( ! $this->has_permission('edit')) $this->not_permission();
                        $this->data['setting_bussiness'] = $this->setting_bussiness_model->get($id);
                        if(! $this->data['setting_bussiness'] ) {
                            $this->data['errors'][] = 'setting_bussiness could not be found!';
                            redirect(base_url('setting_bussiness'));
                        }
                    }
                    else {
                        if ( ! $this->has_permission('add')) $this->not_permission();
                        $this->data['setting_bussiness'] = $this->setting_bussiness_model->get_new();
                        $action = 'insert';
                    }

                    $rules = $this->setting_bussiness_model->rules;
                
                    $this->form_validation->set_rules($rules);
                    if($this->form_validation->run() == TRUE) {                   
                        $data = $this->setting_bussiness_model->array_from_post(array('name','status','image'));
                        if(!$data['name']) $data['name'] = $data['title'];
                        if($save_id = $this->setting_bussiness_model->save($data,$id)) {
                           
                            $this->session->set_flashdata('session_msg','Cập nhật danh mục thành công');
                        }
                        else {
                            $this->session->set_flashdata('session_error','Không thể cập nhật danh mục');
                        }
                        // print_r($data);
                        // exit(); 
                        redirect(base_url('setting_bussiness'));
                    }
                    
                    //Load view
                    $this->data['meta_title'] = 'Thêm mới danh mục';
                    if($id) {
                        $this->data['meta_title'] = 'Sửa danh mục';
                    }
                    $this->data['sub_view'] = 'admin/setting_bussiness/edit';
                    $this->data['sub_js'] = 'admin/setting_bussiness/edit-js';
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
                        $this->setting_bussiness_model ->delete($id);
                        $this->history_model->add_history(NULL,'Deleted',$id,'setting_bussiness');
                    }
                    $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                    redirect(base_url('setting_bussiness'));
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