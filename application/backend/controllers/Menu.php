<?php
    class Menu extends MY_Controller {

        public function __construct() 
        {
            parent::__construct();
            $this->load->model('menu_m');
        }

        public function index() 
        {   
            if ( ! $this->has_permission('view')) $this->not_permission();     
            //fetch all menus
            $this->data['meta_title'] = 'Listing menus';
            $this->data['breadcrumbs']['List menu'] = base_url('admin/menu');
            $this->data['menus'] = $this->menu_m->get_with_parent();

            //load view template
            $this->data['sub_view'] = 'admin/menu/index';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {
            $this->data['meta_title'] = 'Add new menu';
            $this->data['breadcrumbs'] = array('List menu' => base_url('admin/menu'));

            //Fetch a menu or set a new one
            if($id) {
                if ( ! $this->has_permission('edit')) $this->not_permission();     
                $this->data['menu'] = $this->menu_m->get($id);
                if(! count($this->data['menu']) ) $this->data['errors'][] = 'menu could not be found!';
                $this->data['meta_title'] = 'Editting menu';
                $this->data['breacrumbs']['Edit menu'] = base_url('admin/menu/edit/' . $id);
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();     
                $this->data['breadcrumbs']['Add new menu'] = base_url('admin/menu');
                $this->data['menu'] = $this->menu_m->get_new();
            }

            //Fetch list menus no parent
            $this->data['menu_no_parent'] = $this->menu_m->get_no_parent();

            //validate form
            $rules = $this->menu_m->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() === TRUE) 
            {
                $data = $this->menu_m->array_from_post(array('title','slug','order','content','parent_id'));
                if($data['slug'] == '') $data['slug'] = $data['title'];
                $data['slug'] = build_slug($data['slug']);            
                if($saved_id = $this->menu_m->save($data,$id))
                {
                    //save history
                    if($id) $_action = 'Updated';
                    else $_action = 'Added';
                    $this->history_model->add_history(NULL,$_action,$saved_id,'menu');
                }
                
                redirect('menu');
            }

            //Fetch list message waitting reply
            $this->data['message_waiting'] = $this->message_m->get_by('status = 2');

            //$this->data['validation_check'] = $this->validate_check;
            $this->data['sub_view'] = 'admin/menu/edit';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) 
            {
                $this->not_permission();
            }
            if ( ! $this->has_permission('delete')) $this->not_permission();     
            $this->menu_m->delete($id);
            
            //save history
            $_action = 'Deleted';
            $this->history_model->add_history(NULL,$_action,$id,'menu');
            
            redirect('menu');
        }

        public function _unique_slug($str) 
        {
            //Don't validate form if this slug already

            $id = $this->uri->segment(4);
            $this->db->where('slug',$this->input->post('slug'));
            !$id || $this->db->where('id !=', $id);
            $menu = $this->menu_m->get();
            if(count($menu)) {
                $this->form_validation->set_message('_unique_slug','%s should be Unique');
                return FALSE;
            }
            return TRUE;
        }
}