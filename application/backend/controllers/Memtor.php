<?php
    class Memtor extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('memtor_model');
        }

        public function index() {
            $status = $this->input->get_post('status');
            $group = $this->input->get_post('group');
            $this->data['filters'] = [
                'status' => $status,
                'group' => $group,
            ];
            $this->data['memtors'] = $memtors = $this->memtor_model->getAllMemtor($this->data['filters']);

            //Load View
            $this->data['meta_title'] = 'Danh sách Thành viên';
            $this->data['sub_view'] = 'admin/memtor/index';
            $this->data['sub_js'] = 'admin/memtor/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function feedback() {
            
            $this->load->model('portfolio_model');
            $this->data['portfolios'] = $this->portfolio_model->get();
            $this->data['mentors'] = $this->memtor_model->get();

            //Load View
            $this->data['meta_title'] = 'Portfolio feedback';
            $this->data['sub_view'] = 'admin/memtor/feedback';
            $this->data['sub_js'] = 'admin/memtor/feedback-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function feedbackList()
        {
            $status = $this->input->get_post('status');
            $mentor_id = $this->input->get_post('mentor_id');
            $portfolio_id = $this->input->get_post('portfolio_id');
            $where = [];
            if ($status) 
                $where['a.status'] = $status;
            if ($mentor_id) 
                $where['a.mentor_id'] = $mentor_id;
            if ($portfolio_id) 
                $where['a.portfolio_id'] = $portfolio_id;
            
            $data['feedbacks'] = $this->db->select('m.name AS mentor_name, a.id, a.feedback, a.title, a.`status`, a.`order`, p.name AS portfolio_name')
            ->from('mentor_portfolio AS a')
            ->join('memtor AS m', 'a.mentor_id=m.id', 'inner')
            ->join('portfolio AS p', 'a.portfolio_id=p.id', 'inner')
            ->where($where)
            ->get()->result();

            echo $this->load->view('admin/memtor/feedback-list', $data, TRUE);
        }

        public function feedbackEdit($id=0) {
            $this->data['feedback'] = ($id) ? $this->db->get_where('mentor_portfolio', ['id' => $id], 1)->row() :
            $this->memtor_model->feedbackNew();

            # validate form submit
            $rules = $this->memtor_model->feedbackRules;
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == TRUE) 
            {
                $saved = $this->memtor_model->saveFeedback( intval($id) );
                if ($saved) {
                    $this->session->set_flashdata('session_msg', 'thành công');
                    redirect('/memtor/feedback');
                }
                else
                    $this->session->set_flashdata('session_error', 'Có lỗi, vui lòng thử lại');
            }

            $this->load->model('portfolio_model');
            $this->data['portfolios'] = $this->portfolio_model->get();
            $this->data['mentors'] = $this->memtor_model->get();

            //Load view
            $this->data['meta_title'] = 'Feedback to mentor';
            $this->data['sub_view'] = 'admin/memtor/feedback-edit';
            $this->data['sub_js'] = 'admin/memtor/feedback-edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function feedbackDelete($id)
        {
            $this->db->delete('mentor_portfolio', ['id' => intval($id)]);
            echo 'success';
        }

        public function edit($id=0) {
            if($this->data['userdata']['level'] > 2) $this->not_permission();
            $id = (int)$id;
            if(!$id) $id = NULL;
            if($id)
            {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['memtor'] = $memtor = $this->memtor_model->get($id,true);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['memtor'] = $memtor = $this->memtor_model->get_new();
            }

            //validation form
            $rules = $this->memtor_model->rules;
            $this->form_validation->set_rules($rules);
            if ( $this->form_validation->run()==true ) {
                $input_var = array('name','birthday','gender','country','status','description','meta_title','meta_keyword','meta_description','job_title', 'linkedin_url', 'position', 'company', 'group', 'facebook', 'twitter', 'website', 'og_image');
                $data = $this->memtor_model->array_from_post($input_var);
                if(!$data['meta_title']) $data['meta_title'] = $data['name'];
                if(!$data['meta_keyword']) $data['meta_keyword'] = $data['name'];
                if(!$data['meta_description']) $data['meta_description'] = '';
                if(!isset($data['status'])) $data['status'] = 2;
                $data['position'] = intval($data['position']);
                
                //time birthday
                $_birthday = explode(' ',$data['birthday']);
                $_date = explode('-',$_birthday[0]);
                $_time = explode(':',$_birthday[1]);
                $data['birthday'] = mktime($_time[0],$_time[1],0,$_date[1],$_date[0],$_date[2]);
                
                //upload thumbnail image
                if($_FILES['thumbnail']['size'] > 0) {
                    $_thumnail_uploaded = parent::upload_file('thumbnail');
                    $_thumb_parse = array('path'=>'');
                    if($_thumnail_uploaded['image_url'] !=''){
                        $_thumb_parse = parse_url($_thumnail_uploaded['image_url']);
                    }
                    $data['image'] = $_thumb_parse['path'];
                }
                if($save_id = $this->memtor_model->save($data,$id)) {
                    
                    //save history
                    if ( ! $id) $_action = 'Added';
                    else $_action = 'Updated';
                    $this->history_model->add_history(NULL,$_action,$id,'memtor');
                    
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công.');
                    redirect(base_url('memtor'));
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu của bạn');
                }
            }
            
            //Load view
            $this->data['meta_title'] = ($id) ? 'Sửa thông tin Nhân vật' : 'Tạo Nhân vật mới';
            $this->data['sub_view'] = 'admin/memtor/edit';
            $this->data['sub_js'] = 'admin/memtor/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete') || $this->data['userdata']['level'] > 2) return FALSE;
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            if($this->memtor_model->updateStatus($post_id, STATUS_DELETED)) {
                
                //save history
                foreach ($post_id as $key => $val) {
                    $_action = 'Deleted';
                    $this->history_model->add_history(NULL,$_action,$val,'memtor');
                }
                
                if ($id) {
                    $this->session->set_flashdata('session_success','Successfully!');
                    redirect( base_url('memtor'),'refresh');
                }
                else
                {
                    $result['code'] = 0;
                    $result['msg'] = 'Successfully!';
                    echo json_encode($result);
                    exit();
                }

            }
            else 
            {
                if ($id) {
                    $this->session->set_flashdata('session_error','Can not removed item');
                    redirect( base_url('memtor'),'refresh');
                }
                else
                {
                    $result['code'] = -2;
                    $result['msg'] = 'Can not removed items!';
                    echo json_encode($result);
                    exit();
                }
            }
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
            if($this->memtor_model->updateStatus($ids,$status)) 
            {
                //save history
                foreach ($ids as $key => $val) {
                    if ($status==1) $_action = 'Published';
                    else $_action = 'UnPublished';
                    $this->history_model->add_history(NULL,$_action,$val,'memtor');
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