<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <form action="" method="get" id="filterForm">
                    <div class="clearfix form-group">
                        <div class="col-xs-3">
                            <label>Quốc gia/Tỉnh thành</label>
                            <input type="text" name="parent_id" id="token-input-location" class="form-control ">
                        </div>
                        <div class="col-xs-3">
                            <label>Châu lục/Khu vực/vùng miền</label>
                            <input type="text" name="group_id" id="token-input-location-group" class="form-control ">
                        </div>
                        <div class="col-xs-2">
                            <label style="color:transparent;">&nbsp;</label><br>
                            <button class="btn btn-primary btn-sm" type="submit"> <i class="fa fa-search"></i> Tìm kiếm </button>
                        </div>
                    </div>
                    </form>
                </div>
                <hr class="line">
                <div class="box-body">
                    <?php if(isset($parentLocation) && $parentLocation) : ?>
                    <div class="form-group well">
                        <h3 style="margin:0"><?php echo $parentLocation->name ?> - <small><a href="<?php echo base_url('location/edit/' . $parentLocation->id);?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Sửa</a></small></h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <h4>Danh sách trực thuộc</h4>
                    </div>
                    <?php endif; ?>
                    
                    <table id="datatable" class="table table-bordered table-hover" data-controller="<?php echo $this->router->fetch_class();?>">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="simple" name="select_all">
                                </th>
                                <th>Tên</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>