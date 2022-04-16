/**
* Created by longn on 18-Feb-18.
*/
$(document).ready(function(){
    var filterCategory = $('select[name="category"]');
    var table = $("#datatable").DataTable({
        searching:true,
        serverSide:true,
        ajax:{
            url: domain + 'news/getListNewsData/',
            method:'POST',
            data:function(d){
                var category=$('select[name="category"] option:selected').val();
                var status = $('select[name=status] option:selected').val();
                var create_by = $('select[name=create_by] option:selected').val();
                d.category=category;
                d.create_by=create_by;
                d.status=status;
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "title" },
            { "data": "author" },
            { "data": "category"},
            { "data": "create_time"},
            { "data": "public_time"},
            { "data": "status"},
            { "data": "is_hot"},
            { "data": "id"}
        ],
        buttons: [
            {
                text: 'Viết bài mới',
                className: 'btn btn-info btn-sm',
                action: function ( e, dt, node, config ) {
                    location.href = baseUrl + 'news/edit';
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
            }
        ],
        "columnDefs": [
            {
                targets: 0,
                searchable: true,
                'checkboxes': {
                    'selectRow': true
                 },
                orderable: false,
                width: '1%',
                className: 'dt-body-center',
                render: function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]">';
                }
            },
            {
                "targets": 1,
                "render":function(data,type,row){
                    return data;
                },
                "sortable": false
            },
            {
                "targets": 2,
                "render":function(data,type,row){
                    return '<a href="?create_by='+data.id+'">'+data.name+'</a>';
                    //return '<a href="?created_by='+data._id['$id']+'">'+data.full_name+'</a>';
                    //return 'Author';
                },
                "orderable": false
            },
            {
                "targets":3,
                "orderable":false,
                "render":function(data,type,row){
                    return '<a href="?category='+data.id+'">'+data.name+'</a>';
                }
            },
            {
                "targets":4,
                "orderable":false,
                "render":function(data,type,row){
                    return data;
                }
            },
            {
                "targets":5,
                "orderable":false,
                "render":function(data,type,row){
                    return data;
                }
            },
            {
                "targets":6,
                "orderable":false,
                "render":function(data,type,row){
                    if(data == 1 )
                        return '<i class="fa fa-check green"></i>';
                    if(data == 2 )
                        return '<i class="fa fa-check yellow"></i>';
                    if(data == 3 )
                        return '<i class="fa fa-times red"></i>';
                }
            },
            {
                "targets":7,
                "orderable":false,
                "render":function(data,type,row){
                    return (data==1) ? '<i class=" fa fa-star" style="color:#fda709"></i>' : '';
                }
            },
            {
                "targets":8,
                "orderable":false,
                "render":function(data,type,row){
                    var txt = '';
                    txt += '<a href="'+baseUrl+'news/edit/'+data+'" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>';
                    return txt;
                }
            }
        ],
        'select': {
          'style': 'multi'
       },
        "lengthMenu": [
            [20, 50, 100, -1],
            [20, 50, 100, "All"]
        ],
        "pageLength": 50,
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    });

    $('#datatable tbody').on('click', 'button.btn-delete', function(evt){
        var id = $(this).attr('data-id');
        var row = table.row($(this).parents('tr'));
        var data = row.data();
        if(confirm('Ooop! Bạn có thực sự muốn xóa bài viết này không?'))
        {
            $.ajax({
                type:'post',
                url: baseUrl + 'article/delete',
                dataType:'json',
                data:{id:id},
                success: function(res){
                    if(res.code==0)
                    {
                        table.row(row).data(data).remove().draw();
                    }
                }
            });
        }
    });
    
    $('select').find('.filter-cat').on('click',function(){
        table.ajax.reload();
    });
    
    $('form[name=form-filter]').find('button[name="submit_search"]').on('click',function(evt){
        evt.preventDefault();
        table.ajax.reload();
    });
    
    $('form[name=form-filter]').find('button[name="clear_filter"]').on('click',function(evt){
        evt.preventDefault();
        $('select[name=status] option:selected').removeAttr('selected');
        $('select[name=category]').val(null).trigger('change');
        $('select[name=create_by]').val(null).trigger('change');
        table.ajax.reload();
    });
    
});