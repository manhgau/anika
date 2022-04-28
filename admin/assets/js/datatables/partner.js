$(document).ready(function () {
    var rows_selected = [];
    var controller = $('#datatable').data('controller');
    
    var table = $('#datatable').DataTable({
        dom: "Bfrtip",
        pageLength: 10,
        "oLanguage": {
            "sSearch": "Tìm kiếm:&nbsp;"
        },
        lengthMenu: [ 10, 20, 50, 75, 100],
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
            }
        ],
        buttons : [
            {text : '<i class="fa fa-plus"></i> Thêm mới', action : bunk_addnew, className:"btn btn-sm btn-success"},
            
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

function bunk_unlock(e, dt, node, config) {
    var confirm_msg = 'Bạn muốn thực hiện thao tác này?';
    var buttons = { 
        'Ok' : function(){ exec_unlock(dt); },
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
        url: baseUrl+'cms/'+controller+'/publish',
        type:'post',
        dataType:'json',
        data:{ids:ids,unPublish:1}
    }).done(function(resp){
        if(resp.code==0){
            dt.rows('.selected').remove().draw();
            close_dialog();
        } else {
            showMessage(resp.msg);
        }
    });
}

function exec_unlock(dt) {
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
        url: baseUrl+'cms/'+controller+'/publish',
        type:'post',
        dataType:'json',
        data:{ids:ids,unPublish:0}
    }).done(function(resp){
        if(resp.code==0){
            dt.rows('.selected').remove().draw();
            close_dialog();
        } else {
            showMessage(resp.msg);
        }
    });
}

function close_dialog(){
    $('.ui-dialog-titlebar-close').trigger('click');
}
