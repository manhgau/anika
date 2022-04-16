<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function get_image_thumb($img_url,$width=200,$height=150,$ratio = false) {
        preg_match('/[^\/]*$/',$img_url,$matches);
        $image_name  = $matches[0];
        $thumb_name  = $width . 'x' . $height . '_' . $image_name;
        $_parse_dir  = parse_url(dirname($img_url));
        $image_dir   = $_parse_dir['path'];
        $source_path = realpath(config_item('upload_dir') .'/'. $image_dir .'/'. $image_name);
        $thumb_path  = '/home/admin.pga.vn/public_html/' . config_item('upload_dir') . DIRECTORY_SEPARATOR . $image_dir .'/'. $thumb_name;
        $thumb_link  = dirname($img_url) .'/'. $thumb_name;
        //Get the CI super object
        $CI =& get_instance();
        //Config image library
        $config['image_library']='gd2';
        $config['source_image']=$source_path;
        $config['new_image']=$thumb_path;
//        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = $ratio;
        $config['height']=$height;
        $config['width']=$width;
        $CI->load->library('image_lib');
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
        return $thumb_link;
    }

    function getImageUrl($imagePath)
    {
        return config_item('media_uri') . $imagePath;
    }
    
    function create_watermark($img_path) {
        $source_path = __DIR__ . '/../../../' . config_item('upload_dir') .'/'. $img_path;  
        $CI =& get_instance();
        $config['source_image'] = $source_path;
        $config['wm_text'] = config_item('watermark_text');
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = '../system/fonts/texb.ttf';
        $config['wm_font_size'] = '16';
        $config['wm_font_color'] = config_item('watermark_color');
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'right';
        $config['wm_padding'] = '-20';
        $CI->load->library('image_lib',$config);
        $CI->image_lib->watermark();
        $CI->image_lib->clear();
    }
    
    function getYoutubeThumb($youtube_id) {
        return 'http://i3.ytimg.com/vi/'.$youtube_id.'/hqdefault.jpg';
    }