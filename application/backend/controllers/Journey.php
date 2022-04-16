<?php
class Journey extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('journey_model');
        $this->load->model('journey_milestone_model');
        $this->data['breadcrumbs'] = array('Journey' => base_url('journey'));
    }

    public function index() 
    {
        if ( ! $this->has_permission('view')) $this->not_permission();
        
        //Get conditions
        $this->data['journey'] = $this->journey_model->getStartupJourney();
        $this->data['milestone'] = NULL;
        $milestone = $this->journey_milestone_model->getMilestone();
        if ($milestone) 
        {
            foreach ($milestone as $key => $value) 
            {
                $this->data['milestone'][$value->journey_id][] = $value;
            }
        }

        $this->data['sub_view'] = 'admin/journey/index';
        $this->data['meta_title'] = 'Journey Manager';
        
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function edit($id=NULL)
    {
        $this->data['journey'] = $this->journey_model->getJourneyDetail($id, TRUE);
        $this->data['milestone'] = $this->journey_milestone_model->getMilestone($id);

        $rules = $this->journey_model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            $postField = ['name', 'note', 'position'];
            $post = $this->journey_model->array_from_post($postField);
            if ( $savedId = $this->journey_model->save($post, $id)) 
            {
                // save journey_milistone
                $redirectUrl = ($id) ? base_url('journey') : base_url('journey/edit/'.$savedId);
                redirect( $redirectUrl ,'refresh');
            }
        } 

        $this->data['sub_view'] = 'admin/journey/edit';
        $this->data['sub_js'] = $this->data['sub_view'] . '-js';
        $this->data['meta_title'] = 'Journey Manager';
        
        $this->load->view('admin/_layout_main',$this->data);
    }
}