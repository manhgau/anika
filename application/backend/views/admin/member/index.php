<?php 
    $statusFilter = $this->member_model->getStatus();
    $member = $this->member_model->getList();
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
                                <input id="find-keyword" class="form-control" name="keyword" value="" placeholder="Nhập họ tên/số điện thoại/Email">
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
                            <div class="col-md-2">
                                <label>Phòng ban</label>
                                <?php
                                $department = toArray($department);
                                $departments = ['' => '--- Tất  cả ---'] + array_combine(array_column($department, 'id'), array_column($department, 'name') );
                                echo form_hidden('postDepartment', json_encode($departments));
                                echo form_element([
                                    'name' => 'department_id',
                                    'type' => 'select',
                                    'value' => '',
                                    'options' => $departments,
                                ]);
                                ?>
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
                            'department_id' => 'Phòng ban',
                            ''=>'Thao tác',
                        ], true, true);
                        ?>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    const SETTING_DEPARTMENT = JSON.parse($('[name="postDepartment"]').val())
    const columnValues = [
        {
            targets: 0,
            width: '5%',
            render: function (data, type, full, meta){
                return '<input type="checkbox" name="id[]">';
            }
        },

        {
            targets: 5,
            width: '12%',
            render: function (data, type, full, meta){
                return SETTING_DEPARTMENT[data] || '';
            }
        },
        {
            targets: 6,
            render: function (data, type, full, meta){
                return `
                <p>
                    <a href="/member/edit/${full.id}" class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o text-primary"></i></a>
                    <a href="#" onclick="confirmRemove(${full.id}); return false;" class="btn btn-xs btn-default"><i class="fa fa-trash-o text-danger"></i></a>
                    <br>
                    <a href="#" onclick="confirmTogglePublic(${full.id}, ${data}); return false;" class="btn btn-xs btn-default" title="${(data=='public') ? 'Khóa' : 'Mở'}"><i class="fa fa-refresh"></i></a>
                </p>
                `;
            }
        },
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
    // function bunk_delete(e, dt, node, config) {
    //     var confirm_msg = 'Bạn muốn xóa dữ liệu?';
    //     var buttons = {
    //         'Ok' : function(){ exec_delete(dt); },
    //         'Cancel': function(){ $(this).dialog('close'); }
    //     };
    //     confirm_dialog(confirm_msg,buttons);
    // }
    var confirmRemove = (id) => {
        confirmAction('execRemove('+id+')', 'Xóa bản ghi này?', 'Xóa');
    }

    var execRemove = (id) => {
        $.post('/member/apis/delete', {id}, (res) => {
            (res.code===200)
                ? _redrawPage()
                : showMessage(res.msg, 'error')
        })
    }

    var confirmTogglePublic = (id, currentPublic='public') => {
        let msg = (currentPublic=='public') ? 'Khóa tài khoản này?' : 'Mở tài khoản này?';
        confirmAction('togglePublic('+id+')', msg, (currentPublic=='public') ? 'Khóa' : 'Mở');

    }

    var togglePublic = (id) => {
        $.post('/member/apis/togglePublic', {id}, (res) => {
            _redrawPage()
        })
    }

</script>