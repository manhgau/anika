<?php 
    $statusFilter = $this->member_model->getStatus();
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/member/getDataGrid" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="find-keyword">Từ khóa</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="">
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
                            <div class="col-md-3">
                                <?php echo dateRangePicker() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-search"></i> Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr class="line">
                    <div class="box-body table-responsive" style="padding-bottom:350px">
                        <?php 
                        echo dataTable([
                            'id' => '<input type="checkbox" name="select_all" class="simple" />',
                            'fullname' => 'Họ và tên',
                            'phone' => 'Số điện thoại',
                            'email' => 'Email',
                            'status_name' => 'Trạng thái',
                            'point' => 'Điểm<br>hiện có',
                            'used_point' => 'Điểm<br>đã sử dụng',
                            'news_viewed' => 'Bài đã xem',
                            'created_time' => 'Ngày đăng ký',
                            'last_login' => 'Đăng nhập<br>gần nhất',
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
            targets: 1,
            width: '20%',
            render: function (data, type, full, meta){
                return `
                <p>
                    ${data}<br>
                    <a href="#" onclick="showModal('/pointload/modalRecharge/${full.id}'); return false;" class="btn btn-xs btn-default"><i class="fa fa-plus text-success"></i> nạp điểm</a>
                    <a href="/member/edit/${full.id}" class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o text-primary"></i> sửa</a>
                    ${(full.id!='1') ? `<a href="#" onclick="confirmRemove(${full.id}); return false;" class="btn btn-xs btn-default"><i class="fa fa-trash-o text-danger"></i> xóa</a>` : ``}
                </p>
                `;
            }
        },
        {
            targets: 5,
            className: 'text-right',
            render: function (data, type, full, meta){
                return number_format(data);
            }
        },
        {
            targets: 6,
            className: 'text-right',
            render: function (data, type, full, meta){
                return number_format(data);
            }
        },
        {
            targets: 7,
            className: 'text-right',
            render: function (data, type, full, meta){
                return number_format(data);
            }
        }
    ];

    const tableButtons = [
        {
            text: '<i class="fa fa-plus"></i> Thêm mới',
            className: 'btn btn-sm btn-success',
            action: function ( e, dt, node, config ) {
                location.href = '/member/edit'
            }
        }
    ];

    var confirmRemove = (id) => {
        confirmAction('execRemove('+id+')', 'Xóa bản ghi này?', 'Xóa');
    }

    var execRemove = (id) => {
        $.post('/member/apis/remove', {id}, (res) => {
            _redrawPage()
        })
    }

    var confirmTogglePublic = (id, currentPublic=1) => {
        let msg = (currentPublic==1) ? 'Ẩn bài viết này?' : 'Công khai bài viết này?';
        confirmAction('togglePublic('+id+')', msg, (currentPublic==1) ? 'Ẩn bài' : 'Công khai');
    }

    var togglePublic = (id) => {
        $.post('/member/apis/togglePublic', {id}, (res) => {
            _redrawPage()
        })
    }

</script>