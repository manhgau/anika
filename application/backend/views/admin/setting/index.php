<section class="content">
    <div class="row">
        <!-- left column -->
        <?php echo form_open_multipart('','role="form"'); ?>
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Cài đặt website</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <div class="box-body">                       
                    <div class="form-group">
                        <label for="exampleInputEmail1">Slogan</label> <?php echo form_error('slogan');?>
                        <?php echo form_input('slogan',set_value('slogan',$setting->slogan),'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputText1"> Địa chỉ </label> <?php echo form_error('address');?>
                        <?php echo form_input('address',set_value('address',$setting->address),'class="form-control"'); ?>
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputText1">Điện thoại di động</label> <?php echo form_error('phone');?>
                        <?php echo form_input('phone',set_value('phone',$setting->phone),'class="form-control"'); ?>
                    </div>                        
                    <div class="form-group">
                        <label for="exampleInputEmail1">Điện thoại cố định</label> <?php echo form_error('telephone');?>
                        <?php echo form_input('telephone',set_value('telephone',$setting->telephone),'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Email giao dịch </label>
                        <?php echo form_input('email',set_value('email',$setting->email),'class="form-control" placeholder="Email:"'); ?>
                        <?php echo form_input('email_password',set_value('email_password',$setting->email_password),'class="form-control" placeholder="Mật khẩu:"'); ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Facebook Fanpage</label> <?php echo form_error('facebook_fanpage');?>
                        <?php echo form_input('facebook_fanpage',set_value('facebook_fanpage',$setting->facebook_fanpage),'class="form-control"'); ?>
                    </div>                       

                    <div class="form-group">
                        <label for="exampleInputEmail1">Facebook App_id</label> <?php echo form_error('fb_app_id');?>
                        <?php echo form_input('fb_app_id',set_value('fb_app_id',$setting->fb_app_id),'class="form-control"'); ?>
                    </div>                       

                    <div class="form-group">
                        <label for="exampleInputEmail1">GooglePlus Page</label> <?php echo form_error('gplus_page');?>
                        <?php echo form_input('gplus_page',set_value('gplus_page',$setting->gplus_page),'class="form-control"'); ?>
                    </div>                      

                    <div class="form-group">
                        <label for="exampleInputEmail1">Youtube Chanel</label> <?php echo form_error('youtube_chanel');?>
                        <?php echo form_input('youtube_chanel',set_value('youtube_chanel',$setting->youtube_chanel),'class="form-control"'); ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Twiter Page</label> <?php echo form_error('twiter_page');?>
                        <?php echo form_input('twiter_page',set_value('twiter_page',$setting->twiter_page),'class="form-control"'); ?>
                    </div>                    

                    <div class="form-group">
                        <label for="exampleInputEmail1"> RSS link </label>
                        <?php echo form_input('rss_link',set_value('rss_link',$setting->rss_link),'class="form-control"'); ?>
                    </div>                                      

                    <div class="form-group">
                        <label for="exampleInputEmail1"> Nội dung chân trang 01 </label>
                        <?php echo form_textarea('footer_text_1',set_value('footer_text_1',$setting->footer_text_1),'class="form-control" id="tinymce"'); ?>
                    </div>                                      

                    <div class="form-group">
                        <label for="exampleInputEmail1"> Nội dung chân trang 02 </label>
                        <?php echo form_textarea('footer_text_2',set_value('footer_text_2',$setting->footer_text_2),'class="form-control" id="tinymce1"'); ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> Hỗ trợ kinh doanh </label> <?php echo form_error('rss_link');?>
                        <cite>cách nhau bằng dấu phảy: ","</cite>
                        <?php echo form_input('sale_support_phone',set_value('sale_support_phone',$setting->sale_support_phone),'class="form-control" placeholder="Số điện thoại:"'); ?>
                        <div style="border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;padding:5px">
                            <div>
                                <label for="exampleInputEmail1" style="display:block;text-align:center;text-transform:uppercase"> Online Support </label>
                                <table style="width:100%;margin:0 auto;">
                                    <tr id="sale-support-yahoo-table">
                                        <th>Tên nhân viên</th>
                                        <th>Yahoo</th>
                                        <th>Skype</th>
                                    </tr>
                                    <?php if($setting->sale_support_yahoo != '') : 
                                        $array_data = json_decode($setting->sale_support_yahoo); 
                                        $array_skype = json_decode($setting->sale_support_skype);
                                        foreach($array_data as $key => $val) :
                                    ?>
                                    <tr>
                                        <td><input type="text" name="sale_yahoo_name[]" class="form-control" value="<?php echo $val->name;?>"></td>
                                        <td><input type="text" name="sale_yahoo_acc[]" class="form-control" value="<?php echo $val->acc;?>"></td>
                                        <td><input type="text" name="sale_skype_acc[]" class="form-control" value="<?php echo $array_skype[$key]->acc;?>"></td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </table>
                                <a href="#" onclick="add_more_sale_support_yahoo();return false;" class="btn btn-sm btn-primary" style="float:right">Thêm mới</a>
                                <div style="clear:both"></div>
                            </div>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> Hỗ trợ kỹ thuật </label>
                        <cite>cách nhau bằng dấu phảy: ","</cite>
                        <?php echo form_input('tech_support_phone',set_value('tech_support_phone',$setting->tech_support_phone),'class="form-control" placeholder="Số điện thoại:"'); ?>
                        <div style="border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;padding:5px">
                            <div>
                                <label for="exampleInputEmail1" style="display:block;text-align:center;text-transform:uppercase"> Online Support </label>
                                <table style="width:100%;margin:0 auto;">
                                    <tr id="tech-support-yahoo-table">
                                        <th>Tên nhân viên</th>
                                        <th>Yahoo</th>
                                        <th>Skype</th>
                                    </tr>
                                    <?php if($setting->tech_support_yahoo != '' && $setting->tech_support_yahoo != 'null') : 
                                        $array_data = json_decode($setting->tech_support_yahoo);
                                        $tech_skype = json_decode($setting->tech_support_skype);
                                        foreach($array_data as $key => $val) :
                                    ?>
                                    <tr>
                                        <td><input type="text" name="tech_yahoo_name[]" class="form-control" value="<?php echo $val->name; ?>"></td>
                                        <td><input type="text" name="tech_yahoo_acc[]" class="form-control" value="<?php echo $val->acc; ?>"></td>
                                        <td><input type="text" name="tech_skype_acc[]" class="form-control" value="<?php echo $tech_skype[$key]->acc;?>"></td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </table>
                                <a href="#" onclick="add_more_tech_support_yahoo();return false;" class="btn btn-sm btn-primary" style="float:right">Thêm mới</a>
                                <div style="clear:both"></div>
                            </div>
                        </div>

                    </div>

                    <!--<div class="form-group">
                    <label for="exampleInputEmail1" style="width:100%;"> Top Banner </label>
                    <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
                    <p><span id="status"></span></p>
                    <div id="display-file">
                    <ul class="list-top-banner">
                    <?php if ( isset($top_banners) ) : foreach ( $top_banners as $key => $val ) : ?>
                        <li id="banner-<?=$val->id;?>">
                        <table>
                        <tr>
                        <td><img src="<?=get_image($val->img_url);?>" alt="">
                        <input type="hidden" name="bannerId[]" value="<?=$val->id;?>"/>
                        <input type="hidden" name="bannerImage[]" value="<?=$val->img_url;?>">
                        </td>
                        <td><input type="text" name="bannerTitle[]" class="form-control" placeholder="Tiêu đề:" value="<?=$val->title;?>"/></td>
                        <td><input type="text" name="bannerLink[]" class="form-control" placeholder="Đường dẫn:" value="<?=$val->out_link;?>"/></td>
                        <td><input type="text" name="bannerOrder[]" class="form-control" placeholder="Vị trí:" value="<?=$val->order;?>"/></td>
                        <td style="width:120px"><a style="display:inline-block" class="btn btn-default" href="<?php echo base_url('admin/setting/banner_edit/'.$val->id); ?>"> Sửa </a>&nbsp;<a class="btn btn-default" style="display:inline-block" href="javascript:;" onclick="delete_banner(<?=$val->id;?>)"> Xóa </a></td>
                        </tr>
                        </table>
                        </li>
                        <?php endforeach; endif; ?>
                    <li class="clear hidden"></li>
                    </ul>
                    </div>
                    <div class="clear"></div>
                    </div>-->
                    <hr> 
                    <div class="clear"></div>                     
                </div><!-- /.box-body -->
                <div class="box-footer" style="clear: both;">
                    <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                </div>
            </div><!-- /.box -->
        </div>
        <?php echo form_close();?>
    </div>
</section>
<script type="text/javascript">
    function delete_banner(i) {
        $.ajax({
            url : '<?=base_url('setting/delete_banner');?>/'+i,
            type : 'get',
            success:function(data){
                $('li#banner-'+i).remove();
                return false;
            }

        })
    }
    function add_more_sale_support_yahoo(){
        var t='<tr><td><input type="text" name="sale_yahoo_name[]" class="form-control"></td><td><input type="text" name="sale_yahoo_acc[]" class="form-control"></td><td><input type="text" name="sale_skype_acc[]" class="form-control"></td></tr>';
        $('#sale-support-yahoo-table').after(t);
    }
    function add_more_tech_support_yahoo(){
        var t='<tr><td><input type="text" name="tech_yahoo_name[]" class="form-control"></td><td><input type="text" name="tech_yahoo_acc[]" class="form-control"></td><td><input type="text" name="tech_skype_acc[]" class="form-control"></td></tr>';
        $('#tech-support-yahoo-table').after(t);
    }
</script>