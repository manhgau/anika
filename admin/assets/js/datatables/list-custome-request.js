$(document).ready(function () {
    var rows_selected = [];
    var controller = $('#datatable').data('controller');
    var filterForm = $('form#filter-form');
    filterForm.on('submit', function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
    var table = $('#datatable').DataTable({
        dom: "Bfrtip",
        pageLength: 50,
        "oLanguage": {
            "sSearch": "Tìm kiếm:&nbsp;"
        },
        lengthMenu: [ 10, 25, 50, 75, 100 ],
        "processing": true,
        "serverSide": true,
        ajax: {
            url: domain + 'booking/getListCustomeRequest',
            type: 'post',
            data: function (d) {
                d.requestDate = filterForm.find('input[name="request_date"]').val();
                d.status = filterForm.find('select[name="status"] option:selected').val();
            },
            dataSrc: 'data'
        },
        columns: [
            {data: 'id'},
            {data: 'created_time'},
            {data: 'customer'},
            {data: 'type'},
            {data: 'service'},
            {data: 'service_time'},
            {data: 'person_number'},
            {data: 'note'},
            {data: 'status'},
            {data: 'id'}
        ],
        columnDefs: [
            {
                targets: 0,
                searchable: false,
                orderable: false,
                width: '1%',
                className: 'dt-body-center',
                render: function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]">';
                }
            },
            {
                targets: 1,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 2,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 3,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 4,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 5,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 6,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-center',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 7,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 8,
                searchable: false,
                orderable: false,
                // width: '1%',
                className: 'dt-body-center',
                render: function (data, type, full, meta) {
                    if (data == 1) {
                        return '<i class="fa fa-check green" title="đã đăng"></i>';
                    } 
                    if(data==2 || data==0) {
                        return '<i class="fa fa-minus yellow" title="chờ duyệt"></i>';
                    }
                    if(data==3){
                        return '<i class="fa fa-times red" title="đã xóa"></i>';
                    }
                }
            },
            {
                targets: 9,
                render: function (data, type, full, meta) {
                    var txt = '';
                    txt += '<a href="'+baseUrl+'booking/editCustomeRequest/'+data+'" class="btn btn-xs btn-default" title="Sửa"><i class="fa fa-pencil blue"></i></a>';
                    // txt += '<a class="btn-default btn-xs btn delete-btn" href="#" data-href="'+baseUrl+'booking/delete/'+data+'" title="Xóa"><i class="fa fa-trash-o red"></i></a>';
                    
                    return txt;
                }
            }
        ],
        buttons : [
            {text : '<i class="fa fa-plus"></i> Thêm mới', action : bunk_addnew, className:"btn btn-sm btn-success"},
            {text : '<i class="fa fa-eye-slash"></i> Đánh dấu đã xử lý', action : bunk_processed, className:"btn btn-sm btn-warning"},
            {text : '<i class="fa fa-trash-o"></i> Xóa', action : bunk_delete, className:"btn btn-sm btn-danger"},
            // {text : '<i class="fa fa-paper-plane-o"></i> Duyệt đăng', action : bunk_public, className:"btn btn-sm btn-info"},
            // {text : '<i class="fa fa-lock"></i> Khóa bài viết', action : bunk_lock, className:"btn btn-sm btn-warning"},
        ],
        order: [[0, 'desc']],
        rowCallback: function (row, data, dataIndex) {
            // Get row ID
            var rowId = data[0];
            // If row ID is in the list of selected row IDs
            if ($.inArray(rowId, rows_selected) !== -1) {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }
        }
    });

    // SINGLE SELECTION
    $('#datatable tbody').on('click', 'input[type="checkbox"]', function (e) {
        var $row = $(this).closest('tr');
        // Get row data
        var data = table.row($row).data();

        // Get row ID
        var rowId = data[0];

        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);

        // If checkbox is checked and row ID is not in list of selected row IDs
        if (this.checked && index === -1) {
            rows_selected.push(rowId);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1) {
            rows_selected.splice(index, 1);
        }

        if (this.checked) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }

        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });
    $('#datatable').on('click', 'tbody tr td:first-child, thead th:first-child', function (e) {
        $(this).parent().find('input[type="checkbox"]').trigger('click');
    });
    $('thead input[name="select_all"]', table.table().container()).on('click', function (e) {
        if (this.checked) {
            $('#datatable tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('#datatable tbody input[type="checkbox"]:checked').trigger('click');
        }
        e.stopPropagation();
    });
    // Handle table draw event
    table.on('draw', function () {
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);
    });
});

function bunk_delete(e, dt, node, config) {
    var confirm_msg = 'Bạn muốn xóa yêu cầu này?';
    var buttons = { 
        'Ok' : function(){ exec_delete(dt); },
        'Cancel': function(){ $(this).dialog('close'); }
    };
    confirm_dialog(confirm_msg,buttons);
}

