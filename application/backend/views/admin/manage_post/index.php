<?php 
    $statusFilter = $this->manage_post_model->getStatus();
    $typeFilter = $this->manage_post_model->getType();
    $serviceFilter = $this->manage_post_model->getService();
    $post = $this->manage_post_model->getList();
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/manage_post/getListPostData" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="find-keyword">Tìm kiếm</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="" placeholder="Mã bài/Sđt chủ/Tên sản phẩm">
                            </div>
                            <div class="col-md-2">
                                <label>Danh mục</label>
                                <?php
                                    $category_post = toArray($category_post);
                                    $categoryOptions = ['' => '--- Tất  cả ---'] + array_combine(array_column($category_post, 'id'), array_column($category_post, 'name') );
                                    echo form_hidden('postCategories', json_encode($categoryOptions));
                                    echo form_element([
                                        'name' => 'category_id',
                                        'type' => 'select',
                                        'options' => $categoryOptions,
                                    ]);
                                    // print_r($categoryOptions);
                                    // exit();
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-search"></i> Tìm kiếm</button>
                                <!-- <a class="btn btn-sm btn-default" href="<?php echo base_url('mange_post');?>"> <i class="fa fa-refresh"></i>Reset</a> -->
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
                            'title' => 'Tên bài viết',
                            'category_id' => 'Danh mục',
                            'is_public' => 'Công khai',
                            'created_time' => 'Thời gian',
                            'created_by' => 'Người đăng',
                            '' => 'Thao tác',
                        ], true, true);
                        ?>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    const PRODUCT_CATEGORIES = JSON.parse($('[name="postCategories"]').val())
    
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
            targets: 4,
            className:"text-center",
            render: function (data, type, full, meta){
                return `
                    <span class="${(data==1) ? 'text-success' : 'text-muted'}">${(data==1) ? 'Công khai' : 'Tạm ẩn'}</span><br>
                    <a href="#" onclick="confirmTogglePublic(${full.id}, ${data}); return false;" class="btn btn-xs btn-default" title="${(data==1) ? 'Ẩn bài' : 'Công khai'}"><i class="fa fa-refresh"></i></a>
                `;
                // <i class="fa ${(data==1) ? 'fa-check green' : 'fa-minus text-muted'}"></i><br>
            }
        },
        {
            targets: 6,
            render: function (data, type, full, meta){
                return `${full.created_by_user.name}`;
            }
        },
        {
            targets: 7,
            render: function (data, type, full, meta){
                return `
                <p>
                    <a href="/manage_post/edit/${full.id}" class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o text-primary"></i></a>
                    <a href="#" onclick="confirmRemoveNews(${full.id}); return false;" class="btn btn-xs btn-default"><i class="fa fa-trash-o text-danger"></i></a>
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
                location.href = '/manage_post/edit'
            }
        },
        {
            text: '<i class="fa fa-upload"></i> Tải lên danh sách',
            className: 'btn btn-sm btn-primary',
            action: function ( e, dt, node, config ) {
                showModal('/manage_post/importModal')
            }
        }
    ];

    var confirmRemoveNews = (id) => {
        confirmAction('execRemoveNews('+id+')', 'Xóa bài viết này?', 'Xóa');
    }

    var execRemoveNews = (id) => {
        $.post('/manage_post/apis/removeNews', {id}, (res) => {
            (res.code===200)
                ? _redrawPage()
                : showMessage(res.msg, 'error')
        })
    }

    var confirmTogglePublic = (id, currentPublic=1) => {
        let msg = (currentPublic==1) ? 'Ẩn bài viết này?' : 'Công khai bài viết này?';
        confirmAction('togglePublic('+id+')', msg, (currentPublic==1) ? 'Ẩn bài' : 'Công khai');
    }

    var togglePublic = (id) => {
        $.post('/manage_post/apis/togglePublic', {id}, (res) => {
            _redrawPage()
        })
    }

</script>