<?php
    class Log_view_model extends MY_Model {

        protected $_table_name  = 'log_view';
        protected $_primary_key = 'id';
        protected $_order_by    = 'view_date DESC, id DESC';
        public    $rules        = array (
            'type' => array(
                'field'   => 'news_id',
                'rules'   => 'trim|intval|required' ),
            'view' => array(
                'field'   => 'view',
                'rules'   => 'trim|intval|required' ),
            'view_date' => array(
                'field'   => 'view_date',
                'rules'   => 'trim|required' ),
        );
        public $dayOfDelay;

        public function __construct(){
            parent::__construct();
            $this->dayOfDelay = config_item('day_number_to_count_view');
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->news_id = null;
            $data->view = 0;
            $data->view_date = date('Y-m-d', time());
            $data->update_time = date('Y-m-d H:i:s', time());
            return $data;
        }

        public function getSumViewByNews($newsId)
        {
            $this->db->select('SUM(view) AS view');
            $this->db->where('news_id', $newsId);
            $result = $this->get();
            return ($result) ? $result[0]['view'] : 0;
        }

        public function updateOrInsertViewLog($newsId=NULL, $view, $date )
        {
            //$this->db->query("CALL up_or_in_logview(".$newsId.",".$view.", '".$date."')");
            $currentTime = date('Y-m-d H:i:s', time());
            $data = array('view' => $view, 'update_time' => $currentTime);
            $chkParams = array('news_id' => $newsId, 'view_date' => $date);
            if ( $already = $this->get_by( $chkParams, TRUE ) ) {
                $this->save($data, $already->id);
                return TRUE;
            }
            else {
                $data['news_id'] = $newsId;
                $data['view_date'] = $date;
                $this->save($data, NULL);
                return TRUE;
            }
        }

        public function getViewByNews($news_id)
        {
            $this->db->select('SUM(view) as hit_view');
            $this->db->from($this->_table_name);
            $this->db->where('news_id', $news_id);
            $data = $this->db->get()->result_array();
            return ($data) ? intval($data[0]['hit_view']) : 0;
        }
}