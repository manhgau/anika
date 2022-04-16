<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Thêm mới</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="type">Tên</label>
                        <input type="text" name="type" class="form-control" id="type" placeholder="Type: " value="<?php echo $seo->type;?>">
                    </div>
                    <div class="form-group">
                        <label for="meta-title">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" id="meta-title" placeholder="" value="<?php echo $seo->meta_title;?>">
                    </div>
                    <div class="form-group">
                        <label for="meta-keyword">Meta Keyword</label>
                        <textarea name="meta_keyword" class="form-control" id="meta-keyword" rows="4"><?php echo $seo->meta_keyword;?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta-description">Meta Description</label>
                        <textarea name="meta_description" class="form-control" id="meta-description" rows="4"><?php echo $seo->meta_description;?></textarea>
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="id" id="seo-id" value="<?php echo (isset($seo->id)) ? $seo->id : 0;?>">
                    <p><a href="javascript:;" onclick="add_option();" class="btn btn-primary"> Lưu </a></p>
                    </div>
                </div>
            </div><!-- /.box -->
        </div>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách SEO</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="menu-listing">
                    <table class="table table-bordered table-hover dataTable">
                        <tr>
                            <th>Type</th>
                            <th>Thông tin seo</th>
                        </tr>
                        <?php foreach ($list_seo as $key => $val) : ?>
                        <tr>
                            <td><a href="<?=base_url('setting/seo_option/'.$val->id);?>"><?=$val->type;?></a></td>
                            <td>
                                <input type="text" name="meta_title[<?php echo $val->id; ?>]" value="<?php echo htmlspecialchars($val->meta_title);?>" class="form-control" readonly="readonly">
                                <textarea cols="" rows="" class="form-control" name="meta_keyword[<?php echo $val->id; ?>]" readonly="readonly"><?php echo htmlspecialchars($val->meta_keyword);?></textarea>
                                <textarea cols="" rows="" class="form-control" name="meta_description[<?php echo $val->id; ?>]" readonly="readonly"><?php echo htmlspecialchars($val->meta_description);?></textarea>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div><!-- /.box-primary -->
        </div>
    </div>
</section>
<script type="text/javascript">
    function add_option(){
        var a=$('#type').val(),b=$('#meta-title').val(),c=$('#meta-keyword').val(),d=$('#meta-description').val();
        var id = $('#seo-id').val();
        if(a==''){alert('Tên thông tin không được để trống');return false;}
        if(b==''){alert('Tiêu đề trang không được để trống');return false;}
        $.ajax({
            url:baseUrl+'apis/save_seo_option',
            type:'post',
            dataType:'json',
            data:{type:a,meta_title:b,meta_keyword:c,meta_description:d,id:id},
            success:function(data){
                if (data.code==0) {
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