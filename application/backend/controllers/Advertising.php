<?php
    class Advertising extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('advertising_group_model');
            $this->load->model('advertising_model');
            $this->data['breadcrumbs'] = array('Tin khuyến mãi' => base_url('advertising'));
        }

        public function group($id=null)
        {
            $id = intval($id);
            $this->data['group'] = $this->advertising_group_model->getDetailGroup($id);

            $rules = $this->advertising_group_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run()==TRUE)
            {
                $_args = array('name');
                $data = $this->advertising_group_model->array_from_post($_args);
                $input_id = ($id) ? $id : null;
                $data['slugname'] = build_slug($data['name']);

                if($saved_id = $this->advertising_group_model->save($data, $input_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công');
                }
                else {
                    $this->session->set_flashdata('session_error', 'Không thành công');
                }
            }

            $this->data['groups'] = $this->advertising_group_model->get();

            //Fetch banner type
            $this->data['sub_view'] = 'admin/advertising/group';
            $this->data['sub_js'] = 'admin/advertising/group-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete_group($id)
        {
            $id = intval($id);
            if (!$id)
            {
                $this->session->set_flashdata('session_error', 'Missing input params');
                redirect(base_url('advertising/group'));
            }

            if ($this->advertising_group_model->delete($id))
            {
                $this->session->set_flashdata('session_success', 'Successfully!');
            }
            else{
                $this->session->set_flashdata('session_error', 'Error! can not update database.');
            }
            redirect(base_url('advertising/group'));
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            
            //Get conditions
            $this->data['status'] = $status = isset($_GET['status']) ? $_GET['status'] : 0;
            $this->data['group_id'] = $group = isset($_GET['group_id']) ? $_GET['group_id'] : 0;
            $this->data['is_hot'] = $is_hot = isset($_GET['is_hot']) ? $_GET['is_hot'] : 0;
            if($status!=0) {
                $condition = 'status='.$status;
            } else {
                $condition = 'status <> 3';
            }
            if($this->data['group_id'] != 0) {
                $condition .= ' AND group_id='.$this->data['group_id'];
            }
            if($is_hot != 0) {
                $condition .= ' AND is_hot='.$is_hot;
            }

            //Fetch all banner
            $list = $this->advertising_model->get_by($condition);
            if ( count($list) > 0 )
                $this->data['advertisings'] = $list;

            //fetch all groups
            $groups  = $this->advertising_group_model->getGroups();
            foreach($groups as $key => $val)
            {
                $this->data['adsGroups'][$val->id] = $val;
            }
                
            $this->data['sub_view'] = 'admin/advertising/index';
            $this->data['meta_title'] = 'Danh sách quảng cáo';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Thêm mới';
            $this->data['breadcrumbs'] = array('Tin khuyến mãi' => base_url('advertising'));
            if($id) 
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();                
                $this->data['advertising'] = $_this_advertising = $this->advertising_model->get($id,true);
                if(! count($this->data['advertising']) ) $this->data['errors'][] = 'advertising could not be found!';
                $this->data['meta_title'] = 'Sửa thông tin quảng cáo';
                $this->data['breadcrumbs']['Sửa'] = base_url('advertising/edit/' . $id);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['advertising'] = $this->advertising_model->get_new();
                $this->data['breadcrumbs']['Thêm mới'] = base_url('advertising/edit');
            }

            //validate form
            $rules = $this->advertising_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $args = array('title', 'image', 'sale_info', 'is_hot', 'group_id', 'status', 'url', 'position');
                $data = $this->advertising_model->array_from_post($args);
                if ( ! $data['status']) $data['status'] = 2;
                if ( ! $data['is_hot']) $data['is_hot'] = 0;
                $data['slugname'] = build_slug($data['title']);
                if($savedId = $this->advertising_model->save($data,$id)) {
                    if( ! $id) $_act = 'Added';
                    else $_act = 'Updated';
                    $this->history_model->add_history(NULL,$_act,$savedId,'advertising');
                    $this->session->set_flashdata('session_msg','Success!');
                }
                else {
                    $this->session->set_flashdata('session_error','Error!');   
                }
                redirect(base_url('advertising'));
            }

            //fetch all groups
            $this->data['adsGroups'] = $this->advertising_group_model->getGroups();

            //Load view
            $this->data['sub_view'] = 'admin/advertising/edit';
            $this->data['sub_js'] = 'admin/advertising/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            if ($this->advertising_model->delete($id))
            {
                $this->history_model->add_history(NULL,'Deleted',$id,'advertising');
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            }
            else
            {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
            }
            redirect(base_url('advertising'));
        }
}