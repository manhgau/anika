<section class="content">
    <div class="row">
        <form action="<?php echo base_url('product/edit');?>" method="get" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Chọn Loại Sản phẩm</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <?php $iconConfigs = array(
                                1 => 'fa-plane',
                                2 => 'fa-home',
                                3 => 'fa-car',
                            ); ?>
                            <?php foreach ($mainType as $key => $val) : ?>
                            <a href="<?php echo base_url('product/edit/?product_type=' . $val->id);?>" class="btn btn-primary btn-app">
                                <i class="fa fa-2x <?php echo $iconConfigs[$val->id]; ?> blue"></i> 
                                <strong style="font-size:14px"><?php echo $val->title; ?></strong>
                            </a>
                            <?php endforeach; ?>
                        </div>       
                    </div>
                </div>
            </div>

            <div class="col-md-3 hidden">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <hr class="line" />
                </div>
            </div>
        </form>
    </div>
</section>