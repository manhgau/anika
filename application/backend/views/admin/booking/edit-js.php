<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<script type="text/javascript">
    $('#checkinTime').datepicker({
        dateFormat:'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });
    $('#checkoutTime').datepicker({
        dateFormat:'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });
    // $(".timepicker").timepicker({
    //     showInputs: true
    // });
</script>