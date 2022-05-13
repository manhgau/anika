<?php
class Setting_department extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_department_model');

        //fetch breadcrumbs
        $this->data['breadcrumbs'] = array(
            // 'Danh sách sản phẩm' => base_url('products'),
            'Danh mục phòng ban' => base_url('setting_department')
        );
    }

    public function index()
    {
        if ( ! $this->has_permission('view')) $this->not_permission();
        $this->data['department'] = $this->setting_department_model->getList();

        // print_r($this->data['category_post']);
        // exit();

        //load view template
        $this->data['meta_title'] = 'Phòng ban';
        $this->data['sub_view'] = 'admin/setting_department/index';
        $this->data['sub_js'] = 'admin/setting_department/index-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function edit($id = NULL)
    {
        $this->data['meta_title'] = 'Thêm phòng ban ';
        $_list_department = $this->setting_department_model->getList();
        $this->data['list_department'] = $_list_department;
        if($id) {
            if ( ! $this->has_permission('edit')) $this->not_permission();
            $this->data['department'] = $this->setting_department_model->get($id);
            if(! $this->data['department'] ) {
                $this->data['errors'][] = 'setting_department could not be found!';
                redirect(base_url('department'));
            }
        }
        else {
            if ( ! $this->has_permission('add')) $this->not_permission();
            $this->data['department'] = $this->setting_department_model->get_new();
            $action = 'insert';
        }

        $rules = $this->setting_department_model->rules;
        // print_r($rules);
        // exit();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE) {
            $data = $this->setting_department_model->array_from_post(array('name'));
            if(!$data['name']) $data['name'] = $data['title'];
            if($save_id = $this->setting_department_model->save($data,$id)) {

                $this->session->set_flashdata('session_msg','Cập nhật phòng ban thành công');
            }
            else {
                $this->session->set_flashdata('session_error','Không thể cập nhật phòng ban');
            }
            // print_r($data);
            // exit();
            redirect(base_url('setting_department'));
        }

        //Load view
        $this->data['meta_title'] = 'Thêm mới phòng ban';
        if($id) {
            $this->data['meta_title'] = 'Sửa phòng ban';
        }
        $this->data['sub_view'] = 'admin/setting_department/edit';
        $this->data['sub_js'] = 'admin/setting_department/edit-js';
        $this->load->view('admin/_layout_main',$this->data);

    }

    public function delete($id = NULL)
    {
        if ( ! $this->has_permission('delete')) $this->not_permission();
        $post_id = $this->input->post('ids');
        if($id) {
            $post_id[] = $id;
        }
        foreach ($post_id as $key => $val) {
            $this->setting_department_model ->delete($id);
            $this->history_model->add_history(NULL,'Deleted',$id,'department');
        }
        $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
        redirect(base_url('setting_department'));
    }

    // public function _unique_slug($str)
    // {
    //     //Don't validate form if this slug already
    //     $id = $this->uri->segment(3);
    //     $this->db->where('slug',$this->input->post('slug'));
    //     !$id || $this->db->where('id !=', $id);
    //     $category_post = $this->category_post_model->get();
    //     if(count($category_post)) {
    //         $this->form_validation->set_message('_unique_slug','%s should be Unique');
    //         return FALSE;
    //     }
    //     return TRUE;
    // }



}

?>