<?php
    class User extends MY_Controller {
        private $dashboard_page;
        private $login_page;
        private $profile_page;
        private $user_page;
        private $validate_check;
        private $userdata;

        public function __construct() 
        {
            parent::__construct();
            $this->load->model('user_permission_model');
            $this->load->model('category_model');
            $this->load->model('news_model');
            $this->dashboard_page = base_url('dashboard');
            $this->login_page = base_url('user/login');
            $this->profile_page = base_url('user/profile');
            $this->user_page = base_url('user');
            $this->validate_check = FALSE;

        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $this->data['users'] = $this->user_model->get_by("status <> 3");        
            $this->data['sub_view'] = 'admin/user/index';
            $this->data['sub_js'] = 'admin/user/index-js';
            $this->data['meta_title'] = 'Danh sách thành viên';
            $this->data['breadcrumbs'] = array('Thành viên' => base_url('user'));
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {

            //Define user_level
            $this->data['user_levels'] = config_item('user_levels');            
            $this->data['meta_title'] = 'Thêm thành viên mới';
            $this->data['breadcrumbs'] = array('Thành viên' => base_url('user'));
            if($this->data['userdata']['level'] > 1)$this->not_permission();

            if($id)
            {
                if ( ! $this->has_permission('edit') && $id != $this->data['userdata']['id']) $this->not_permission();
                $this->data['user'] = $this->user_model->get($id);
                if(! $this->data['user'] ) $this->data['errors'][] = 'User could not be found!';
                $this->data['meta_title'] = 'Thông tin thành viên';
                $this->data['breadcrumbs']['Sửa'] = base_url('user/edit/' . $id);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['user'] = $this->user_model->get_new();
                $this->data['breadcrumbs']['Thêm'] = base_url('user/edit/');
            }

            //validate form
            $rules = $this->user_model->rules_admin;
            if(!$id) {
                $rules['password']['rules'] .= '|required';
                $rules['password_confirm']['rules'] .= '|required';
                $rules['email']['rules'] .= '|callback__unique_email';
                $id = NULL;
            }
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) 
            {
                $data = $this->user_model->array_from_post(array('name','email','password','status','level', 'intro'));
                if($id == $this->data['userdata']['id'] && $this->data['userdata']['level'] > 1)
                {
                    unset($data['status']);
                    unset($data['level']);
                }

                if($data['password']=='')
                    unset($data['password']);
                else
                    $data['password'] = $this->user_model->hash_str($data['password']);

                if($_FILES['image']['size']>0) {
                    $upload = $this->upload_file('image');
                    if($upload['msg'] == 'success') 
                        $data['image'] = $upload['image_url'];
                }
                if ($saved_id = $this->user_model->save($data,$id))
                {
                    $_user_permission = $this->user_permission_model->get_permission_by_user($saved_id);
                    if ( ! $_user_permission)
                    {
                        $_perm_data = array(
                            'user_id' => $saved_id,
                            'action_perm' => config_item('permission_user_level_'.$data['level']),
                            'category_perm' => NULL
                        );
                        $this->user_permission_model->save($_perm_data,NULL);
                    }
                    else {
                        $_perm_data = array(
                            'action_perm' => config_item('permission_user_level_'.$data['level'])
                        );
                        $this->user_permission_model->save($_perm_data, $_user_permission->id);
                    }
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công!');

                    $this->history_model->add_history(NULL,'update_user',$saved_id, 'user');
                }
                redirect(base_url('user'));
            }

            //check level user
            $userdata = $this->data['userdata'];
            if( ($userdata['level'] > 1) && ($id != $userdata['id']) ) {
                $this->data['out_of_power'] = 1;
            }
            //Load view
            $this->data['sub_view'] = 'admin/user/edit';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            if ($this->userdata['level'] = 1) {
                if($id) {
                    $data = array('status' => 3);
                    $user = $this->user_model->get($id);
                    if($user) $this->user_model->save($data, $id);

                    $this->session->set_flashdata('session_msg','Xóa thành công');
                    redirect(base_url('user'));
                }
            }
            $this->session->set_flashdata('session_error','Xóa không thành công');
            redirect(base_url('user'));
        }

        public function login() 
        {
            if( $this->user_model->loggedin() == TRUE ) 
                redirect($this->dashboard_page);

            // check failed login times
            $this->data['allowLogin'] = TRUE;
            $currentSess = $this->session->all_userdata();
            if (isset($currentSess['failed']) && $currentSess['failed']>2 ) 
            {
                $_round = isset($currentSess['failed_round']) ? $currentSess['failed_round'] : 1;
                $timeLimit = 0*60;
                $timeRange = time() - $currentSess['failed_time'];
                if ( $timeRange<$timeLimit ) 
                {
                    $this->data['allowLogin'] = FALSE;
                    $errorAlert = ($_round>=2) ? 'Tài khoản đã bị khóa. Vui lòng liên hệ Admin.' : 'Đăng nhập sai 3 lần. Vui lòng chờ 30p để đăng nhập lại.';
                    $this->session->set_flashdata('session_error', $errorAlert);
                }
                else
                {
                    $this->data['allowLogin'] = TRUE;
                    // clear times
                    $this->session->unset_userdata('failed');
                    $this->session->unset_userdata('failed_time');
                    if ($_round >= 2) {
                        $this->session->unset_userdata('failed_round');
                    }
                }
            }

            $rules = $this->user_model->rules;
            $this->form_validation->set_rules($rules); 

            if($this->form_validation->run() == TRUE) 
            {
                //We can loggedin and redirect pages
                if($this->user_model->login()) 
                {
                    $this->session->unset_userdata('failed');
                    $this->session->unset_userdata('failed_time');
                    $this->session->unset_userdata('failed_round');

                    $this->data['userdata'] = $this->session->all_userdata();
                    $this->history_model->add_history(NULL,'Login');
                    redirect($this->dashboard_page,'refresh');
                }
                else 
                {
                    $failedTime = [
                        'failed' => (isset($currentSess['failed']) && $currentSess['failed']) ? ++$currentSess['failed'] : 1,
                        'failed_time' => time()
                    ];
                    $_round = (isset($currentSess['failed_round']) && $currentSess['failed_round']) ? $currentSess['failed_round'] : 0;
                    
                    if ($failedTime['failed']==3) {
                        $_round++;
                    }
                    $failedTime['failed_round'] = $_round;
                    $this->session->set_userdata( $failedTime );

                    if ($_round >= 2) 
                    {
                        # disabled this account email
                        $_chkEmail = ['email' => $this->input->post('email')];
                        if ($_accEmail = $this->user_model->get_by($_chkEmail, TRUE)) 
                        {
                            $this->user_model->changeUserStatus($_accEmail->id, STATUS_PENDING);
                        }
                    }
                    $this->session->set_flashdata('session_error', 'Login Failed!');
                    redirect($this->login_page, 'refresh');
                }
            }

            $this->data['sub_view'] = 'admin/user/login';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->load->view('admin/_layout_modal',$this->data);
        }

        public function logout() 
        {
            $user_logedin = $this->session->userdata;
            $this->history_model->add_history(NULL,'Logout');
            $this->user_model->logout();

            removeAllLogsByMember($user_logedin['id']);

            redirect($this->login_page);
        }

        public function profile() 
        {
            //Define user_level
            $id = $this->data['userdata']['id'];
            $this->data['user'] = $this->user_model->get($id);

            //validate form
            $rules = $this->user_model->rules_admin;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) 
            {
                $data = $this->user_model->array_from_post(array('name','email','password'));
                if($data['password']=='')
                    unset($data['password']);
                else
                    $data['password'] = $this->user_model->hash_str($data['password']);

                if($_FILES['image']['size']>0) {
                    $upload = $this->upload_file('image');
                    if($upload['msg'] == 'success') 
                        $data['image'] = $upload['image_url'];
                }

                if ($id = $this->user_model->save($data,$id))
                {
                    $this->history_model->add_history(NULL,'update_profile');
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công!');
                }
                redirect(base_url('dashboard'));
            }

            //Load view
            $this->data['meta_title'] = 'User Profile';
            $this->data['sub_view'] = 'admin/user/profile';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function _unique_email($str)
        {
            $id = $this->uri->segment(4);
            $this->db->where('email',$this->input->post('email'));
            !$id || $this->db->where('id !=', $id);
            $user = $this->user_model->get();
            if(count($user)) {
                $this->form_validation->set_message('_unique_email','%s should be Unique');
                return FALSE;
            }
            return TRUE;
        }

        public function user_permission()
        {
            
            $this->data['meta_title'] = 'Phân quyền người dùng';
            if ((int)$this->data['userdata']['level'] !== 1)
                $this->not_permission();
            $this->data['users'] = $users = $this->user_model->get_by( array('status'=>1) );
            if($this->input->post('category_perm')) {
                $input_args = array('category_perm');
                $data = $this->user_permission_model->array_from_post($input_args);
                
                $categories = $this->category_model->get_all_category();
                foreach ($users as $key => $val) {
                    if (isset($data['category_perm'][$val->id]))
                    {
                        $_cat_permission = implode(',',$data['category_perm'][$val->id]);
                    } 
                    else 
                    {
                        $_cat_permission = NULL; 
                    }
                    $_insert_data = array(
                        'user_id' => $val->id,
                        'category_perm' => $_cat_permission
                    );
                    if( ! $u_permission = $this->user_permission_model->get_permission_by_user($val->id))
                    {
                        $this->user_permission_model->save($_insert_data,NULL);
                        $this->session->set_flashdata('session_msg','Phân quyền thành công!');
                    }
                    else
                    {
                        $this->user_permission_model->save($_insert_data,$u_permission->id);
                        $this->session->set_flashdata('session_msg','Phân quyền thành công!');
                    }
                }
            }

            $this->data['list_permission'] = $this->user_permission_model->get_list_permission();
            $this->load->model('category_model');
            $this->data['list_category'] = $this->category_model->get();
            //Load view
            $this->data['sub_view'] = 'admin/user/permission';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function my_posted()
        {
            $me = $this->data['userdata'];
            $page = (int)$this->input->get_post('page');
            if ($page < 1) $page = 1;
            $limit = 5000;
            $this->data['paging'] = $paging = build_pagination($page,$limit);

            $cat = (int)$this->input->get_post('cat');
            $is_hot = (int)$this->input->get_post('is_hot');
            $is_popular = (int)$this->input->get_post('is_popular');
            $status = (int)$this->input->get_post('status');

            $this->data['filters'] = array(
                'cat' => $cat,
                'status' => $status,
                'is_hot' => $is_hot,
                'is_popular' => $is_popular,
            );

            $this->data['articles'] = $list_news = $this->news_model->get_my_posted($me['id'],$paging['offset'],$paging['limit']);
            $this->data['list_categories'] = $this->category_model->get_all_category();
            $this->data['category_id'] = $cat;
            $this->data['tree_categories'] = $this->category_model->get_tree_categories();

            //Load view
            $this->data['meta_title'] = 'Bài đã đăng';
            $this->data['sub_view'] = 'admin/user/my-posted';
            $this->data['sub_js'] = 'admin/user/my-posted-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
}