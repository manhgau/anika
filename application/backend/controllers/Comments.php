<?php
    class Comments extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('product_type_m');
            $this->load->model('filter_m');
            $this->load->model('filter_detail_m');
            $this->load->model('message_m');
        }

        public function index() {    
            //Fetch list message waitting reply
            $this->data['message_waiting'] = $this->message_m->get_by('status = 2');
            
            //load view template
            $this->data['breadcrumbs'] = array( 'Quản lý comments' => base_url('admin/comments'));
            $this->data['meta_title'] = 'Quản lý comment';
            $this->data['sub_view'] = 'admin/comments/index_view';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($prod_type_id = NULL) {
            //Fetch a product or set a new one
            if($prod_type_id) {
                $this->data['type_id'] = $prod_type_id;
                $this->data['filters'] = $list_filter = $this->filter_m->get_filter_by_product_type($prod_type_id);
                foreach ( $list_filter as $key => $val ) {
                    $this->data['filter_values'][$val->id] = $this->filter_detail_m->get_list_by_filter_id($val->id);
                }
                $action = 'update';
            }
            else {
                $this->data['type_id'] = 0;
                $action = 'insert';
            }

            //Get tree product type
            $this->data['product_types'] = $list_types = $this->product_type_m->get_tree_product_type();
            $tree_types  = array(0=>' Chọn loại sản phẩm ');
            if(count($list_types)){
                foreach($list_types as $_caties){
                    $_title_refix = '';
                    for($i=1;$i<$_caties->level;$i++){
                        $_title_refix .= '&mdash;';
                    }
                    $tree_types[$_caties->id] = $_title_refix.' '.$_caties->name;
                }
            }
            $this->data['tree_types'] = $tree_types;

            //validate form
            $rules = $this->filter_m->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $filter_input_arr = $this->filter_m->array_from_post(array('name_filter','product_type'));
                $filter_detail_input_arr = $this->filter_detail_m->array_from_post(array('name_filter','value_filter'));
                $product_type_id = $filter_input_arr['product_type'];

                foreach ( $filter_input_arr['name_filter'] as $key => $name ) {
                    $filter_id = NULL;
                    $data = array(
                        'name' => $name,
                        'product_type_id' => $product_type_id
                    );
                    $filter_id = $this->filter_m->save($data,NULL);
                    $arr_value_filter = explode('|',$filter_detail_input_arr['value_filter'][$key]);                                                      foreach ( $arr_value_filter as $k => $v ) {
                        $_detail_data = array(
                            'filter_id' => $filter_id,
                            'value' => $v
                        );
                        $this->filter_detail_m->save($_detail_data,NULL);
                    }         
                }
                redirect(base_url('admin/filter'));
            }

            //Fetch list message waitting reply
            $this->data['message_waiting'] = $this->message_m->get_by('status = 2');
            //Load view
            $this->data['breadcrumbs'] = array( 'Bộ lọc' => base_url('admin/filter'));
            $this->data['sub_view'] = 'admin/filter/edit_view';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit_filter ($filter_id) {
            $this->data['filter'] = $filter = $this->filter_m->get($filter_id,TRUE);
            $this->data['list_detail'] = $list_detail = $this->filter_detail_m->get_list_by_filter_id($filter_id);
            $rules = $this->filter_detail_m->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $arr_input = $this->filter_detail_m->array_from_post(array('filter_id','value_filter'));
                $filter_id = $arr_input['filter_id'];
                if(! empty($arr_input['value_filter']) ){
                    $arr_value = $arr_input['value_filter'];
                    foreach ( $arr_value as $key => $val ) {
                        if(trim($val) != '') {
                            $data = array(
                                'filter_id' => $filter_id,
                                'value' => trim($val)
                            );
                            $this->filter_detail_m->save($data,NULL);
                        }
                    }                    
                }                
                redirect(base_url('admin/filter/edit/' . $filter->product_type_id));
            }
            //Fetch list message waitting reply
            $this->data['message_waiting'] = $this->message_m->get_by('status = 2');
            //Load view
            $this->data['breadcrumbs'] = array( 'Bộ lọc' => base_url('admin/filter'));
            $this->data['sub_view'] = 'admin/filter/edit_filter_view';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit_detail($id,$value) {
            $data = array('value' => urldecode($value));
            $this->filter_detail_m->save($data,$id);
            return TRUE;
        }

        public function delete_filter($id = NULL) {
            $filter = $this->filter_m->get($id,TRUE);
            $this->filter_m->delete($id);
            $list_detail = $this->filter_detail_m->get_list_by_filter_id($id);
            foreach ( $list_detail as $key => $val ) {
                $this->filter_detail_m->delete($val->id);
            }
            redirect(base_url('admin/filter/edit/' . $filter->product_type_id));
        }

        public function delete_detail($id) {
            $this->filter_detail_m->delete($id);
            return true;
        }
        
        public function _unique_slug($str) {
            //Don't validate form if this slug already        
            $id = $this->uri->segment(4);
            $this->db->where('slug',$this->input->post('slug'));
            !$id || $this->db->where('id !=', $id);
            $product_type = $this->product_type_m->get();
            if(count($product_type)) {
                $this->form_validation->set_message('_unique_slug','%s Slugname này đã tồn tại');
                return FALSE;
            }
            return TRUE;
        }

        public function autoload_filter_for_product_type($product_type_id) {
            $html = '';
            //get product_type
            $product_types = $this->product_type_m->get_all_parent_product_type($product_type_id);
            
            foreach ( $product_types as $key => $type ) {
                $arr_type_ids[] = $type->id;
            }
            $arr_type_ids = array_unique($arr_type_ids);
            $list_filter = array();
            foreach ( $arr_type_ids as $key => $val ) {
                $_filtes = $this->filter_m->get_filter_by_product_type($val);
                $list_filter = array_merge_recursive($list_filter, $_filtes);
            }
            foreach ( $list_filter as $key => $val ) {
                $html .= '<div class="form-group"><label for="exampleInputEmail1"> '.$val->name.' </label><select name="filterbox['.$val->id.']" class="form-control">';
                $list_filter_detail = $this->filter_detail_m->get_list_by_filter_id($val->id);
                foreach ( $list_filter_detail as $k => $v ) {
                    $html .= '<option value="'.$v->id.'"> '.$v->value.' </option>';
                }
                $html .= '</select></div>';
            }
            print_r($html);
            die();            
        }
}