<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <form action="" method="get" id="filterForm">
                    <div class="clearfix">
                        <div class="col-xs-3">
                            <label>Từ khóa</label>
                            <input type="text" name="keyword" class="form-control" value="<?php echo $keyword; ?>">
                        </div>
                        <div class="col-xs-2">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="">tất cả</option>
                                <option value="1" <?php if($status == 1) echo 'selected="selected"';?>>hoạt động</option>
                                <option value="2" <?php if($status == 2) echo 'selected="selected"';?>>Chờ duyệt</option>
                                <option value="3" <?php if($status == 3) echo 'selected="selected"';?>>Cảnh báo</option>
                                <option value="4" <?php if($status == 4) echo 'selected="selected"';?>>Bị chặn</option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label>Địa điểm ĐKKD</label>
                            <input type="text" name="province_id" id="token-input-parent" class="form-control">
                        </div>
                        <div class="col-xs-2">
                            <label>Mã số ĐKKD</label>
                            <input type="text" name="bussiness_code" value="<?php echo $bussiness_code; ?>" class="form-control">
                        </div>
                        <div class="col-xs-3">
                            <label style="width:100%">&nbsp;</label>
                            <button class="btn btn-primary btn-sm" type="submit"> <i class="fa fa-search"></i> Tìm kiếm </button>
                        </div>
                    </div>
                    </form>
                </div>
                <hr style="margin:10px 0">
                
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-hover" data-controller="<?php echo $this->router->fetch_class();?>">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" name="select_all" class="simple"> </th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                                <th>ĐKKD tại</th>
                                <th>Số ĐKKD</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>                   
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>