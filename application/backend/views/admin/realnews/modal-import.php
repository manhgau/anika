<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Tải lên file Import danh sách</h4>
</div>
<div class="modal-body">
    <form action="">
        <div class="form-group">
            <label>File danh sách</label>
            <input type="file" name="import_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-info" id="modal-save-act"><i class="fa fa-floppy-o"></i> Tải lên</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $('#modal-save-act').on('click', function() {
        var formData = new FormData();
        // Attach file
        formData.append('import_file', $('input[type=file]')[0].files[0]); 
        $.ajax({
            url: '/realnews/importExec',
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: (res) => {
                closeAppModal()
                showMessage(res.msg, (res.code==200) ? 'success' : 'error')
            }
        });
    });
</script>