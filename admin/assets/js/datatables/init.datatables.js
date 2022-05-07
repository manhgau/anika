/*====== start init databales =====*/
var table;
var rows_selected = [];
// var tableButtons = [];
// var columnValues = [];

const _redrawPage = () => 
{
    table.ajax.reload(null, false)
}

const callApi = (api, data)=>{
  
        (response.code===200)
        ? _redrawPage()
        : showMessage(response.msg, 'error');
    
}

const callApiSelectedRows = (api, alert='Chưa chọn bản ghi nào')=>{
    $.when( reloadSelectedRows() )
    .done(()=>{
        (rows_selected.length==0)
        ? showMessage('Chưa chọn đối tượng nào.', 'error')
        : confirmAction(`execSelectedAction('${api}')`, alert, 'Đồng ý');
    })
}

const execSelectedAction = (api) => {
    callApi(api, {selectedId:rows_selected})
   
}

const button = (title, href=null, onclick=null, icon='fa fa-pencil-square-o') =>
{
    return `<a href="${(href!==null) ? href : 'javascript:;'}" ${(onclick==null) ? '' : `onclick="${onclick}"`} class="btn btn-xs btn-default" title="${title}"><i class="${icon}"></i></a>`
}

const reloadSelectedRows = (callback=null) => {
    rows_selected = [];
    var sRows = table.rows('.selected'),
    dts = sRows.data();
    for (var i = 0; i < dts.length; i++) {
        rows_selected.push(dts[i].id);
    }
    if (callback!=null && typeof callback=='function') {
        callback(rows_selected);
    }
}

const reloadReportView = (data) => {
    if (filterReport.offset())
    {
        $.each(data, (index, value) => {
            let fm = ( Number.isInteger(value)==true ) ? '0,0' : '0,0.00';
            filterReport.find('.number.'+index).text( numeral(value).format(fm) );
        })
    }
}

const updateDataTableSelectAllCtrl = (table) => {
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
    } else {
        chkbox_select_all.checked = true;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = true;
        }
    }
}

const filterForm = $('#filter-form');
const filterReport = $('#filter-report');
const searchBtn = filterForm.find('button');
const tableField = $.parseJSON($('input[name="tableField"]').val());
const hasExport = parseInt($('input[name="exportTool"]').val());

const exportButton = {
    extend: 'collection',
    text: 'Export',
    className:'btn btn-sm btn-primary',
    buttons: [
        'copy',
        'excel',
        // 'csv',
        'pdf',
        'print'
    ]
};

if (hasExport==1) {
    tableButtons.push(exportButton);
}

$(document).ready(function () {

    filterForm.on('change', 'input, select', () => {
        table.ajax.reload();
    });

    table = $('#datatable').DataTable({
        dom: "Britlp",
        pageLength: 10,
        "oLanguage": {
            "sSearch": "Tìm kiếm:&nbsp;",
        },
        lengthMenu: [ 10, 25, 50, 75, 100 ],
        "processing": true,
        "serverSide": true,
        "ordering": false,
        ajax: {
            url : filterForm.attr('action'),
            type:'post',
            data : function(d) {
                let param = filterForm.serializeArray();
                $.each(param, function(index, item){
                    d[item.name] = item.value;
                });
            },
            dataSrc : 'data'
        },
        columns: tableField,
        columnDefs: columnValues,
        buttons : tableButtons,
        order: [[0, 'desc']],
        rowCallback: function (row, data, dataIndex) {
            // Get row ID
            var rowId = data[0];
            // If row ID is in the list of selected row IDs
            if ($.inArray(rowId, rows_selected) !== -1) {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }
        },
        'drawCallback': function(settings) {
            // reload report view
            reloadReportView(settings.json.report);
            $('thead input[name="select_all"]').prop("checked", false)
        }
    });

    // handle item action
    table.on('click', 'tbody .action-btn', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let act = $(this).data('action');
        let row = $(this).closest('tr');
        // let dt = $(this).parent().parent().parent().parent().parent();
        switch(act) {
          case 'edit':
            bunk_edit_item(id);
            break;
          case 'view_detail':
            bunk_view_detail($(this));
            break;
          case 'cancel_order':
            bunk_cancel($(this));
            break;
          default:
            return false;
        }
    });

    // SINGLE SELECTION
    $('#datatable tbody').on('click', 'input[type="checkbox"]', function (e) {
        var $row = $(this).closest('tr');
        var data = table.row($row).data();
        var rowId = data[0];
        var index = $.inArray(rowId, rows_selected);
        if (this.checked && index === -1) {
            rows_selected.push(rowId);
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
        // updateDataTableSelectAllCtrl(table);
    });

    searchBtn.on('click', function(e){
        e.preventDefault();
        table.ajax.reload();
    });
});

/*====== end init databales =====*/