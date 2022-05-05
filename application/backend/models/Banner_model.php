<?php
    class Banner_model extends MY_Model {

        protected $_table_name  = 'banner';
        protected $_primary_key = 'id';
        protected $_order_by    = 'position ASC, id DESC';
        public    $rules        = array (
            'type' => array(
                'field'   => 'type',
                'rules'   => 'trim|intval|required' )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new($type=1)
        {
            $data = new stdClass();
            $data->image = '';
            $data->is_blank = 0;
            $data->url = NULL;
            $data->type = $type;
            $data->name = '';
            $data->status = 1;
            $data->position = $this->getNextPosition($type);
            $data->html = NULL;
            return $data;
        }

        public function getNextPosition($type=0)
        {
            $this->db->select('IF (position IS NULL, 0, MAX(position)) AS pos');
            $this->db->from($this->_table_name);
            if ($type) 
                $this->db->where('type', intval($type));
            $data = $this->db->get()->row();
            $pos = intval($data->pos);
            return ++$pos;
        }

        public function get_banner_by_group ($group_id)
        {
            $conds = array(
                'type' => $group_id, 
                'status' => 1
            );
            $this->db->where($conds);
            return parent::get();
        }

        public function get_list_banner($status=0)
        {
            $this->db->select('*');
            if( ! $status)
                $this->db->where_in('status',array(1,2));
            else
                $this->db->where('status',$status);
            return $this->get();
        }

        public function updateStatus($ids,$status) 
        {
            $this->db->where_in('id',$ids);
            $args = array('status' => $status);
            if($this->db->update($this->_table_name,$args)) {
                return true;
            }
            return false;
        }
        public function get_list_banners($offset=0, $limit=10 ,$type=0)
        {                       
            $this->db->select('*');
            $this->db->from($this->_table_name );
            if($type>0){
                $this->db->where('type',$type);
            }
            $this->db->where('status','1');
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
  
}