<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin dịch vụ</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered">
                            <tr>
                                <td class="col-xs-3"><label>Loại dịch vụ</label></td>
                                <td class="col-xs-9">
                                    <?php echo $this->lang->line($booking->product_type); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Sản phẩm</label></td>
                                <td>
                                    <?php echo ucfirst($product->title); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Gói dịch vụ</label></td>
                                <td>
                                    <?php echo ucfirst($booking->pack_name); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Giá</label></td>
                                <td>
                                    - Giá cho người lớn: <strong><?php echo number_format($booking->price) , ' USD'; ?></strong><br>
                                    - Giá cho trẻ em: <strong><?php echo number_format($booking->price_child) , ' USD'; ?></strong><br>
                                    - Giá cho em bé: <strong><?php echo number_format($booking->price_baby) , ' USD'; ?></strong><br>
                                </td>
                            </tr>
                            <?php if ($booking->product_type == 'restaurant') : ?>
                            <tr>
                                <td><label>Thời gian</label></td>
                                <td>
                                    <?php echo date('H:i d/m/Y', strtotime($booking->pack_date)); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Số người</label></td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php
                                            $_adultNumber = ($booking->person_number - $booking->child_number - $booking->baby_number);
                                             echo number_format($_adultNumber); ?> Người lớn</label>
                                            <p class="gray"><?php echo number_format($booking->price * $_adultNumber), ' vnd'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php echo ($booking->child_number); ?> Trẻ em</label>
                                            <p class="gray"><?php echo number_format($booking->price_child * $booking->child_number), ' vnd'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php echo ($booking->baby_number); ?> Em bé</label>
                                            <p class="gray"><?php echo number_format($booking->price * $booking->baby_number), ' vnd'; ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php elseif ($booking->product_type == 'stay'):  ?>
                            <tr>
                                <td><label>Thời gian</label></td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label class="thin">Checkin</label>
                                            <p><?php echo date('H:i d/m/Y', strtotime($booking->pack_date)); ?></p>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="thin">Checkout</label>
                                            <p><?php echo date('H:i d/m/Y', strtotime($booking->checkout_date)); ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Số lượng phòng</label></td>
                                <td><?php echo $booking->room_number; ?></td>
                            </tr>
                            <tr>
                                <td><label>Số người</label></td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php
                                            $_adultNumber = ($booking->person_number - $booking->child_number - $booking->baby_number);
                                             echo number_format($_adultNumber); ?> Người lớn</label>
                                            <p class="gray"><?php echo number_format($booking->price * $_adultNumber), ' vnd'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php echo ($booking->child_number); ?> Trẻ em</label>
                                            <p class="gray"><?php echo number_format($booking->price_child * $booking->child_number), ' vnd'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php echo ($booking->baby_number); ?> Em bé</label>
                                            <p class="gray"><?php echo number_format($booking->price * $booking->baby_number), ' vnd'; ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php elseif ($booking->product_type == 'tour'):  ?>
                            <tr>
                                <td><label>Ngày khởi hành</label></td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($booking->pack_date)); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Số người</label></td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php
                                            $_adultNumber = ($booking->person_number - $booking->child_number - $booking->baby_number);
                                             echo number_format($_adultNumber); ?> Người lớn</label>
                                            <p class="gray"><?php echo number_format($booking->price * $_adultNumber), ' vnd'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php echo ($booking->child_number); ?> Trẻ em</label>
                                            <p class="gray"><?php echo number_format($booking->price_child * $booking->child_number), ' vnd'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin"><?php echo ($booking->baby_number); ?> Em bé</label>
                                            <p class="gray"><?php echo number_format($booking->price * $booking->baby_number), ' vnd'; ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td><label>Tổng số tiền</label></td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="" class="thin">Tổng tiền</label>
                                            <p class="orange"><?php echo number_format($booking->total), ' USD'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin">Đặt cọc</label>
                                            <p class="<?php echo ($booking->status == STATUS_PUBLISHED) ? 'green' : 'gray'; ?>"><?php echo number_format($booking->paid), ' USD'; ?></p>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="" class="thin">Còn nợ</label>
                                            <?php if($booking->status == STATUS_PUBLISHED) : ?>
                                            <p class="orange"><?php echo number_format($booking->total - $booking->paid), ' USD'; ?></p>
                                            <?php else: ?>
                                            <p class="red"><?php echo number_format($booking->total), ' USD'; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Ghi chú</label></td>
                                <td>
                                    <div style="white-space: pre-wrap;"><?php echo $booking->note; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Thanh toán</label></td>
                                <td>
                                    <select class="form-control" name="status">
                                        <option value="<?php echo STATUS_PUBLISHED; ?>" <?php if($booking->status ==STATUS_PUBLISHED) echo 'selected="selected"'; ?>>Đã đặt cọc</option>
                                        <option value="<?php echo STATUS_PENDING; ?>" <?php if($booking->status ==STATUS_PENDING) echo 'selected="selected"'; ?>>Chưa đặt cọc</option>
                                        <option value="<?php echo STATUS_DELETED; ?>" <?php if($booking->status ==STATUS_DELETED) echo 'selected="selected"'; ?>>Đã xóa</option>
                                    </select>
                                    <p class="gray mt-10"><?php echo $booking->payment_return; ?></p>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="border-bottom:1px solid #ccc;display:block!important;width:100%">Thông tin Khách hàng</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="status">Họ và tên: <span class="thin"><?php echo $booking->name;?></span></label>
                        </div>
                        <div class="form-group">
                            <label for="status">Email: <span class="thin"><?php echo $booking->email;?></span></label>
                        </div>
                        <div class="form-group">
                            <label for="status">Phone: <span class="thin"><?php echo $booking->phone;?></span></label>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="border-bottom:1px solid #ccc;display:block!important;width:100%">Nhà cung cấp</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="status">Tên công ty</label>
                            <p><?php echo $bussiness->title, ' (', $bussiness->display_name,')'; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="status">Số điện thoại: <span class="thin"><?php echo $bussiness->phone; ?></span></label>
                        </div>
                        <div class="form-group">
                            <label for="status">Email: <span class="thin"><?php echo $bussiness->email; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="status">Zalo</label>
                            <p><?php echo $bussiness->zalo_account; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="status">Facebook</label>
                            <p><?php echo $bussiness->facebook_account; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>