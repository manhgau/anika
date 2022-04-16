<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Nạp điểm</h4>
</div>
<div class="modal-body">
	<form action="" id="modal-form" style="padding:0">
		<div class="form-group">
			<label class="required">Thành viên</label>
			<?php
			$prepopulate = [];
			if ($user) {
				$prepopulate[] = [
					'id' => $user->id,
					'name' => $user->fullname
				];
			}
			echo tokeninput('member_id', '/member/tokenSearch', 1, $prepopulate, 'member-id'); 
			?>
		</div>
		<div class="form-group">
			<label class="required">Số điểm</label>
			<input type="text" name="amount" id="point-mask" value="0" class="form-control" required>
		</div>
		<div class="form-group">
			<label class="required">Ghi chú</label>
			<textarea class="form-control" rows="3" name="note" required></textarea>
		</div>
		<div class="text-right">
			<?php echo form_hidden('type', 'recharge') ?>
			<button type="submit" class="btn btn-sm btn-danger" id="modal-save-act"><i class="fa fa-floppy-o"></i> Lưu</button>
			<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Hủy</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	initTokenInput($('#modal-form'));

	$('#modal-form').on('submit', function(event) {
		event.preventDefault();
		let form = $(this);

		$.post('/pointload/apis/recharge', form.serializeArray(), (res) => {
			closeAppModal();
			(res.code==200) ? _redrawPage() : showMessage(res.msg, 'error');
		});
	});
	
</script>