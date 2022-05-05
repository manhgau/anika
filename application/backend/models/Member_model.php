<?php
    class Member_model extends MY_Model {

        protected $_table_name  = 'member';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        protected $_data_type    = [
            'id' => 'int',
            'department_id'=>'int',
        ];

        public    $rules        = array (
            'fullname' => [
                'field' => 'fullname',
                'rules' => 'required|trim',
            ],
            'department_id' => array(
                'field'   => 'department_id',
                'rules'   => 'trim|max_length[50]' ),
            'email' => [
                'field' => 'email',
                'rules' => 'required|trim|valid_email',
            ],
            'password' => array(
                'field' => 'password',
                'rules' => 'trim'),
            'password_confirm' => array(
                'field' => 'password_confirm',
                'label' => 'Confirm Password',
                'rules' => 'trim|matches[password]'),
            'phone' => [
                'field' => 'phone',
                'rules' => 'required|trim',
            ],
            'status' => array(
                'field'   => 'status',
                'rules'   => 'trim'
            )
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

//        public function getMemberByFbId($facebookId)
//        {
//            return $this->setData( $this->get_by(['fb_id'=>$facebookId], true), true );
//        }

//        public function getNew()
//        {
//            $data = parent::getNew();
//            $data->created_time = date('Y-m-d H:i:s');
//            return $data;
//        }
    public function getListMember(array $data)
    {

        $query = $this->db->get($this->_table_name);
        return ($query->num_rows() > 0 ) ? $query->result_array() : null;

    }

    // public function getCategory()
    // {
    //     $query = $this->db->get($this->_table_name['category_id']);
    //     return ($query->num_rows() > 0 ) ? $query->result_array() : null;
    // }

    public function getList( $limit=10, $offset=0){
        $this->db->select('a.*, b.name AS department_name');
        $this->db->from($this->_table_name . ' as a');
        $this->db->join('department as b', 'a.department_id=b.id', 'left');
        $this->db->where('status', 'public');
        $this->db->or_where('status', 'block');
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;


    }
//    public function hash_str($string)
//    {
//        return 'hash432' . md5($string) . config_item('encryption_key');
//    }

        public function dataGrid()
        {
            $post = $this->input->post();
            $offset = intval($post['start']);
            $limit = intval($post['length']);
            $where = [];
            if ($post['status'])
                $where['status'] = $post['status'];
            else
                $where['status !='] = self::STATUS_DELETED;

            if (@$post['department_id']) $where['department_id'] = $post['department_id'];
            if ($post['keyword']) {
                if (filter_var($post['keyword'], FILTER_VALIDATE_EMAIL)) 
                    $where['email'] = $post['keyword'];
                elseif (preg_match('/^0[1-9][0-9]{8,9}/',$post['keyword'])) 
                    $where['phone'] = $post['keyword'];
                else
                    $where["fullname LIKE '%".$post['keyword']."%'"] = NULL;
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

                        $value['department_id'] = intval($value['department_id']);
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
    public function changeMemberStatus($memberId, $status)
    {
        $data = [
            'status' => $status
        ];
        return $this->save($data, $memberId);
    }
        public function getServiceName($service_type)
        {
            $serviceType = json_decode($service_type, true);
            $service_type_name = [];
            if ($serviceType) {
                foreach ($serviceType as $key => $value) {
                    $service_type_name[]= $this->getService($value)['name'];
                }
            }
            return $service_type_name;
        }
        public function getType($type='')
        {
            return ($type) ? $this->allType[$type] : $this->allType;
        }

        public function getService($service='')
        {
            return ($service) ? $this->allService[$service] : $this->allService;
        }
        public function search($keyword)
        {
            $where = [];
            if (preg_match('/^0[1-9][0-9]{8,9}$/', $keyword)) {
                $where['phone'] = strtolower($keyword);
            }
            elseif (filter_var($keyword, FILTER_VALIDATE_EMAIL)) {
                $where['email'] = strtolower($keyword);
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
            $this->db->select('a.id,a.fullname,a.email,a.phone,a.addres,a.avatar,a.url_fb, b.name AS office_name,c.name AS department_name');
            $this->db->from($this->_table_name . ' as a');
            $this->db->join('office as b', 'a.office_id=b.id', 'left');
            $this->db->join('department as c', 'a.department_id=c.id', 'left');
            if($id>0){
                $this->db->where('a.id',$id);
            }
            $data = $this->db->get()->row();
            return $data;
            
    
        }

        public function do_login(array $data){                        
            $this->db->select('id, email, phone, password');
            $this->db->from($this->_table_name);
            if($data['phone'] == NULL){
                $this->db->where('email',$data['email']);
            }
            if($data['email'] == NULL){
                $this->db->where('phone',$data['phone']);
            }
            $user = $this->db->get()->row();                            
            if($user){
                //var_dump($user);die;
                if(password_verify($data['password'], $user->password)){
                    return array(
                        'code'  => 1,
                        'status'=>"OK",
                        'data'  => $user->id
                    );
                }                  
                return array(
                    'code'  => 2,
                    'status'=>"Tài khoản, mật khẩu không chính xác"
                );
            }
            return array(
                'code'  => 3,
                'status'=>"Tài khoản không tồn tại"
            );

                                 
        }

        private function __check_phone_email ($email,$phone){
            $this->db->select("email, phone");
            $this->db->from($this->_table_name);
            $this->db->where("email", $email );
            $this->db->or_where("phone", $phone );
            $data = $this->db->get()->result();  
            return $data;
        }
        private function __check_profile_email ($email,$id){
            $this->db->select("id,email, phone");
            $this->db->from($this->_table_name);
            $this->db->where_not_in("id", $id );
            $this->db->where("email", $email );
            $data = $this->db->get()->result();  
            return $data;
        }
        private function __check_profile_phone ($phone,$id){
            $this->db->select("id,email, phone");
            $this->db->from($this->_table_name);
            $this->db->where_not_in("id", $id );
            $this->db->where("phone", $phone );
            $data = $this->db->get()->result();  
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
            $check_email = $this->__check_profile_email($data['email'],$id);
            $check_phone = $this->__check_profile_phone($data['phone'],$id);
            // var_dump($check_email);
            // var_dump($check_phone);
            // die;
            if(!$check_email && !$check_phone){
                $this->db->where('id',$id);
                $result =$this->db->update($this->_table_name, $data);
                if($result == true){
                    return array(
                        'code'  => 1,
                        'status'=>"OK"
                    );
                }
                return array(
                    'code'  => 2,
                    'status'=>"Đã có lỗi xảy ra"
                );
            }else{
                return array(
                    'code'  => 3,
                    'status'=>"Email,sdt đã được sử dụng"
                );
            }
        }

        private function __insert_member(array $data){
            $this->db->insert($this->_table_name, $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }

        public function __check_key_email($key){
            $this->db->select("key_email, expire");
            $this->db->from($this->_table_name);
            $this->db->where("key_email", $key );
            $this->db->where("expire >", time() );
            $data = $this->db->get()->result(); 
            return $data;
        }
        public function update_password($password,$key,$password_confirm){
            if($this->__check_key_email($key)){
                if(password_verify($password_confirm, $password)){
                $update = [
                    'key_email'     =>  NULL,
                    'expire'        =>  NULL,
                    'password'      =>  $password
                ];
                $this->db->where('key_email',$key);
                $result =$this->db->update($this->_table_name, $update);
                if($result == true){
                    return 1;
                }else{
                    return 2;
                }
            } 
            return 3;
            }
            return 4;
        }
        public function change_password(array $data){
            $member= $this->get($data['id']);
            $password_data =$member->password;
            if(password_verify($data['password_old'], $password_data)){
                if(password_verify($data['password_confirm'], $data['password'])){
                    $id = (int) $data['id'];
                    $this->db->set('password', $data['password']);
                    $this->db->where('id',$id);
                    $result =$this->db->update($this->_table_name);
                    if( $result == true){
                        return array(
                            'code'  => 1,
                            'status'=>"OK"
                        );
                    }
                    return array(
                        'code'  => 3,
                        'status'=>"false"
                    );
                }
                return array(
                    'code'  => 2,
                    'status'=>"false"
                );
            }
            return array(
                'code'  => 2,
                'status'=>"false"
            );
            
        }
        public function check_email($email){
            $this->db->select("fb_id,gg_id,email,fullname");
            $this->db->from($this->_table_name);
            $this->db->where("email", $email );
            $data = $this->db->get()->row();  
            return $data;
        }
        public function check_phone($phone){
            $this->db->select("fb_id,gg_id,phone");
            $this->db->from($this->_table_name);
            $this->db->where("phone", $phone );
            $data = $this->db->get()->row();  
            return $data;
        }
        public function check_id_fb($id_fb){
            $this->db->select("id,fb_id");
            $this->db->from($this->_table_name);
            $this->db->where("fb_id", $id_fb );
            $data = $this->db->get()->row();  
            return $data;
        }
        public function check_id_gg($id_gg){
            $this->db->select("id,fb_id");
            $this->db->from($this->_table_name);
            $this->db->where("fb_id", $id_gg );
            $data = $this->db->get()->row();  
            return $data;
        }
        public function update_key_email($email,$key){
            $data =[
                'key_email'   => $key,
                'expire'      => time() + 60*60
            ];
            $this->db->where("email", $email );
            $result =$this->db->update($this->_table_name, $data);
            return $result;
        }
        public function update_id(array $data){
            if($data['fb_id']){
                $this->db->set('fb_id',$data['fb_id']);
            }
            if($data['gg_id']){
                $this->db->set('gg_id',$data['gg_id']);
            }
            if($data['email']){
                $this->db->where('email',$data['email']);
            }
            if($data['phone']){
                $this->db->where('phone',$data['phone']);
            }
            $result = $this->db->update($this->_table_name);
            if($result == true){
                $data = $this->check_id_fb($data['fb_id']);
                return array(
                    'code'  => 1,
                    'satus' => 'Update thành công',
                    'data'  => $data->id
                );
            }

        }
        public function save_image($avatar, $id){		
            $this->db->set('avatar', $avatar);
            $this->db->where('id',$id);
            $result =$this->db->update($this->_table_name);
            if( $result == true){
                return array(
                    'code'  => 1,
                    'status'=>"OK"
                );
            }
            return array(
                'code'  => 2,
                'status'=>"Đã có lỗi xảy ra."
            );
        }
        public function auth_facebook(array $data){
            $check_id_fb = $this->check_id_fb($data['fb_id']);
            if($check_id_fb){
                return array(
                    'code'  => 1,
                    'satus' => 'Đăng nhập thành công',
                    'data'  => $check_id_fb->id
                );
            }
            $check_phone = $this->check_phone($data['phone']);
            $check_email = $this->check_email($data['email']);
            if(!$check_email && !$check_phone){
                $inser_member = $this->__insert_member($data);
                if($inser_member){
                    return array(
                        'code'  => 1,
                        'satus' => 'Thêm, Đăng nhập thành công',
                        'data'  => $inser_member
                    );
                }
            }
            // if($check_email && $check_phone){
            //     $update_id = $this->update_id($data);
            //     if($update_id['code'] == 1){
            //         //$data = $this->check_id_fb($data['fb_id']);
            //         return array(
            //             'code'  => 1,
            //             'satus' => 'Update,Đăng nhập thành công',
            //             'data'  => $update_id['data']
            //         );
            //     }
            // }
            
            if($check_email || $check_phone){
                if($check_email->fb_id || $check_phone->fb_id){
                    return array(
                        'code'  => 2,
                        'satus' => 'Tài khoản tồn tại',
                    );
                }
                return array(
                    'code'  => 3,
                    'satus' => 'Lựa chọn đồng bộ tài khoản',
                );
            }


        }

}