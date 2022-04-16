$(document).ready(function () {
    var rows_selected = [];
    var controller = $('#datatable').data('controller');
    var filterForm = $('form#filter-form');

    var table = $('#datatable').DataTable({
        dom: "Birtlp",
        pageLength: 20,
        "oLanguage": {
            "sSearch": "Tìm kiếm:&nbsp;"
        },
        lengthMenu: [ 10, 20, 50, 75, 100 ],
        "processing": true,
        "serverSide": true,
        ajax: {
            url : domain + 'product/getProductData',
            type:'post',
            data : function(d) {
                d.keyword = filterForm.find('input[name="keyword"]').val();
                d.product_type = filterForm.find('select[name="product_type"] option:selected').val();
                d.status = filterForm.find('select[name="status"] option:selected').val();
                d.created_date = filterForm.find('input[name="created_date"]').val();
                d.bussiness_id = filterForm.find('input[name="bussiness_id"]').val();
                d.location_id = filterForm.find('input[name="location_id"]').val();
            },
            dataSrc : 'data'
        },
        columns: [
            {data: 'id'},
            {data: 'id'},
            {data: 'title'},
            {data: 'category'},
            {data: 'product_type'},
            {data: 'status'},
            {data: 'bussiness'},
            {data: 'created_time'},
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
                className: 'dt-body-left',
                width: '40px',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 2,
                searchable: false,
                orderable: false,
                className: 'dt-body-left',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                targets: 3,
                searchable: false,
                orderable: false,
                width: '10%',
                render : function (data, type, full, meta) {
                    return data.title;
                }
            },
            {
                targets: 4,
                searchable: false,
                orderable: false,
                width: '10%',
                render : function (data, type, full, meta) {
                    if (data == 1)
                        return 'Tour';
                    if (data == 2)
                        return 'Vận chuyển';
                    if (data == 3)
                        return 'Khách sạn';
                    if (data == 4)
                        return 'Nhà hàng';
                }
            },
            {
                targets: 5,
                searchable: false,
                orderable: false,
                width: '50px',
                render : function (data, type, full, meta) {
                    var cl = '';
                    var title = 'Đang bán';
                    if (data == 1) {
                        cl = 'fa-check green';
                    }
                    if (data == 2) {
                        cl = 'fa-minus yellow';
                        title = 'Chờ duyệt/ẩn';
                    }
                    if (data == 3) {
                        cl = 'times red';
                        title = 'Đã xóa';
                    }
                    if (data == 4) {
                        cl = 'fa-pencil-square-o';
                        title = 'Đang soạn';
                    }
                    return '<i class="fa '+cl+'" title="'+title+'"></i>';
                }
            },
            {
                targets: 6,
                searchable: false,
                orderable: false,
                width: '10%',
                render : function (data, type, full, meta) {
                    return data.display_name;
                }
            },
            {
                targets: 7,
                searchable: false,
                orderable: false,
                width: '60px',
                render : function (data, type, full, meta) {
                    return data;
                }
            },
            {
                targets: 8,
                searchable: false,
                orderable: false,
                // className: 'dt-body-right',
                width: '80px',
                render : function (data, type, full, meta) {
                    var btns = '<div class="btn-group">';
                    btns += '<button type="button" class="btn btn-sm btn-warning">Thao tác</button>';
                    btns += '<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
                    btns += '<ul class="dropdown-menu pull-right">';
                    btns += '<li><a href="'+baseUrl+'product/edit/'+data+'"><i class="fa fa-pencil-square"></i> Sửa</a></li>';
                    btns += '<li><a href="'+baseUrl+'product/editPrice/'+data+'"><i class="fa fa-pencil-square"></i> Sửa giá</a></li>';
                    btns += '<li><a href="javascript:;" data-id="'+data+'" class="act-active"><i class="fa fa-paper-plane-o"></i> Duyệt đăng</a></li>';
                    btns += '<li><a href="javascript:;" data-id="'+data+'" class="act-deactive"><i class="fa fa-minus-square"></i> Ẩn SP</a></li>';
                    btns += '<li><a href="javascript:;" data-id="'+data+'" class="act-delete"><i class="fa fa-trash-o"></i> Xóa</a></li>';
                    btns += '</ul>';
                    btns += '</div>';
                    return btns;
                }
            }
        ],
        buttons : [
            // {text : '<i class="fa fa-plus"></i> Thêm mới', action : bunk_addnew, className:"btn btn-sm btn-success"},
            // {text : '<i class="fa fa-trash"></i> Xóa', action : bunk_delete, className:"btn btn-sm btn-danger"},
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

    //Ajax reload callback
    filterForm.find('button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    //action for delete item button
    table.on('click', 'a.act-delete', function() {
        var id = $(this).data('id');
        var msg = lang.confirm_action;
        var btns = {
            'ok' : {
                'text': lang.confirm,
                'class': 'btn btn-xs btn-danger',
                'click': function() {
                    $(this).dialog('close');
                    exec_delete_product(id, table);
                }
            },
            'cancel' : {
                'text': lang.cancel,
                'class': 'btn btn-xs btn-default',
                'click': function() {
                    $(this).dialog('close');
                }
            }
        };
        confirm_dialog(msg, btns);
    });

    //action for active item button
    table.on('click', 'a.act-active', function() {
        var id = $(this).data('id');
        var msg = lang.confirm_action;
        var btns = {
            'ok' : {
                'text': lang.confirm,
                'class': 'btn btn-xs btn-success',
                'click': function() {
                    $(this).dialog('close');
                    exec_active_product(id, table);
                }
            },
            'cancel' : {
                'text': lang.cancel,
                'class': 'btn btn-xs btn-default',
                'click': function() {
                    $(this).dialog('close');
                }
            }
        };
        confirm_dialog(msg, btns);
    });

    //action for active item button
    table.on('click', 'a.act-deactive', function() {
        var id = $(this).data('id');
        var msg = lang.confirm_action;
        var btns = {
            'ok' : {
                'text': lang.confirm,
                'class': 'btn btn-xs btn-danger',
                'click': function() {
                    $(this).dialog('close');
                    exec_deactive_product(id, table);
                }
            },
            'cancel' : {
                'text': lang.cancel,
                'class': 'btn btn-xs btn-default',
                'click': function() {
                    $(this).dialog('close');
                }
            }
        };
        confirm_dialog(msg, btns);
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


function deleteAct(id) {
    var msg = lang.confirm_action;
    var btns = {
        'ok' : {
            'text': lang.confirm,
            'class': 'btn btn-xs btn-danger',
            'click': function() {
                $(this).dialog('close');
                exec_delete_product(id);
            }
        },
        'cancel' : {
            'text': lang.cancel,
            'class': 'btn btn-xs btn-default',
            'click': function() {
                $(this).dialog('close');
            }
        }
    };
    confirm_dialog(msg, btns);
}

function exec_delete_product(id, eTable) {
    $.ajax({
        url: baseUrl + 'apis/changeStatusProduct',
        type:'post',
        dataType: 'json',
        data:{id:id, status:3},
        success: function(res) {
            if(res.code == 0)
            {
                eTable.rows( function ( idx, data, node ) {
                    return data[1] === id;
                } ).remove().draw();
            }
        }
    });
}

function exec_active_product(id, eTable) {
    $.ajax({
        url: baseUrl + 'apis/changeStatusProduct',
        type:'post',
        dataType: 'json',
        data:{id:id, status:1},
        success: function(res) {
            if(res.code == 0)
            {
                eTable.draw();
            }
        }
    });
}

function exec_deactive_product(id, eTable) {
    $.ajax({
        url: baseUrl + 'apis/changeStatusProduct',
        type:'post',
        dataType: 'json',
        data:{id:id, status:4},
        success: function(res) {
            if(res.code == 0)
            {
                eTable.draw();
            }
        }
    });
}

function bunk_delete(e, dt, node, config) {
    var confirm_msg = 'Bạn muốn xóa dữ liệu?';
    var buttons = { 
        'Ok' : function(){ exec_delete(dt); },
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
    }).done(location.reload());
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
        url: baseUrl+''+controller+'/publish',
        type:'post',
        dataType:'json',
        data:{ids:ids,status:2}
    }).done(function(resp){
        if(resp.code==0){
            //dt.rows('.selected').remove().draw();
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
        url: baseUrl+''+controller+'/publish',
        type:'post',
        dataType:'json',
        data:{ids:ids,status:1}
    }).done(function(resp) {
        if (resp.code==0) {
            //dt.rows('.selected').remove().draw();
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
