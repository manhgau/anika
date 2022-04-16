<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Ghi chú</h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<label>Ghi chú</label>
		<textarea class="form-control" rows="6" name="note"><?php echo $newsSalary->note; ?></textarea>
	</div>
</div>
<div class="modal-footer">
	<input type="hidden" name="news_id" value="<?php echo $news->id; ?>">
	<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
	<button type="button" class="btn btn-info" id="modal-save-act"><i class="fa fa-floppy-o"></i> Lưu</button>
</div>
<script type="text/javascript">
	$('#modal-save-act').on('click', function() {
		var newsId = bootModal.find('input[name="news_id"]').val();
		var note = bootModal.find('textarea[name="note"]').val();
		$.ajax({
			type: 'post',
			url: domain + 'apis/saveNewsNote4Salary',
			dataType: 'json',
			data: {news_id:newsId, note:note},
			success: function(res) {
				closeAppModal();
				if (res.code != 0) {
					showMessage(res.msg);
				}
			}
		});
	});
</script>