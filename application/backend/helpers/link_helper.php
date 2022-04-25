<?php
    function build_link_admin_page ($action_path='',$params=array()) {
        $str_uri=$action_path;
        if(!empty($params)) {
            foreach ($params as $key => $val) {
                $_params[] = $key.'='.$val;
            }
            $str_uri.='/?'.implode('&',$_params);
        }
        return base_url($str_uri);
    }
    
    function build_link_to_detail_article($slugname='',$id) {
        $str_uri = $slugname . '-a' . $id . '.html';
        return base_url($str_uri);
    }

    function build_link_to_category_news($slugname,$id,$page=1) {
        if($page == 1) {
            $str_uri = $slugname . '-c' . $id;
        } else {
            $str_uri = $slugname . '-c' . $id . '/trang-' . $page;
        }
        return base_url($str_uri);
    }

    function build_link_to_detail_event($slugname,$id) {
        $str_uri = $slugname . '-ev' . $id . '.html';
        return base_url($str_uri);
    }

    function build_link_to_detail_product($slugname,$id) {
        $str_uri = $slugname . '-pr' . $id . '.html';
        return base_url($str_uri);
    }

    function build_link_to_register_event($slugname,$id) {
        $str_uri = 'dang-ky/' . $slugname . '-dk' . $id;
        return base_url($str_uri);
    }

    function build_link_to_detail_page($slug,$id) {
        $str_uri = $slug . '-pa' . $id . '.html';
        return base_url($str_uri);
    }

    function build_link_to_list_product($type_slug='',$type_id=0,$page=1) {
        $url_str = 'san-pham';
        if($type_id != 0)
            $url_str .= '/' . $type_slug . '-ty' . $type_id;
        if($page != 1)
            $url_str .= '/trang-' . $page;

        return base_url($url_str);
    }

    function build_link_to_list_article($cat_slug='',$cat_id=0,$page=1) {
        $url_str = 'tin-tuc';
        if ($cat_id != 0) 
            $url_str = $cat_slug . '-c' . $cat_id;
        if($page > 1) 
            $url_str .= '/trang-' . $page;
        return base_url($url_str);
    }

    function build_link_to_tag($tag_name='',$tag_id=0,$page=1) {
        if ($tag_id != 0) 
            $url_str = strtolower(str_replace(' ','-',$tag_name)) . '-tag' . $tag_id;
        if($page > 1) 
            $url_str .= '/trang-' . $page;
        return base_url($url_str);
    }
    
    function link_to_my_news($userid=NULL,$status=NULL,$page=1)
    {
        $uri = array();
        if($userid) $uri[] = 'userId='.$userid;
        if($status) $uri[] = 'status='.$status;
        if($page) $uri[] = 'page='.$page;
        return ($uri) ? base_url( 'news/myNews?'. implode('&',$uri) ) : base_url( 'news/myNews');
    }
    
    function link_preview_detail_news($slugname, $id)
    {
        //http://thuonghieucongluan.com.vn/khoang-trong-dinh-gia-thuong-hieu-a45552.html
        return config_item('main_domain') . $slugname;
    }
    
    function link_preview_news_category($id, $slugname)
    {
        //http://thuonghieucongluan.com.vn/khoang-trong-dinh-gia-thuong-hieu-a45552.html
        return '/category/' . $slugname;
    }

    function link_preview_category_product($id, $slugname)
    {
        //http://thuonghieucongluan.com.vn/khoang-trong-dinh-gia-thuong-hieu-a45552.html
        return '/category_product/' . $slugname;
    }

    function linkToDetailRealNews($slugname, $code)
    {
        return base_url("/home/newsDetail/{$slugname}/{$code}");
    }