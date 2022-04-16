<?php 
    $statusFilter = $this->realnews_model->getStatus();
    $typeFilter = $this->realnews_model->getType();
    $serviceFilter = $this->realnews_model->getService();
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/realnews/getListNewsData" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="find-keyword">Mã bài/Sđt chủ/tiêu đề</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="">
                            </div>
                            <div class="col-md-2">
                                <label>Dịch vụ</label>
                                <select class="form-control" name="service_type">
                                    <option value="">--- Tất cả ---</option>
                                    <?php foreach ($serviceFilter as $key => $value): ?>
                                        <option value="<?php echo $key ?>"><?php echo $value['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
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
                            <div class="col-md-2">
                                <label>Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="">--- Tất cả ---</option>
                                    <?php foreach ($statusFilter as $key => $value): ?>
                                        <option value="<?php echo $key ?>"><?php echo $value['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-search"></i> Tìm kiếm</button>
                                <a class="btn btn-sm btn-default" href="<?php echo base_url('news');?>"> <i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr class="line">
                    <div class="box-body table-responsive" style="padding-bottom:350px">
                        <?php 
                        echo dataTable([
                            'id' => '<input type="checkbox" name="select_all" class="simple" />',
                            'code' => 'Mã bài',
                            'title' => 'Tiêu đề',
                            'type_name' => 'Phân loại',
                            'service_type_name' => 'Dịch vụ',
                            'price' => 'Giá bán',
                            'rent_price_month' => 'Giá<br>thuê tháng',
                            'point' => 'Số điểm',
                            'status_name' => 'Tình trạng',
                            'is_public' => 'Công khai',
                            'created_time' => 'Thời gian',
                            'created_by' => 'Người đăng',
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
            targets: 0,
            width: '5%',
            render: function (data, type, full, meta){
                return '<input type="checkbox" name="id[]">';
            }
        },
        {
            targets: 2,
            width: '25%',
            render: function (data, type, full, meta){
                return `
                <p>
                    ${data}<br>
                    <a href="/realnews/edit/${full.id}" class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o text-primary"></i></a>
                    <a href="#" onclick="confirmRemoveNews(${full.id}); return false;" class="btn btn-xs btn-default"><i class="fa fa-trash-o text-danger"></i></a>
                </p>
                `;
            }
        },
        {
            targets: 5,
            render: function (data, type, full, meta){
                return `<p class="text-right">${number_format(data)}</p>`;
            }
        },
        {
            targets: 6,
            render: function (data, type, full, meta){
                return `<p class="text-right">${number_format(data)}</p>`;
            }
        },
        {
            targets: 7,
            render: function (data, type, full, meta){
                return `<p class="text-right">${number_format(data)}</p>`;
            }
        },
        {
            targets: 9,
            className: 'text-center',
            render: function (data, type, full, meta){
                return `
                <span class="${(data==1) ? 'text-success' : 'text-muted'}">${(data==1) ? 'Công khai' : 'Tạm ẩn'}</span><br>
                <a href="#" onclick="confirmTogglePublic(${full.id}, ${data}); return false;" class="btn btn-xs btn-default" title="${(data==1) ? 'Ẩn bài' : 'Công khai'}"><i class="fa fa-refresh"></i></a>`;
            }
        },
        {
            targets: 11,
            render: function (data, type, full, meta){
                return full.created_by_user.name;
            }
        }
    ];

    const tableButtons = [
        {
            text: '<i class="fa fa-plus"></i> Thêm mới',
            className: 'btn btn-sm btn-success',
            action: function ( e, dt, node, config ) {
                location.href = '/realnews/edit'
            }
        },
        {
            text: '<i class="fa fa-upload"></i> Tải lên danh sách',
            className: 'btn btn-sm btn-primary',
            action: function ( e, dt, node, config ) {
                showModal('/realnews/importModal')
            }
        }
    ];

    var confirmRemoveNews = (id) => {
        confirmAction('execRemoveNews('+id+')', 'Xóa bài viết này?', 'Xóa');
    }

    var execRemoveNews = (id) => {
        $.post('/realnews/apis/removeNews', {id}, (res) => {
            (res.code===200)
                ? _redrawPage()
                : showMessage(res.msg, 'error')
        })
    }

    var confirmTogglePublic = (id, currentPublic=1) => {
        let msg = (currentPublic==1) ? 'Ẩn bài viết này?' : 'Công khai bài viết này?';
        confirmAction('togglePublic('+id+')', msg, (currentPublic==1) ? 'Ẩn bài' : 'Công khai');
    }

    var togglePublic = (id) => {
        $.post('/realnews/apis/togglePublic', {id}, (res) => {
            _redrawPage()
        })
    }

</script>