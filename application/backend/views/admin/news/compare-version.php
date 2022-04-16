<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if($news->update_by && isset($versions)) : ?>
            <div class="box box-primary">
                <form>
                <div class="box-header clearfix">
                    <div class="col-xs-6">
                        <label>Thời điểm sửa</label>
                        <select class="form-control" name="left_version">
                            <?php foreach($versions as $key => $val) : ?>
                            <option value="<?php echo $val->id; ?>" <?php if($val->id == $leftId) echo 'selected="selected"';?>>
                                <?php echo date('H:i d/m/Y', $val->create_time);?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <label style="width:100%;">&nbsp;</label>
                        <button type="submit" class="btn btn-sm btn-info">Xem chi tiết</button>
                    </div>
                </div>
                </form>

                <hr class="line">
                <style type="text/css">tr.info{background:#f3f3f3;}th{font-size:1.6rem}tr.danger{background:#9c9c9c;}</style>
                <h3 style="padding-left:15px">Người sửa: <?php echo $leftAuthor->name; ?></h3>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr class="danger">
                            <th>Trước</th>
                            <th>Sau</th>
                        </tr>
                        <tr class="info">
                            <th colspan="2">
                                Tiêu đề
                            </th>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><?php echo $leftNews->title; ?></td>
                            <td class="col-xs-6"><?php echo $rightNews->title; ?></td>
                        </tr>
                        <tr class="info">
                            <th colspan="2">
                                Mô tả
                            </th>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><?php echo $leftNews->description; ?></td>
                            <td class="col-xs-6"><?php echo $rightNews->description; ?></td>
                        </tr>
                        <tr class="info">
                            <th colspan="2">
                                Nội dung
                            </th>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><?php echo $leftNews->content; ?></td>
                            <td class="col-xs-6"><?php echo $rightNews->content; ?></td>
                        </tr>
                        <tr class="info">
                            <th colspan="2">Trạng thái</th>
                        </tr>
                        <tr>
                            <?php 
                            $txtStatus = array(
                                1 => 'Xuất bản','Ẩn (chờ duyệt)', 'Đã xóa', 'Trả lại'
                            );
                            ?>
                            <td class="col-xs-6"><?php echo $txtStatus[$leftNews->status]; ?></td>
                            <td class="col-xs-6"><?php echo $txtStatus[$rightNews->status]; ?></td>
                        </tr>
                        <tr class="info">
                            <th colspan="2">Chuyên mục</th>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><?php echo (isset($leftCat)) ? $leftCat->title : ''; ?></td>
                            <td class="col-xs-6"><?php echo (isset($rightCat)) ? $rightCat->title : ''; ?></td>
                        </tr>
                        <tr class="info">
                            <th colspan="2">Ảnh đại diện</th>
                        </tr>
                        <tr>
                            <td class="col-xs-6">
                                <?php if($leftNews->thumbnail) : ?>
                                <img src="<?php echo get_image($leftNews->thumbnail); ?>" style="height:100px">
                                <?php endif; ?>
                            </td>
                            <td class="col-xs-6">
                                <?php if($leftNews->thumbnail) :?>
                                <img src="<?php echo get_image($leftNews->thumbnail); ?>" style="height:100px">
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php else : ?>
                <p>Bài viết chưa có lần thay đổi nào hoặc không có bản ghi lịch sử nào!</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<div class="modal fade bd-example-modal-lg" id="modal-preview-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:600;font-size:1.7rem" id="exampleModalLongTitle">Modal title</h5>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>