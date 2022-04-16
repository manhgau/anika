<?php
    class Event extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('event_model');
        }

        public function index() {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $status = (int)$this->input->get_post('status');
            $this->data['filters']['status'] = $status;
            
            /*$location = (int)$this->input->get_post('location');
            $begin = $this->input->get_post('begin');*/

            $this->data['events'] = $events = $this->event_model->getListEvent($status);

            //Load View
            $this->data['meta_title'] = 'Sự kiện';
            $this->data['sub_view'] = 'admin/event/index';
            $this->data['sub_js'] = 'admin/event/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id=0) {
            $id = (int)$id;
            if(!$id) $id = NULL;
            if($id)
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['event'] = $event = $this->event_model->get($id,true);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['event'] = $event = $this->event_model->get_new();
            }

            //validation form
            $rules = $this->event_model->rules;
            $this->form_validation->set_rules($rules);
            if ( $this->form_validation->run()==true ) {
                $input_var = array('title','status','intro','description','begin_time','location','meta_title','meta_keyword','meta_description','is_hot', 'image');
                $data = $this->event_model->array_from_post($input_var);
                $data['slugname'] = build_slug($data['title']);
                if(!$data['meta_title']) $data['meta_title'] = $data['title'];
                if(!$data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if(!$data['meta_description']) $data['meta_description'] = $data['intro'];
                if(!isset($data['status'])) $data['status'] = 2;
                if(!isset($data['is_hot'])) $data['is_hot'] = 0;
                if($data['image'])
                    $data['thumbnail'] = $data['image'];
                else
                    $data['thumbnail'] = null;
                unset($data['image']);
                
                
                if($save_id = $this->event_model->save($data,$id)) {
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công.');
                    
                    //save history
                    if ( ! $id) $_action = 'Added';
                    else $_action = 'Updated';
                    $this->history_model->add_history(NULL,$_action,$save_id,'event');
                    
                    redirect(base_url('event'));
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu của bạn');
                }
            }
            
            //Load view
            $this->data['meta_title'] = ($id) ? 'Sửa sự kiện' : 'Tạo sự kiện mới';
            $this->data['sub_view'] = 'admin/event/edit';
            $this->data['sub_js'] = 'admin/event/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function delete($id = NULL) {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            if($this->event_model->updateStatus($post_id,3)) {
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                
                //save history
                foreach ($post_id as $key => $val) {
                    $_action = 'Deleted';
                    $this->history_model->add_history(NULL,$_action,$val,'event');
                }
                
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
            if ( ! $this->has_permission('edit')) 
            {
                $result['code'] = -2;
                $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($result);
                exit();
            }
            
            $ids = $this->input->post_get('ids');
            $status = $this->input->post_get('status');
            if($this->event_model->updateStatus($ids,$status)) 
            {
                if ($status==1) $_action = 'Published';
                else $_action = 'UnPublished';
                foreach ($ids as $key => $val) {
                    $this->history_model->add_history(NULL,$_action,$val,'event');
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
