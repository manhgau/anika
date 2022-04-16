<?php
    class Booking extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('booking_model');
            $this->load->model('news_model');
            $this->load->model('bussiness_model');
            $this->load->model('custome_request_model');
            $this->load->model('location_model');
        }

        public function customeRequestProcessed()
        {
            $response = [
                'code' => 0,
                'msg' => 'successfully',
            ];
            $ids = $this->input->get_post('ids');
            if ( ! $this->custome_request_model->changeStatus($ids, STATUS_PUBLISHED))
            {
                $response['code'] = -1;
                $response['msg'] = 'failed';
            }
            echo json_encode($response);
            exit();
        }

        public function customeBooking()
        {
            $this->data['filters'] = array();
            $this->data['filters']['status'] = ($this->input->get_post('status')) ? $this->input->get_post('status') : '';

            $limit = 20;
            $page = ($this->input->get_post('page')) ? intval($this->input->get_post('page')) : 1;
            $this->data['paging'] = build_pagination($page, $limit);
            $params = array();
            $params['status'] = $this->data['filters']['status'];
            $params['offset'] = $this->data['paging']['offset'];
            $params['limit'] = $this->data['paging']['limit'];

            //Load View
            $this->data['meta_title'] = 'Yêu cầu riêng';
            $this->data['sub_view'] = 'admin/booking/custome-request';
            $this->data['sub_js'] = 'admin/booking/custome-request-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getListCustomeRequest()
        {
            $param['status'] = $this->input->get_post('status');
            $param['created_date_from'] = $this->input->get_post('requestDate');
            $param['created_date_to'] = $this->input->get_post('requestDate');
            $param['offset'] = intval($this->input->get_post('start'));
            $param['limit'] = intval($this->input->get_post('length'));
            $list = $this->custome_request_model->getListCustomeBooking($param);

            $data = array('data' => array());
            if ($list) {
                foreach ($list as $key => $val)
                {
                    $__customerPatt = '%s<br><span class="gray">%s</span><br><span class="gray">%s</span>';
                    $_item = [
                        'id' => $val->id,
                        'created_time' => date('H:i:s d/m/Y', strtotime($val->created_time)),
                        'type' => $val->type,
                        'status' => ($val->status) ? $val->status : STATUS_PENDING,
                        'note' => $val->note,
                        'person_number' => number_format($val->person_number),
                        'customer' => sprintf($__customerPatt, $val->customer_name, $val->customer_email, $val->customer_phone),
                    ];
                    if ($val->product_id) {
                        $product = $this->product_model->get($val->product_id, TRUE);
                        $_item['service'] = '<a href="'. linkPreviewProduct($product->slugname, $product->id) .'" target="_blank">'.$product->title.'</a>';
                    }
                    elseif ($val->location_to)
                    {
                        $location = $this->location_model->get($val->location_to, TRUE);
                        $_item['service'] = $location->name;
                    }

                    if ($val->request_time == 'fixed')
                        $_item['service_time'] = date('d/m/Y', strtotime($val->request_time_from));
                    elseif ($val->request_time == 'flexible') 
                        $_item['service_time'] = date('d/m/Y', strtotime($val->request_time_from)) . ' - ' . date('d/m/Y', strtotime($val->request_time_to));
                    else
                        $_item['service_time'] = '';

                    $data['data'][] = $_item;
                }
            }
            echo json_encode($data);
        }

        public function index() {

            $this->data['filters'] = array();
            $this->data['filters']['status'] = ($this->input->get_post('status')) ? $this->input->get_post('status') : '';
            $this->data['filters']['process_status'] = ($this->input->get_post('process_status')) ? $this->input->get_post('process_status') : '';

            $limit = 20;
            $page = ($this->input->get_post('page')) ? intval($this->input->get_post('page')) : 1;
            $this->data['paging'] = build_pagination($page, $limit);
            $params = array();
            $params['status'] = $this->data['filters']['status'];
            $params['process_status'] = $this->data['filters']['process_status'];
            $params['offset'] = $this->data['paging']['offset'];
            $params['limit'] = $this->data['paging']['limit'];
            $this->data['bookings'] = $this->booking_model->getListBooking($params);

            if ($this->data['bookings'])
            {
                foreach ($this->data['bookings'] as $key => $val)
                {
                    $_tour = $this->product_model->get($val->tour_id, true);
                    $val->tour = $_tour;
                    $this->data['bookings'][$key] = $val;
                }
            }

            //Load View
            $this->data['meta_title'] = 'Danh sách đặt dịch vụ';
            $this->data['sub_view'] = 'admin/booking/index';
            $this->data['sub_js'] = 'admin/booking/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id=0) {
            $id = (int)$id;
            if(!$id) $id = NULL;
            $this->data['booking'] = $booking = $this->booking_model->getBookingById($id,TRUE);

            $this->data['product'] = $this->product_model->get($booking->tour_id);

            $this->data['productPrice'] = $this->product_model->get($booking->tour_id);

            $this->data['bussiness'] = $this->bussiness_model->get($booking->bussiness_id, TRUE);
            
            //validation form
            $rules = $this->booking_model->editRules;
            $this->form_validation->set_rules($rules);
            if ( $this->form_validation->run()==true ) {
                $input_var = array('status');
                $data = $this->booking_model->array_from_post($input_var);
                
                if(!isset($data['status']))
                    $data['status'] = STATUS_PENDING;

                $data['process_status'] = STATUS_PUBLISHED;

                if($save_id = $this->booking_model->save($data,$id)) 
                {
                    $this->session->set_flashdata('session_msg','Cập nhật dữ liệu thành công.');
                    redirect(base_url('booking'));
                }
                else 
                {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu của bạn');
                }
            }
            
            //Load view
            $this->data['meta_title'] = ($id) ? 'Edit booking' : 'Add new booking';
            $this->data['sub_view'] = 'admin/booking/edit';
            $this->data['sub_js'] = 'admin/booking/edit-js';
            $this->data['subCss'] = [
                'css/timepicker/bootstrap-timepicker.min.css'
            ];
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function delete($id = NULL) {
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            if($this->booking_model->updateStatus($post_id, STATUS_PUBLISHED)) {
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                $response = [
                    'code' => 0,
                    'msg' => 'Xóa thành công!'
                ];
                echo json_encode($response);
                exit();
            }
            else {
                $response = [
                    'code' => -1,
                    'msg' => 'Error! Không thể thực hiện yêu cầu này.'
                ];
                echo json_encode($response);
                exit();
            }
        }
        
        public function publish()
        {
            $result = array('code'=>0 , 'msg' => 'success', 'data' => NULL);
            if ( ! $this->has_permission('edit')) 
            {
                $result['code'] = -2;
                $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($result);
                exit();
            }
            
            $ids = $this->input->post_get('ids');
            $status = $this->input->post_get('status');
            if($this->booking_model->updateStatus($ids,$status)) 
            {
                if ($status==1) $_action = 'Published';
                else $_action = 'UnPublished';
                foreach ($ids as $key => $val) {
                    $this->history_model->add_history(NULL,$_action,$val,'booking');
                }
                
                $result['msg'] = 'Cập nhật dữ liệu thành công';
                echo json_encode($result);                
                exit();
            }
            $result['code'] = -1;
            $result['msg'] = 'Không thành công!';
            echo json_encode($result);                
            exit();
        }

    }
