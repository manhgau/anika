<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title w-100">Tìm kiếm</h4>
                    <div class="col-xs-12">
                        <form id="filter-form">
                            <div class="row">
                                <div class="form-group col-xs-6 col-md-3">
                                    <label>ID/tên người gửi</label>
                                    <input type="text" autocomplete="off" class="form-control" name="keyword" value="<?= $filter['keyword'] ?>">
                                </div>
                                <div class="form-group col-xs-12 col-md-4">
                                    <label>Ngày tạo</label>
                                    <div class="row">
                                    	<div class="col-xs-6">
                                    		<input type="text" class="form-control vn-datepicker" name="from_date" value="<?php echo $filter['from_date']; ?>" autocomplete="off" placeholder="từ ngày">
                                    	</div>
                                    	<div class="col-xs-6">
		                                    <input type="text" class="form-control vn-datepicker" name="to_date" value="<?php echo $filter['to_date']; ?>" autocomplete="off" placeholder="đến ngày">
		                                </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-6 col-md-2">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                    	<option value="">--- tất cả ---</option>
                                    	<?php foreach ($this->feedback_model->feedbackStatus as $key => $value): ?>
                                    		<option value="<?= $key ?>"><?= $value['name'] ?></option>
                                    	<?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <button style="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i> Tra cứu</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group" style="padding-bottom: 200px">
                        <table id="datatable" class="table table-condensed table-striped table-bordered table-hover" data-controller="<?php echo $this->router->fetch_class();?>">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Thời gian</th>
                                    <th>Họ và tên</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Yêu cầu</th>
                                    <th>Trạng thái</th>
                                    <th>Nội dung</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section> 	