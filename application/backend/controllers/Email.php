<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('my_phpmailer');
    }

    // Show email page
    public function index()
    {
        $email = 'baomdc.04gec@gmail.com';
        $name = 'Bao MDC';
        $title = 'MynkCMS Alert';
        $body = file_get_contents( APPPATH . 'libraries/index.html');
        $htmlContent = true;
        $attachFile = APPPATH . 'third_party/phpmailer/examples/images/phpmailer.png';
        if ($this->my_phpmailer->send_mail($email, $name, $title, $body, $htmlContent, $attachFile)) {
            echo 'Email sent';
        }
        else
            echo 'failed';

    }

    // Send Gmail to another user

}