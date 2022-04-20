<?php
    class Member_model extends MY_Model {

        protected $_table_name  = 'member';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        protected $_data_type    = [
            'id' => 'int',
            'point' => 'int',
            'used_point' => 'int',
            'news_viewed' => 'int',
        ];

        public    $rules        = array (
            'fullname' => [
                'field' => 'fullname',
                'rules' => 'required|trim',
            ],
            'username' => [
                'field' => 'username',
                'rules' => 'required|trim',
            ],
            'email' => [
                'field' => 'email',
                'rules' => 'required|trim|valid_email',
            ],
            'phone' => [
                'field' => 'phone',
                'rules' => 'required|trim',
            ],
        );

        const STATUS_ACTIVE = 'public';
        const STATUS_BLOCK = 'block';
        const STATUS_DELETED = 'deleted';

        protected $allStatus = [
            'public' => [
                'name' => 'Hoạt động',
            ],
            
            'block' => [
                'name' => 'Tạm khóa',
            ],
            
            'deleted' => [
                'name' => 'Đã xóa',
            ],
        ];

        public function __construct(){
            parent::__construct();
        }

        public function getMemberByFbId($facebookId)
        {
            return $this->setData( $this->get_by(['fb_id'=>$facebookId], true), true );
        }

        public function getNew()
        {
            $data = parent::getNew();
            $data->created_time = date('Y-m-d H:i:s');
            return $data;
        }

        public function dataGrid()
        {
            $post = $this->input->post();
            $offset = intval($post['start']);
            $limit = intval($post['length']);
            $where = [];
            if ($post['status']) $where['status'] = $post['status'];
            if ($post['keyword']) {
                if (filter_var($post['keyword'], FILTER_VALIDATE_EMAIL)) 
                    $where['email'] = strtolower($post['keyword']);
                elseif ($id = intval($post['keyword'])) 
                    $where['id'] = $id;
                elseif (preg_match('/^0[1-9][0-9]{8,9}/',$post['keyword'])) 
                    $where['owner_phone'] = $post['keyword'];
                elseif (preg_match('/^[a-zA-Z0-9]{8,9}/',$post['keyword'])) 
                    $where['code'] = $post['keyword'];
                else
                    $where["title LIKE '".$post['keyword']."'"] = NULL;
            }

            $result = [
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ];

            #counter
            $this->db->select('COUNT(id) AS number');
            if ($where) $this->db->where($where);
            $counter = $this->get(null, true);

            if ($counter && $counter->number) {
                $result['recordsFiltered'] = $result['recordsTotal'] = intval($counter->number);

                $this->db->select('*');
                $this->db->from($this->_table_name);
                if ($where) $this->db->where($where);
                $this->db->order_by('id', 'desc');
                $this->db->limit($limit, $offset);
                $result['data'] = $this->db->get()->result_array();
                if ($result['data']) {
                    $authors = [];
                    foreach ($result['data'] as $key => $value) {
                        $value['status_name'] = $this->allStatus[ $value['status'] ]['name'];
                        $result['data'][$key] = $value;
                    }
                }
            }
            
            return $result;
        }

        public function getStatus($status='')
        {
            return ($status) ? $this->allStatus[$status] : $this->allStatus;
        }

        public function search($keyword)
        {
            $where = [];

            if (filter_var($keyword, FILTER_VALIDATE_EMAIL)) {
                $where['email'] = strtolower($keyword);
            }
            elseif (preg_match('/^0[1-9][0-9]{8,9}$/', $keyword)) {
                $where['phone'] = strtolower($keyword);
            }
            elseif ($id = intval($keyword)) {
                $where['id'] = $id;
            }
            else {
                $where["fullname LIKE '%".$keyword."%'"] = null;
            }
            $this->db->limit(10);
            return $this->get_by($where, false);

            return ($status) ? $this->allStatus[$status] : $this->allStatus;
        }

        /**
         * Đăng ký, Đăng nhập bằng tài khoản facebook
         */
        public function fbLogin($fbId, $fbEmail, $fbName)
        {
            $where = [
                'fb_id' => $fbId
            ];

            $member = $this->get_by($where, true);
            if (! $member) {
                $newAccount = [
                    'fb_id' => $fbId,
                    'username' => $fbName,
                    'fullname' => $fbName,
                    'email' => $fbEmail,
                    'point' => 0,
                    'status' => self::STATUS_ACTIVE,
                    'last_login' => date('Y-m-d H:i:s')
                ];
                $memberId = intval($this->save($newAccount, null));

                # thưởng điểm tạo tài khoản
                $pointBonusRegister = intval(siteOption('point_bonus_register', 100));
                if ($pointBonusRegister) {
                    $this->load->model('pointload_model');
                    $this->pointload_model->addPointLoad($pointBonusRegister, $memberId, 'bonus', 'Thưởng Điểm mở tài khoản', json_encode($newAccount));
                    $newAccount['point'] = $pointBonusRegister;
                }

                return $newAccount;
            }
            elseif ($member->status === self::STATUS_ACTIVE) {
                $this->save(['last_login' => date('Y-m-d H:i:s')], $member->id);
                return (array)$member;
            }
            else
                return false;
        }

        public function logout($fbId)
        {
            return true;
        }
        // Dùng trong CI APIapp
        public function get_detail_member($id){
            $this->db->select('a.id,a.fullname,a.email,a.phone,a.addres,a.url_fb, b.name AS office_name,c.name AS department_name');
            $this->db->from($this->_table_name . ' as a');
            $this->db->join('office as b', 'a.office_id=b.id', 'left');
            $this->db->join('department as c', 'a.department_id=c.id', 'left');
            if($id>0){
                $this->db->where('a.id',$id);
            }
            $data = $this->db->get()->result();
            return $data;
            
    
        }

        public function do_login(array $data){                        
            $this->db->select('id, email, phone, password');
            $this->db->from($this->_table_name);
            if($data['phone'] == NULL){
                echo ("1111");
                $this->db->where('email',$data['email']);
            }
            if($data['email'] == NULL){
                echo ("122222");
                $this->db->where('phone',$data['phone']);
            }
            $this->db->limit(1,0);
            $user = $this->db->get()->result();                            
            if($user){
                if(is_array($user) && count($user) > 0){
                    foreach($user as $item){
                        $password = $item->password;
                    }
                    if(password_verify($data['password'], $password)){
                        return $item->id;
                    }else{
                        return false; 
                    }
                }                   
            }else{
                return false;
            }
                                 
        }

        private function __check_phone_email ($email,$phone){
            $this->db->select("email, phone");
            $this->db->where("email", $email );
            $this->db->or_where("phone", $phone );
            $data =$this->db->count_all_results($this->_table_name);
            return $data;
        }
        public function do_registration(array $data){
            $check = $this->__check_phone_email($data['email'],$data['phone']);
            if($check){
                return 1;
            }else{
                $this->db->insert($this->_table_name, $data);
                $insert_id = $this->db->insert_id();
                return  $insert_id;
            }
        }
        public function update_profile(array $data, $id){
            $check = $this->__check_phone_email($data['email'],$data['phone']);
            if($check > 0){
                return 1;
            }else{
                $this->db->where('id',$id);
                $this->db->update($this->_table_name, $data);
                return 2;
            }
        }


}