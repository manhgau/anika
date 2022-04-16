<section class="content">
    <div class="row">

        <div class="col-xs-12">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Thông tin chung</a></li>
            <li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Chi tiết</a></li>
            <li role="presentation"><a href="#prices" aria-controls="prices" role="tab" data-toggle="tab">Giá</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Cài đặt</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="summary">
                <?php $this->load->view('admin/product/_edit_intro_part'); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="detail">
                <?php $this->load->view('admin/product/_edit_detail_part'); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="prices">
                <?php $this->load->view('admin/product/_edit_price_part'); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
                <?php $this->load->view('admin/product/_edit_setting_part'); ?>
            </div>
          </div>
        </div>
    </div>
</section>