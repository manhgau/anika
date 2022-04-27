<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/department.js');?>"></script>
<script type="text/javascript">
    $(function(){
        $('.delete-btn').on('click',function(){
            var url = $(this).attr('href');
            $.get( url, function( data ) {
                location.reload();
            });
            return false;
        });
    });
</script>