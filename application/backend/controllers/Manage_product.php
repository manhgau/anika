<?php
require_once APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Manage_product extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('manage_product_model');
        $this->load->model('category_product_model');
        $this->load->model('member_model');

        //Breadcrumbs
        $this->data['breadcrumbs']['Bài viết sản phẩm'] = base_url('manage_product');
    }

    public function index()
    {
        $this->data['category_product'] = $this->category_product_model->get();

        //load view template
        $this->data['meta_title'] = 'Bài viết sản phẩm';
        $this->data['sub_view'] = 'admin/manage_product/index';
        $this->data['sub_js'] = 'admin/manage_product/index-js';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function token_search()
    {
        $q = $_GET['q'];
        $list_product = $this->manage_product_model->get_by('name LIKE "%' . $q . '%"');
        foreach ($list_product as $key => $val) {
            $data[] = array(
                'id' => $val->id,
                'name' => $val->title
            );
        }
        print_r(json_encode($data));
        die();
    }
    public function edit($id = NULL)
    {
        

        $this->data['product'] = ($id) ? $this->manage_product_model->get($id) : $this->manage_product_model->getList();
        //validate form
        $rules = $this->manage_product_model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            $data = $this->manage_product_model->array_from_post(array('title', 'intro', 'category_id', 'thumbnail',  'content', 'type', 'status','price', 'code','fb_page_url', 'member_id','is_public'));

            $data['rent_enddate'] = ($data['rent_enddate']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['rent_enddate']))) : null;
            
            $data['slugname'] = build_slug($data['title']);
            if(!$data['title']) $data['title'] = $data['title'];
            if(!$data['intro']) $data['intro'] = $data['intro'];
            $data['is_public'] = ($data['is_public']) ? 1 : 0;
            if(!$data['category_id']) $data['category_id'] = $data['category_id'];
            if(!$data['content']) $data['content'] = $data['content'];
            $data['member_id'] = ($data['member_id']) ? intval($data['member_id']) : 0;
            if (!$data['thumbnail']) unset($data['thumbnail']);
            

            if (!$id) {
                $data['created_by'] = $this->data['userdata']['id'];
            }
           
            if ($id = $this->manage_product_model->save($data, $id)) {
               
                $this->session->set_flashdata('session_msg', 'Cập nhật thành công.');
            } else {
                $this->session->set_flashdata('session_error', 'Không thể cập nhật dữ liệu.');
            }
            print_r($data['title']);
        
            redirect(base_url('manage_product'));
            ;
          
        }
        
        //Load View
        $this->data['meta_title'] = ($id) ? 'Sửa bài viết' : 'Viết bài mới';
        $this->data['sub_view'] = 'admin/manage_product/edit';
        $this->data['sub_js'] = 'admin/manage_product/edit-js';
        $this->load->view('admin/_layout_main', $this->data);
    }

            public function delete($id = NULL) 
            {
                $product = $this->manage_product_model->get($id,true);
            
                if ( ! $this->has_permission('delete',$product->category)) $this->not_permission();     
                $post_id = $this->input->post('ids');
                if($id) {
                    $post_id[] = $id;
                }
                if($this->manage_product_model->updateStatus($post_id,3)) {

                    //save history
                    $_action = 'Deleted';
                    foreach ($post_id as $key => $val) {
                        $this->history_model->add_history(NULL,$_action,$val,'product');
                    }

                    $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
                    return true;
                }
                else {
                    $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
                    return false;
                }
                return false;
            }

            public function _unique_slug($str) 
            {
                //Don't validate form if this slug already
                $id = $this->uri->segment(3);
                $this->db->where('slug',$this->input->post('slug'));
                !$id || $this->db->where('id !=', $id);
                $article = $this->manage_product_model->get();
                if(count($article)) {
                    $this->form_validation->set_message('_unique_slug','%s should be Unique');
                    return FALSE;
                }
                return TRUE;
            }

            public function getListProductData()
            {
                $result = $this->manage_product_model->dataGrid();
                header('Content-Type: application/json');
                echo json_encode($result);
            }

            public function apis($action)
            {
                $fnc = "__{$action}";
                $this->$fnc();
            }

            private function __removeNews()
            {
                if ($this->data['userdata']['level']>1) 
                    $this->jsonResponse(400, lang('not_permission'), []);

                $id = intval($this->input->post('id'));
                $this->manage_product_model->removeNews($id);
                $this->jsonResponse(200, 'success', []);
            }

            private function __togglePublic()
            {
                $id = intval($this->input->post('id'));
                $product = $this->manage_product_model->get($id);
                $data = [
                    'is_public' => ($product->is_public) ? 0 : 1
                ];
                $this->manage_product_model->save($data, $id);
                $this->jsonResponse(200, 'success');
            }

            
            // public function publish() 
            // {
            //     $result = array('code'=>0 , 'msg' => 'success', 'data' => NULL);

            //     $userdata = $this->data['userdata'];
            //     if($userdata['level'] > 2)
            //     {
            //         $result['code'] = -2;
            //         $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
            //         echo json_encode($result);
            //         exit();
            //     }

            //     if ( ! $this->has_permission('edit'))
            //     {
            //         $result['code'] = -2;
            //         $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
            //         echo json_encode($result);
            //         exit();
            //     }

            //     $ids = $this->input->post_get('ids');
            //     $status = $this->input->post_get('status');
            //     if($this->realnews_model->updateStatus($ids,$status)) 
            //     {

            //         //save history
            //         if($status == 1) $_action = 'Published';
            //         else $_action = 'UnPublished';
            //         foreach ($ids as $key => $val) {
            //             $this->history_model->add_history(NULL,$_action,$val,'news');
            //         }

            //         $result['msg'] = 'Cập nhật dữ liệu thành công';
            //         echo json_encode($result);                
            //         exit();
            //     }
            //     $result['code'] = -1;
            //     $result['msg'] = 'Không thành công!';
            //     echo json_encode($result);                
            //     exit();
            // }

            public function search()
            {
                $keyword = trim($this->input->get('q'));
                $this->data['articles'] = $this->realnews_model->search($keyword);

                //Fetch all category
                $this->data['list_categories'] = $this->category_model->get_all_category();

                //Fetch all author
                $this->data['authors'] = $this->user_model->get_list_author();

                //Load View
                $this->data['meta_title'] = 'Kết quả tìm kiếm: '. $keyword;            
                $this->data['sub_view'] = 'admin/news/search';
                $this->data['sub_js'] = 'admin/news/search-js';
                $this->load->view('admin/_layout_main',$this->data);

            }

    //         public function reportNewsByAuthor()
    //         {

    //             //fetch report all news
    //             $allNewsReport = $this->realnews_model->getReportNewsByStatus();
    //             if ( ! isset($allNewsReport[STATUS_PUBLISHED])) $allNewsReport[STATUS_PUBLISHED] = 0;
    //             if ( ! isset($allNewsReport[STATUS_PENDING])) $allNewsReport[STATUS_PENDING] = 0;
    //             if ( ! isset($allNewsReport[STATUS_WRITING])) $allNewsReport[STATUS_WRITING] = 0;
    //             if ( ! isset($allNewsReport[STATUS_COMEBACK])) $allNewsReport[STATUS_COMEBACK] = 0;
    //             if ( ! isset($allNewsReport[STATUS_DELETED])) $allNewsReport[STATUS_DELETED] = 0;
    //             $this->data['allNewsReport'] = $allNewsReport;

    //             $me = $this->data['userdata'];
    //             if($me['level'] > 2)
    //             {
    //                 $this->not_permission('Bạn không có quyền xem thông tin của thành viên: ' . $userId);
    //             }

    //             $createTimeFilter = ($this->input->get_post('createTimeFilter')) ? trim($this->input->get_post('createTimeFilter')) : '';
    //             if($createTimeFilter) {
    //                 $_parseTime = explode(' - ', $createTimeFilter);
    //                 $_startTime = explode('/', $_parseTime[0]);
    //                 $_endTime = explode('/', $_parseTime[1]);
    //                 $_startTime = mktime(0,0,0,$_startTime[0], $_startTime[1], $_startTime[2]);
    //                 $_endTime = mktime(23,59,59,$_endTime[0], $_endTime[1], $_endTime[2]);
    //             }
    //             else {
    //                 $firstDay = strtotime('first day of this month');
    //                 $lastDay = strtotime('last day of this month');
    //                 $_startTime = mktime(0,0,0, date('m', $firstDay), 1, date('Y', $firstDay));
    //                 $_endTime = mktime(23,59,59, date('m', $lastDay) , date('d', $lastDay), date('Y', $lastDay));
    //             }

    //             $this->data['timeFilter'] = array(
    //                 'start' => date('m/d/Y', $_startTime),
    //                 'end' => date('m/d/Y', $_endTime)
    //             );

    //             $authors = $this->user_model->get_list_author();
    //             //Fetch all author
    //             $this->data['authors'] = $authors;

    //             //get report news
    //             $reportsNews = $this->realnews_model->getReportByAuthor($_startTime, $_endTime);
    //             $arrKey = array(0=>'all','approved','pending','trash','writting','return');
    //             foreach ($reportsNews as $key => $val) {
    //                 if(isset($arrKey[$val->status]))
    //                 {
    //                     $statusName = $arrKey[$val->status];
    //                     $this->data['reports'][$val->create_by][$statusName] = $val->number;
    //                 }
    //                 else {
    //                     $this->data['reports'][$val->create_by][$statusName] = 0;
    //                 }
    //             }

    //             //load view
    //             $this->data['meta_title'] = 'Thống kê bài viết ';
    //             $this->data['meta_title_1'] = 'Thống kê từ: ' . date('d/m/Y', $_startTime) .' đến ' . date('d/m/Y', $_endTime);
    //             $this->data['sub_view'] = 'admin/news/report-news';
    //             $this->data['sub_js'] = 'admin/news/report-news-js';
    //             $this->load->view('admin/_layout_main',$this->data);
    //         }

    public function listNews()
    {
        $this->data['tree_categories'] = $this->category_model->get_tree_categories();
        $this->data['category_id']=0;
        $this->data['authors'] = $this->user_model->get_list_author();
        //Load view
        $this->data['meta_title'] = 'Quản lý bài viết';
        $this->data['sub_view'] = 'admin/news/list-news';
        $this->data['sub_js'] = 'admin/news/list-news-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

   

    //         public function getListLocationByPrarent(
    //         {
    //             $parentId = $this->input->get_post('parent_id');
    //             $type = $this->input->get_post('type');
    //             $allowType = ['country', 'region', 'province', 'district', 'ward'];
    //             $locName = [
    //                 'country'=>'Quốc gia', 
    //                 'region' => 'Vùng miền', 
    //                 'province' => 'Tỉnh/thành', 
    //                 'district' => 'Quận/huyện', 
    //                 'ward' => 'Xã/phường'
    //             ];

    //             if ( ! in_array($type, $allowType)) 
    //                 $this->responseJson(400, 'Yêu cầu không hợp lệ');

    //             if ($type=='region') 
    //             {
    //                 $this->load->model('region_model');
    //                 $location = $this->region_model->getRegionByCountry(VIETNAM);
    //             }
    //             elseif ($type=='province') 
    //                 $location = $this->location_model->getProvince();
    //             elseif ($type=='district') 
    //                 $location = $this->location_model->getDistrictByProvince($parentId);
    //             elseif ($type=='ward') 
    //                 $location = $this->location_model->getWardByDistrict($parentId);

    //             if ($location) 
    //             {
    //                 $data[] = [
    //                     'id'=>'', 
    //                     'name'=>'--- Chọn '.$locName[$type].' ---'
    //                 ];
    //                 foreach ($location as $key => $value) 
    //                 {
    //                     $data[] = [
    //                         'id' => $value->id,
    //                         'name' => $value->name
    //                     ];
    //                 }
    //                 $this->responseJson(200, 'success', $data);
    //             }
    //             else
    //                 $this->responseJson(200, 'data empty', NULL);
    //         }

          

    //         private function __checkPhone()
    //         {
    //             $phone = trim($this->input->get('phone'));
    //             $id = intval($this->input->get('id'));
    //             if (!$phone)
    //                 $this->jsonResponse(400, lang('phone_not_valid'), []);

    //             $where = ['owner_phone' => $phone];
    //             if ($id) 
    //                 $where['id !='] = $id;

    //             $already = $this->realnews_model->get_by($where, true);
    //             if ($already) 
    //                 $this->jsonResponse(201, lang('owner_phone_already'), []);

    //             $salePhone = isNotSalePhone($phone);
    //             if ($salePhone != 'success') 
    //                 $this->jsonResponse(202, lang($salePhone), []);
    //             else
    //                 $this->jsonResponse(200, 'not exist', []);
    //         }

    //         private function __checkAddress()
    //         {
    //             $address = trim($this->input->get('address'));
    //             $id = intval($this->input->get('id'));
    //             $province_id = intval($this->input->get('province_id'));
    //             $district_id = intval($this->input->get('district_id'));
    //             $where = [
    //                 'address' => $address,
    //                 'province_id' => $province_id,
    //                 'district_id' => $district_id
    //             ];
    //             if ($id) 
    //                 $where['id !='] = $id;

    //             $already = $this->realnews_model->get_by($where, true);
    //             if ($already) 
    //                 $this->jsonResponse(200, 'already', []);
    //             else
    //                 $this->jsonResponse(201, 'not exist', []);
    //         }

    //         private function __checkCode()
    //         {
    //             $code = trim($this->input->get('code'));
    //             $id = intval($this->input->get('id'));
    //             if (! preg_match('/^[0-9]{8}$/', $code)) 
    //                 $this->jsonResponse(201, 'not valid', []);

    //             $where = ['code' => $code];
    //             if ($id) 
    //                 $where['id !='] = $id;

    //             $already = $this->realnews_model->get_by($where, true);
    //             if ($already) 
    //                 $this->jsonResponse(200, 'already', []);
    //             else
    //                 $this->jsonResponse(201, 'not exist', []);
    //         }

          

            public function importModal()
            {
                $this->load->view('admin/realnews/modal-import');
            }

//             public function importExec()
//             {
//                 $data = parent::upload_file('import_file');
//                 if ($data['msg'] != 'success') 
//                     $this->jsonResponse(400, $data['msg']);

//                 $imageFilePath = BASEPATH . '../' . config_item('upload_dir') . $data['image_url'];
//                 $imageFilePaths = $imageFilePath;

//             if (!empty($imageFilePath)) {
//                 $keys = 0;
//                 $keyr = 0;
//                 $inputFileType = 'Xlsx';
//                 $inputFileName = './sampleData/example1.xls';

//                 /**  Create a new Reader of the type defined in $inputFileType  **/
//                 $reader = PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
//                 /**  Load $inputFileName to a Spreadsheet Object  **/
//                 $spreadsheet = $reader->load($imageFilePath);
//                 $data = $spreadsheet->getActiveSheet()->toArray();
//                 $i = 0;
//                 $arr = [];

//                 foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
//                     list($startColumn, $startRow) = Coordinate::coordinateFromString($drawing->getCoordinates());
//                     $imageFileName = $drawing->getCoordinates() . mt_rand(1000, 9999);

//                     switch ($drawing->getExtension()) {
//                         case 'jpg':
//                         $imageFileName .= '.jpg';
//                         $source = imagecreatefromjpeg($drawing->getPath());
//                         imagejpeg($source, $imageFilePath . $imageFileName);
//                         imagejpeg($source, $imageFilePathss . $imageFileName);
//                         break;
//                         case 'jpeg':
//                         $imageFileName .= '.jpg';
//                         $source = imagecreatefromjpeg($drawing->getPath());
//                         imagejpeg($source, $imageFilePath . $imageFileName);
//                         imagejpeg($source, $imageFilePathss . $imageFileName);
//                         break;
//                         case 'gif':
//                         $imageFileName .= '.gif';
//                         $source = imagecreatefromgif($drawing->getPath());
//                         imagegif($source, $imageFilePath . $imageFileName);
//                         break;
//                         case 'png':
//                         $imageFileName .= '.png';
//                         $source = imagecreatefrompng($drawing->getPath());
//                         imagepng($source, $imageFilePath . $imageFileName);
//                         imagepng($source, $imageFilePathss . $imageFileName);
//                         break;
//                     }
//                     $startColumn = $this->ABC2decimal($startColumn);
//                     $data[$startRow - 1][$startColumn] = $imageFileName;
//                 }

//                 foreach ($data as $key => $row) {
//                     $keyss = 0;
//                     $arr = [];

//                     if ($key != 0 && $key != 1 && $key != 2) {
//                         if (!empty($row[0])) {
//                             $arr[] = $row[0];
//                         }
//                         if (!empty($row[1])) {
//                             $arr[] = $row[1];
//                         }
//                         if (!empty($row[2])) {
//                             $arr[] = $row[2];
//                         }
//                         if (!empty($row[3])) {
//                             $arr[] = $row[3];
//                         }
//                         if (!empty($row[4])) {
//                             $arr[] = $row[4];
//                         }


//                         $category = !empty($request->types) ? Category::where('name', $row[7])->where('type', 2)->first() :
//                         Category::where('name', $row[7])->where('type', 1)->first();
//                         if ((empty($category) || empty($row[0]) || empty($row[5])
//                             || empty($row[10])
//                             || empty($row[11])
//                             || empty($row[12]) || empty($row[13]) || empty($row[16]) || empty($row[17]) || empty($row[19]) || empty($row[20]) || empty($row[21]) || empty($row[22]) || empty($row[23])) && empty($request->types)) {
//                             $keys++;
//                         $keyss++;
//                     }
//                     if (!empty(preg_match('/[L,l][ẻ,Ẻ]/', $row[13])) && empty($row[14]) && empty($request->types)) {
//                         $keys++;
//                         $keyss++;
//                     }
//                     if ((empty($category) || empty($row[0]) || empty($row[5]) || empty($row[10]) || empty($row[11]) || empty($row[12]) || empty($row[15]) || empty($row[16]) || empty($row[17]) || empty($row[18]) || empty($row[19])) && !empty($request->types)) {
//                         $keys++;
//                         $keyss++;
//                     } else {
//                         if (empty($category->parent_id) && !empty($category)) {
//                             $check = Category::where('parent_id', $category->id)->count();
//                             if ($check > 0) {
//                                 $keys++;
//                                 $keyss++;
//                             }
//                         }
//                     }
//                     $trademark = Trademark::where('name', $row[8])->where('enable', 1)->first();
//                     $source = Source::where('name', $row[9])->where('enable', 1)->first();
//                     if (!empty($row[18]) && empty($request->types)) {
//                         $address = [];
//                         $latlong = [];
//                         $array = explode(',', $row[18]);
//                         foreach ($array as $key) {
//                             $key = $key - 1;
//                             if (!empty(auth()->user()->shop->extracontentAddress) && !empty(auth()->user()->shop->lat_long)) {
//                                 $json_decode = json_decode(auth()->user()->shop->extracontentAddress);
//                                 if (count($json_decode) > 0 && $key <= count($json_decode)) {
//                                         //$address[] = @$json_decode[$key]->address;
//                                     $address[] = @$json_decode[$key]->addressFull;
//                                     $latlong[] = @$json_decode[$key]->latLong;
//                                 }
//                             }
//                         }

//                     }
//                     else {
//                         if (!empty($row[14])) {
//                             $address = [];
//                             $latlong = [];
//                             $array = explode(',', $row[14]);
//                             foreach ($array as $key) {
//                                 $key = $key - 1;
//                                 if (!empty(auth()->user()->shop->extracontentAddress) && !empty(auth()->user()->shop->lat_long)) {
//                                     $json_decode = json_decode(auth()->user()->shop->extracontentAddress);
//                                     if (count($json_decode) > 0 && $key <= count($json_decode)) {
//                                             //$address[] = @$json_decode[$key]->address;
//                                         $address[] = @$json_decode[$key]->addressFull;
//                                         $latlong[] = @$json_decode[$key]->latLong;
//                                     }
//                                 }
//                             }
//                         }
//                     }
//                     if (!empty($request->types)) {
//                         if ($keyss == 0) {
//                             $data = \App\Models\Service::create([
//                                 'name'           => $row[5],
//                                 'shop_id'        => auth()->user()->shop->id,
//                                 'category_id'    => !empty($category) ? $category->id : 1,
//                                 'description'    => @$row[6],
//                                 'trademark_id'   => !empty($trademark) ? $trademark->id : 1,
//                                 'price'          => @$row[10],
//                                 'original_price' => @$row[11],
//                                 'enable'         => ($row[16] == "Hiện" || $row[16] == "hiện") ? 1 : 0,
//                                 'realtime'       => trim($row[18]) == "Bật" ? 1 : 0,
//                                 'unit'           => @$row[12],
//                                 'source_id'      => !empty($source) ? $source->id : 1,
//                                 'images'         => @\GuzzleHttp\json_encode($arr),
//                                 'bargain'        => trim($row[17]) == "Có" ? 1 : 0,
//                                 'order_status'   => trim($row[15]) == "Có" ? 1 : 0,
//                                 'link'           => trim($row[19]) == "Có" ? 1 : 0,
//                                 'property'       => !empty($row[13]) ? "{" . implode(',', preg_split("/\\r\\n|\\r|\\n/", $row[13])) . "}" : null,
//                                 'shop_address'   => !empty($address) ? json_encode($address) : null,
//                                 // 'lat_long'       => !empty($latlong) ? json_encode($latlong) : null,
//                                 //    'weight'         => @$row[21],
//                                 //    'length'         => @$row[22],
//                                 //    'width'          => @$row[23],
//                                 //    'height'         => @$row[24],
//                                 //                                'quantity'       => @$row[12],
//                                 //                                    'type_unit'      => ($row[9] == "Lẻ"||$row[9] == "lẻ"||$row[9] == "LẺ") ? 1 : 0,
//                                 //                                    'sum_unit'       => $row[10],
//                                 //                                    'quality'        => trim($row[13]) == "Mới" ? 1 : 0,
//                             ]);
//                             $keyr++;
//                             $this->uploadImageImport($data['images'], 'services');
//                         }
//                     }
//                     else {
//                         if ($keyss == 0) {
//                             $data = Product::create([
//                                 'name'           => $row[5],
//                                 'shop_id'        => auth()->user()->shop->id,
//                                 'category_id'    => !empty($category) ? $category->id : 1,
//                                 'description'    => @$row[6],
//                                 'quantity'       => @$row[16],
//                                 'trademark_id'   => !empty($trademark) ? $trademark->id : 1,
//                                 'price'          => @$row[10],
//                                 'original_price' => @$row[11],
//                                 'enable'         => ($row[20] == "Hiện" || $row[20] == "hiện") ? 1 : 0,
//                                 'realtime'       => trim($row[22]) == "Bật" ? 1 : 0,
//                                 'unit'           => @$row[12],
//                                 'type_unit'      => !empty(preg_match('/[L,l][ẻ,Ẻ]/', $row[13])) ? 1 : 0,
//                                 'sum_unit'       => !empty(preg_match('/[L,l][ẻ,Ẻ]/', $row[13])) ? $row[14] : 1,
//                                 'source_id'      => !empty($source) ? $source->id : 1,
//                                 'images'         => @$arr,
//                                 'quality'        => trim($row[17]) == "Mới" ? 1 : 0,
//                                 'bargain'        => trim($row[21]) == "Có" ? 1 : 0,
//                                 'order_status'   => trim($row[19]) == "Có" ? 1 : 0,
//                                 'link'           => trim($row[23]) == "Có" ? 1 : 0,
//                                 'property'       => !empty($row[15]) ? "{" . implode(',', preg_split("/\\r\\n|\\r|\\n/", $row[15])) . "}" : null,
//                                 'shop_address'   => !empty($address) ? json_encode($address) : null,
//                                 'lat_long'       => !empty($latlong) ? json_encode($latlong) : null,
//                                 'weight'         => @$row[24],
//                                 'length'         => @$row[25],
//                                 'width'          => @$row[26],
//                                 'height'         => @$row[27],
//                             ]);

//                             $numbers = [];
//                             $keyr++;
//                             if (!empty($data->property)) {
//                                 $x2Numbers = array_map(function ($values) {
//                                     return explode(',', $values);
//                                 }, json_decode($data->property, true));
//                                 $a = $this->generate($x2Numbers);
//                                 foreach ($a as $key => $value) {
//                                     $numbers[$key]['name'] = $value;
//                                     $numbers[$key]['quantity'] = $key == 0 ? @$row[16] : 0;
//                                 }
//                                 $data->update([
//                                     'number_feature' => json_encode(@$numbers),
//                                 ]);
//                             }
//                             $this->uploadImageImport($data['images'], 'products');
//                         }
//                     }
//                     if ($keyss == 0) {
//                         $shop_id = $data->shop_id < 10 ? '0' . $data->shop_id : $data->shop_id;
//                         $product_id = $data->id < 10 ? '0' . $data->id : $data->id;
//                         $code = $shop_id . 'MA' . $product_id;
//                         $data->update(['code' => $code]);
//                     }
//                 }
//             }
//         }
//     return $this->jsonResponse('status', 'Tải danh sách sản phẩm thành công');
// }
}