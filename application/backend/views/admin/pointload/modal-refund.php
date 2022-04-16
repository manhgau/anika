<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Yêu cầu hoàn điểm</h4>
</div>
<div class="modal-body">
	<ul class="list-unstyled">
		<li>- Họ và tên: <?php echo $member->fullname ?></li>
		<li>- SĐT: <?php echo $member->phone ?></li>
		<li>- Email: <?php echo $member->email ?></li>
		<li>- Mã bài viết: <strong><?php echo $request->news_code ?></strong></li>
		<li>- Link bài viết: <a href="<?php echo $request->news_url ?>" target="_blank"><strong>Link bài</strong></a></li>
		<li>- Số điểm: <strong class="text-danger"><?php echo number_format($request->amount) ?></strong></li>
		<li>- Lý do: 
			<span class="text-warning"><?php echo $request->note ?></span>
		</li>
	</ul>
	<hr>
	<form action="" id="modal-refund-form" style="padding:0">
		<div class="form-group">
			<label class="required">Chọn trạng thái</label>
			<ul class="list-inline text-center">
				<?php foreach ($this->pointrefund_model->getStatus() as $key => $value): ?>
					<li class="list-inline-item">
						<label>
							<input type="radio" class="simple" name="status" value="<?php echo $key ?>" <?php echo ($key==$request->status) ? 'checked' : '' ?>>
							<?php echo $value['name'] ?>
						</label>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<div class="form-group">
			<label class="required">Ghi chú</label>
			<textarea class="form-control" rows="3" name="note" required></textarea>
		</div>
		<div class="text-right">
			<?php echo form_hidden('id', $request->id) ?>
			<button type="submit" class="btn btn-sm btn-danger" id="modal-save-act"><i class="fa fa-floppy-o"></i> Lưu</button>
			<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Hủy</button>
		</div>
	</form>
</div>
<script type="text/javascript">

	$('#modal-refund-form').on('submit', function(event) {
		event.preventDefault();
		let form = $(this);

		$.post('/pointload/apis/refundAnswer', form.serializeArray(), (res) => {
			closeAppModal();
			(res.code==200) ? _redrawPage() : showMessage(res.msg, 'error');
		});
	});
	
</script>