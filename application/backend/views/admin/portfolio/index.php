<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('portfolio/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:80px" class="text-center">Vị trí</th>
                                <th>Logo</th>
                                <th>Tên</th>
                                <th>HOT</th>
                                <th>Trạng thái</th>
                                <th>Url</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($portfolios)) : foreach($portfolios as $key => $portfolio) : ?>
                            <tr id="row-item-<?=$portfolio->id;?>">
                                <td><?=$portfolio->order;?></td>
                                <td style="max-width:150px" class="text-center">
                                    <img src="<?php echo ($portfolio->logo) ? get_image($portfolio->logo) : ''; ?>" alt="Logo" style="max-width:100px;height:60px">
                                </td>
                                <td>
                                    <?php echo $portfolio->name; ?>
                                </td>
                                <td class="text-center"><?php echo ($portfolio->isHot==1) ? '<i class="fa fa-star orange"></i>' : ''; ?></td>
                                <td class="text-center"> 
                                    <?php echo ($portfolio->status==1) ? '<i class="fa fa-check green"></i>' : '<i class="fa fa-minus gray"></i>'; ?>
                                </td>
                                <td>
                                    <?php if ($portfolio->url): ?>
                                        <a href="<?php echo $portfolio->url ?>"><i class="fa fa-link"></i></a>
                                    <?php endif ?>
                                </td>
                                <td class="center">
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="<?php echo base_url('portfolio/edit/' . $portfolio->id);?>"><i class="fa fa-pencil-square-o"></i></a>&nbsp;
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="javascript:;" onclick="change_status(<?php echo $portfolio->id; ?>);return false;">
                                    <span class="status-txt-<?php echo $portfolio->id; ?>" <?php if($portfolio->status != 1) echo 'style="display:none;color:red"';?>> <i class="fa fa-eye-slash orange"></i> </span>
                                    <span class="status-txt-<?php echo $portfolio->id; ?>" <?php if($portfolio->status == 1) echo 'style="display:none;color:blue"';?>> <i class="fa fa-eye green"></i> </span>
                                    </a>&nbsp;
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="javascript:;" onclick="delete_item(<?=$portfolio->id;?>);return false;"><i class="fa fa-times red"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="5"><h3>We could not found any portfolios!!!</h3></td></tr>
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
        var u=domain+'admin/portfolio/change_status/'+id;
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
        var u=domain+'admin/portfolio/delete/'+id;
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