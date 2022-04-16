<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form action="" method="get" id="filter-form">
                    <div class="box-header row" style="margin: 10px 0 0 0;padding: 10px 0 0px 0;">
                        <div class="col-xs-3">
                            <label>Ngày gửi yêu cầu</label>
                            <input class="form-control datepicker" name="request_date" placeholder="Nhập ngày" readonly="readonly">
                        </div>
                        <div class="col-xs-2">
                            <label>Trạng thái xử lý</label>
                            <select id="status-filter" name="status" class="form-control filter" >
                                <option value=""> -- Tất cả -- </option>
                                <option value="1" <?php if($filters['status'] == STATUS_PUBLISHED) echo 'selected="selected"'; ?>> Đã xử lý </option>
                                <option value="4" <?php if($filters['status'] == 4) echo 'selected="selected"'; ?>> Đang xử lý </option>
                                <option value="2" <?php if($filters['status'] == STATUS_PENDING) echo 'selected="selected"'; ?>> Chờ xử lý </option>
                                <option value="3" <?php if($filters['status'] == STATUS_DELETED) echo 'selected="selected"'; ?>> Đã xóa </option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label style="width:100%">&nbsp;</label>
                            <button class="btn btn-sm btn-info"><i class="fa fa-search"></i> Lọc</button>
                        </div>
                    </div>
                </form>
                <hr class="line">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?php echo $this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="simple" id="check-all" name="select_all"></th>
                                <th>Gửi lúc</th>
                                <th>Khách hàng</th>
                                <th>Dịch vụ</th>
                                <th>Tên dịch vụ</th>
                                <th>Thời gian</th>
                                <th>Số người</th>
                                <th>Ghi chú</th>
                                <th>Trạng thái</th>
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