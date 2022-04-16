<?php
    class Cronjob extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->library('curl');
        }

        public function index() 
        {
            echo '<h1>403 Forbidden</h1>', '<p>Directory access is forbidden.</p>';
            exit();
        }

        public function updateRentStatus()
        {
            $this->load->model('realnews_model');
            $this->realnews_model->updateRentStatus();
            echo 'done';
        }
}