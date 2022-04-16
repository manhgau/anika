<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="box-header">
                        <button class="btn btn-primary small" onclick="add_more_sale();return false;"><i class="fa fa-plus"></i> Thêm mới</button>
                    </div>
                    <table id="example2" class="table table-bordered table-hover" style="margin:10px 0 0 0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá gốc</th>
                                <th>Giá bán</th>
                                <th>Tỉ lệ giảm giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list_product)) : foreach($list_product as $key => $product) : ?>
                                <tr>
                                    <td><?=++$key;?></td>
                                    <td>
                                        <h4><a href="<?=base_url('admin/product/edit/'.$product->id)?>"><?php echo $product->name; ?></a> </h4>
                                        <p>
                                            <!-- <button class="btn btn-sm edit" onclick="window.location='<?=base_url('admin/product/edit/'.$product->id)?>'"><i class="fa fa-edit blue"></i> Sửa</button>-->
                                            <button class="btn btn-sm edit" data-id="<?php echo $product->id;?>" data-price="<?=$product->sale_price;?>"><i class="fa fa-edit blue"></i> Sửa</button>
                                            <button class="btn btn-sm destroy-saleoff" data-id="<?=$product->id?>"><i class="fa fa-minus-circle red"></i> Hủy khuyến mãi</button>
                                        </p>
                                    </td>
                                    <td><?php echo number_format($product->price) . ' VNĐ'; ?></td>
                                    <td><?php echo number_format($product->sale_price) . ' VNĐ'; ?></td>
                                    <td><?php echo ceil((1-($product->sale_price/$product->price))*100) . ' %'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any saleoffs!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
<div id="modal-form" style="display:none"></div>
<script src="<?php echo base_url('tempAdmin');?>/js/jquery.blockUI.js" type="text/javascript"></script>
<script type="text/javascript">
    
    $('.edit').click(function(){
        $('#modal-form').toggle();
        var id=$(this).attr('data-id'),price=$(this).attr('data-price'),html ='<div class="modal-item"><label>Giá bán</label><input type="text" name="sale_price" value="'+parseInt(price)+'" /><input type="hidden" name="product_id" value="'+id+'" /></div><p><button class="btn btn-primary btn-sm" onclick="save_saleoff_product();return false;">Lưu</button>&nbsp;<button onclick="cancel_edit();return false;" class="btn btn-danger btn-sm cancel-btn">Hủy</button></p>';
        dialog(html);
    });
    $('.destroy-saleoff').on('click',function(){
        if(window.confirm('Bạn có hủy khuyến mãi này????')){
            var url = domain+'admin/saleoff/destroy_product/'+$(this).attr('data-id');
            $.get(url,function(data){location.reload();});
        }
    });
    function cancel_edit(){
        $.unblockUI();$('#modal-form').toggle();$('#modal-form').empty();
    }
    function save_saleoff_product() {
        var id=$('#modal-form').find('input[name="product_id"]').val(),sale_price=$('#modal-form').find('input[name="sale_price"]').val(),url=domain+'admin/saleoff/save_product_saleoff/'+id+'/'+sale_price;
        $.get(url,function(data){location.reload();});
        return false;
    }
    function add_more_sale() {
        var html='<div class="modal-item"><label>Mã sản phẩm</label><input type="text" name="product_model" value="" class="form-control" /></div><div class="modal-item"><label>Giá bán</label><input type="text" name="sale_price" value="" class="form-control" /></div><p><button class="btn btn-primary btn-sm" onclick="add_product_saleoff();return false;">Lưu</button>&nbsp;<button onclick="cancel_edit();return false;" class="btn btn-danger btn-sm cancel-btn">Hủy</button></p>';
        dialog(html);
        return false;
    }
    $('#modal-form').find('input[name="product_model"]').click(function(){alert('click');});
    function add_product_saleoff(){
        var sale_price=$('#modal-form').find('input[name="sale_price"]').val(),
        product_model=$('#modal-form').find('input[name="product_model"]').val(),
        url=domain+'admin/saleoff/add_product_saleoff/';
        $.post(url,{sale_price:sale_price,product_model:product_model},function(data){location.reload();});
        return false;
    }
    function dialog(html){
        $('#modal-form').html(html);
        $.blockUI({ message: $('#modal-form') });
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
        $('.blockOverlay').click(function(){$('#modal-form').toggle();$('#modal-form').empty();});
    }
    function hidden_dialog() {
        $.unblockUI();$('#modal-form').toggle();$('#modal-form').empty();
    }
</script>