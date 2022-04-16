<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="/ourteam/edit" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Vị trí</th>
                                <th>Image</th>
                                <th>Tên</th>
                                <th>Trạng thái</th>
                                <th>Nhóm</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($members)) : foreach($members as $key => $value) : ?>
                            <tr id="row-item-<?=$value->id;?>">
                                <td><?=$value->order;?></td>
                                <td style="max-width:100px" class="text-center">
                                    <img src="<?php echo $value->imageUrl ?>" alt="Logo" style="max-width:100px;height:60px">
                                </td>
                                <td><a href="/ourteam/edit/<?php echo $value->id; ?>"><?php echo $value->name; ?></a></td>
                                <td class="text-center"><?php echo $value->status_name ?></td>
                                <td class="text-center"><?php echo $value->group_name ?></td>
                                <td class="center">
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="<?php echo base_url('ourteam/edit/' . $value->id);?>"><i class="fa fa-pencil-square-o"></i></a>&nbsp;
                                    <?php /*
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="javascript:;" onclick="change_status(<?php echo $value->id; ?>);return false;">
                                    <span class="status-txt-<?php echo $value->id; ?>" <?php if($value->status != 1) echo 'style="display:none;color:red"';?>> <i class="fa fa-eye-slash orange"></i> </span>
                                    <span class="status-txt-<?php echo $value->id; ?>" <?php if($value->status == 1) echo 'style="display:none;color:blue"';?>> <i class="fa fa-eye green"></i> </span>
                                    </a>&nbsp;
                                    <a class="btn-default btn" style="margin:5px 0;padding:0 3px" href="javascript:;" onclick="delete_item(<?=$value->id;?>);return false;"><i class="fa fa-times red"></i></a>
                                    */ ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="7"><h3>We could not found any portfolios!!!</h3></td></tr>
                            </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
