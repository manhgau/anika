<?php
    class Relation_model extends MY_Model {

        protected $_table_name  = 'relation';
        protected $_primary_key = 'id';
        protected $_order_by    = 'position ASC, id DESC';
        protected $_data_type = [
            'id' => 'int',
            'name' => 'int',
            'description' => 'int',
            'is_hot' => 'int',
           
        ];

        public $rules = array (
            'name' => array(
                'field' => 'title',
			'rules' => 'required|trim'),
            'description' => array(
                'field' => 'title',
			'rules' => 'required|trim'),    
            'is_hot' => array(
                'field' => 'title',
                'rules' => 'required|trim' 
            )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->name = '';
            $data->position = $this->getMaxPosition()+1;
            $data->image = NULL;
            $data->image_trans = NULL;
            $data->url = NULL;
            $data->description = NULL;
            $data->content = NULL;
            $data->status = STATUS_PUBLISHED;
            $data->email = NULL;
            $data->facebook = NULL;
            $data->instagram = NULL;
            $data->phone = NULL;
            $data->address = NULL;
            $data->is_hot = FALSE;
            $data->group_index = 0;
            $data->invest_location = '';
            $data->deposit_amount = 0;
            $data->deposit_text = null;
            return $data;
        }

        public function getMaxPosition()
        {
            $this->db->select('MAX(position) AS pos');
            $data = $this->get(NULL, TRUE);
            return intval($data->pos);
        }
        
        public function get_list_relation($status=NULL)
        {
            if($status) $this->db->where('status', $status);
            else $this->db->where_in('status', array(1,2));
            return $this->get();
        }
        
        public function get_detail_relation($id)
        {
            if( ! $id) return FALSE;
            return $this->get($id, TRUE);
        }
        // public function getList(){
        //     $request = $this->db->get($this->_table_name);
        //         return ($request->num_rows() > 0) ? $request->result_array() : null;
        // }

}