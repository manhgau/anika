<?php
    class Upload extends MY_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('file_model');
        }

        public function index(){
            $this->data['img'] = '';
            $this->load->view('admin/upload.php',$this->data);
        }

        public function save_image() {
            $respone = parent::upload_file('fileImage');
            $this->data['img'] = $respone['image_url'];
            $this->load->view('admin/upload.php',$this->data);
        }

        public function uploadCopyrightImage() 
        {
            $files = $_FILES['fileUpload'];
            $number_of_files = sizeof($_FILES['fileUpload']['tmp_name']);
            for($i=0;$i<$number_of_files;$i++) {
                $_FILES['uploadedimage']['name'] = $files['name'][$i];
                $_FILES['uploadedimage']['type'] = $files['type'][$i];
                $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['uploadedimage']['error'] = $files['error'][$i];
                $_FILES['uploadedimage']['size'] = $files['size'][$i];
                $_thumnail_uploaded = parent::upload_file('uploadedimage', '', true);
                $data=array(
                    'name' => '',
                    'url' => $_thumnail_uploaded['image_url'],
                    'description' => '', 
                    'status' => 1
                );
                $id = $this->file_model->save($data,NULL);
                
                if(preg_match('/image/',$files['type'][$i]) && config_item('auto_watermark')) {
                    create_watermark($_thumnail_uploaded['image_url']);
                }
                $respone[] = array(
                    'id' => $id,
                    'image_url' => $_thumnail_uploaded['image_url']
                );
            }
            print_r (json_encode($respone));
            exit();
        }

        public function ajaxUpload() {
            $files = $_FILES['fileUpload'];
            $number_of_files = sizeof($_FILES['fileUpload']['tmp_name']);
            for($i=0;$i<$number_of_files;$i++) {
                $_FILES['uploadedimage']['name'] = $files['name'][$i];
                $_FILES['uploadedimage']['type'] = $files['type'][$i];
                $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['uploadedimage']['error'] = $files['error'][$i];
                $_FILES['uploadedimage']['size'] = $files['size'][$i];
                $_thumnail_uploaded = parent::upload_file('uploadedimage');
                $data=array(
                    'name' => '',
                    'url' => $_thumnail_uploaded['image_url'],
                    'description' => '', 
                    'status' => 1
                );
                $id = $this->file_model->save($data,NULL);
                
                if(preg_match('/image/',$files['type'][$i]) && config_item('auto_watermark')) {
                    create_watermark($_thumnail_uploaded['image_url']);
                }
                $respone[] = array(
                    'id' => $id,
                    'image_url' => $_thumnail_uploaded['image_url']
                );
            }
            print_r (json_encode($respone));
            die();
        }
        
        public function ajaxUploadSingle() 
        {
            $files = $_FILES['file_upload'];
                $_FILES['uploadedimage']['name'] = $files['name'];
                $_FILES['uploadedimage']['type'] = $files['type'];
                $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'];
                $_FILES['uploadedimage']['error'] = $files['error'];
                $_FILES['uploadedimage']['size'] = $files['size'];
                $uploaded = parent::upload_file('uploadedimage');
                $data=array(
                    'name' => '',
                    'url' => $uploaded['image_url'],
                    'description' => '', 
                    'status' => 1
                );
                $id = $this->file_model->save($data,NULL);
                $respone = array(
                    'id' => $id,
                    'image_url' => $uploaded['image_url']
                );
            echo json_encode($respone);
            die();
        }
    }