<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ourteam extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ourteam_model');
	}

	public function edit($id=NULL)
	{
		$this->data['meta_title'] = ($id) ? 'Update our team' : 'Addnew our team';
		$member = ($id) 
			? $this->ourteam_model->getMemberById($id) 
			: $this->ourteam_model->getNew();

		$this->data['member'] = $member;
		
		//validate form
		$rules = $this->ourteam_model->rules;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) 
		{
			if ($savedId = $this->ourteam_model->saveMember($id)) 
			{
				$this->session->set_flashdata('session_msg', 'Thành công');
				redirect('/ourteam/index');
			}
			else
				$this->session->set_flashdata('session_error', 'Hệ thống bận, thử lại sau');
		}

		//Load view
		$this->data['sub_view'] = 'admin/ourteam/edit';
		$this->data['sub_js'] = $this->data['sub_view'] . '-js';
		$this->load->view('admin/_layout_main',$this->data);
	}

	public function index()
	{
		$this->data['members'] = $this->ourteam_model->getListMember();
		
		//load view template
		$this->data['meta_title'] = 'Our team';
		$this->data['sub_view'] = 'admin/ourteam/index';
		$this->data['sub_js'] = 'admin/ourteam/index-js';
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

/* End of file ourteam.php */
/* Location: ./application/backend/controllers/ourteam.php */