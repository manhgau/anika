<?php
        class Partner extends MY_Controller {
                public function __construct() 
                {
                    parent::__construct();
                    $this->load->model('partner_model');
        
                    //fetch breadcrumbs
                    $this->data['breadcrumbs'] = array( 
                     
                        'Đối tác kinh doanh' => base_url('partner')
                    );
                }
        
                public function index() 
                {
                    if ( ! $this->has_permission('view')) $this->not_permission();
                    $this->data['partner'] = $this->partner_model->getList();

                    // print_r($this->data['partner']);
                    // exit();

                    //load view template
                    $this->data['meta_title'] = 'Listing category';
                    $this->data['sub_view'] = 'admin/partner/index';
                    $this->data['sub_js'] = 'admin/partner/index-js';
                    $this->load->view('admin/_layout_main',$this->data);
                }
        
                public function edit($id = NULL) 
                {
                    $this->data['meta_title'] = 'Thêm đối tác ';
                    $_list_catgory = $this->partner_model->getList();
                    $this->data['list_category'] = $_list_catgory;
                    if($id) {
                        if ( ! $this->has_permission('edit')) $this->not_permission();
                        $this->data['partner'] = $this->partner_model->get($id);
                        if(! $this->data['partner'] ) {
                            $this->data['errors'][] = 'partner could not be found!';
                            redirect(base_url('partner'));
                        }
                    }
                    else {
                        if ( ! $this->has_permission('add')) $this->not_permission();
                        $this->data['partner'] = $this->partner_model->get_new();
                        $action = 'insert';
                    }

                    $rules = $this->partner_model->rules;
                    // print_r($this->data['partner']);
                    // exit();
                    $this->form_validation->set_rules($rules);
                    if($this->form_validation->run() == TRUE) {                   
                        $data = $this->partner_model->array_from_post(array('name','status','image','description','is_hot'));
                        if(!$data['name']) $data['name'] = $data['name'];
                        if(!$data['description']) $data['description'] = $data['description'];
                        if($save_id = $this->partner_model->save($data,$id)) {
                           
                            $this->session->set_flashdata('session_msg','Cập nhật đối tác thành công');
                        }
                        else {
                            $this->session->set_flashdata('session_error','Không thể cập nhật đối tác');
                        }
                        // print_r($data);
                        // exit(); 
                        redirect(base_url('partner'));
                    }
                    
                    //Load view
                    $this->data['meta_title'] = 'Thêm mới đối tác';
                    if($id){
                        $this->data['meta_title'] = 'Sửa đối tác';
                    }
                    $this->data['sub_view'] = 'admin/partner/edit';
                    $this->data['sub_js'] = 'admin/partner/edit-js';
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
                        $this->partner_model ->delete($id);
                        $this->history_model->add_history(NULL,'Deleted',$id,'partner');
                    }
                    $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                    redirect(base_url('partner'));
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