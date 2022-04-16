<?php
class Comment_model extends MY_Model{
    
    protected $_table_name  = 'comment';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id DESC';    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function get_new(){
        $data = new stdClass();
        $data->username = '';
        $data->email = '';
        $data->comment = '';
        $data->newsId = 0;
        $data->parentId = NULL;
        $data->status = 2;
        return $data;
    }
    
    public function getDetailComment($id=NULL)
    {
        if( ! $id) return $this->get_new();
        return $this->get($id, TRUE);
    }
    
    public function getCommentByNews($newsId)
    {
        if( ! $newsId) return FALSE;
        $args = array('newsId', $newsId);
        $this->db->where($args);
        $this->db->limit(20,0);
        return $this->get();
    }
    
    public function getListComment($status=NULL, $newsId=NULL, $offset=0, $limit=20)
    {
        $args = array();
        if($status)
        {
            $args['status'] = $status;
        }
        else {
            $args['status !='] = 3;
        }
        if($newsId) $args['newsId'] = $newsId;
        $this->db->where($args);
        $this->db->limit($limit, $offset);
        return $this->get();
    }
    
    public function updateStatus($ids,$status) {
        $this->db->where_in('id',$ids);
        $args = array('status' => $status);
        if($this->db->update($this->_table_name,$args)) {
            return true;
        }
        return false;
    }
    
}