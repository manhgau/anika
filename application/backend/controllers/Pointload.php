<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pointload extends MY_Controller {        
        public function __construct() 
        {
            parent::__construct();
            $this->load->model('pointload_model');
            $this->load->model('pointrefund_model');

            //Breadcrumbs
            $this->data['breadcrumbs']['Điểm'] = base_url('pointload');
        }

        public function index() 
        {
        	$this->data['report'] = $this->pointload_model->reportSystemPoint();
            //load view template
            $this->data['meta_title'] = lang('point');
            $this->data['sub_view'] = 'admin/pointload/index';
            $this->data['sub_js'] = 'admin/pointload/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function refund() 
        {
        	$this->data['filter'] = $this->input->get();
            //load view template
            $this->data['meta_title'] = lang('point');
            $this->data['sub_view'] = 'admin/pointload/refund';
            $this->data['sub_js'] = 'admin/pointload/refund-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getRefundGrid()
        {
            $result = $this->pointrefund_model->dataGrid();
            header('Content-Type: application/json');
            echo json_encode($result);
        }

        public function modalRecharge($userId=null) 
        {
        	$this->load->model('member_model');
        	$this->data['user'] = ($userId) ? $this->member_model->get($userId, true) : null;
        	$this->load->view('admin/pointload/modal-recharge', $this->data);
        }

        public function modalRefundProcess($requestId) 
        {
        	$this->load->model('member_model');
        	$this->data['request'] = $request = $this->pointrefund_model->get($requestId, true);
        	$this->data['member'] = $this->member_model->get($request->member_id, true);
        	$this->load->view('admin/pointload/modal-refund', $this->data);
        }

        public function getDataGrid()
        {
            $result = $this->pointload_model->dataGrid();
            header('Content-Type: application/json');
            echo json_encode($result);
        }

        public function apis($action)
        {
            $fnc = "__{$action}";
            $this->$fnc();
        }

        private function __removeNews()
        {
            $id = intval($this->input->post('id'));
            $this->jsonResponse(200, 'success', []);
        }

        private function __checkPhone()
        {
            $phone = trim($this->input->get('phone'));
            $id = intval($this->input->get('id'));
            $where = ['owner_phone' => $phone];
            if ($id) 
                $where['id !='] = $id;

            $already = $this->member_model->get_by($where, true);
            if ($already) 
                $this->jsonResponse(200, 'already', []);
            else
                $this->jsonResponse(201, 'not exist', []);
        }

        private function __checkCode()
        {
            $code = trim($this->input->get('code'));
            $id = intval($this->input->get('id'));
            $where = ['code' => $code];
            if ($id) 
                $where['id !='] = $id;
            
            $already = $this->member_model->get_by($where, true);
            if ($already) 
                $this->jsonResponse(200, 'already', []);
            else
                $this->jsonResponse(201, 'not exist', []);
        }

        private function __togglePublic()
        {
            $id = intval($this->input->post('id'));
            $news = $this->member_model->get($id);
            $data = [
                'is_public' => ($news->is_public) ? 0 : 1
            ];
            $this->member_model->save($data, $id);
            $this->jsonResponse(200, 'success');
        }

        private function __recharge()
        {
            $member_id = intval($this->input->post('member_id'));
            $amount = intval(str_replace(',', '', $this->input->post('amount')));
            $note = cleanInputString($this->input->post('note'));
            $data = [
            	'member_id' => $member_id,
            	'amount' => $amount,
            	'note' => $note,
            	'type' => 'recharge',
            	'admin_id' => $this->data['userdata']['id'],
            ];

            if ($this->pointload_model->save($data, null)) 
            	$this->jsonResponse(200, 'success');
            else
            	$this->jsonResponse(500, 'Hệ thống bận.');
        }

        private function __refundAnswer()
        {
            $requestId = intval($this->input->post('id'));
            $status = trim($this->input->post('status'));
            $note = cleanInputString($this->input->post('note'));

			if ($this->pointrefund_model->refundProccess($requestId, $note , $status, $this->data['userdata']['id'])) 
            	$this->jsonResponse(200, 'success');
            else
            	$this->jsonResponse(500, 'Hệ thống bận.');
        }
}

/* End of file Pointload.php */
/* Location: ./application/backend/controllers/Pointload.php */