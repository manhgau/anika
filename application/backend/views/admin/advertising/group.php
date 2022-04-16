<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <form method="post">
                <!-- form start -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo (isset($group->id)) ? 'Cập nhật' : 'Thêm mới'; ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title">Tên</label>
                            <input type="text" name="name" id="title" class="form-control" placeholder="Tên nhóm"
                                   value="<?php echo $group->name; ?>">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="id"
                                   value="<?php echo (isset($group->id)) ? $group->id : ''; ?>">
                            <button type="submit" class="btn btn-sm btn-info">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách nhóm quảng cáo</h3>
                </div>
                <div class="box-body" id="menu-listing">
                    <table class="table table-bordered table-hover dataTable">
                        <tr>
                            <th>Tên</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($groups as $key => $val) : ?>
                            <tr>
                                <td><a href="<?= base_url('advertising/group/' . $val->id); ?>"><?= $val->name; ?></a>
                                </td>
                                <td>
                                    <?php
                                    echo btn_edit('advertising/group/' . $val->id);
                                    echo btn_delete('advertising/delete_group/' . $val->id);
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