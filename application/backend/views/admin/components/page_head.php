<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title><?php echo 'Dashboard - ', $this->input->server('HTTP_HOST'); ?></title>
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="<?php echo base_url('favicon.png');?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link href="<?php echo base_url('admin/assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/ionicons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/token-input.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/token-input-facebook.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/AdminLTE.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/bootstrap-datetimepicker.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/daterangepicker/daterangepicker-bs3.css'); ?>" rel="stylesheet" type="text/css" />

    <!--  Tags-input  -->
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.core.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.plugin.arrow.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.plugin.autocomplete.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.plugin.clear.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.plugin.focus.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.plugin.prompt.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/js/plugins/jquery-textext/css/textext.plugin.tags.css'); ?>" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo base_url('admin/assets/css/tags-input/jquery.tagit.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin/assets/css/tags-input/tagit.ui-zendesk.css'); ?>" rel="stylesheet" type="text/css" />
    <!--  Datatablegame  -->
    <link rel="stylesheet" href="<?php echo base_url('admin/assets');?>/js/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>

    <style>
        .btn {min-width:25px}.gray{color:#a1a1a1;}
        #imagePreview{width:150px;margin:5px 0;height:150px;background-position:center center;background-size:cover;display:inline-block;-webkit-box-shadow:0 0 1px 1px rgba(0, 0, 0, .3);background-color:#f2f2f2;max-width:300px}th{text-align:center}#list-image ul li{list-style:none;margin:5px;display:block;float:left;border:1px solid #ccc;padding:3px;position:relative}#list-image li img{height:100px;width:100px;display:block;}.item-note{color:#999;margin:0 0 0 20px;font-size:.8em;font-weight:400}.insert_img_content{display:block;text-align:center}ul.list-top-banner li{list-style:none;border-bottom:1px solid #DBDBDB;padding:5px 0}.list-top-banner img{width:200px!important;}.remove-image-item{position: absolute;top: -5px;right: 0px;color: #f00;font-weight: 700;cursor: pointer;}.glyphicon-remove{color:#BE0A0A}.red,.error{color:#F00;font-size:.9em;}.blue,.success{color:#067DC2}.blue,.success{color:#067DC2}.red,.error{color:#BA0303}.orange{color:rgb(255,77,0)}#modal-form{padding:20px}.modal-item{margin:10px 0;text-align:justify;border-bottom:1px solid #e4e4e4;padding-bottom:5px}.modal-item label{margin-right:10px;text-align:justify}.modal-item input{padding:0 7px;width:250px}.btn-primary{color:#FFF}.btn-primary:hover{color:#444}.clear{clear:both;height:1;width:100%;background:none!important;border:none!important}#datatable_wrapper .dt-buttons {margin:0 0 10px 0;}
        .seo-box{display:none}
        .btn{margin:0 2px}.yellow{color:#ff8f00}.green{color:#008000}
        #seo-box-title{
            position:relative;
            background-color:#e4f5ff;
            padding:6px 10px;
            cursor:pointer
        }
        #seo-box-title:after{
            content:"";
            display:block;
            position:absolute;
            height:0;
            width:0;
            border-top: 10px solid #f97314;
            border-left:5px solid transparent;
            border-right:5px solid transparent;
            top:15px;
            right:10px;
        }
        #seo-box-title.active:after{border-bottom: 10px solid #f97314;border-top:none!important}
        .txt-center{text-align:center;}
        .list-news-trending li{list-style:none!important;}
        #datatable_paginate{text-align:right;}
        #datatable_paginate a{display:inline-block;padding:5px 10px;background:#e4e4e4;color:#4a85fb;margin:2px}
        #datatable_paginate a.current, #datatable_paginate a:hover{display:inline-block;padding:5px 10px;background:#4a85fb;color:#fff;margin:2px}.thin{font-weight:400}
        .entry-inner.highlight {
            background:url('images/quote-double.png') no-repeat 50% 40px rgba(63, 170, 97, 0.1);
            padding:90px 20px 40px 20px;
            border-radius:20px;
            margin:40px 0
        }
         .entry-inner.highlight p {
            font-size:1.0rem;
            font-family:'droid-serif'!important;
            text-align:center
        }
        .button {
            display: inline-block;
            vertical-align: middle;
            margin: 0 0 1rem 0;
            padding: 0.85em 1em;
            border: 1px solid transparent;
            border-radius: 0;
            -webkit-transition: background-color 0.25s ease-out, color 0.25s ease-out;
            transition: background-color 0.25s ease-out, color 0.25s ease-out;
            font-family: inherit;
            font-size: 0.9rem;
            -webkit-appearance: none;
            line-height: 1;
            text-align: center;
            cursor: pointer;
            background-color: #1779ba;
            color: #fefefe;
        }
        .rounded {
            border-radius: 30px;
            color: #FFF;
            padding: 12px 50px
        }
        .bg-gradient-green {
            background: linear-gradient(90.43deg, #3FAA61 0.4%, #3FAF61 39.59%, #3FBD61 84.45%, #3FC361 99.66%);
        }
        .required::after{
            content: " *";
            color: #C03;
        }
        .token-input-dropdown-facebook {z-index: 99999!important;}
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="<?php echo base_url('admin/assets');?>/js/jquery-ui.min.js"></script>
    <script type="text/javascript">var domain = '<?php echo base_url();?>';</script>  
    
</head>