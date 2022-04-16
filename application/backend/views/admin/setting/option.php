<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Thêm thông tin mới</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Tên thông tin: ">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="2" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kiểu dữ liệu</label>
                        <select name="var_type" id="select-type" class="form-control" style="display:inline-block;width:auto">
                            <option value=""> --- Chọn kiểu --- </option>
                            <option value="int">Kiểu số</option>
                            <option value="string">Kiểu chữ</option>
                            <option value="html">Kiểu Html</option>
                            <option value="image">Ảnh</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giá trị</label>
                        <div id="input-value"></div>
                        <div id="upload-img" style="display:none">
                            <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>                              <p><span id="status"></span></p>
                            <style type="text/css">
                                #display-file ul,#display-file li{list-style:none;margin:10px 0;padding:0}
                                #display-file img{border:1px solid #ccc;padding:5px;width:auto!important;max-width:100%}
                                #display-file .insert_img_content{display:none}
                            </style>
                            <div id="display-file"> <ul></ul> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p><a href="javascript:;" onclick="add_option();" class="btn btn-primary"> Lưu </a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách thông tin</h3>
                </div>
                <div class="box-body" id="menu-listing">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-condensed dataTable">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Giá trị</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($options as $key => $val) : ?>
                            <tr>
                                <td style="width:120px">
                                    <a href="<?=base_url('setting/configOption/'.$val->id);?>"><?=$val->name;?></a>
                                    <br><small class="gray fs10"><?php echo $val->name_desc; ?></small>
                                </td>
                                <td>
                                    <?php 
                                        switch ($val->var_type) {
                                            case 'int':
                                                echo number_format($val->value);
                                                break;
                                            case 'image':
                                                echo '<image src="', get_image($val->value), '" width="150" />';
                                                break;
                                            
                                            default:
                                                echo trim($val->value);
                                                break;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo btn_edit('setting/configOption/'.$val->id);
                                    echo btn_delete('setting/delete_option/'.$val->id);
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-primary -->
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        $('#select-type').change(function(){
            var i=$(this).val();
            if(i==='int') {
                t = '<input type="text" class="form-control input-value" name="value">';
                $('#input-value').html(t);
                $('#upload-img').hide();
            } 
            else if(i==='string') {
                t='<textarea name="value" class="form-control input-value"></textarea>';
                $('#input-value').html(t);
                $('#upload-img').hide();
            } 
            else if(i==='html') {
                t='<textarea name="value" class="form-control input-value" id="tinymce"></textarea>';
                $('#input-value').html(t);
                $('#upload-img').hide();
            } 
            else if (i==='image') {
                $('#input-value').html('');
                $('#upload-img').show();
            }
            
        });
    });
    function add_option(){
        var a=$('input[name="name"]').val(),b=$('select[name="var_type"]').val(),c=$('.input-value').val();
        if(a==''){alert('Tên thông tin không được để trống');return false;}
        // if(c=='') {alert('Giá trị không được để trống');return false;}
        var desc = $('textarea[name="description"]').val();
        $.ajax({
            url: '/setting/add_option',
            type:'post',
            dataType:'json',
            data:{name:a,value:c,var_type:b,description:desc},
            success:function(data){
                if (data.msg=='success') {
                    location.reload();
                } else {
                    alert(data.msg);
                    return false;
                }
            }
        });
        return false;
    }
</script>

<script type="text/javascript" src="/admin/assets/js/ajaxUpload/single-upload.js"></script>
<script type="text/javascript" src="/admin/assets/js/plugins/numeral-js/numeral.min.js"></script>
<script type="text/javascript" src="/admin/assets/js/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="/admin/assets/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    $(function() {
        $('#datatable').DataTable({
            dom: "lfrtlip",
            pageLength: 10,
            "oLanguage": {
                "sSearch": "Tìm kiếm:&nbsp;"
            },
        });
    })
</script>
