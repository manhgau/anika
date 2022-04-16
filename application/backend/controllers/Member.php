<?php
    class Member extends MY_Controller {        
        public function __construct() 
        {
            parent::__construct();
            $this->load->model('member_model');
            $this->load->model('postrequest_model');

            //Breadcrumbs
            $this->data['breadcrumbs']['User'] = base_url('member');
        }

        public function index() 
        {
            //load view template
            $this->data['meta_title'] = lang('member');
            $this->data['sub_view'] = 'admin/member/index';
            $this->data['sub_js'] = 'admin/member/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function post() 
        {
            $this->data['filter'] = $this->input->get();
            //load view template
            $this->data['meta_title'] = lang('post');
            $this->data['sub_view'] = 'admin/member/post';
            $this->data['sub_js'] = 'admin/member/post-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $this->data['member'] = ($id) ? $this->member_model->get($id) : $this->member_model->getNew();

            //validate form
            $rules = $this->member_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->member_model->array_from_post(array('username', 'fullname', 'email', 'phone', 'status'));

                if($id = $this->member_model->save($data,$id)) {
                    $this->session->set_flashdata('session_msg', 'Cập nhật thành công.');
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu.');
                }
                redirect(base_url('member'));
            }

            //Load View
            $this->data['meta_title'] = lang('member_infomation');            
            $this->data['sub_view'] = 'admin/member/edit';
            $this->data['sub_js'] = 'admin/member/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function postEdit($id = NULL) 
        {
            $this->data['post'] = ($id) ? $this->postrequest_model->get($id) : $this->postrequest_model->getNew();

            //validate form
            $rules = $this->postrequest_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $inputs = array('point', 'url', 'title');
                if (!$id) {
                    $inputs[] = 'member_id';
                    $inputs[] = 'status';
                }

                $data = $this->postrequest_model->array_from_post();
                if($id = $this->postrequest_model->save($data,$id)) {
                    $this->session->set_flashdata('session_msg', 'Cập nhật thành công.');
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu.');
                }
                redirect(base_url('member/post'));
            }

            //Load View
            $this->data['meta_title'] = lang('post_infomation');            
            $this->data['sub_view'] = 'admin/member/post-edit';
            $this->data['sub_js'] = 'admin/member/post-edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function modalPostProcess($requestId) 
        {
            $this->data['request'] = $request = $this->postrequest_model->get($requestId, true);
            $this->data['member'] = $this->member_model->get($request->member_id, true);
            $this->load->view('admin/member/modal-post', $this->data);
        }

        public function getDataGrid()
        {
            $result = $this->member_model->dataGrid();
            header('Content-Type: application/json');
            echo json_encode($result);
        }

        public function getPostGrid()
        {
            $result = $this->postrequest_model->dataGrid();
            header('Content-Type: application/json');
            echo json_encode($result);
        }

        public function apis($action)
        {
            $fnc = "__{$action}";
            $this->$fnc();
        }

        private function __checkPhone()
        {
            $phone = trim($this->input->get('phone'));
            $id = intval($this->input->get('id'));
            $where = ['owner_phone' => $phone];
            if ($id) 
                $where['id !='] = $id;

            $already = $this->member_model->get_by($where, true);
            if ($already) 
                $this->jsonResponse(200, 'already', []);
            else
                $this->jsonResponse(201, 'not exist', []);
        }

        private function __postAnswer()
        {
            $requestId = intval($this->input->post('id'));
            $status = trim($this->input->post('status'));
            $note = cleanInputString($this->input->post('note'));

            if ($this->postrequest_model->postProccess($requestId, $note , $status, $this->data['userdata']['id'])) 
                $this->jsonResponse(200, 'success');
            else
                $this->jsonResponse(500, 'Hệ thống bận.');
        }

        private function __checkCode()
        {
            $code = trim($this->input->get('code'));
            $id = intval($this->input->get('id'));
            $where = ['code' => $code];
            if ($id) 
                $where['id !='] = $id;
            
            $already = $this->member_model->get_by($where, true);
            if ($already) 
                $this->jsonResponse(200, 'already', []);
            else
                $this->jsonResponse(201, 'not exist', []);
        }

        public function tokenSearch()
        {
            $str = $this->input->get('q');
            $data = $this->member_model->search($str);
            if(!$data) {
                $output[] = array('id' => 0, 'name' => 'not found');
                echo json_encode($output);
                exit();
            }
            foreach ($data as $key => $val) {
                $output[] = array(
                    'id' => $val->id,
                    'name' => $val->fullname
                );
            }
            echo json_encode($output);
            exit();
        }
}