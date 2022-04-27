<?php
    class Notification_model extends MY_Model {
        protected $_table_name  = 'notifycation_user';
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