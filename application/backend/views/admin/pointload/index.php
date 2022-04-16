<?php 
    $typeFilter = $this->pointload_model->getType();
?>

<section class="content">
    <div class="form-group text-center">
        <label class="btn btn-primary">
            <strong style="font-size:18px"><?php echo number_format($report->point + $report->used_point) ?></strong>
            <br>Đã phát hành
        </label>
        <label class="btn btn-success">
            <strong style="font-size:18px"><?php echo number_format($report->point) ?></strong>
            <br>Chưa sử dụng
        </label>
        <label class="btn btn-default">
            <strong style="font-size:18px"><?php echo number_format($report->used_point) ?></strong>
            <br>Đã sử dụng
        </label>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/pointload/getDataGrid" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="find-keyword">UserID/Email/Phone</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="">
                            </div>
                            <div class="col-md-2">
                                <label>Phân loại</label>
                                <select class="form-control" name="type">
                                    <option value="">--- Tất cả ---</option>
                                    <?php foreach ($typeFilter as $key => $value): ?>
                                        <option value="<?php echo $key ?>"><?php echo $value['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <?php echo dateRangePicker() ?>
                            </div>
                            <div class="col-xs-12 col-md-1" style="padding-top:23px">
                                <button type="submit" class="btn btn-block btn-primary"> <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr class="line">
                    <div class="box-body table-responsive" style="padding-bottom:350px">
                        <?php 
                        echo dataTable([
                            'id' => 'Mã GD',
                            'created_time' => 'Thời gian',
                            'amount' => 'Số điểm',
                            'type_name' => 'Phân loại',
                            'member_name' => 'Thành viên',
                            'member_phone' => 'Số điện thoại',
                            'member_email' => 'Email',
                            'note' => 'Ghi chú'
                        ], true, true);
                        ?>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    const columnValues = [
        {
            targets: 2,
            width: '10%',
            className: 'text-right',
            render: function (data, type, full, meta){
                return `<span class="${(data<0) ? 'text-danger' : 'text-success'}">${(data<0) ? data : '+'+data}</span>`
            }
        }
    ];

    const tableButtons = [
        {
            text: '<i class="fa fa-plus"></i> Nạp điểm',
            className: 'btn btn-sm btn-success',
            action: function ( e, dt, node, config ) {
                showModal('/pointload/modalRecharge');
            }
        }
    ];

</script>