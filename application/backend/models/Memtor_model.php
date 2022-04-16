<?php
    class Memtor_model extends MY_Model {
        protected $_table_name  = 'memtor';
        protected $_table_feedback  = 'mentor_portfolio';
        protected $_primary_key = 'id';
        protected $_order_by    = 'position ASC, name ASC';
        public    $rules        = array (
            'name'            => array(
                'field'   => 'name',
                'rules'   => 'trim|max_length[100]|required' 
            ),
            'status'           => array(
                'field'   => 'status',
                'rules'   => 'trim|intval' 
            ),
            'position'           => array(
                'field'   => 'position',
                'rules'   => 'intval|required',
                'errors' => [
                    'intval' => 'Nhập số!',
                    'required' => 'Bắt buộc nhập'
                ] 
            )
        );

        public function __construct() {
            parent::__construct();
        }

        public function get_new() {
            $data = new stdClass();
            $data->name = '';
            $data->image = '';
            $data->job_title = NULL;
            $data->birthday = time(); 
            $data->gender = 0;
            $data->country = '';
            $data->description = '';
            $data->create_time = time();
            $data->status = 1;
            $data->meta_title = '';
            $data->meta_keyword = ''; 
            $data->meta_description = '';
            $data->linkedin_url = NULL;
            $data->twitter = NULL;
            $data->facebook = NULL;
            $data->website = NULL;
            $data->company = NULL;
            $data->position = $this->getNextPosition();
            $data->group = 'mentor';
            return $data;
        }

        public function getNextPosition()
        {
            $this->db->select('MAX(position) AS mp');
            $result = $this->get(NULL, TRUE);
            return ++$result->mp;
        }
        
        public function getAllMemtor($args) {
            $where = [];
            if (isset($args['status']) && $args['status']) 
                $where['status'] = $args['status'];
            else
                $where['status !='] = 3;

            if (isset($args['group']) && $args['group']) 
                $where['group'] = $args['group'];

            $this->db->where($where);
            return $this->get();
        }
        
        public function getMemtorById($id) {
            return $this->get($id,true);
        }
        
        public function deleteMemtors($ids) {
            $this->db->where_in('id',$ids);
            $args = array('status' => 3);
            $this->db->update($this->_table_name,$args);
        }
        
        public function search($q) {
            $this->db->distinct();
            $this->db->select('id,name');
            $this->db->like('name',$q);
            $this->db->group_by('id');
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

        function feedbackByMemtor($mentorId, $limit=30, $offset=0)
        {
            return $this->db->select('a.*, p.name AS name, p.logo')
                    ->from('mentor_portfolio AS a')
                    ->join('portfolio AS p', 'a.portfolio_id=p.id', 'inner')
                    ->where(['a.mentor_id' => $mentorId])
                    ->limit($limit, $offset)
                    ->get()->result();
        }

        public $feedbackRules = [
            'feedback' => [
                'field' => 'feedback',
                'rules' => 'required|trim'
            ],
            'title' => [
                'field' => 'title',
                'rules' => 'required|trim'
            ],
            'mentor_id' => [
                'field' => 'mentor_id',
                'rules' => 'required|intval'
            ],
            'portfolio_id' => [
                'field' => 'portfolio_id',
                'rules' => 'required|intval'
            ],
            'order' => [
                'field' => 'order',
                'rules' => 'required|intval'
            ],
        ];

        const FB_PUBLIC = 'public';
        const FB_HIDE = 'hide';

        function feedbackStatus()
        {
            return [
                self::FB_PUBLIC => [
                    'code' => self::FB_PUBLIC,
                    'name' => 'Công khai',
                    'color' => 'green',
                    'icon' => 'fa fa-globe',
                ],
                self::FB_HIDE => [
                    'code' => self::FB_HIDE,
                    'name' => 'Ẩn',
                    'color' => 'gray',
                    'icon' => 'fa fa-eye-slash',
                ],
            ];
        }

        function feedbackStatusFilter($txt='tất cả')
        {
            $options = ['' => "--- {$txt} ---"];
            $keys = array_keys($this->feedbackStatus());
            $values = array_column($this->feedbackStatus(), 'name');
            return $options + array_combine($keys, $values);
        }

        function saveFeedback($id=0)
        {
            $data['feedback'] = $this->input->post('feedback');
            $data['mentor_id'] = $this->input->post('mentor_id');
            $data['portfolio_id'] = $this->input->post('portfolio_id');
            $data['title'] = $this->input->post('title');
            $data['status'] = (@$this->input->post('status')) ? strtolower($this->input->post('status')) : self::FB_PUBLIC;
            $data['order'] = $this->input->post('order');
            if ($data['order']<1) 
                $data['order'] = 1;

            if ($id) 
                return $this->db->update('mentor_portfolio', $data, ['id' => $id]);
            else
                return $this->db->insert('mentor_portfolio', $data);
        }

        function feedbackNew()
        {
            $data = new stdClass();
            $data->id = null;
            $data->mentor_id = null;
            $data->portfolio_id = null;
            $data->title = null;
            $data->feedback = null;
            $data->order = 1;
            $data->status = self::FB_PUBLIC;
            return $data;
        }
}