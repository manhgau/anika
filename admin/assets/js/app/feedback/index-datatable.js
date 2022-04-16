var table, filterForm;
$(document).ready(function(){
    filterForm = $('#filter-form');
    filterForm.on('change', 'input, select', function(){
        table.ajax.reload();
    });
    filterForm.on('submit', function(e){
        e.preventDefault();
        table.ajax.reload();
    });

    var attachFileTemp = (file) => {

        return `<a href="${mediaUri}${file}" target="_blank">${file.split('/').pop()}</a>`;
    }

    table = $("#datatable").DataTable({
        "dom": "Birtlp",
        "searching":true,
        "processing": true,
        "serverSide": true,
        'select': {
          'style': 'multi'
        },
        "lengthMenu": [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"]
        ],
        "pageLength": 10,
        ajax:{
            url: '/feedback/getFeedbackDatatable',
            method:'POST',
            data:function(d){
                let fparam = filterForm.serializeArray();
                $.each(fparam, function(index, item) {
                    d[ item.name ] = item.value;
                });
            },
            dataSrc : 'data'
        },
        "columns": [
            { "data": "id" },
            { "data": "createTime" },
            { "data": "name" },
            { "data": "phone" },
            { "data": "email"},
            { "data": "type"},
            { "data": "status"},
            { "data": "message"},
        ],
        "columnDefs": [
            {
                targets: 0,
                searchable: false,
                orderable: false,
                width: '5%',
                className: 'dt-body-center',
                render: function (data, type, full, meta){
                    return data;
                }
            },
            {
                "targets": 1,
                width: '10%',
                className: 'dt-body-left text-uppercase',
                "render":function(data, type, full, meta){
                    let dt = new Date(data),
                    dtTxt = vnDateFormat(dt);
                    return dtTxt;
                }
            },
            {
                "targets": 2,
                width: '10%',
                className: 'dt-body-left text-uppercase',
                "render":function(data, type, full, meta){
                    return data;
                }
            },
            {
                "targets": 3,
                width: '10%',
                className: 'dt-body-left',
                "render":function(data, type, full, meta){
                    return data;
                }
            },
            {
                "targets": 4,
                width: '10%',
                className: 'dt-body-left',
                "render":function(data, type, full, meta){
                    return data;
                }
            },
            {
                "targets": 5,
                width: '10%',
                className: 'dt-body-left',
                "render":function(data, type, full, meta){
                    return TYPE_NAME[data];
                    // return data;
                }
            },
            {
                "targets": 6,
                width: '5%',
                className: 'dt-body-center',
                "render":function(data, type, full, meta){
                    let stt = ITEM_STATUS[data];
                    return '<a href="javascript:;" title="'+stt.name+'"><i class="'+stt.icon+'"></i></a>';
                }
            },
            {
                "targets": 7,
                width: '40%',
                className: 'dt-body-left',
                "render":function(data, type, full, meta){
                    let txt = '';
                    if (full.company_name != null) 
                        txt += '<p>- Tên công ty: <strong>'+full.company_name+'</strong></p>';
                    txt += '<p style="white-space: pre-wrap;margin-bottom: 0">'+data+'</p>';

                    if (full.attach_file!=null && full.attach_file!='') {
                        let arrFiles = full.attach_file.split(',');
                        txt += '<p><i class="fa fa-paperclip gray"></i> '+ arrFiles.map(file => attachFileTemp(file)).join(', ') +'</p>';
                    }
                    return txt;
                }
            }
        ],
        buttons: [
            /*{
                text: '<i class="fa fa-plus"></i> Thêm mới',
                className: 'btn btn-success btn-sm',
                action: function ( e, dt, node, config ) {
                    location.href = baseUrl + 'feedback/edit';
                }
            },
            {
                text: 'Ẩn',
                className: 'btn btn-warning btn-sm',
                action: function ( e, dt, node, config ) {
                    location.href = baseUrl + 'news/edit';
                }
            },
            {
                text: 'Xóa',
                className: 'btn btn-danger btn-sm',
                action: function ( e, dt, node, config ) {
                    location.href = baseUrl + 'news/edit';
                }
            }*/
        ]
    });

    $('#datatable tbody').on('click', 'tr td:nth-child(3) a', function(evt){
        evt.preventDefault();
        var $row = $(this).closest('tr');
        var data = table.row($row).data();
        let msg = (data.enable_search==1) ? 'Chặn máy tìm kiếm với Tag này?' : 'Cho phép máy tìm kiếm Index Tag này?';
        let btns = {
            'ok' : {
                'text': 'OK',
                'class': 'btn btn-sm btn-danger',
                click:function() {
                    exec_toggle_searchIndex(data.id, $row);
                    $(this).dialog('close');
                }
            },
            'cancel' : {
                'text': 'Close',
                'class': 'btn btn-sm btn-default',
                click: function(){$(this).dialog('close');}
            }
        };
        confirm_dialog(msg, btns);
    });

    $('select').find('.filter-cat').on('click',function(){
        table.ajax.reload();
    });
    
    filterForm.find('button[name="submit_search"]').on('click',function(evt){
        evt.preventDefault();
        table.ajax.reload();
    });
    
    filterForm.find('button[name="clear_filter"]').on('click',function(evt){
        evt.preventDefault();
        $('select[name=status] option:selected').removeAttr('selected');
        $('select[name=category]').val(null).trigger('change');
        $('select[name=create_by]').val(null).trigger('change');
        table.ajax.reload();
    });

    function __redrawRow(row, data) 
    {
        table.row(row).data(data).draw();
    }

    function exec_toggle_searchIndex(id, row) 
    {
        $.ajax({
            url: baseUrl + 'tag/toggleSearch',
            type: 'post',
            dataType : 'json',
            data: {id: id},
            success: function(res){
                if (res.code==0) {
                    let _data = table.row(row).data();
                    _data['enable_search'] = res.data;
                    __redrawRow(row, _data);
                }
            }
        });
    }
    
});