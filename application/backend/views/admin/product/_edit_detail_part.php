<div class="panel-body">
    <form action="" id="product-detail-form">

    <?php if ($product->product_type == PRODUCT_TOUR)  : ?>
        <?php $this->load->view('admin/product/_edit-tour-detail'); ?>

    <?php elseif ($product->product_type == PRODUCT_TRANSFER)  : ?>
        <?php $this->load->view('admin/product/_edit-transfer-detail'); ?>

    <?php elseif ($product->product_type == PRODUCT_STAY)  : ?>
        <?php $this->load->view('admin/product/_edit-stay-detail'); ?>

    <?php elseif ($product->product_type == PRODUCT_RESTAURANT)  : ?>
        <?php $this->load->view('admin/product/_edit-restaurant-detail'); ?>
    <?php endif; ?>
    
    </form>
</div>