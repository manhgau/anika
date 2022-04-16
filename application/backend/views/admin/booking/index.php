<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form action="" method="get">
                    <div class="box-header row" style="margin: 10px 0 0 0;padding: 10px 0 0px 0;">
                        <div class="col-xs-3">
                            <label>Thanh toán</label>
                            <select id="status-filter" name="status" class="form-control filter">
                                <option value=""> -- Tất cả -- </option>
                                <option value="1" <?php if($filters['status']==1) echo 'selected="selected"'; ?>> Đã thanh toán </option>
                                <option value="2" <?php if($filters['status']==2) echo 'selected="selected"'; ?>> Chưa thanh toán </option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label>Trạng thái xử lý</label>
                            <select id="status-filter" name="process_status" class="form-control filter" >
                                <option value=""> -- Tất cả -- </option>
                                <option value="1" <?php if($filters['process_status']==STATUS_PUBLISHED) echo 'selected="selected"'; ?>> Đã xử lý </option>
                                <option value="2" <?php if($filters['process_status']==STATUS_PENDING) echo 'selected="selected"'; ?>> Đang chờ </option>
                                <option value="3" <?php if($filters['process_status']==STATUS_DELETED) echo 'selected="selected"'; ?>> Đã xóa </option>
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
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Thời gian</th>
                                <th>Tour</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($bookings) : foreach ($bookings as $key => $val) : ?>
                                <tr>
                                    <td><?php echo $val->id; ?></td>
                                    <td><?php echo $val->id; ?></td>
                                    <td><?php echo $val->name; ?></td>
                                    <td><?php echo $val->phone; ?></td>
                                    <td><?php echo $val->email; ?></td>
                                    <td><?php echo date( 'H:i d/m/Y', strtotime($val->created_time) );?></td>
                                    <td><?php
                                        $_tour = $val->tour;
                                        if ($_tour)
                                        {
                                           echo '<a href="', config_item('main_domain'), $_tour->slugname, '-prod', $_tour->id, '.html" target="_blank">', $_tour->title, '</a>'; 
                                        }
                                        ?></td>
                                    <td><?php echo $val->process_status; ?></td>
                                    <td><?php echo ($val->payment_return) ? $val->payment_return : ''; ?></td>
                                    <td><?php echo $val->id; ?></td>
                                </tr>
                            <?php endforeach; else : ?>
                                <tr>
                                    <td colspan="9">
                                        Could not found any bookings!!!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>