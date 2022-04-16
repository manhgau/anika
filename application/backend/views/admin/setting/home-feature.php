<div class="box-header" style="width:300px;padding:0 0 0 20px">
    <h3 class="box-title"> Tin HOT - Trang chủ </h3>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Tìm kiếm</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-md-8">
                            <input type="text" id="quick-search-input" placeholder="Từ khóa" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button id="quick-search-btn" class="btn btn-sm btn-info"> <i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
                        <div class="clear"></div>
                    </div> 
                    <div class="form-group">
                        <ul id="quick-search-result">
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
        <?php echo form_open_multipart('','role="form"'); ?>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Tin HOT</h3>
                </div>
                <div class="box-body" id="menu-listing">
                    <ul id="sortable">
                        <?php if($order_ids) : foreach($order_ids as $id) : if( isset($home_feature[$id]) ) : $val = $home_feature[$id];?>
                        <li class="ui-state-default">
                            <input type="hidden" name="home_feature[]" value="<?php echo $val->id; ?>">
                            <?php echo $val->title;?>
                        </li>
                        <?php endif; endforeach; endif;?>
                    </ul>
                </div>
                <hr class="line">
                <?php echo form_submit('submit','Lưu','class="btn btn-primary"');?>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</section>