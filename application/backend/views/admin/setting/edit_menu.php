<div class="box-header" style="width:300px;padding:0 0 0 20px">
    <h3 class="box-title"> Chọn Menu </h3>
    <select id="select-menu-group" class="form-control" disabled="disabled">
        <?php $group_menu = config_item('menuGroup');
            foreach ($group_menu as $key => $val) : ?>
            <option value="<?=$key;?>" <?php if($key==$menu_group) echo 'selected="selected"';?>><?=$val;?></option>
            <?php endforeach; ?>
    </select>
</div><!-- /.box-header -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Sửa Menu</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputText1">Parent</label>
                        <select name="parentMenu" class="form-control">
                            <option value="0"> --- Select option --- </option>
                            <?php adminPage_select_parent_menu($tree_menu,0,$menu->parent_id,'select-parent'); ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tiêu đề:&nbsp;</label>
                        <input type="text" class="form-control" id="custome-title" placeholder="Tiêu đề menu: " value="<?php echo $menu->title;?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Link:&nbsp;</label>
                        <input type="text" class="form-control" id="custome-url" placeholder="Menu URL: " value="<?php echo $menu->url;?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Order:&nbsp;</label>
                        <input type="text" class="form-control" id="custome-order" placeholder="Menu order: " value="<?php echo $menu->order;?>">
                    </div>
                    
                    <!--<div class="form-group" id="list-image">
                        <label for="exampleInputEmail1" style="width:100%;">Icon <cite class="item-note">Kích thước: 40x40(px) Max: 50KB</cite></label>
                        <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
                        <p><span id="status"></span></p>
                        <div id="display-file">
                            <ul>
                            <li><img width="100" src="<?=get_image($menu->icon_url);?>"></li>
                            <li class="clear"></li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>-->
                    
                    <input type="hidden" id="menu-id" value="<?php echo $menu->id;?>">
                    <a href="#" onclick="save_menu();return false;" class="btn btn-default"> Save Menu </a>
                </div>
            </div><!-- /.box -->
        </div>

        <?php echo form_open_multipart('','role="form"'); ?>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Menu Listing</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="menu-listing">
                    <style type="text/css">.main-nav{margin:0;padding:0}.sub-menu{padding-left:10px}.main-nav li{list-style:none;padding:10px;}.main-nav li a{border-bottom:1px solid #ccc;display:inline-block;width:80%}</style>
                    <?php adminPage_menu_manager($tree_menu,0,'main-nav','sub-menu'); ?>
                </div>
                <hr class="line">
                <?php echo form_submit('submit','Save Menu','class="btn btn-primary"');?>
            </div><!-- /.box-primary -->
        </div>
        <?php echo form_close();?>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        $('#select-menu-group').change(function(){
            var i=$(this).val(),url='<?php echo base_url('setting/setting_menu');?>/'+i;
            window.location = url;
        });
    });
    function save_menu(){
        var a=$('input[id="menu-id"]').val(),b=$('select[name="parentMenu"]').val(),c=$('#custome-title').val(),d=$('#custome-url').val(),e=$('#custome-order').val(),img=$('#display-file').find('img').attr('src');
        if(img==undefined){img='';}
        if(c==''){alert('Tiêu đề menu không được để trống');return false;}
        if(d==''){d='#'}
        $.ajax({
            url:'<?=base_url('setting/save_menu');?>',
            type:'post',
            dataType:'html',
            data:{id:a,parent:b,name:c,url:d,order:e,img:img},
            success:function(data){
                if (data=='success') {
                    location.reload();
                } else {
                    alert(data);
                    return false;
                }
            }

        });
        return false;
    }
    function remove_menu(id) {
        if(! confirm('Bạn thực sự muốn xóa menu này???') ) {
            return false;
        }
        $.ajax({
            url:'<?php echo base_url('setting/remove_menu/');?>/'+id,
            type:'get',
            success:function(data){
                if (data=='success') {
                    location.reload();
                } else {
                    alert(data);
                    return false;
                }
            }
        });
    }
</script>