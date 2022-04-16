<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <form method="post">
                <!-- form start -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo (isset($v_cat->id)) ? 'Cập nhật' : 'Thêm mới';?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title">Tên</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Tên chuyên mục" value="<?php echo $v_cat->title; ?>">
                        </div>
                        <hr class="line">
                        <div class="form-group">
                            <label for="meta_title">Meta title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Tên chuyên mục" value="<?php echo $v_cat->meta_title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="meta_keyword">Meta keyword</label>
                            <textarea name="meta_keyword" id="meta_keyword" class="form-control"><?php echo $v_cat->meta_keyword; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta description</label>
                            <textarea name="meta_description" class="form-control"><?php echo $v_cat->meta_description; ?></textarea>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo (isset($v_cat->id)) ? $v_cat->id : 'NULL'; ?>">
                            <button type="submit" class="btn btn-sm btn-info">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách Chuyên mục</h3>
                </div>
                <div class="box-body" id="menu-listing">
                    <table class="table table-bordered table-hover dataTable">
                        <tr>
                            <th>Tên</th>
                            <th>URI</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($v_categories as $key => $val) : ?>
                            <tr>
                                <td><a href="<?=base_url('video/video_category/'.$val->id);?>"><?=$val->title;?></a></td>
                                <td><?php echo $val->slugname . '-vcat'. $val->id . '.html';?></td>
                                <td>
                                    <?php
                                        echo btn_edit('video/video_category/'.$val->id);
                                        echo btn_delete('video/delete_video_category/'.$val->id);
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                    </table>
                </div>
            </div><!-- /.box-primary -->
        </div>
    </div>
</section>