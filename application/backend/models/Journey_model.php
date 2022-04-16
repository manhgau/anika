<?php
class Journey_model extends MY_Model {

    protected $_table_name  = 'startup_journey';
    protected $_primary_key = 'id';
    protected $_order_by    = 'position ASC, id DESC';
    public    $rules        = array (
        'name' => array(
            'field'   => 'name',
            'rules'   => 'trim|required' )
    );

    public function __construct(){
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->id = NULL;
        $data->name = NULL;
        $data->note = NULL;
        $data->position = $this->getNextPosition();
        return $data;
    }

    public function getNextPosition()
    {
        $this->db->select('MAX(position) AS pos');
        $result = $this->get(NULL, TRUE);
        return ++$result->pos;
    }

    public function getStartupJourney()
    {
        $this->db->select('id, name, position, note');
        return $this->get();
    }

    public function getJourneyDetail($id=NULL)
    {
        return ($id) ? $this->get($id, TRUE) : $this->get_new();
    }

}