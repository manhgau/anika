<?php
    class Banner extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('banner_model');
            $this->data['breadcrumbs'] = array('Banner' => base_url('banner'));
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            
            //Get conditions
            $this->data['status'] = $status = isset($_GET['status']) ? $_GET['status'] : 0;
            $this->data['type'] = $type = isset($_GET['type']) ? $_GET['type'] : 0;
            if($status!=0) {
                $condition = 'status='.$status;
            } else {
                $condition = 'status <> 3';
            }
            if($type != 0) {
                $condition .= ' AND type='.$type;
            }

            //Fetch all banner
            $list_banner = $this->banner_model->get_by($condition);
            if ( count($list_banner) > 0 )
                $this->data['banners'] = $list_banner;
                
            $this->data['sub_view'] = 'admin/banner/index_view';
            $this->data['meta_title'] = 'Quản lý banner';
            
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $type = ($this->input->get_post('type')) ? intval($this->input->get_post('type')) : NULL;
            $this->data['meta_title'] = 'Thêm banner mới';
            $this->data['breadcrumbs'] = array('Banner' => base_url('banner'));
            if($id) 
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();                
                $this->data['banner'] = $banner = $this->banner_model->get($id,true);
                if(! $this->data['banner'] ) $this->data['errors'][] = 'banner could not be found!';
                $this->data['meta_title'] = 'Sửa thông tin banner';
                $this->data['breadcrumbs']['Sửa'] = base_url('banner/edit/' . $id);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $banner = $this->banner_model->get_new( $type );
                $banner->type = $type;
                $this->data['banner'] = $banner;
                $this->data['breadcrumbs']['Thêm mới'] = base_url('banner/edit/');
            }
            //validate form
            $rules = $this->banner_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $args = array('type','name','url','position','status','is_blank','html','image');
                $data = $this->banner_model->array_from_post($args);
                if ( ! $data['status']) $data['status'] = 2;
                if ( ! $data['is_blank']) $data['is_blank'] = 0;
                if($banner_id = $this->banner_model->save($data,$id)) {
                    if( ! $id) $_act = 'Added';
                    else $_act = 'Updated';
                    $this->history_model->add_history(NULL,$_act,$banner_id,'banner');
                    $this->session->set_flashdata('session_msg','Success!');
                }
                else {
                    $this->session->set_flashdata('session_error','Error!');   
                }
                redirect(base_url('banner/?type='.$data['type']));
            }
            
            //Fetch banner type
            $this->data['banner_type'] = config_item('bannerGroup');
            $this->data['sub_view'] = ($banner->type == 7) ? 'admin/banner/edit-supported-sys' : 'admin/banner/edit_view';
            $this->data['sub_js'] = 'admin/banner/edit_js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $post_id = $this->input->post('ids');
            
            if ($id) $post_id[] = $id;
            
            if ($this->banner_model->updateStatus($post_id,3))
            {
                foreach ($post_id as $key => $val) {
                    $this->history_model->add_history(NULL,'Deleted',$val,'banner');
                }
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            }
            else
            {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
            }
            redirect(base_url('banner'));
        }
}