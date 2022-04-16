<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Sửa thông tin</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('setting/edit_option/'.$option->id));?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Tên thông tin: " value="<?=htmlspecialchars($option->name)?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <?php echo form_textarea(['name'=>'name_desc', 'value'=>$option->name_desc, 'class'=>'form-control', 'rows'=>3]); ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kiểu dữ liệu</label>
                        <input type="text" name="var_type" class="form-control" id="name" placeholder="Kiểu dữ liệu: " value="<?php echo $option->var_type; ?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giá trị</label>
                        <div id="input-value">
                            <?php 
                                if($option->var_type=='int') 
                                    echo '<input type="text" class="form-control input-value" name="value" value="'.$option->value.'">';
                                elseif ($option->var_type =='string')
                                    echo '<textarea name="value" rows="4" class="form-control input-value">'.$option->value.'</textarea>';
                                elseif ($option->var_type =='html')
                                    echo '<textarea name="value" class="form-control input-value" id="tinymce">'.$option->value.'</textarea>';
                                else {
                                    echo '<div id="upload-img">
                                            <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
                                            <p><span id="status"></span></p>
                                            <style type="text/css">#display-file ul,#display-file li{list-style:none;margin:10px 0;padding:0}#display-file img{border:1px solid #ccc;padding:5px;width:auto!important;max-width:100%}#display-file .insert_img_content{display:none}</style>
                                            <div id="display-file"> <ul><li><img src="'.get_image($option->value).'"><input type="hidden" name="value" value="'.$option->value.'" class="input-value"/></ul> </div>
                                        </div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_submit('submit','Lưu','class="btn btn-primary"');?>
                    </div>
                </div>
                <?php
                    echo form_close();
                ?>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        $('#select-type').change(function(){
            var i=$(this).val();
            if(i=='int') {
                t = '<input type="text" class="form-control input-value" name="value" value="'+'<?=$option->value;?>'+'">';
            } else {
                t='<textarea name="value" class="form-control input-value" id="tinymce">'+'<?=$option->value;?>'+'</textarea>';
            }
            $('#input-value').html(t);
        });
    });
</script>