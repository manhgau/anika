<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Tìm kiếm</h3>
                </div>
                <div class="box-body"> 
                    <form name="form-filter" action="">
                        <div class="row">
                            <div class="col-xs-3">
                                <label>Chuyên mục</label>
                                <?php if(!empty($tree_categories)):?>
                                    <select id="category-filter" class="form-control filter" name="category">
                                        <option value="" <?php if($category_id==0) echo 'selected="selected"'; ?>> -- Danh mục -- </option>
                                        <?php foreach ($tree_categories as $key => $val) : ?>
                                            <option value="<?php echo $val->id?>" <?php if($val->id == $category_id) echo 'selected="selected"';?>> <?php for($i=1;$i<$val->level;$i++){echo '&mdash;';} echo '&nbsp;' . $val->title; ?> </option>
                                            <?php endforeach; ?>
                                    </select>
                                    <?php endif;?>
                            </div> 
                            <div class="col-xs-3">
                                <label>Trạng thái</label>
                                <select class="form-control filter" name="status">
                                    <option value="">Tất cả</option>
                                    <option value="1">Đã xuất bản</option>
                                    <option value="2">Chờ duyệt</option>
                                    <option value="3">Đã xóa</option>
                                    <option value="3">Đã trả lại</option>
                                </select>
                            </div> 
                            <div class="col-xs-3">
                                <label>Tác giả</label>
                                <select class="form-control filter" name="create_by">
                                    <option value="">Tất cả</option>
                                    <?php foreach($authors as $key => $val) : ?>
                                    <option value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label>Thời gian</label>
                                <select class="form-control filter" name="create_time">
                                    <option value="0">Tất cả</option>
                                    <option value="1">Đã xuất bản</option>
                                    <option value="2">Chờ duyệt</option>
                                    <option value="3">Đã xóa</option>
                                    <option value="3">Đã trả lại</option>
                                </select>
                            </div>

                        </div>  
                        <div class="row" style="margin-top:10px;">
                            <div class="col-xs-12">
                                <button type="submit" name="submit_search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Lọc dữ liệu</button>
                                <button name="clear_filter" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách bài viết</h3>
                </div>
                <div class="box-body">        
                    <table class="table table-striped table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Tiêu đề </th>
                                <th> Tác giả </th>
                                <th> Chuyên mục </th>
                                <th> Viết lúc </th>
                                <th> Đăng lúc </th>
                                <th> Trạng thái </th>
                                <th> HOT </th>
                                <th> Thao tác </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>