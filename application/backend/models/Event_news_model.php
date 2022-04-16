<?php
class Event_news_model extends MY_Model {
    protected $_table_name  = 'event_news';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array ();
        
    public function __construct() {
        parent::__construct();
    }
    
    public function get_new() {
        $data = new stdClass();
        $data->event_id=0; 
        $data->news_id=0; 
        return $data;
    }
    
    function getNewsByEvent($event_id) {
        $this->db->select('n.id,n.title,n.slugname,n.category,n.description,n.public_time,n.create_by,n.hit_view');
        $this->db->from('news AS n');
        $this->db->join('event_news AS en', 'n.id = en.news_id');
        $this->db->where('en.event_id',$event_id);
        $this->db->where('n.status !=',3);
        $query = $this->db->get();
        if($query->num_rows() > 0) return $query->result();
        return false;
    }
    
    function getEventByNews($news_id) {
        $this->db->select('e.id,e.title,e.slugname,e.intro,e.begin_time,e.begin_time,e.location');
        $this->db->from('event AS e');
        $this->db->join('event_news AS en', 'en.event_id = e.id');
        $this->db->where('en.news_id',$news_id);
        $this->db->where('status !=', 3);
        $query = $this->db->get();
        if($query->num_rows() > 0) return $query->result();
        return false;
    }
    
    function removeEventByNews($news_id) {
        $this->db->where('news_id',$news_id);
        if($this->db->delete($this->_table_name)) {
            return true;
        }
        return false;
    }
    
    function saveEventByNews($news_id,$event_ids) {
        foreach ($event_ids as $event_id) {
            $data = array(
                'news_id' => $news_id,
                'event_id' => $event_id
            );
            if(!$this->save($data,NULL)) {
                return false;
            }
        }
        return true;
    }
    
}