<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accelerator extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('accelerator_model');
	}

	public function edit($id=NULL)
	{
		$this->data['meta_title'] = ($id) ? 'Update accelerator' : 'Addnew accelerator';
		$this->data['accelerator'] = ($id) 
			? $this->accelerator_model->getAcceleratorById($id) 
			: $this->accelerator_model->getNew();

		//validate form
		$rules = $this->accelerator_model->rules;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) 
		{
			if ($savedId = $this->accelerator_model->saveAccelerator($id)) 
			{
				$this->session->set_flashdata('session_msg', 'Thành công');
				redirect('/accelerator/index');
			}
			else
				$this->session->set_flashdata('session_error', 'Hệ thống bận, thử lại sau');
		}

		//Load view
		$this->data['sub_view'] = 'admin/accelerator/edit';
		$this->data['sub_js'] = $this->data['sub_view'] . '-js';
		$this->load->view('admin/_layout_main',$this->data);
	}

	public function index()
	{
		$this->data['accelerator'] = $this->accelerator_model->getAcceleratorData();

		//load view template
		$this->data['meta_title'] = 'Accelerator';
		$this->data['sub_view'] = 'admin/accelerator/index';
		$this->data['sub_js'] = 'admin/accelerator/index-js';
		$this->load->view('admin/_layout_main',$this->data); 
	}

	public function api($action='')
	{
		$fnc = "__{$action}";
		$this->$fnc();
	}

    public function delete($id) {
        $data = array('status' => 3);
        $this->portfolio_model->save($data,$id);
        return TRUE;
    }

    public function __toggleStatus($id) {
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

/* End of file Accelerator.php */
/* Location: ./application/backend/controllers/Accelerator.php */