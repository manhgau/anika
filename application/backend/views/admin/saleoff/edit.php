<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <?php echo form_open('','role="form"');?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name</label>&nbsp;<?php echo form_error('name','<span class="error">','</span>'); ?>
                        <?php echo form_input('name',set_value('name',$saleoff->name),'class="form-control"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mã chương trình</label>&nbsp;<?php echo form_error('code','<span class="error">','</span>'); ?>
                        <?php echo form_input('code',set_value('code',$saleoff->code),'class="form-control"'); ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Slugname</label>&nbsp;<?php echo form_error('slug','<span class="error">','</span>'); ?>
                        <?php echo form_input('slug',set_value('slug',$saleoff->slug),'class="form-control"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">% Giảm giá</label>&nbsp;<?php echo form_error('off_percent','<span class="error">','</span>'); ?>
                        <?php echo form_input('off_percent',set_value('off_percent',$saleoff->off_percent),'class="form-control"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chi tiết chương trình</label>&nbsp;<?php echo form_error('description','<span class="error">','</span>'); ?>
                        <?php echo form_textarea('description',set_value('description',$saleoff->description),'class="form-control" id="tinymce"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Trạng thái</label>&nbsp;<?php echo form_error('status','<span class="error">','</span>'); ?>
                        <?php echo form_checkbox('status','1',($saleoff->status==1) ? TRUE : FALSE, 'class="form-control"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Sản phẩm áp dụng</label>
                        <table style="margin-left:40px;">
                            <tr>
                                <td>Nhóm sản phẩm</td>
                                <td><?php echo form_dropdown('product_type',$tree_types,(isset($saleoff->product_type)) ? end(explode(',',$saleoff->product_type)) : 'null','class="form-control" id="product-type"');?> </td>
                            </tr>
                            <tr>
                                <td>Chọn sản phẩm</td>
                                <td><input type="text" id="demo-input-facebook-theme" name="list_product" style="width:600px;" placeholder="tên sản phẩm?" /> </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group">
                        <label>Date and time range:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="reservationtime" name="timerange" value="<?php echo date('d/m/Y H:i A',$saleoff->begin_time);?> - <?php echo date('d/m/Y H:i A',$saleoff->end_time);?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số lượng sản phẩm</label>&nbsp;<?php echo form_error('product_limit','<span class="error">','</span>'); ?>
                        <?php echo form_input('product_limit',set_value('product_limit',$saleoff->product_limit),'class="form-control"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số lượng khách hàng</label>&nbsp;<?php echo form_error('customer_limit','<span class="error">','</span>'); ?>
                        <?php echo form_input('customer_limit',set_value('customer_limit',$saleoff->product_limit),'class="form-control"'); ?>
                    </div>
                    
                    <hr class="line">
                    <h3 class="form-title">SEO Options</h3>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Meta title</label>
                        <?php echo form_input('meta_title',set_value('meta_title',$saleoff->meta_title),'class="form-control"'); ?>
                        <?php echo form_error('meta_title'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Meta description</label>
                        <?php echo form_textarea('meta_description',set_value('meta_description',$saleoff->meta_description),'class="form-control"'); ?>
                        <?php echo form_error('meta_description'); ?>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <?php echo form_submit('submit','Save','class="btn btn-primary"'); ?>
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script src="<?php echo base_url('tempAdmin');?>/js/jquery.tokeninput.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("input#demo-input-facebook-theme").tokenInput("<?php echo base_url('admin/product/token_search'); ?>", {                   
            theme : "facebook",
            tokenDelimiter: ",",
            preventDuplicates: true,
            <?php if(isset($json_list_product)) : ?>
            prePopulate : <?php echo $json_list_product; ?>
            <?php endif; ?>
        });
    });
</script>