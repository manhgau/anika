<?php
    class Bussiness extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('bussiness_model');
            $this->load->model('location_model');
            $this->data['breadcrumbs'] = array('Nhà cung cấp' => base_url('bussiness'));
        }

        public function index() 
        {
            //Get conditions
            $this->data['status'] = $status = isset($_GET['status']) ? $_GET['status'] : 0;
            $this->data['province_id'] = $province_id = isset($_GET['province_id']) ? $_GET['province_id'] : 0;
            $this->data['bussiness_code'] = $bussiness_code = isset($_GET['bussiness_code']) ? $_GET['bussiness_code'] : '';
            $this->data['keyword'] = $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

            if ($province_id) {
                $location = $this->location_model->getDetailLocation($province_id);
                $tokenLocation = array(
                    'id' => $location->id,
                    'name' => $location->name,
                );
                $this->data['tokenLocation'] = json_encode( array($tokenLocation) );
            }
                
            $this->data['sub_view'] = 'admin/bussiness/index';
            $this->data['sub_js'] = 'admin/bussiness/index-js';
            $this->data['meta_title'] = 'Quản lý nhà cung cấp';
            
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getBussinessData()
        {
            $search = $this->input->get_post('search');
            $args['offset'] = $this->input->get_post('start');
            $args['limit'] = $this->input->get_post('length');
            $args['province_id'] = $this->input->get_post('province_id');
            $args['bussiness_code'] = $this->input->get_post('bussiness_code');
            $args['status'] = $this->input->get_post('status');
            if ($search['value']) {
                $args['keyword'] = $search['value'];
            }

            $listData = $this->bussiness_model->getListBussiness($args);
            if ($listData) {
                foreach ($listData as $key => $value) {
                    $_location = $this->location_model->getDetailLocation($value['province_id']);
                    $value['location'] = array(
                        'id' => (isset($_location->id)) ? $_location->id : NULL,
                        'name' => ($_location->name) ? $_location->name : '...',
                    );
                    $value['created_time'] = ($value['created_time']) ? date('H:i d/m/Y', strtotime($value['created_time'])) : '...';
                    $listData[$key] = $value;
                }
            }
            
            $totalRecords = $this->bussiness_model->getNumberBussiness($args);

            $response = array();
            $response['data'] = $listData;
            $response['recordsTotal'] = $totalRecords;
            $response['recordsFiltered'] = $totalRecords;

            echo json_encode($response);
            exit();
        }


        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Thêm nhà cung cấp mới';
            $this->data['breadcrumbs'] = array('Nhà cung cấp' => base_url('bussiness'));
            $this->data['bussiness'] = $bussiness = $this->bussiness_model->getDetailBussiness($id);
            if($id) 
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();                
                $this->data['meta_title'] = 'Sửa thông tin bussiness';
                $this->data['breadcrumbs']['Sửa'] = base_url('bussiness/edit/' . $id);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['breadcrumbs']['Thêm mới'] = base_url('bussiness/edit');
            }

            //validate form
            $rules = $this->bussiness_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                //save bussiness
                $args = array('title','description','thumbnail','images','display_name','login_name','password', 'email', 'phone', 'status', 'bussiness_code', 'tax_code', 'province_id', 'address', 'website', 'fax','director_name', 'bank_name', 'bank_card_owner', 'facebook_account', 'zalo_account', 'viber_account', 'google_account');
                $data = $this->bussiness_model->array_from_post($args);

                if ( ! $data['status']) $data['status'] = 2;
                
                if ($data['password']) 
                {
                    $data['password'] = $this->bussiness_model->hashString($data['password']);
                }
                else {
                    if ( ! $id) 
                        $data['password'] = $this->bussiness_model->hashString('123abc456');
                    else
                        unset($data['password']);
                }

                $data['slugname'] = build_slug($data['title']);

                if($savedId = $this->bussiness_model->save($data,$id)) {
                    if( ! $id) $_act = 'Added';
                    else $_act = 'Updated';
                    $this->session->set_flashdata('session_msg','Success!');
                }
                else {
                    $this->session->set_flashdata('session_error','Error!');   
                }
                redirect(base_url('bussiness'));
            }

            //location config
            if ($bussiness->province_id) {
                $location = $this->location_model->get($bussiness->province_id, true);

                $tokenLocation = array(
                        'id' => $location->id,
                        'name' => $location->name,
                    );

                if ($location->parent_id) {
                    $_parent = $this->location_model->get($location->parent_id, true);
                    $tokenLocation['name'] .= ', '. $_parent->name;

                    if ($_parent->parent_id) {
                        $__parent = $this->location_model->get($_parent->parent_id, true);
                        $tokenLocation['name'] .= ', '. $__parent->name;
                    }
                }
                $this->data['tokenLocation'] = json_encode( array($tokenLocation) );
            }
            
            //Fetch bussiness type
            $this->data['sub_view'] = 'admin/bussiness/edit';
            $this->data['sub_js'] = 'admin/bussiness/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $post_id = $this->input->post('ids');
            
            if ($id) $post_id[] = $id;
            
            if ($this->bussiness_model->updateStatus($post_id,3))
            {
                foreach ($post_id as $key => $val) {
                    $this->history_model->add_history(NULL,'Deleted',$val,'bussiness');
                }
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            }
            else
            {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
            }
            redirect(base_url('bussiness'));
        }

        public function testMail()
        {
            $sender_email = 'vuminhndvn@gmail.com';// $this->input->post('user_email');
            $user_password = 'Canhh0adau';
            $receiver_email = 'tuanviet9791@gmail.com';
            $username = 'MynkCMS';
            $subject = 'Verify your code by MynkCMS';
            $message = 'Please click to me to verify your code; then login to MynkCMS.';

            // Configure email library
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com';
            $config['smtp_port'] = 465;
            $config['smtp_user'] = $sender_email;
            $config['smtp_pass'] = $user_password;

            // Load email library and passing configured values to email library
            $this->load->library('email', $config);

            $this->email->set_newline("rn");

            // Sender email address
            $this->email->from($sender_email, $username);
            // Receiver email address
            $this->email->to($receiver_email);
            // Subject of email
            $this->email->subject($subject);
            // Message in email
            $this->email->message($message);

            if ($this->email->send()) {
                echo $data['message_display'] = 'Email Successfully Send !';
            } else {
                echo $data['message_display'] = '<p class="error_msg">Invalid Gmail Account or Password !</p>';
            }

        }
}