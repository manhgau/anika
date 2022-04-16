<?php
    class Portfolio extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('portfolio_model');
            $this->load->model('file_model');
            $this->load->model('option_model');
        }

        public function index() {
            // if ( ! $this->has_permission('view')) $this->not_permission();
            $status = (int)$this->input->get_post('status');
            $this->data['portfolios'] = $this->portfolio_model->getListPorfolio($status, 20);

            //fetch breadcrumbs
            $this->data['breadcrumbs'] = array( 'Portfolio' => base_url('portfolio'));

            //load view template
            $this->data['meta_title'] = 'Our Portfolio';
            $this->data['sub_view'] = 'admin/portfolio/index';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) {
            $this->data['meta_title'] = 'Portfolio';

            //Fetch a portfolio or set a new one
            if($id) {
                if ( ! $this->has_permission('edit')) $this->not_permission();
                $this->data['portfolio'] = $this->portfolio_model->get($id);
                if( ! $this->data['portfolio'] ) {
                    $this->data['errors'][] = 'portfolio could not be found!';
                    redirect(base_url('portfolio'));
                }
                $action = 'update';
                $this->data['meta_title'] = 'Thông tin Portfolio';
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['portfolio'] = $this->portfolio_model->getNew();
                $action = 'insert';
            }
            
            //validate form
            $rules = $this->portfolio_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->portfolio_model->array_from_post(array('name','logo','status','order', 'url', 'description', 'isHot', 'type', 'thinkzone_batch', 'bussiness_area', 'vision_mission', 'key_traction', 'year_foundation', 'founder_name', 'founder_image'));
                $data['name'] = cleanInputString($data['name']);
                $data['description'] = cleanInputString($data['description']);
                $data['isHot'] = (isset($data['isHot'])) ? 1 : 0;
                $data['status'] = ($data['status']) ? 1 : 2;
                $data['type'] = ($data['type']) ? $data['type'] : '';

                if ($data['thinkzone_batch']) 
                {
                    $_arrBatch = explode(',', $data['thinkzone_batch']);
                    $_arrBatch = array_filter($_arrBatch);
                    $_arrBatch = array_map('trim',$_arrBatch);
                    $_batch = implode(',', $_arrBatch);
                    $data['thinkzone_batch'] = ",{$_batch},";
                }

                if ($data['bussiness_area']) 
                {
                    $_arrBatch = explode(',', $data['bussiness_area']);
                    $_arrBatch = array_filter($_arrBatch);
                    $_arrBatch = array_map('trim',$_arrBatch);
                    $_batch = implode(',', $_arrBatch);
                    $data['bussiness_area'] = ",{$_batch},";
                }
                
                $this->portfolio_model->save($data,$id);
                redirect('portfolio');
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/portfolio/edit';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id) {
            $data = array('status' => 3);
            $this->portfolio_model->save($data,$id);
            return TRUE;
        }

        public function change_status($id) {
            $status = 1;
            $portfolio = $this->portfolio_model->get($id,TRUE);
            if ($portfolio->status == 1) 
                $status=2;
            $data = array('status'=>$status);
            if ($this->portfolio_model->save($data,$id))
                $this->responseJson(1, 'success', $data);
            else
                $this->responseJson(0, 'error');
        }
}