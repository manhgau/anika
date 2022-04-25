<?php
class MY_Controller extends CI_Controller {

    public $data;

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->model('user_model');
        $this->load->model('history_model');
        $this->data['meta_title'] = 'Dashboard';
        
        //check user loggedIn
        $exception_uris = array (
            'user/login',
            'user/logout'
        );
        if( in_array(uri_string(),$exception_uris) == false ) {
            if($this->user_model->loggedin() == FALSE) 
            {
                redirect(base_url('user/login'));
            }
            else 
            {
                $this->data['userdata'] = $this->session->all_userdata();
                $user = (array)$this->user_model->get($this->data['userdata']['id'], true);
                $this->data['userdata'] = array_merge($this->data['userdata'], $user);
            }
        }

        //Xoa logs sua bai viet khi chuyen trang
        if(isset($_SERVER['HTTP_REFERER']))
        {
            $referalUrl = strtolower($_SERVER['HTTP_REFERER']);
            $uriLower = strtolower(uri_string());
            if(preg_match('/cms\.thinkzone\.vn\/news\/edit\/[0-9]*$/', $referalUrl) && !preg_match("/^(apis|upload)/", $uriLower))
            {
                $parse = explode('/', $referalUrl);
                $_count = count($parse);
                $newsId = $parse[$_count-1];
                if(isset($this->data['userdata']))
                    removeEditLog($newsId, $this->data['userdata']['id']);    
            }
        }
    }

    public function upload_file ($file_element_name, $file_name='', $watermark=false)
    {
        $msg = "";
        if (!defined('__DIR__'))
            define('__DIR__', dirname(__FILE__));
        $config['upload_path'] = realpath(config_item('upload_dir'));

        $config['allowed_types'] = 'gif|jpg|png|doc|txt|jpeg|swf|xlsx|xls';
        $config['max_size'] = 1024 * 20;
        $config['encrypt_name'] = TRUE;
        
        //build file uploaded name
        $_arr_file_name = explode('.',$_FILES[$file_element_name]['name']);
        $_file_extention = end($_arr_file_name);
        if(!$file_name) $file_name = $this->build_slug($_arr_file_name[0]) .'-' . time();
        $file_name .= '.' . $_file_extention;

        //upload path
        $_sub_path = date('Y_m');
        $config['upload_path'] .= DIRECTORY_SEPARATOR . $_sub_path;

        if(!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'],0777);
        }
        $img_url = $_sub_path . '/';
        $img_url .= $file_name;
        //load upload library
        $this->load->library('upload', $config);
        //setup upload
        $this->upload->initialize($config); 
        //upload
        if (!$this->upload->do_upload($file_element_name))
        {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
            $url = '';
        }
        else
        {
            $data = $this->upload->data();
            rename($data['full_path'], $config['upload_path'] . DIRECTORY_SEPARATOR . $file_name);

            if ($data['image_type'] != 'gif' && $watermark == true) {  
                $this->addWaterMark($config['upload_path'] . DIRECTORY_SEPARATOR . $file_name);
            }
            $url = $img_url;
            $msg = 'success';
        }
        @unlink($_FILES[$file_element_name]);
        return array('msg' => $msg,'image_url' => $url);
    }

    public function resizeImage($imgPath, $width=0, $height=0)
    {
        $imgSize = getimagesize($imgPath);
        if($imgSize[0] < $width || $imgSize['mime']=='image/gif')
        {
            $this->addWaterMark($imgPath);
            return false;
        }
        $config['image_library'] = 'gd2';
        $config['source_image'] = $imgPath;
        //$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '80%';
        $config['width'] = $width;
        if ($height) $config['height'] = $height;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        unset($config);
        $this->addWaterMark($imgPath);
        return true;
    }

    public function addWaterMark($imgPath) {
        $this->load->library('image_lib');
        $config['source_image'] = $imgPath;
        $config['create_thumb'] = FALSE;
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = 'admin/assets/img/tnviet-wtmark.png';
        $config['wm_vrt_alignment'] = 'top';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_padding'] = '10';
        $config['wm_opacity'] = '60';
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
        $this->image_lib->clear();
        unset($config);
    }

    private function build_slug($str) {
        $str = strtolower($str);
        $str = trim($str);
        $patterns = array(
            'á|ã|ả|à|ạ|ă|ắ|ẵ|ẳ|ặ|ằ|â|ấ|ẫ|ẩ|ầ|ậ|A|Á|Ả|À|Ã|Ạ|Ắ|Ẳ|Ằ|Ẵ|Ặ|Ă|Â|Ấ|Ẫ|Ẩ|Ầ|Ậ' => 'a',        
            'ó|õ|ỏ|ò|ọ|ơ|ớ|ở|ỡ|ờ|ợ|ô|ố|ỗ|ổ|ồ|ộ|O|Ó|Õ|Ỏ|Ò|Ọ|Ơ|Ớ|Ỡ|Ở|Ờ|Ợ|Ô|Ố|Ỗ|Ổ|Ồ|Ộ' => 'o',
            'đ|Đ' => 'd',
            'é|ẽ|ẻ|è|ẹ|ê|ế|ễ|ể|ề|ệ|E|É|Ẽ|Ẻ|È|Ẹ|Ê|Ế|Ễ|Ể|Ề|Ệ' => 'e',
            'í|ĩ|ỉ|ì|ị|Í|Ĩ|Ỉ|Ì|Ị' => 'i',
            'ú|ủ|ũ|ù|ụ|ư|ứ|ữ|ử|ừ|ự|Ư|Ú|Ù|Ủ|Ũ|Ụ|Ứ|Ữ|Ử|Ừ|Ự' => 'u',
            'ý|ỹ|ỷ|ỳ|ỵ|Ý|Ỷ|Ỹ|Ỳ|Ỵ' => 'y'
        );    
        foreach ($patterns as $pattern => $char) {
            $str = preg_replace("/($pattern)/i",$char,$str);
        }    
        $str = preg_replace("/[^a-z0-9]+/",'-',$str);    
        $str = str_replace(' ','-',$str);
        $str = str_replace('--','-',$str);
        $str = preg_replace("/^-|-$/","",$str);

        return $str;
    }

    public function has_permission($action='view',$category_product=0) {
        $permission_conf = config_item('permission');

        if($permission_conf[$action] & $this->data['userdata']['action_perm'])
        {
            if ($category_product)
            {
                    //Fetch all category_product perm for user
                $list_id = $this->category_product_model->get_category_perm_in($this->data['userdata']['category_product_perm']);
                if ( ! in_array($category_product,$list_id))
                {
                    return FALSE;
                }
                return TRUE;
            }
            return TRUE;
        }
        return FALSE;
    }

    public function not_permission($msg='Bạn không có quyền thực hiện thao tác này')
    {
        $this->data['msg'] = $msg;
        $this->load->view('admin/_layout_permission',$this->data);
    }

    public function responseJson($code=1, $msg='success', $data=NULL)
    {
        $data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function jsonResponse($code=1, $msg='success', $data=NULL)
    {
        $this->responseJson($code, $msg, $data);
    }
}