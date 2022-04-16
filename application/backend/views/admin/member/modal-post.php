<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Yêu cầu đăng bài</h4>
</div>
<div class="modal-body">
	<ul class="list-unstyled">
		<li>- Họ và tên: <?php echo $member->fullname ?></li>
		<li>- SĐT: <?php echo $member->phone ?></li>
		<li>- Email: <?php echo $member->email ?></li>
		<li>- Tiêu đề: <strong><?php echo $request->title ?></strong></li>
		<li>- Link bài viết: <a href="<?php echo $request->url ?>" target="_blank"><strong>Link bài</strong></a></li>
		<li>- Số điểm: <strong class="text-danger"><?php echo number_format($request->point) ?></strong></li>
	</ul>
	<hr>
	<form action="" id="modal-refund-form" style="padding:0">
		<div class="form-group">
			<label class="required">Chọn trạng thái</label>
			<ul class="list-inline text-center">
				<?php foreach ($this->postrequest_model->getStatus() as $key => $value): ?>
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

		$.post('/member/apis/postAnswer', form.serializeArray(), (res) => {
			closeAppModal();
			(res.code==200) ? _redrawPage() : showMessage(res.msg, 'error');
		});
	});
	
</script>