function bunk_processed(e, dt, node, config) {
    var confirm_msg = 'Bạn muốn đánh dấu đã xử lý booking này?';
    var buttons = { 
        'Ok' : function(){ exec_processed(dt); },
        'Cancel': function(){ $(this).dialog('close'); }
    };
    confirm_dialog(confirm_msg,buttons);
}

function bunk_lock(e, dt, node, config) {
    var confirm_msg = 'Bạn muốn thực hiện thao tác này?';
    var buttons = { 
        'Ok' : function(){ exec_lock(dt); },
        'Cancel': function(){ $(this).dialog('close'); }
    };
    confirm_dialog(confirm_msg,buttons);
}

function bunk_public(e, dt, node, config) {
    var confirm_msg = 'Bạn muốn thực hiện thao tác này?';
    var buttons = { 
        'Ok' : function(){ exec_public(dt); },
        'Cancel': function(){ $(this).dialog('close'); }
    };
    confirm_dialog(confirm_msg,buttons);
}

function bunk_addnew() {
    var control = $('#datatable').data('controller');
    location.href=baseUrl+control+"/edit";
}

function updateDataTableSelectAllCtrl(table) {
    var $table = table.table().node();
    var $chkbox_all = $('tbody input[type="checkbox"]', $table);
    var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
    var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

    // If none of the checkboxes are checked
    if ($chkbox_checked.length === 0) {
        chkbox_select_all.checked = false;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = false;
        }

        // If all of the checkboxes are checked
    } else if ($chkbox_checked.length === $chkbox_all.length) {
        chkbox_select_all.checked = true;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = false;
        }

        // If some of the checkboxes are checked
    } else {
        chkbox_select_all.checked = true;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = true;
        }
    }
}

function exec_delete(dt) {
    var controller = $('#datatable').data('controller');
    var sRows = dt.rows('.selected');
    var dts = sRows.data();
    var ids = [];
    for (var i = 0; i < dts.length; i++) {
        ids.push(dts[i][0]);
    }
    if(ids.length==0) {
        showMessage('Sorry! Bạn chưa chọn item nào.');
        return false;
    }
    $.ajax({
        url: baseUrl+controller+'/delete',
        type:'post',
        dataType:'json',
        data:{ids:ids}
    }).done(function(resp){
        if(resp.code==0) {
            dt.rows('.selected').remove().draw();
            close_dialog();
        } else {
            var msg = 'Lỗi! Không thể xóa dữ liệu';
            showMessage(msg);
        }
    });
}

function exec_processed(dt) {
    var controller = $('#datatable').data('controller');
    var sRows = dt.rows('.selected');
    var dts = sRows.data();
    var ids = [];
    for (var i = 0; i < dts.length; i++) {
        var _rowData = dts[i];
        ids.push(_rowData.id);
    }
    if(ids.length==0) {
        showMessage('Sorry! Bạn chưa chọn yêu cầu nào.');
        return false;
    }
    $.ajax({
        url: baseUrl+controller+'/customeRequestProcessed',
        type:'post',
        dataType:'json',
        data:{ids:ids}
    }).done(function(resp){
        if(resp.code==0) {
            close_dialog();
            dt.rows('.selected').remove().draw();
        } else {
            var msg = 'Lỗi! Không thể cập nhật dữ liệu';
            showMessage(msg);
        }
    });
}

function exec_lock(dt) {
    var controller = $('#datatable').data('controller');
    var sRows = dt.rows('.selected');
    var dts = sRows.data();
    var ids = [];
    for (var i = 0; i < dts.length; i++) {
        ids.push(dts[i][0]);
    }
    if(ids.length==0) {
        showMessage('Sorry! Bạn chưa chọn item nào.');
        return false;
    }
    $.ajax({
        url: baseUrl+controller+'/publish',
        type:'post',
        dataType:'json',
        data:{ids:ids,status:2}
    }).done(function(resp){
        if(resp.code==0){
//            dt.rows('.selected').remove().draw();
            close_dialog();
            location.reload();
        } else {
            showMessage(resp.msg);
        }
    });
}

function exec_public(dt) {
    var controller = $('#datatable').data('controller');
    var sRows = dt.rows('.selected');
    var dts = sRows.data();
    var ids = [];
    for (var i = 0; i < dts.length; i++) {
        ids.push(dts[i][0]);
    }
    if(ids.length==0) {
        showMessage('Sorry! Bạn chưa chọn item nào.');
        return false;
    }
    $.ajax({
        url: baseUrl+controller+'/publish',
        type:'post',
        dataType:'json',
        data:{ids:ids,status:1}
    }).done(function(resp){
        if(resp.code==0){
//            dt.rows('.selected').remove().draw();
            close_dialog();
            location.reload();
        } else {
            showMessage(resp.msg);
        }
    });
}

function close_dialog(){
    $('.ui-dialog-titlebar-close').trigger('click');
}
