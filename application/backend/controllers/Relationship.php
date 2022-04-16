<?php
    class Relationship extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('relation_model');
            $this->load->model('file_model');
            $this->load->model('option_model');
            $partnerGroup = $this->option_model->get_by(['name'=>'partner_group'], TRUE);
            $this->data['group'] = explode(',', $partnerGroup->value);
        }

        public function index() {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $status = (int)$this->input->get_post('status');
            if( ! $status)
                $this->data['relationships'] = $this->relation_model->get_list_relation(NULL);
            else
                $this->data['relationships'] = $this->relation_model->get_list_relation($status);

            //fetch breadcrumbs
            $this->data['breadcrumbs'] = array( 'Liên kết trang' => base_url('relationship'));

            //load view template
            $this->data['meta_title'] = 'Quản lý liên kết trang';
            $this->data['sub_view'] = 'admin/relationship/index';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) {
            $this->data['meta_title'] = 'Quỹ đầu tư';

            //Fetch a relationship or set a new one
            if($id) {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['relationship'] = $this->relation_model->get_detail_relation($id);
                if( ! $this->data['relationship'] ) {
                    $this->data['errors'][] = 'relationship could not be found!';
                    redirect(base_url('relationship'));
                }
                $action = 'update';
                $this->data['meta_title'] = 'Thông tin quỹ đầu tư';
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['relationship'] = $this->relation_model->get_new();
                $action = 'insert';
            }
            
            //validate form
            $rules = $this->relation_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->relation_model->array_from_post(array('name','url','status','position', 'email', 'phone', 'facebook', 'phone', 'instagram', 'description', 'content', 'address', 'image', 'image_trans', 'is_hot', 'group_index', 'deposit_text', 'invest_location'));

                $data['name'] = cleanInputString($data['name']);
                $data['description'] = cleanInputString($data['description']);
                $data['invest_location'] = cleanInputString($data['invest_location']);
                $data['deposit_text'] = $data['deposit_text'];
                // $data['deposit_amount'] = intval($data['deposit_amount']);
                $data['is_hot'] = intval($data['is_hot']);

                $this->relation_model->save($data,$id);
                redirect('relationship');
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/relationship/edit';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id) {
            if ( ! $this->has_permission('delete')) return FALSE;
            $data = array('status' => 3);
            $this->relation_model->save($data,$id);
            return TRUE;
        }

        public function _unique_website($str) {
            //Don't validate form if this slug already

            $id = $this->uri->segment(4);
            $this->db->where('slug',$this->input->post('slug'));
            !$id || $this->db->where('id !=', $id);
            $relationship = $this->relation_model->get();
            if(count($relationship)) {
                $this->form_validation->set_message('_unique_slug','%s should be Unique');
                return FALSE;
            }
            return TRUE;
        }

        public function change_status($id) {
            if ( ! $this->has_permission('edit')) return FALSE;
            $status = 1;
            $relation = $this->relation_model->get($id,TRUE);
            if ($relation->status == 1) 
                $status=2;
            $data = array('status'=>$status);
            $this->relation_model->save($data,$id);
            return FALSE;
        }
}