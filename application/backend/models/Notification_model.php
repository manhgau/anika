<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Notification_model extends MY_Model {
        protected $_table_name  = 'notification';

        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'title'            => array(
                'field'   => 'title',
                'rules'   => 'trim|max_length[255]|required' ),
            'content'        => array(
                'field'   => 'content',
                'rules'   => 'trim' ),
            'type'        => array(
                'field'   => 'type',
                'rules'   => 'trim' ),
            'sender_type' => array(
                'field'   => 'sender_type',
                'rules'   => 'trim' ),
            'status'      => array(
                'field'   => 'status',
                'rules'   => 'intval'
            )
        );
        public function __construct() {
            parent::__construct();
        }
        const TYPE_HETHONG = 'thong_bao_he_thong';
        const TYPE_KHUYENMAI = 'thong_bao_khuyen_mai';
        protected $allTYPE = [
            self::TYPE_HETHONG => [
                'name' => 'Hệ thống',
            ],
            self::TYPE_KHUYENMAI => [
                'name' => 'Khuyến mãi',
            ]
        ];
        public function get_new($type ='thong_bao_he_thong', $sender='all'){
            $data = new stdClass();
            $data->id = NULL;
            $data->title = '';
            $data->content = '';
            $data->type = $type;
            $data->sender_type=$sender;
            $data->meta_keyword = config_item('default_meta_keyword');
            $data->created_time = date('Y-m-d H:i:s');
            $data->created_by = $this->session->userdata['id'];
            $data->status = 0;
            $data->display_author = 1;
            return $data;
        }
        public function getType($type='')
        {
            return ($type) ? $this->allType[$type] : $this->allType;
        }
        public function getAuthorHasArticle($args)
        {
//            $default = array(
//                'status' => 0,
//            );
            $params = array_merge( $args);

            $where = array();
//            $where['status'] = $params['status'];

            $this->db->distinct();
            $this->db->select('created_by AS user_id');
            $this->db->where($where);
            $this->db->group_by('user_id');
            $this->db->limit(200);

            if (! $resultQuery = $this->get()) {
                return FALSE;
            }
            $data = array();
            foreach ($resultQuery as $key => $value) {
                $data[] = $value->user_id;
            }
            return $data;
        }
        public function get_list_notification($offset=0, $limit=10,$authorId=NULL, $keyword=NULL) {
            $this->db->distinct();
            $this->db->select('a.*');
            $this->db->from('notification AS a');
            if($authorId) $this->db->where('a.created_by',$authorId);
            if($keyword) $this->db->like('a.title',$keyword);
            $this->db->order_by('a.created_time DESC');
            $this->db->group_by('id');
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
        public function delete_list($ids) {
            $this->db->where_in('id',$ids);
            if($this->db->delete($this->_table_name)) {
                return true;
            }
            return false;
        }
        public function list_notification ($offset=0, $limit=10, $member_id=0, $is_read= NULL, $type= NULL){
            $this->db->select('a.*, b.title, b.title, b.content, b.sender_id, b.type, b.created_by, b.sender_type');
            $this->db->from($this->_table_name . ' as a');
            $this->db->join('notification as b', 'a.notify_id = b.id', 'inner');
            $this->db->where('a.member_id',$member_id);
            if($type != NULL){
                $this->db->where('b.type',$type);
            }
            if($is_read != NULL){
                $this->db->where('a.is_read',$is_read);
            }
            $this->db->order_by('a.id',"DESC");
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
        public function count_unread_notifications($member_id=0){
            $this->db->select('*');
            $this->db->where('is_read','0');
            $this->db->where('member_id',$member_id);
            $data =$this->db->count_all_results($this->_table_name);
            return $data;
        }
        public function detail_notification ($id = 0, $member_id = 0){
            $this->db->select('a.*, b.title, b.title, b.content, b.sender_id, b.type, b.created_by, b.sender_type');
            $this->db->from($this->_table_name . ' as a');
            $this->db->join('notification as b', 'a.notify_id = b.id', 'inner');
            $this->db->where('a.member_id',$member_id);
            $this->db->where('a.id',$id);
            $data = $this->db->get()->row();
            if($data){
                if($this->__update_is_read($id) == TRUE){
                    return $data;  
                }
            }
        }
        private function __update_is_read($id){
            $this->db->set('is_read', '1');
            $this->db->where('id', $id);
            $this->db->update($this->_table_name);
            return TRUE;
        }
    }