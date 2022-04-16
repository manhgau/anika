<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form method="get" action="" id="filter-form">
                <div class="box-header clearfix">
                    <div class="col-xs-3">
                        <label>Tên/Mã SP</label>
                        <input class="form-control" name="keyword" placeholder="Nhập tên hoặc mã sản phẩm"></input>
                    </div>
                    <div class="col-xs-2 hidden">
                        <label>Phân loại</label>
                        <select name="product_type" id="" class="form-control">
                            <option value="">Tất cả</option>
                            <option value="<?php echo PRODUCT_TOUR; ?>">Tour</option>
                            <option value="<?php echo PRODUCT_STAY; ?>">Khách sạn</option>
                            <option value="<?php echo PRODUCT_TRANSFER; ?>">Di chuyển</option>
                            <option value="<?php echo PRODUCT_RESTAURANT; ?>">Nhà hàng</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label>Trạng thái</label>
                        <select name="status" id="" class="form-control">
                            <option value="">Tất cả</option>
                            <option value="<?php echo STATUS_PUBLISHED; ?>">Đang bán</option>
                            <option value="<?php echo STATUS_PENDING; ?>">Chờ duyệt đăng</option>
                            <option value="<?php echo STATUS_DRAFF; ?>">Đang viết</option>
                            <option value="<?php echo STATUS_DELETED; ?>">Đã xóa</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label>Ngày tạo</label>
                        <input type="text" name="created_date" class="form-control is-datepicker" readonly="">
                    </div>
                    <div class="col-xs-2 hidden">
                        <label>Nhà cung cấp</label>
                        <input type="text" name="bussiness_id" class="form-control token-input" data-api="apis/tokenSearchBussiness" data-limit="1" data-tokenname="tokenBussiness">
                    </div>
                    <div class="col-xs-2">
                        <label>Địa điểm</label>
                        <input type="text" name="location_id" class="form-control token-input" data-api="apis/token_search_location" data-limit="1" data-tokenname="tokenLocation">
                    </div>
                    <div class="col-xs-1">
                        <label style="width:100%">&nbsp;</label>
                        <button type="submit" class="btn btn-sm btn-info" style="width:100%;text-align:center"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                </form>
                <hr class="line">

                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-hover" data-controller="<?php echo $this->router->fetch_class();?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="simple" name="select_all"></th>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Chuyên mục</th>
                                <th>Phân loại</th>
                                <th>Trạng thái</th>
                                <th>Bussiness</th>
                                <th>Thời gian</th>
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