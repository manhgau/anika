<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('feedback_model');
        $this->data['breadcrumbs']['Feedback'] = '/feedback/index';
    }

    public function index()
    {
        $filter = [
            'keyword' => ($this->input->get('keyword')) ? $this->input->get('keyword') : NULL,
            'status' => ($this->input->get('status')) ? $this->input->get('status') : NULL,
            'from_date' => ($this->input->get('from_date')) ? $this->input->get('from_date') : NULL,
            'to_date' => ($this->input->get('to_date')) ? $this->input->get('to_date') : NULL,
        ];
        $this->data['filter'] = $filter;

        //load view template
        $this->data['meta_title'] = 'Danh sách feedback';
        $this->data['sub_view'] = 'admin/feedback/index';
        $this->data['sub_js'] = $this->data['sub_view'] . '-js';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function edit($id=NULL)
    {
        $feedback = ($id) ? $this->feedback_model->get($id, TRUE) : $this->feedback_model->getNew();
        $this->data['feedback'] = $feedback;

        $this->data['listProvince'] = $this->province_model->get();
        if ($feedback->province_id) 
        {
            $this->data['listDistrict'] = $this->district_model->getDistrictByProvince($feedback->province_id);
            if ($feedback->district_id) 
                $this->data['listWard'] = $this->ward_model->getWardByDistrict($feedback->district_id);
        }

        # validate form
        $rules = $this->feedback_model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()==TRUE) 
        {
            $inputVar = ['fullname', 'short_name', 'phone', 'email', 'description', 'province_id', 'district_id', 'ward_id', 'address', 'is_hot', 'status', 'thumbnail', 'leader_name', 'order'];
            $data = $this->feedback_model->array_from_post($inputVar);
            $data['logo'] = $data['thumbnail'];
            $data['email'] = strtolower($data['email']);
            unset($data['thumbnail']);
            $data['phone'] = preg_replace('/[^\d]*/', '', $data['phone']);

            if (!$feedback->id) 
            {
                $data['create_by'] = $this->me->id;
                $data['create_time'] = date('Y-m-d H:i:s');
            }

            $alreadyId=$this->feedback_model->checkEmailOrPhoneAlready($data['email'], $data['phone']);
            if ($alreadyId && $alreadyId!=$feedback->id)
                    $this->session->set_flashdata('session_error', 'Email hoặc Số điện thoại đã tồn tại');
            else
            {
                if (!$savedId = $this->feedback_model->save($data, $feedback->id))
                    $this->session->set_flashdata('session_error', 'Lỗi! hệ thống bận, thử lại sau');
                else
                {
                    $this->session->set_flashdata('session_msg', 'Thành công.');
                    $this->data['feedback'] = $this->feedback_model->get($savedId, TRUE);
                }
            }
        }

        //load view template
        $this->data['meta_title'] = ($feedback->id) ? $feedback->short_name : 'Tạo feedback mới';
        $this->data['sub_view'] = 'admin/feedback/edit';
        $this->data['sub_js'] = $this->data['sub_view'] . '-js';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function getFeedbackDatatable()
    {
        $filter = [
            'keyword' => ($this->input->post('keyword')) ? $this->input->post('keyword') : NULL,
            'status' => ($this->input->post('status')) ? $this->input->post('status') : NULL,
            'from_date' => ($this->input->post('from_date')) ? $this->input->post('from_date') : NULL,
            'to_date' => ($this->input->post('to_date')) ? $this->input->post('to_date') : NULL,
            'offset' => intval($this->input->post('start')),
            'limit' => intval($this->input->post('length')),
        ];
        if ($filter['from_date']) $filter['from_date'] = date('Y-m-d', strtotime( str_replace('/', '-', $filter['from_date']) ));
        if ($filter['to_date']) $filter['to_date'] = date('Y-m-d', strtotime( str_replace('/', '-', $filter['to_date']) ));
        
        $datatable = $this->feedback_model->getFeedbackDatatable($filter);
        echo json_encode($datatable);
        exit();
    }

}

/* End of file feedback.php */
/* Location: ./application/backend/controllers/feedback.php */