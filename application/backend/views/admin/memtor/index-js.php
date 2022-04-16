<script type="text/javascript">
$('.filter').change(function(){
    let param = {};
	param.status = $('select[name="status"] option:selected').val();
    param.group = $('select[name="group"] option:selected').val();
    u = '?'+$.param(param);
    window.location=u;
});
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/memtor.js');?>"></script>