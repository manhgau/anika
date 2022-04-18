<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/core/REST_Controller.php';
// This can be removed if you use __autoload() in config.php OR use Modular Extensions

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Users extends REST_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->model('user_model');
		$this->load->model('banner_model');
    }

    // Call list users and default user
    public function member_list_get()
    {
        $limit  = max(1, (int)$_GET['limit']??1);
        $page  = max(1, (int)$_GET['page']??1);
        $offset = ($page - 1) * $limit;

        // Users from a data store e.g. database
        $members = $this->user_model->get_list_member($offset, $limit);
        echo json_encode([
            'status'    =>  1,
            'message'   =>  'Danh sách member',
            'data'      =>  $members
        ]);
    }
    public function member_default_get(){
        die("111");
        $limit  = max(1, (int)$_GET['limit']??1);
        $page  = max(1, (int)$_GET['page']??0);
        $offset = ($page - 1) * $limit;
        $id = isset($_GET['id'])?$_GET['id']:"";
        if (!isset($_GET['id'])){
            echo json_encode([
                'status'    =>  2,
                'message'   =>  'Vui lòng cung cấp id member',
                'data'      =>  NULL
            ]);
        }else{
            $members = $this->user_model->get_default_member($offset, $limit ,$id);
            if($members == NULL){
                echo json_encode([
                    'status'    =>  3,
                    'message'   =>  'Member không tồn tại',
                    'data'      =>  NULL
                ]);
            }else{
                echo json_encode([
                    'status'    =>  1,
                    'message'   =>  'Thông tin member',
                    'data'      =>  $members
                ]);
        }
        }
    }
    public function list_banner()
	{
		die("222");
		$limit  = max(1, (int)$_GET['limit']??1);
        $page  = max(1, (int)$_GET['page']??1);
        $offset = ($page - 1) * $limit;
        $type = isset($_GET['type'])?$_GET['type']:"";
        $banner = $this->banner_model->get_list_banner($offset, $limit ,$type);

        if (!isset($type)){
            echo json_encode([
                'status'    =>  1,
                'message'   =>  'Danh sách tin tức',
                'data'      =>  $banner
            ]);
        }
        if($news == NULL){
            echo json_encode([
                'status'    =>  3,
                'message'   =>  'Không có tin tức loại này',
                'data'      =>  NULL
            ]);
        }else{
            echo json_encode([
                'status'    =>  1,
                'message'   =>  'Danh sách tin tức loại'." ".$type,
                'data'      =>  $banner
            ]);
        }
	}
}


