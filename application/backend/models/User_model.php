<?php
class User_model extends MY_Model
{
    protected $_table_name = 'user';
    protected $_order_by = 'name';
    public $rules = array(
            'email' => array(
                'field' => 'email',
                'rules' => 'trim|required|valid_email'), 
            'password' => array(
                'field' => 'password',
                'rules' => 'trim|required')
            );

    public $rules_admin = array(
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'),
        'email' => array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|matches[password_confirm]'),
        'password_confirm' => array(
            'field' => 'password_confirm',
            'label' => 'Confirm Password',
            'rules' => 'trim|matches[password]'));
            
    public function __construct() 
    {
        parent::__construct();
    }

    public function changeUserStatus($userId, $status)
    {
        $data = [
            'status' => $status
        ];
        return $this->save($data, $userId);
    }

    public function login() 
    {
        $args = array(
            'email' => $this->input->post('email'),
            'password' => $this->hash_str($this->input->post('password')),
            'status' => STATUS_PUBLISHED
        );
        $user = $this->get_by($args, true);

        //login
        if ($user) {
            $permission = $this->get_permission_for_user($user->id);
            $data = array(
                'name' => $user->name,
                'id' => $user->id,
                'email' => $user->email,
                'level' => $user->level,
                'image' => $user->image,
                'image' => $user->image,
                'action_perm' => $permission->action_perm,
                'category_perm' => $permission->category_perm,
                'loggedin' => true);
            if($data['level'] <=1)
            {
                $data['action_perm'] = config_item('permission')['view'] | config_item('permission')['add'] | config_item('permission')['edit'] | config_item('permission')['delete'];
            }
            
            //block Session Fixation Attack
            session_regenerate_id(TRUE);
            $this->session->set_userdata($data);
            return true;
        }
    }

    public function get_list_member($offset=0, $limit=10){
        $this->db->select();
        $this->db->from('member');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    public function get_default_member($offset=0, $limit=1, $id){
        $this->db->select();
        $this->db->from('member');
        $this->db->where('id',$id);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result();
        if (is_array($data) && count($data) > 0){
            return $data;
        }else{
            return NULL;
        }
        // echo "<xmp>";
        // print_r($data);
        // die;

    }


    private function get_permission_for_user($user_id)
    {
        $this->db->select('action_perm,category_perm');
        $this->db->from('user_permission');
        $this->db->where('user_id',$user_id);
        $this->db->limit(1,0);
        $query = $this->db->get();
        if ($query->num_rows())
        {
            return $query->result()[0];
        }
        return FALSE;
    }
    
    public function logout() 
    {
        if ($this->session->sess_destroy())
        {
            return TRUE;
        }
        else
        {
            return FALSE;    
        }   
    }

    public function loggedin() 
    {
        return (bool)($this->session->userdata('loggedin'));
    }

    public function hash_str($string) 
    {
        return 'hash432' . md5($string) . config_item('encryption_key');
    }

    public function get_new() 
    {
        $data = new stdClass();
        $data->name = '';
        $data->email = '';
        $data->password = '';
        $data->level = 1;
        $data->status = 1;
        $data->image = NULL;
        return $data;
    }

    public function get_list_user() 
    {
        $data = parent::get();
        foreach ($data as $val) {
            $result[$val->id] = $val;
        }
        return $result;
    }
    
    public function get_list_author()
    {
        $this->db->select('id,name,email,image,level');
        $query = $this->get();
        if($query)
        {
            foreach ($query as $key => $val) {
                $data[$val->id] = $val;
            }
            return $data;
        }
        return FALSE;
    } 

    public function getUserById($id)
      {
            if (! is_array($id)) {
                return $this->get($id, TRUE);
            }

            $this->db->where_in('id', $id);
            return $this->get();
      }  
}