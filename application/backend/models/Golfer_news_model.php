<?php
    class Golfer_news_model extends MY_Model {
        protected $_table_name  = 'golfer_news';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array ();

        public function __construct() {
            parent::__construct();
        }

        public function get_new() {
            $data = new stdClass();
            $data->golfer_id=0; 
            $data->news_id=0; 
            return $data;
        }

        public function getGolferByNews($news_id) {
            $this->db->select('g.*');
            $this->db->from('golfer AS g');
            $this->db->join('golfer_news AS gn','gn.golfer_id = g.id');
            $this->db->where('gn.news_id',$news_id);
            $query = $this->db->get();
            if($query->num_rows() > 0) {
                return $query->result();    
            }
            return false;
        }

        public function getNewsByGolfer($golfer_id) {
            $this->db->select('n.*');
            $this->db->from('news AS n');
            $this->db->join('golfer_news AS gn','gn.news_id = n.id');
            $this->db->where('gn.golfer_id',$golfer_id);
            $query = $this->db->get();
            if($query->num_rows()>0) {
                return $query->result();    
            }
            return false;
        }

        function removeGolferByNews($news_id) {
            $this->db->where('news_id',$news_id);
            if($this->db->delete($this->_table_name)) {
                return true;
            }
            return false;
        }

        function saveGolferByNews($news_id,$golfer_ids) {
            foreach ($golfer_ids as $golfer_id) {
                $data = array(
                    'news_id' => $news_id,
                    'golfer_id' => $golfer_id
                );
                if(!$this->save($data,NULL)) {
                    return false;
                }
            }
            return true;
        }

}