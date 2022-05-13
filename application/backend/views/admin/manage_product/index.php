<?php 
    $statusFilter = $this->manage_product_model->getStatus();
    $product = $this->manage_product_model->getList();
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/manage_product/getListProductData" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="find-keyword">Tìm kiếm</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="" placeholder="Tên sản phẩm">
                            </div>
                            <div class="col-md-2">
                                <label>Danh mục</label>
                                <?php
                                    $category_product = toArray($category_product);
                                    $categoryOptions = ['' => '--- Tất  cả ---'] + array_combine( array_column($category_product, 'id'), array_column($category_product, 'title') );
                                    echo form_hidden('productCategories', json_encode($categoryOptions));
                                    echo form_element([
                                        'name' => 'category_id',
                                        'value' => '',
                                        'type' => 'select',
                                        'options' => $categoryOptions,
                                    ]);
                                ?>
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
                                <a class="btn btn-sm btn-default" href="<?php echo base_url('manage_product');?>"> <i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr class="line">
                    <div class="box-body table-responsive" style="padding-bottom:350px">
                        <?php 
                        
                        echo dataTable([
                            'id' => '<input type="checkbox" name="select_all" class="simple" />',
                            'thumbnail' => 'Ảnh',                           
                            'title' => 'Tên sản phẩm',
                            'price' => 'Giá bán',
                            'status_name' => 'Tình trạng',
                            'category_id' => 'Danh mục',
                            'created_time' => 'Thời gian',
                            'created_by' => 'Người đăng',
                            'status' => 'Thao tác',
                        ], true, true);
                        ?>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    const PRODUCT_CATEGORIES = JSON.parse($('[name="productCategories"]').val())
    
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
            width: '10%',
            render: function (data, type, full, meta){
                return `<img src="${data}" />`;
            }
        },
        {
            targets: 3,
            render: function (data, type, full, meta){
                return `
                <p class="text-right">${number_format(data)}</p>
                `;
            }
        },
        {
            targets: 5,
            width: '12%',
            render: function (data, type, full, meta){
                return PRODUCT_CATEGORIES[data] || '';
            }
        },
        {
            targets: 7,
            render: function (data, type, full, meta){
                return `${full.created_by_user.name}`;
            }
        },
        {
            targets: 8,
            render: function (data, type, full, meta){
                return `
                <p>
                    <a href="/manage_product/edit/${full.id}" class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o text-primary"></i></a>
                    <a href="#" onclick="confirmRemoveNews(${full.id}); return false;" class="btn btn-xs btn-default"><i class="fa fa-trash-o text-danger"></i></a>

                    <a href="#" onclick="confirmTogglePublic(${full.id},'${data}'); return false;" class="btn btn-xs btn-default" title="${(data=='public') ? 'Ẩn bài' : 'Công khai'}"><i class="fa fa-refresh"></i></a>
                </p>
                `;
            }
        }
    ];

    const tableButtons = [
        {
            text: '<i class="fa fa-plus"></i> Thêm mới',
            className: 'btn btn-sm btn-success',
            action: function ( e, dt, node, config ) {
                location.href = '/manage_product/edit'
            }
        },
        {   text : '<i class="fa fa-trash"></i> Xóa',
            className:"btn btn-sm btn-danger",
            action: function(e, dt, node, config) {
            callApiSelectedRows('/manage_product/apis/deleteAll', 'Có xóa danh sách đã chọn không ?', 'Đồng ý')
            
            },

        },
        // {   text : '<i class="fa fa-trash"></i> Xóa',
        //     className:"btn btn-sm btn-danger",
        //     action: function ( e, dt, node, config ) {
        //         callApiSelectedRows('/manage_product/delete', 'Có xóa danh sách đã chọn không ?')
        //         var buttons = {
        //             'Ok' : function(){ exec_delete(dt); },
        //             'Cancel': function(){ $(this).dialog('close'); }
        //         };
        //     }
        // },
        // {
        //     text: '<i class="fa fa-upload"></i> Tải lên danh sách',
        //     className: 'btn btn-sm btn-primary',
        //     action: function ( e, dt, node, config ) {
        //         showModal('/manage_product/importModal')
        //     }
        // }
    ];
    // function exec_delete(dt) {
    //     var controller = $('#datatable').data('controller');
    //     var sRows = dt.rows('.selected');
    //     var dts = sRows.data();
    //     var ids = [];
    //     for (var i = 0; i < dts.length; i++) {
    //         ids.push(dts[i][0]);
    //     }
    //     if(ids.length==0) {
    //         showMessage('Sorry! Bạn chưa chọn item nào.');
    //         return false;
    //     }
    //     $.ajax({
    //         url: baseUrl+controller+'/delete',
    //         type:'post',
    //         dataType:'json',
    //         data:{ids:ids}
    //     }).done(location.reload());
    // }

    var confirmRemoveNews = (id) => {
        confirmAction('execRemoveNews('+id+')', 'Xóa bài viết này?', 'Xóa');
    }

    var execRemoveNews = (id) => {
        $.post('/manage_product/apis/delete', {id}, (res) => {
            (res.code===200)
                ? _redrawPage()
                : showMessage(res.msg, 'error')
        })
    }

    var confirmTogglePublic = (id, currentPublic='public') => {
        let msg = (currentPublic=='public') ? 'Ẩn bài viết này?' : 'Công khai bài viết này?';
        confirmAction('togglePublic('+id+')', msg, (currentPublic=='public') ? 'Ẩn bài' : 'Công khai');
    }

    var togglePublic = (id) => {
        $.post('/manage_product/apis/togglePublic', {id}, (res) => {
            _redrawPage()
        })
    }
    // $(function(){
    //     $('.delete-btn').on('click',function(){
    //         var url = $(this).attr('href');
    //         $.get( url, function( data ) {
    //             location.reload();
    //         });
    //         return false;
    //     });
    // });
    function exec_delete() {
    console.log(rows_selected);
    }

</script>