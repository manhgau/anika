<?php 
    $statusFilter = $this->postrequest_model->getStatus();
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/member/getPostGrid" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
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
                                        <option value="<?php echo $key ?>" <?php echo (@$filter['status']==$key) ? 'selected="selected"' : '' ?>><?php echo $value['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <?php echo dateRangePicker() ?>
                            </div>
                            <div class="col-xs-12 col-md-1">
                                <button type="submit" class="btn btn-block btn-primary"> <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr class="line">
                    <div class="box-body table-responsive" style="padding-bottom:350px">
                        <?php 
                        echo dataTable([
                            'id' => '<input type="checkbox" class="simple"/>',
                            'created_time' => 'Thời gian',
                            'url' => 'Link Facebook',
                            'point' => 'Số điểm',
                            'member_name' => 'Người gửi',
                            'status_name' => 'Trạng thái',
                            'answer_by_name' => 'Người trả lời',
                            'realnews_id' => 'Bài viết',
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
            width:'25%',
            render: function (data, type, full, meta){
                return `${(full.title) ? full.title : ''}<br><a href="${data}" target="_blank">Link Facebook`;
            }
        },
        {
            targets: 3,
            className: 'text-right text-danger',
            render: function (data, type, full, meta){
                return number_format(data);
            }
        },
        {
            targets: 6,
            className: 'text-right',
            render: function (data, type, full, meta){
                let m = `${(data) ? data : ''}<br>${(full.answer_time) ? full.answer_time : ''}`;
                if (full.status == 'pending') {
                    m +=  `<br><label class="btn btn-xs btn-primary" onclick="showModal('/member/modalPostProcess/${full.id}')"><i class="fa fa-reply"></i> trả lời</label>`
                };
                return m;
            }
        },
        {
            targets: 7,
            render: function (data, type, full, meta){
                return (!!data) 
                    ? `<a href="/realnews/edit/${data}" target="_blank" class="btn btn-xs btn-link">Chi tiết &raquo;</a>`
                    : '';
            }
        }
    ];

    const tableButtons = [
        {
            text: '<i class="fa fa-plus"></i> Thêm mới',
            className: 'btn btn-sm btn-success',
            action: function ( e, dt, node, config ) {
                location.href = '/member/postEdit'
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