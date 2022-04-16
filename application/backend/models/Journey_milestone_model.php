<?php
class Journey_milestone_model extends MY_Model {

    protected $_table_name  = 'startup_journey_milestone';
    protected $_primary_key = 'id';
    protected $_order_by    = 'position ASC, id DESC';
    public    $rules        = array (
        'name' => array(
            'field'   => 'name',
            'rules'   => 'trim|intval|required' )
    );

    public function __construct(){
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->id = NULL;
        $data->journey_id = NULL;
        $data->milestone = NULL;
        $data->activities = NULL;
        $data->output = NULL;
        $data->position = $this->getNextPosition();
        return $data;
    }

    public function getNextPosition()
    {
        $this->db->select('MAX(position) AS pos');
        $result = $this->get(NULL, TRUE);
        return ++$result->pos;
    }

    public function getMilestone($journeyId=NULL)
    {
        $this->db->select('id, journey_id, milestone, activities, output, position');
        if ($journeyId) {
            $this->db->where('journey_id', $journeyId);
        }
        return $this->get();
    }

    public function getMilestoneById($id=NULL)
    {
        if ( ! $id) 
            return $this->get_new();

        if ( ! is_array($id)) {
            return $this->get($id, TRUE);
        }
        else
        {
            $this->db->where_in('id', $id);
            return $this->get();
        }
    }

}