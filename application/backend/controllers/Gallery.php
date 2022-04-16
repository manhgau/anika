<?php
    class Gallery extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('gallery_model');
            $this->load->model('gallery_image_model');
            
        }

        public function index() {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $status = (int)$this->input->get_post('status');
            $this->data['filters']['status'] = $status;

            $this->data['galleries'] = $galleries = $this->gallery_model->getListGallery($status);
            //Load view
            $this->data['meta_title'] = 'Quản lý Gallery';
            $this->data['sub_view'] = 'admin/gallery/index';
            $this->data['sub_js'] = 'admin/gallery/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id=0) 
        {
            if($this->data['userdata']['level'] > 2) $this->not_permission();
            $id = (int)$id;
            if(!$id) $id = NULL;
            if($id)
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['gallery'] = $gallery = $this->gallery_model->get($id,true);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['gallery'] = $gallery = $this->gallery_model->get_new();
            }

            //Fetch list image for this gallery
            $this->data['images'] = $this->gallery_image_model->getImagesByGallery($id);

            //validation form
            $rules = $this->gallery_model->rules;
            $this->form_validation->set_rules($rules);
            if ( $this->form_validation->run()==true ) {
                $input_var = array('title','status','description','meta_title','meta_keyword','meta_description','is_hot');
                $data = $this->gallery_model->array_from_post($input_var);
                $data['slugname'] = build_slug($data['title']);
                if(!$data['meta_title']) $data['meta_title'] = $data['title'];
                if(!$data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if(!$data['meta_description']) $data['meta_description'] = $data['description'];
                if(!isset($data['status'])) $data['status'] = 2;
                if(!isset($data['is_hot'])) $data['is_hot'] = 0;

                //Fetch input images
                $_images_args = array('images','caption','position','thumbnail');
                $_images = $this->gallery_image_model->array_from_post($_images_args);
                if(!isset($_images['thumbnail'])) {
                    $_images['thumbnail'] = end($_images['images']);
                }
                $data['thumbnail'] = $_images['thumbnail'];
                if ( ! $id) $_action = 'Added';
                else $_action = 'Updated';
                
                if($saveId = $this->gallery_model->save($data,$id)) {
                    //remove old images
                    foreach ($_images['images'] as $key => $val) {
                        $excludes[] = $val;
                    }
                    $this->gallery_image_model->removeImageInGallery($saveId,$excludes);

                    //Save to gallery_image data_table
                    $_old_images = array();
                    foreach ($this->data['images'] as $key => $val) {
                        $_old_images[] = $val->image_url;
                    }

                    foreach ($_images['images'] as $key => $val) {
                        if(!in_array($val,$_old_images)) {
                            $_data = array(
                                'gallery_id' => $saveId,
                                'image_url' => $val,
                                'image_title' => '',
                                'image_alt' => '',
                                'caption' => $_images['caption'][$key],
                                'position' => $_images['position'][$key],
                            );
                            $this->gallery_image_model->save($_data,null);
                        } else {
                            foreach ($this->data['images'] as $_val) {
                                if($val == $_val->image_url) {
                                    $_update_id = $_val->id;
                                    $_update = array (
                                        'caption' => $_images['caption'][$key],
                                        'position' => $_images['position'][$key],
                                    );
                                    $this->gallery_image_model->save($_update,$_update_id);
                                }
                            }
                        }
                    }
                    
                    //save history
                    $this->history_model->add_history(NULL,$_action,$id,'gallery');
                    
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công.');
                    redirect(base_url('gallery'));
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu của bạn');
                }
            }

            //Load view
            $this->data['meta_title'] = ($id) ? 'Sửa Gallery' : 'Tạo Gallery mới';
            $this->data['sub_view'] = 'admin/gallery/edit';
            $this->data['sub_js'] = 'admin/gallery/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if($this->data['userdata']['level'] > 2) return FALSE;
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            if($this->gallery_model->updateStatus($post_id,3)) {
                
                //save history
                foreach ($post_id as $key => $val) {
                    $_action = 'Deleted';
                    $this->history_model->add_history(NULL,$_action,$val,'gallery');
                }
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                return true;
            }
            else {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
                return false;
            }
            return false;
        }
        
        public function publish()
        {
            $result = array('code'=>0 , 'msg' => 'success', 'data' => NULL);
            if ( ! $this->has_permission('edit') || $this->data['userdata']['level'] > 2) 
            {
                $result['code'] = -2;
                $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($result);
                exit();
            }
            $ids = $this->input->post_get('ids');
            $status = $this->input->post_get('status');
            if($this->gallery_model->updateStatus($ids,$status)) 
            {
                
                //save history
                foreach ($ids as $key => $val) {
                    if ($status==1) $_action = 'Published';
                    else $_action = 'UnPublished';
                    $this->history_model->add_history(NULL,$_action,$val,'gallery');
                }
                
                $result['msg'] = 'Cập nhật dữ liệu thành công';
                echo json_encode($result);                
                exit();
            }
            $result['code'] = -1;
            $result['msg'] = 'Không thành công!';
            echo json_encode($result);                
            exit();
        }

}