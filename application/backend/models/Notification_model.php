<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Notification_model extends MY_Model {
        protected $_table_name  = 'notification';
        protected $_table  = 'notifycation_user';

        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        protected $_data_type = [
            'id' => 'int',
            'province_id' => 'int',
            'district_id' => 'int',
            'department_id' =>'int',
            'sender_id' => 'int',
        ];
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
                'rules'   => 'required|trim' ),
            'device_type' => array(
                'field'   => 'device_type',
                'rules'   => 'trim' ),
            'status'      => array(
                'field'   => 'status',
                'rules'   => 'intval'
            ),
            'province_id' => [
                'field' => 'province_id',
                'rules' => 'intval'
            ],
            'district_id' => [
                'field' => 'district_id',
                'rules' => 'intval'
            ],
            'department_id'=> array(
                'field' => 'department_id',
                'rules'   => 'trim|max_length[50]'
            ),
            'sender_id' => [
                'field' => 'sender_id',
                'rules' => 'intval'
            ],
            'image' => array(
                'field'   => 'image',
                'rules'   => 'trim' ),
        );
        public function __construct() {
            parent::__construct();
        }

        public function get_new($type ='thong_bao_he_thong'){
            $data = new stdClass();
            $data->id = NULL;
            $data->title = '';
            $data->content = '';
            $data->device_type = '';
            $data->type = $type;
            $data->sender_type='';
            $data->meta_keyword = config_item('default_meta_keyword');
            $data->created_time = date('Y-m-d H:i:s');
            $data->created_by = $this->session->userdata['id'];
            $data->status = 0;
            $data->department_id = NULL;
            $data->sender_id = NULL;
            $data->province_id = NULL;
            $data->district_id =NULL;
            $data->url = NULL;
            $data->image = '';
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
        public function get_list_notification($authorId=NULL, $keyword=NULL, $type = NULL) {
            $this->db->distinct();
            $this->db->select('a.*');
            $this->db->from('notification AS a');
            if($authorId) $this->db->where('a.created_by',$authorId);
            if($type) $this->db->where('a.type', $type);
            if($keyword) $this->db->like('a.title',$keyword);
            $this->db->order_by('a.created_time DESC');
            $this->db->group_by('id');

            $data = $this->db->get()->result();
            return $data;
        }
        public function get_notification($id) {
            $this->db->select('a.*');
            $this->db->from('notification AS a');
            $this->db->where('status',1);
            $this->db->where('id', $id);
            $data = $this->db->get()->row();
            return $data;
        }
        public function get_list_member($sender_id, $department_id ,$id)
        {
            $this->db->select('b.id');
            $this->db->from($this->_table_name . ' as a');

            if($sender_id)
            {
                $this->db->join('member as b', 'a.sender_id = b.id', 'inner');
                $this->db->where('a.sender_id', $sender_id);
            }
            if($department_id)
            {
                $this->db->join('member as b', 'a.department_id = b.department_id', 'inner');
                $this->db->where('a.department_id', $department_id);
            }

            $this->db->where('a.id', $id);
            $data = $this->db->get()->result();
            return $data;

        }
        public function get_member()
        {
            $this->db->select('id');
            $this->db->from('member');
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
        public function update_push($id, $push_time) {
            $this->db->set('push_time', $push_time);
            $this->db->where('id', $id);
            $result = $this->db->update($this->_table_name);
            return $result;
        }
        public function list_notification ($offset=0, $limit=10, $member_id=0, $is_read= NULL, $type= NULL){
            $this->db->select('a.id AS id_notify_user , a.* , b.id AS notify_id , b.*');
            $this->db->from($this->_table . ' as a');
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
        public function add_notify_member($id_noti, $member_id = array() ){

            foreach ($member_id as $member) {
                $this->db->set('notify_id', $id_noti);
                $this->db->set('member_id', $member->id);
                $this->db->set('is_read', 0);
                $result = $this->db->insert('notifycation_user');
            }
            return $result;
        }

        public function count_unread_notifications($member_id=0){
            $this->db->select('*');
            $this->db->where('is_read','0');
            $this->db->where('member_id',$member_id);
            $data =$this->db->count_all_results($this->_table);
            return $data;
        }
        public function detail_notification ($id = 0, $member_id = 0){
            $this->db->select('a.id AS id_notify_user , a.*, b.id AS notify_id , b.*');
            $this->db->from($this->_table . ' as a');
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
            $result = $this->db->update($this->_table);
            return $result;
        }
    }