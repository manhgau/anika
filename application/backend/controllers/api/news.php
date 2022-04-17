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
class News extends REST_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->model('user_model');
		$this->load->model('news_model');
    }

    // Call list users and default user
    public function news_list_get()
    {
        $limit  = max(1, (int)$_GET['limit']??1);
        $page  = max(1, (int)$_GET['page']??1);
        $offset = ($page - 1) * $limit;
        $type = isset($_GET['type'])?$_GET['type']:"";
        $news = $this->news_model->get_list_new($offset, $limit ,$type);

        if (!isset($type)){
            echo json_encode([
                'status'    =>  1,
                'message'   =>  'Danh sách tin tức',
                'data'      =>  $news
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
                'data'      =>  $news
            ]);
        }

    }
    public function news_default_get(){
        $limit  = max(1, (int)$_GET['limit']??1);
        $page  = max(1, (int)$_GET['page']??0);
        $offset = ($page - 1) * $limit;
        $id = isset($_GET['id'])?$_GET['id']:"";
        if (!isset($_GET['id'])){
            echo json_encode([
                'status'    =>  2,
                'message'   =>  'Vui lòng cung cấp id tin tức',
                'data'      =>  NULL
            ]);
        }else{
            $news = $this->news_model->get_default_new($offset, $limit ,$id);
            if($news == NULL){
                echo json_encode([
                    'status'    =>  3,
                    'message'   =>  'Tin tức không tồn tại',
                    'data'      =>  NULL
                ]);
            }else{
                echo json_encode([
                    'status'    =>  1,
                    'message'   =>  'Chi tiết tin tức ',
                    'data'      =>  $news
                ]);
        }
        }
    }
}


