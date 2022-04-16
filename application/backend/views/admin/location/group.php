<section class="content">
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title">Thông tin nhóm</h4>
                </div>
                <div class="box-body">
                    <?php if ( ! $group) : ?>
                        <div class="alert alert-warning"><p>Can not found this group!</p></div>
                    <?php else : ?>
                        <form action="" method="post" id="filterForm">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Nhóm cha</label>
                                <input type="text" name="parent_id" id="token-input-location" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Tên nhóm</label>
                                <input type="text" name="name" class="form-control " value="<?php echo $group->name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm" type="submit"> <i class="fa fa-floppy-o"></i> Lưu </button>
                        </div>
                        </form>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <p style="margin:10px 0">
                        <a class="btn-success btn btn-sm" style="color:#FFF" href="<?php echo base_url('location/locationGroup');?>"> <i class="fa fa-plus"></i> Thêm mới</a>
                    </p>
                </div>
                <div class="box-body">
                    <table id="datatable" class="table table-bordered table-hover" data-controller="<?php echo $this->router->fetch_class();?>">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php if($listGroup) : foreach ($listGroup as $key => $val) : ?>    
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $val->name; ?></td>
                                    <td> <a href="<?php echo base_url('location/locationGroup/' . $val->id); ?>" class=btn btn-xs btn-default> <i class="fa fa-pencil" style="color: blue"></i> </a> </td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>