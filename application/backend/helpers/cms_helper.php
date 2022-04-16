<?php
    
    function sortMoney(int $money)
    {
        if (!$money) 
            return '0';

        if ($money >= TYDONG) {
            $ratio = TYDONG;
            $ratioName = 'tỷ';
        }
        elseif ($money >= TRIEUDONG) {
            $ratio = TRIEUDONG;
            $ratioName = 'tr';
        }
        else {
            $ratioName = 'K';
            $ratio = 1000;
        }
        return number_format($money/$ratio, 1) . ' ' . $ratioName;
    }

    function form_element($data)
    {
        if (isset($data['label']) && $data['label']) 
            echo '<label ', ( (isset($data['required']) && $data['required']) ? 'class="required"' : '' ) ,'>', $data['label'] ,'</label>';
        if (! isset($data['type'])) 
            $data['type'] = 'text';

        if ($data['type']=='checkbox') 
            echo form_checkbox($data);
        elseif ($data['type']=='select') 
        {
            $options = $data;
            unset($options['name']);
            unset($options['options']);
            unset($options['value']);
            $options['class'] = 'form-control';
            echo form_dropdown($data['name'], $data['options'], $data['value'], $options);
        }
        elseif ($data['type']=='radio') 
            echo form_radio($data);
        elseif ($data['type']=='radio') 
            echo form_radio($data);
        elseif ($data['type']=='hidden') 
            echo form_hidden($data);
        elseif ($data['type']=='textarea') {
            $data['class'] = 'form-control';
            echo form_textarea($data);
        }
        elseif ($data['type']=='fileupload') 
            echo form_fileupload($data);
        else {
            $data['class'] = 'form-control';
            echo form_input($data);
        }
    }

    function form_fileupload($data)
    {
        echo '
        <div class="image-upload-container">
            <p style="padding-left:20px">
                <a href="javascript:;" class="upload-button btn btn-xs btn-default edit-mode" data-name="', $data['name'] ,'" data-maxwidth="800"><i class="fa fa-upload blue"></i> ', $data['button_label'] ,'</a>
            </p>
            <p class="status-', $data['name'] ,'"></p>
            <div class="preview-', $data['name'] ,'">';
        if ($data['value'])
            echo '<img src="', getImageUrl($data['value']) ,'" class="thumbnail"><input type="hidden" name="', $data['name'] ,'" value="', $data['value'] ,'"/>';
        echo '</div></div>';
    }

    function cleanInputString($str)
    {
        $str = get_plaintext($str);
        $str = preg_replace('/[\'\"();]*/', '', $str);
        return str_replace('-', ' ', $str);
    }

    function btn_edit($uri) {
        return '<a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="'.base_url($uri).'" title="Sửa"><i class="fa fa-pencil-square-o"></i></a>';
    }

    function btn_return($uri) {
        return '<a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="'.base_url($uri).'" title="Trả lại" onclick="return confirm(\'Cornfirm this action. Are you sure?\')"><i class="fa fa-thumbs-down"></i></a>';
    }
    
    function btn_delete($uri) {
        return '<a class="btn-default btn delete-btns" style="margin:5px 0;padding:0 3px" href="#" data-href="' . base_url($uri) . '" title="Xóa"><i class="fa fa-trash-o" style="color: red;"></i></a>';
    }

    function btn_view($url) {
        return '<a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="' . $url . '" target="_blank" title="Xem nhanh"><i class="fa fa-eye"></i></a>';
    }

    function build_slug($str) {
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

    function to_datetime($unix_time) {
        return date('d-m-Y H:i:s',$unix_time);
    }

    /**
    * Convert DateTime: dd-mm-YYYY H:i:s to UnixTime
    * 
    * @var mixed $datetime_str format dd-mm-yyyy H:i:s
    */
    function to_unixtime($datetime_str) {
        $_array_str = explode(' ',$datetime_str);    
        $_array_date = explode('-',$_array_str[0]);
        $_array_time = explode(':',$_array_str[1]);
        if(!isset($_array_time[2])) $_array_time[2] = 0;
        return mktime($_array_time[0],$_array_time[1],$_array_time[2],$_array_date[1],$_array_date[0],$_array_date[2]);
    }

    /**
    * Convert DateTime: dd-mm-YYYY H:i:s to UnixTime
    * 
    * @var mixed $datetime_str format dd-mm-yyyy H:i:s
    */
    function to_dbDateTime($datetime_str) {
        $_array_str = explode(' ',$datetime_str);    
        $_array_date = explode('-',$_array_str[0]);
        $_array_time = explode(':',$_array_str[1]);
        if(!isset($_array_time[2])) $_array_time[2] = 0;
        $time = mktime($_array_time[0],$_array_time[1],$_array_time[2],$_array_date[1],$_array_date[0],$_array_date[2]);
        return date('Y-m-d H:i:s', $time);
    }

    function get_excerpt($str,$length){
        if(strlen($str) > $length) {
            $data = substr($str,0,$length);
            $last_space_pos = strrpos($data,' ');
            $data = substr($data,0,$last_space_pos);
            return $data .' ...';
        } else {
            return $str;
        }
    }

    function insert_cart($id,$qty,$name,$options=array()) {
        $data = array(
            'id' => $id,
            'qty' => $qty,
            'name' => $name,
            'options' => $options
        );
        $this->cart->insert($data);
    }

    function get_childs_menu ($menus,$parent) {
        foreach ($menus as $key => $value) {
            if($value->parent_id == $parent) {
                unset($menus[$key]);
                $data[]=$value;
            }
        }
        return $data;
    }

    function show_menu($menus = array(), $parrent = 0,$main_class='',$sub_class='',$item_menu_class='') {
        if (has_child($menus,$parrent)) {
            if($parrent != 0) echo '<ul class="'.$sub_class.'">';
            else echo '<ul class="'.$main_class.'">';
            foreach ($menus as $key => $val) 
            {
                if ($val->parent_id == $parrent) 
                {
                    unset($menus[$key]);
                    if(has_child($menus,$val->id))
                        echo '<li><a class="'.$item_menu_class.' bold" href="'. $val->url. '"><i class="ico bg-right-arr"></i>'. $val->title. '</a>';
                    else
                        echo '<li><a class="'.$item_menu_class.'" href="'. $val->url. '">'. $val->title. '</a>';
                    show_menu($menus, $val->id, $main_class,$sub_class,$item_menu_class,false);
                    echo '</li>';
                }
            }
            echo '</ul>';
        }
    }

    function has_child ($array,$parent) {
        foreach ($array as $val) {
            if($val->parent_id == $parent)
                return true;
        }
        return false;
    }

    function adminPage_select_parent_menu ($menus,$parrent,$selected=0,$item_id='',$class="form-control") {
        if (has_child($menus,$parrent)) {
            foreach ($menus as $key => $val) 
            {
                if ($val->parent_id == $parrent) 
                {
                    $space='';
                    if($val->level>1){
                        for($i=1;$i<$val->level;$i++){
                            $space .='&ndash;';
                        }
                    }
                    $str = '<option value="'.$val->id.'"';
                    if ($val->id == $selected) $str.=' selected="selected"';
                    $str.='>'.$space.'&nbsp;'. $val->title. '</option>';
                    echo $str;
                    adminPage_select_parent_menu($menus,$val->id,$item_id='',$class="form-control",false);
                }
            }
        }
    }

    function adminPage_menu_manager($menus = array(), $parrent = 0,$main_class='',$sub_class='',$item_menu_class='') {
        if (has_child($menus,$parrent)) {
            if($parrent != 0) echo '<ul class="'.$sub_class.'">';
            else echo '<ul class="'.$main_class.'">';
            foreach ($menus as $key => $val) 
            {
                if ($val->parent_id == $parrent) 
                {
                    unset($menus[$key]);
                    echo '<li><a class="'.$item_menu_class.'" href="'. base_url('setting/edit_menu/'.$val->id). '" data-id="'.$val->id.'">'. $val->title. '</a>&nbsp;<i class="btn" style="cursor:pointer;font-size:.8em;color:#F00" onclick="remove_menu('.$val->id.')" >Remove</i>';
                    adminPage_menu_manager($menus, $val->id, $main_class,$sub_class,$item_menu_class,false);
                    echo '</li>';
                }
            }
            if($parrent != 0) echo '</ul>';
        }
    }

    function get_image ($img_url) {
        $img_url = str_replace('//','/',$img_url);
        return config_item('media_uri') . $img_url;
    }

    function get_url($url)
    {
        if(! strstr($url,'http'))
            $url = 'http://' . $url;
        return $url;
    }
    function get_product_saleoff($list_event,$product_id,$product_type){
        $percent = 0;
        foreach($list_event as $event){
            if (in_array($product_id,explode(',',$event['list_product']))||in_array($product_type,explode(',',$event['product_type'])))
            {
                $percent = $event['off_percent'];
            }
        }
        return $percent;
    }

    function get_plaintext($str){
        return preg_replace('/(<(\/?)[^>]*>)*/','',$str);
    }

    function build_pagination($current_page=1,$limit=5000){
        $next = $current_page+1;
        $prev = $current_page-1;
        if($prev < 1) $prev = 1;
        $offset = ($current_page-1)*$limit;
        $data = array(
            'current' => $current_page,
            'next' => $next,
            'prev' => $prev,
            'offset' => $offset,
            'limit' => $limit
        );
        return $data;        
    }

    function array_from_get($args=array()) {
        foreach ($args as $key => $var_name) {
            $data[$var_name] = $_GET[$var_name];
        }
        return $data;
    }

    function my_form_error($field) {
        echo form_error($field,'<span class="error">','</span>');
    }

    function displayAlert() {
        $CI =& get_instance();

        if( $CI->session->flashdata('session_msg') ) 
        {
            echo '<div class="alert alert-success" style="margin:10px"><p>' , $CI->session->flashdata('session_msg') , '</p></div>';
            $CI->session->set_flashdata('session_msg', '');
        }
        if($CI->session->flashdata('session_error')) 
        {
            echo '<div class="alert alert-warning" style="margin:10px"><p>' , $CI->session->flashdata('session_error') , '</p></div>';
            $CI->session->set_flashdata('session_error', '');
        }
        if($CI->session->flashdata('session_info')) 
        {
            echo '<div class="alert alert-info" style="margin:10px"><p>' , $CI->session->flashdata('session_info') , '</p></div>';
            $CI->session->set_flashdata('session_info', '');
        }
    }

    function select_box_with_level_category($list_category, $parent=0, $selected=NULL)
    {
        foreach ($list_category as $key => $val) {
            if($val->parent_id == $parent)
            {
                $sept = '';
                if($val->level > 1)
                {
                    for($i=1;$i<$val->level;$i++){
                        $sept .= '&mdash;';
                    }
                }
                echo ($selected == $val->id) ? '<option value="'.$val->id.'" selected="selected"> '.$sept.' '.$val->title.' </option>' : '<option value="'.$val->id.'"> '.$sept.' '.$val->title.' </option>';
                unset($list_category[$key]);
                if(has_cat_child($list_category, $val->id)) select_box_with_level_category($list_category, $val->id);
                else continue;
            }

        }
    }

    function has_cat_child($list_category, $parent_id)
    {
        foreach ($list_category as $key => $val) {
            if($val->parent_id == $parent_id) return TRUE;
        }
        return FALSE;
}

    function select_box_with_level_category_permission($list_category, $selected=NULL)
    {
        foreach ($list_category as $key => $val) 
        {
            if($val->parent_id == 0)
            {
                echo ( in_array($val->id, $selected) ) ? '<option value="'.$val->id.'" selected="selected"> '.$val->title.' </option>' : '<option value="'.$val->id.'"> '.$val->title.' </option>';
                unset($list_category[$key]);
                if(has_cat_child($list_category, $val->id))
                {
                    $sept = '&mdash;';
                    foreach ($list_category as $_key => $_val) 
                    {
                        if($_val->parent_id == $val->id)
                        {
                            echo (in_array($_val->id, $selected)) ? '<option value="'.$_val->id.'" selected="selected"> '.$sept.' '.$_val->title.' </option>' : '<option value="'.$_val->id.'"> '.$sept.' '.$_val->title.' </option>';
                            unset($list_category[$_key]);
                        }
                    }
                }
            }
        }
/*
        if($list_category) 
        {
            foreach ($list_category as $key => $val) 
            {
                echo ( in_array($val->id, $selected) ) ? '<option value="' . $val->id . '" selected="selected"> ' . $val->title . ' </option>' : '<option value="' . $val->id . '"> ' . $val->title . ' </option>'; 
            }
        }
        */
    }
    
    function setLogEditNews($newsId,$memberId)
    {
        $path = APPPATH . config_item('logEditNewsFile');
        $_oldContent = trim(file_get_contents($path));
        if($_oldContent){
            $explodeCnt = explode(',', $_oldContent);
            $explodeCnt[] = $newsId.'-'.$memberId; 
            $explodeCnt = array_unique($explodeCnt);
            $content = implode(',', $explodeCnt);
        }
        else
        {
            $content = $newsId.'-'.$memberId;
        }
        $log = fopen($path,'w+');
        fwrite($log, $content);
        fclose($log);
    }
    
    function checkNewsEditAlready($newsId)
    {
        $path = APPPATH . config_item('logEditNewsFile');
        $strLog = file_get_contents($path);
        if($strLog)
        {
            $logs = explode(',', $strLog);
            foreach ($logs as $key => $val) {
                $_p = explode('-', $val);
                if($_p[0] == $newsId)
                {
                    return $val;
                    break;
                }
            }
        }
        return FALSE;
    }
    
    function removeEditLog($newsId, $memberId=NULL)
    {
        $path = APPPATH . config_item('logEditNewsFile');
        $strLog = file_get_contents($path);
        $logs = array();
        if($strLog)
        {
            $logs = explode(',', $strLog);
            foreach ($logs as $key => $val) {
                $_p = explode('-', $val);
                if($_p[0] == $newsId && $_p[1]==$memberId)
                {
                    unset($logs[$key]);
                }
            }
        }
        $logContent = implode(',', $logs);
        $logFile = fopen($path, 'w+');
        fwrite($logFile, $logContent);
        fclose($logFile);
        return TRUE;
    }
    
    function removeAllLogsByMember($memberId)
    {
        $path = APPPATH . config_item('logEditNewsFile');
        $strLog = file_get_contents($path);
        $logs = array();
        if($strLog)
        {
            $logs = explode(',', $strLog);
            foreach ($logs as $key => $val) {
                $_p = explode('-', $val);
                if($_p[1]==$memberId)
                {
                    unset($logs[$key]);
                }
            }
        }
        $logContent = implode(',', $logs);
        $logFile = fopen($path, 'w+');
        fwrite($logFile, $logContent);
        fclose($logFile);
        return TRUE;
    }
    
    function singleUploadForm($params=array()) {
        $default = array(
        'field_name' => 'thumbnail',
        'field_value' => 'thumbnail',
        'image_size' => '800x600',
        'image_src' => ''
        );
        $settings = array_merge($default, $params);
        $t = '<div class="form-group">
                <label for="thumbnail">Ảnh đại diện <span class="required">*</span></label>
                <p><a href="#" class="btn btn-xs btn-info btn-set-thumb-url"> <i class="fa fa-pencil"></i> Set</a> Hoặc</p>
                <p>
                <button id="upload-single" type="button"><span>Tải ảnh từ máy tính</span></button> <small>'. $settings['image_size'] .'</small> </p>
                <p><span id="status-single"></span></p>
                <div id="singleUploaded">
                    '. ($settings['image_src']) ? '<img class="thumbnail" src="'.$settings['image_src'].'" />' : '' .'
                    <input type="hidden" name="'. $settings['field_name'] .'" value="'. $settings['field_value'] .'">
                </div>
            </div>';
        return $t;
    }

    function verifyGgCaptcha($captcha)
    {
        if (!$captcha) return FALSE;

        $params = 
        [
            'secret'    => GG_RECAPTCHA_SECRET_KEY,
            'response'  => $captcha
        ];
        $opts = [
            'http' => [
                'method'    => 'POST',
                'header'    => 'Content-type: application/x-www-form-urlencoded',
                'content'   => http_build_query($params)
            ]
        ];
        $context    = stream_context_create($opts);
        $res        = file_get_contents('https://www.google.com/recaptcha/api/siteverify',false,$context);
        $res        = json_decode($res,true);

        return ($res['success']) ? TRUE : FALSE;
    }

    function dateRangePicker($fromDate=NULL, $toDate=NULL)
    {
        echo '
        <div class="row">
            <div class="col-xs-6" style="padding-right:0px">
                <label>Từ ngày</label>
                <input type="text" name="from_date" autocomplete="off" class="form-control vn-datepicker" value="',$fromDate,'">
            </div>
            <div class="col-xs-6" style="padding-left:0px">
                <label>Đến ngày</label>
                <input type="text" name="to_date" autocomplete="off" class="form-control vn-datepicker" value="', $toDate, '">
            </div>
        </div>
        ';
    }

    function siteOption($key, $defaultValue='')
    {
        $CI =& get_instance();
        $CI->load->model('option_model');
        if ($option = @$CI->option_model->get_by(['name' => $key], true)) {
            return $option->value;
        }
        $data = [
            'name' => $key,
            'value' => $defaultValue,
            'var_type' => 'string',
        ];
        $CI->option_model->save($data, null);
        return $data['value'];
    }

    function dataTable($fields, $loadJs=false, $hasExport=false)
    {
        $fieldData = [];
        echo '
        <style>.dataTables_wrapper .dataTables_paginate li.paginate_button{padding:0!important}</style>
        <table class="table table-bordered table-hover" id="datatable">',
            '<thead><tr>';
        foreach ($fields as $key => $value) {
            echo '<th data-field="', $key, '">', ( ($value) ? $value : lang($key) ), '</th>';
            $fieldData[] = ['data' => $key];
        }
        echo '</tr></thead>';
        echo '<tbody></tbody>';
        echo '</table>';
        echo form_hidden('tableField', json_encode($fieldData));
        echo form_hidden('exportTool', intval($hasExport));
        if ($loadJs==true)
        {
            $jsLib[] = '/admin/assets/js/jquery.tokeninput.js';
            $jsLib[] = 'https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
            $jsLib[] = 'https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js';
            $jsLib[] = 'https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js';
            $jsLib[] = 'https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js';
            $jsLib[] = 'https://cdn.datatables.net/plug-ins/1.10.22/api/sum().js';
            if ($hasExport) 
            {
                $jsLib[] = 'https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js';
                $jsLib[] = 'https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js';
                $jsLib[] = 'https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js';
                $jsLib[] = 'https://cdn.datatables.net/colreorder/1.5.4/js/dataTables.colReorder.min.js';
                $jsLib[] = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js';
                $jsLib[] = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js';
                $jsLib[] = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js';
                $jsLib[] = 'https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js';
                $jsLib[] = 'https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js';
            }
            $jsLib[] = '/admin/assets/js/datatables/init.datatables.js?1.001" defer="defer';

            foreach ($jsLib as $key => $value) {
                echo "<script src=\"{$value}\"></script>";
            }
        }
    }

    function toArray($data)
    {
        return json_decode(json_encode($data), true);
    }

    function tokeninput($name, $src, $limit=1, $prepopulate=[], $id='')
    {
        echo '<input type="text" name="', $name, '" class="form-control app-tokeninput" id="', $id ,'" data-src="', $src,'" data-limit="', $limit, '" data-prepopulate=\'', json_encode($prepopulate) ,'\'>';
    }

    function showUserId($id)
    {
        $pattern = 'ID-000000';
        $_idLen = strlen( (string)$id );
        return substr($pattern, 0, -$_idLen) . $id;
    }

    function hidePhone($phone)
    {
        return substr($phone, 0, 3) . ' ***** ' . substr($phone, -2);
    }

    function isNotSalePhone($phone)
    {
        $phone = substr(preg_replace('/[^\d]*/', '', $phone), 0, 10);
        if (! in_array(strlen($phone), [10, 11])) 
            return 'phone_not_valid';

        $notSaleLimit = 3; # giới hạn tối đa cho 1 sđt có kết quả, không phải là sale
        $CI =& get_instance();
        $CI->load->library('curl');

        $cseApiKey = 'AIzaSyBQ8RRf4t9od4PNjsVTAAGamHaZQoASeo8';
        $cseId = 'd66ad750f36364f2d';
        $url = 'https://customsearch.googleapis.com/customsearch/v1?q=%s&cx=%s&key=%s';
        $response = $CI->curl->_simple_call('get', sprintf($url, $phone, $cseId, $cseApiKey));
        $data = json_decode($response, true);
        $totalResults = @intval($data['searchInformation']['totalResults']);
        if ($totalResults<$notSaleLimit) 
            return 'success';

        return 'is_phone_of_sale';
    }

    function reformatPhoneNumber(string $phone)
    {
        return '0' . substr(preg_replace('/[^0-9]*/', '', $phone), -9);
    }
