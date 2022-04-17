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
class Common extends REST_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->model('user_model');
    }



    public function app_init () {
        $app = $this->api_model->get_app_init();
        echo json_encode($app);
    }
}