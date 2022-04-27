<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('relationship/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:20px">STT</th>
                                <th>Logo</th>
                                <th>Tên</th>
                                <th>Hot</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($relationships)) : foreach($relationships as $key => $relationship) : ?>
                            <tr id="row-item-<?=$relationship->id;?>">
                                <td><?= ++$key;?></td>
                                <td style="max-width:150px">
                                    <img src="<?php echo ($relationship->image_trans) ? get_image($relationship->image_trans) : get_image($relationship->image); ?>" alt="Logo" style="max-width:100px;height:60px">
                                </td>
                                <td style="max-width:350px">
                                    <?php echo $relationship->name; ?>
                                </td>
                               
                                <td class="text-center"><?php echo ($relationship->is_hot==1) ? '<i class="fa fa-star orange"></i>' : ''; ?></td>
                                <td class="text-center"> 
                                    <?php echo ($relationship->status==1) ? '<i class="fa fa-check green"></i>' : ''; ?>
                                </td>
                               
                                <td class="text-center"><p>
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="<?php echo base_url('relationship/edit/' . $relationship->id);?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Sửa</a>&nbsp;
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="javascript:;" onclick="change_status(<?php echo $relationship->id; ?>);return false;">
                                    <span class="status-txt-<?php echo $relationship->id; ?>" <?php if($relationship->status != 1) echo 'style="display:none;color:red"';?>> Ẩn </span>
                                    <span class="status-txt-<?php echo $relationship->id; ?>" <?php if($relationship->status == 1) echo 'style="display:none;color:blue"';?>> Hiện </span>
                                    </a>&nbsp;
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="javascript:;" onclick="delete_item(<?=$relationship->id;?>);return false;"><i class="glyphicon glyphicon-remove"></i>&nbsp;Xóa</a>
                                </p></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="5"><h3>We could not found any relationships!!!</h3></td></tr>
                            </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script type="text/javascript">
    function change_status(id){
        var u=domain+'admin/relationship/change_status/'+id;
        if(confirm('Bạn thực sự muốn thay đổi???')) {
            $.ajax({
                url:u,
                type: 'get',
                success: function(data){
                    $('#status-'+id).parent('div').toggleClass('checked');
                    $('.status-txt-'+id).toggle();
                }
            });
            return false;
        } else {return false;}
    }
    function delete_item(id){
        var u=domain+'admin/relationship/delete/'+id;
        if(confirm('Bạn thực sự muốn xóa???')) {
            $.ajax({
                url:u,
                type: 'get',
                success: function(data){
                    $('#row-item-'+id).remove()
                }
            });
            return false;
        } else {return false;}
    }
    
</script>