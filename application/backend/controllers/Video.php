<?php
    class Video extends MY_Controller {
        
        public function __construct() 
        {
            parent::__construct();
            $this->load->model('video_model');
            $this->load->model('tag_model');
            $this->load->model('video_category_model');
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $status = (int)$this->input->get_post('status');
            $this->data['filters']['status'] = $status;

            $this->data['videos'] = $videos = $this->video_model->getListVideo($status);
            $this->data['video_categories'] = $this->video_category_model->get_list_video_category();
            //Load view
            $this->data['meta_title'] = 'Quản lý video';
            $this->data['sub_view'] = 'admin/video/index';
            $this->data['sub_js'] = 'admin/video/index-js';
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
                $this->data['video'] = $video = $this->video_model->get($id,true);
            }
            else 
            {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['video'] = $video = $this->video_model->get_new();
            }
            
            $this->data['video_categories'] = $this->video_category_model->get_list_video_category();

            //validation form
            $rules = $this->video_model->rules;
            $this->form_validation->set_rules($rules);
            if ( $this->form_validation->run()==true ) {
                $input_var = array('title','status','description','meta_title','meta_keyword','meta_description','fileUrl','is_hot','public_time','cat_id');
                $data = $this->video_model->array_from_post($input_var);
                $data['slugname'] = build_slug($data['title']);
                if(!$data['meta_title']) $data['meta_title'] = $data['title'];
                if(!$data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if(!$data['meta_description']) $data['meta_description'] = $data['description'];
                if(!isset($data['status'])) $data['status'] = 2;   
                if(!isset($data['is_hot'])) $data['is_hot'] = 0;   
                if(!$id) $data['create_time'] = time();
                $data['public_time'] = to_unixtime($data['public_time']);
                //upload thumbnail image
                if($_FILES['thumbnail']['size'] > 0) {
                    $_thumnail_uploaded = parent::upload_file('thumbnail');
                    $_thumb_parse = array('path'=>'');
                    if($_thumnail_uploaded['image_url'] !=''){
                        $_thumb_parse = parse_url($_thumnail_uploaded['image_url']);
                    }
                    if(config_item('auto_watermark')==true) {
                        create_watermark($_thumb_parse['path']);
                    }
                    $data['thumbnail'] = $_thumb_parse['path'];
                }

                //Get input tags
                $_tags_id = array();
                $_input_tags = $this->tag_model->array_from_post(array('tags'));
                $_input_tags = json_decode($_input_tags['tags']);
                if($_input_tags) {
                    foreach ($_input_tags as $val) {
                        $_exist_tag = $this->tag_model->check_exist_tag($val);
                        if ( count($_exist_tag)>0 ) {
                            $_tags_id[] = $_exist_tag[0]->id;
                        } else {
                            $_insert_tag = array(
                                'tag' => $val,
                                'tag_md5' => md5($val),
                                'status' => 1
                            );
                            $_tags_id[] = $this->tag_model->save($_insert_tag,NULL);
                        }
                    }
                }
                $data['tags_id'] = implode(',',$_tags_id);
                
                if($saved_id = $this->video_model->save($data,$id)) {
                    
                    //save history
                    if ($id) $_action = 'Updated';
                    else $_action = 'Added';
                    $this->history_model->add_history(NULL,$_action,$saved_id,'video');
                    
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công.');
                    redirect(base_url('video'));
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu của bạn');
                }
            }

            //Fetch tags
            $this->data['tags'] ='';
            if ($this->data['video']->tags_id != '') {
                $tags = $this->tag_model->getTagsInIds($this->data['video']->tags_id);
                if($tags) {
                    foreach ($tags as $key => $val) {
                        $_tags_name[] = $val->tag;
                    }
                }
                
                $this->data['tags'] = $_tags_name;
            }
            
            //Load view
            $this->data['meta_title'] = ($id) ? 'Sửa video' : 'Tạo video mới';
            $this->data['sub_view'] = 'admin/video/edit';
            $this->data['sub_js'] = 'admin/video/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete') || $this->data['userdata']['level'] > 2) return FALSE;
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            if($this->video_model->updateStatus($post_id,3)) {
                
                //save history
                $_action = 'Deleted';
                foreach ($post_id as $key => $id) {
                    $this->history_model->add_history(NULL,$_action,$id,'video');                
                }
                
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                return TRUE;
            }
            else {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
                return FALSE;
            }
            return FALSE;
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
            if($this->video_model->updateStatus($ids,$status)) 
            {
                //save history
                if ($status==1) $_action = 'Published';
                else $_action = 'UnPublished';
                foreach ($ids as $key => $id) {
                    $this->history_model->add_history(NULL,$_action,$id,'video');
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
        
        public function video_category($id=NULL)
        {
            if(! $id) $this->data['v_cat'] = $this->video_category_model->get_new();
            else $this->data['v_cat'] = $this->video_category_model->get_detail_video_category($id);
            $rules = $this->video_category_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run()==TRUE)
            {
                $_args = array('id', 'title', 'meta_title', 'meta_keyword', 'meta_description');
                $data = $this->video_category_model->array_from_post($_args);
                $input_id = $data['id'];
                if($input_id == 'NULL') $input_id = NULL;
                else $input_id = (int)$input_id;
                if( ! $input_id) $input_id = NULL;
                unset($data['id']);
                
                $data['slugname'] = build_slug($data['title']);
                $data['parent_id'] = 0;
                if( ! $data['meta_title']) $data['meta_title'] = $data['title'];
                if( ! $data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if( ! $data['meta_description']) $data['meta_description'] = $data['title'];
                
                if($saved_id = $this->video_category_model->save($data, $input_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công');
                }
                else {
                    $this->session->set_flashdata('session_error', 'Không thành công');
                }
            }
            
            $this->data['v_categories'] = $this->video_category_model->get_list_video_category();
            //Load view
            $this->data['meta_title'] = 'Chuyên mục Video';
            $this->data['sub_view'] = 'admin/video/category';
            $this->data['sub_js'] = 'admin/video/category-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
}