<?php
    class Product_category extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('product_category_model');
            $this->data['breadcrumbs'] = array('Chuyên mục sản phẩm' => base_url('product_category'));
        }

        public function index() 
        {
            $this->data['sub_view'] = 'admin/product-category/index';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->data['meta_title'] = 'Quản lý chuyên mục sản phẩm';
            
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getCategoryData()
        {

            $data = array('data' => array());
            $treeCategoryData = $this->product_category_model->getTreeData();
            foreach ($treeCategoryData as $key => $value) {
                $item = array();
                $levelSep = '';
                for ($i=1; $i < intval($value->level); $i++) { 
                    $levelSep .= '&mdash;';
                }

                $item['title'] = $levelSep . ' ' . $value->title;
                $item['slugname'] = $value->slugname;
                $item['parent_id'] = $value->parent_id;
                $item['level'] = $value->level;
                $item['id'] = $value->id;
                $data['data'][] = $item;
            }

            $totalCount = $this->product_category_model->getCountCategory();
            $data['recordsTotal'] = $totalCount;
            $data['recordsFiltered'] = $totalCount;


            echo json_encode($data);
            exit();
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Thêm chuyên mục mới';
            $this->data['breadcrumbs'] = array('Chuyên mục sản phẩm' => base_url('product_category'));
            $this->data['category'] = $_this_banner = $this->product_category_model->getDetailCategory($id);
            if($id) 
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();         
                if(! count($this->data['category']) ) $this->data['errors'][] = 'Category could not be found!';
                $this->data['meta_title'] = 'Sửa thông tin chuyên mục';
                $this->data['breadcrumbs']['Sửa'] = base_url('category/edit/' . $id);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['breadcrumbs']['Thêm mới'] = base_url('category/edit/');
            }

            //validate form
            $rules = $this->product_category_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                //save category
                $args = array('title','parent_id','meta_title','meta_keyword','meta_description', 'description');
                $data = $this->product_category_model->array_from_post($args);


                $data['slugname'] = build_slug($data['title']);
                if ( ! $data['meta_title']) $data['meta_title'] = $data['title'];
                if ( ! $data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if ( ! $data['meta_description']) $data['meta_description'] = $data['title'];

                if ($data['parent_id']) {
                    $parent = $this->product_category_model->get($data['parent_id'], true);
                    $data['level'] = ++$parent->level;
                }
                else
                {
                    $data['level'] = 1;
                }

                if ( ! $savedId = $this->product_category_model->save($data, $id)) {
                    $this->session->set_flashdata('flash_error', 'Không thể cập nhật dữ liệu!');
                }
                else
                    $this->session->set_flashdata('flash_msg', 'Cập nhật dữ liệu thành công.');

                redirect(base_url('product_category'));
            }

            //fetch all category
            $treeCategoryData = $this->product_category_model->getTreeData();
            foreach ($treeCategoryData as $key => $value) {
                $item = array();
                $levelSep = '';
                for ($i=1; $i < intval($value->level); $i++) { 
                    $levelSep .= '&mdash;';
                }

                $item['title'] = $levelSep . ' ' . $value->title;
                $item['id'] = $value->id;
                $item['slugname'] = $value->slugname;
                $item['parent_id'] = $value->parent_id;
                $item['level'] = $value->level;
                $this->data['treeCategories'][] = $item;
            }
            
            $this->data['sub_view'] = 'admin/product-category/edit';
            $this->data['sub_js'] = 'admin/product-category/edit-js';
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