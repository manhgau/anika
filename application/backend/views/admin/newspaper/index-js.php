<script type="text/javascript" src="/admin/assets/js/ajaxUpload/single-upload.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript">
function reloadNextPos(el) {
	let page = $(el).find('option:selected').val();
	$.get(`/newspaper/getNextPosition/${page}`, (pos) => {
		$('input[name="order"]').val(pos).trigger('change')
	})
}

$(function(){
	$('#datatable').DataTable();
});
</script>