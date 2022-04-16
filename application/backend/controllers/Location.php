<?php
    class Location extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('location_model');
            $this->load->model('location_group_model');
            $this->data['breadcrumbs'] = array('Địa điểm' => base_url('location'));
        }

        public function index() 
        {
            //Get conditions
            $this->data['parent_id'] = $parentId = $this->input->get('parent_id');
            $this->data['group_id'] = $group_id = $this->input->get('group_id');
            if ($parentId) {
                $this->data['parentLocation'] = $parent = $this->location_model->get($parentId, true);

                $tokenValue = array(
                        'id' => $parent->id,
                        'name' => $parent->name,
                    );

                if ($parent->parent_id) {
                    $_parent = $this->location_model->get($parent->parent_id);
                    $tokenValue['name'] .= ', '. $_parent->name;

                    if ($_parent->parent_id) {
                        $__parent = $this->location_model->get($_parent->parent_id);
                        $tokenValue['name'] .= ', '. $__parent->name;
                    }
                }

                $this->data['tokenParent'] = json_encode( array($tokenValue) );
            }

            if ($group_id) {
                $group = $this->location_group_model->get($group_id, TRUE);
                $tokenValue = array(
                        'id' => $group->id,
                        'name' => $group->name,
                    );
                if ($group->parent_id) {
                    $_parent = $this->location_group_model->get($group->parent_id);
                    $tokenValue['name'] .= ' - '. $_parent->name;

                    if ($_parent->parent_id) {
                        $__parent = $this->location_group_model->get($_parent->parent_id);
                        $tokenValue['name'] .= ', '. $__parent->name;
                    }
                }
                $this->data['tokenGroup'] = json_encode( array($tokenValue) );
            }
            
            //Load view
            $this->data['meta_title'] = 'Danh sách địa điểm';
            $this->data['sub_view'] = 'admin/location/index';
            $this->data['sub_js'] = 'admin/location/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getLocationData()
        {
            $parentId = intval($this->input->get_post('parent_id'));
            $group_id = intval($this->input->get_post('group_id'));
            $offset = $this->input->get_post('start');
            $limit = $this->input->get_post('length');
            $search = $this->input->get_post('search');
            $keyword = '';
            if ($search['value']) {
                $keyword = $search['value'];
            }

            //check childs group
            if ($group_id) {
                $group_ids = array( $group_id );
                $childGroupParams = array('parent_id' => $group_id);
                if ($childGroups = $this->location_group_model->get_by($childGroupParams)) {
                    foreach ($childGroups as $key => $value) {
                        $group_ids[] = $value->id;
                    }
                    $data = $this->location_model->getListLocationByParent($parentId, $offset, $limit, $keyword, $group_ids);
                }
                else {
                    $data = $this->location_model->getListLocationByParent($parentId, $offset, $limit, $keyword, $group_id);
                }
            }
            else
            {
                $data = $this->location_model->getListLocationByParent($parentId, $offset, $limit, $keyword, $group_id);
            }


            $totalRecords = $this->location_model->countLocation($parentId, $group_id);

            $response = array(
                'data' => $data,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords
            );

            echo json_encode($response);
            exit();
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Thêm địa điểm mới';
            $parent_id = ($this->input->get_post('parent_id')) ? $this->input->get_post('parent_id') : 0;
            $group_id = ($this->input->get_post('group_id')) ? $this->input->get_post('group_id') : 0;

            $this->data['location'] = $_this_location = $this->location_model->getDetailLocation($id);
            if($id) 
            {   
                if(! count($this->data['location']) ) $this->data['errors'][] = 'location could not be found!';
                $this->data['meta_title'] = 'Sửa thông tin địa điểm';
            }
            else 
            {
                if ($parent = $this->location_model->get($parent_id, TRUE)) {
                    $_this_location->parent_id = $parent_id;
                    $_this_location->level = ++$parent->level;
                    $_this_location->group_id = $group_id;
                    $this->data['location'] = $_this_location;
                }
                if ( ! $this->has_permission('add')) $this->not_permission();
            }
            //validate form
            $rules = $this->location_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                //save location
                $args = array('name','parent_id', 'group_id', 'thumbnail', 'content', 'description');
                $data = $this->location_model->array_from_post($args);
                if ($data['parent_id']) {
                    $parent = $this->location_model->getDetailLocation($data['parent_id']);
                    $data['level'] = $parent->level+1;
                }
                else {
                    $data['level'] = 1;
                    $data['parent_id'] = 0;
                }
                $data['slugname'] = build_slug($data['name']);
                
                //check location exist
                if (!$id && $this->location_model->checkLocationAlready($data['name'], $data['parent_id'])) {
                    $this->session->set_flashdata('session_error','Error! location already.');  
                }
                else
                {
                    if($savedId = $this->location_model->save($data,$id)) {
                        $this->session->set_flashdata('session_msg','Success!');
                    }
                    else {
                        $this->session->set_flashdata('session_error','Error!');   
                    }
                }
                redirect(base_url('location/index/?parent_id='.$data['parent_id']. '&group_id='.$data['group_id']  ));
            }

            if ($parentId = $_this_location->parent_id) {
                $parent = $this->location_model->get($parentId, true);
                $tokenValue = array(
                        'id' => $parent->id,
                        'name' => $parent->name,
                    );
                if ($parent->parent_id) {
                    $_parent = $this->location_model->get($parent->parent_id);
                    $tokenValue['name'] .= ', '. $_parent->name;
                    if ($_parent->parent_id) {
                        $__parent = $this->location_model->get($_parent->parent_id);
                        $tokenValue['name'] .= ', '. $__parent->name;
                    }
                }
                $this->data['tokenParent'] = json_encode( array($tokenValue) );
            }

            //token group location
            if ($_this_location->group_id) {
                $group = $this->location_group_model->get($_this_location->group_id, TRUE);
                $tokenGroup = array();
                $tokenGroup[] = array( 'id' => $group->id, 'name' => $group->name );
                $this->data['tokenGroup'] = json_encode($tokenGroup);
            }
            
            //Fetch location type
            $this->data['sub_view'] = 'admin/location/edit';
            $this->data['sub_js'] = 'admin/location/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            $location = $this->location_model->getDetailLocation($id);

            if ($this->location_model->delete($id))
            {
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            }
            else
            {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
            }

            redirect(base_url('location/index/?parent_id=' . $location->parent_id));
        }

        public function locationGroup($id=NULL)
        {

            //update database when submit data
            $rules = $this->location_group_model->rules;
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == TRUE) {
                $inputFields = array('name', 'parent_id');
                $data = $this->location_group_model->array_from_post($inputFields);
                $data['slugname'] = build_slug($data['name']);

                if ( ! $saved_id = $this->location_group_model->save($data, $id) ) 
                    $this->session->set_flashdata('session_error', 'Không thể cập nhật dữ liệu');
                else
                    $this->session->set_flashdata('session_msg', 'Cập nhật dữ liệu thành công');
            }

            //Fetch all group
            $listGroup = $this->location_group_model->get();
            if ($listGroup) {
                foreach ($listGroup as $key => $val) {
                    if ($val->parent_id == 0) {
                        $this->data['listGroup'][] = $val;
                        unset($listGroup[$key]);
                        foreach ($listGroup as $_key => $_val) {
                            if ($_val->parent_id == $val->id) {
                                $_val->name = '&mdash; ' . $_val->name;
                                $this->data['listGroup'][] = $_val;
                            }
                        }
                    }
                }
            }

            $this->data['group'] = $group = $this->location_group_model->getDetailGroup($id);
            if ( $group && $group->parent_id) {
                $this->data['groupParent'] = $groupParent = $this->location_group_model->getDetailGroup($group->parent_id);
                $tokenParent = array();
                $tokenParent[] = array( 'name' => $groupParent->name, 'id' => $groupParent->id );
                $this->data['tokenParent'] = json_encode($tokenParent);
            }

            //Fetch location type
            $this->data['sub_view'] = 'admin/location/group';
            $this->data['sub_js'] = 'admin/location/group-js';
            $this->load->view('admin/_layout_main',$this->data);

        }
}