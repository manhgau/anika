<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
	var filterForm = $('form#filter-form');
    filterForm.find('.token-input').each(function() {
        $(this).tokenInput(
            adminUrl + $(this).data('api'),
            {   
                theme : "facebook",
                tokenDelimiter: ",",
                tokenLimit: $(this).data('limit'),
                preventDuplicates: true,
                <?php if(isset($tokenBussiness)) : ?>
                prePopulate:<?php echo $tokenBussiness;?>,
                <?php endif; ?>
            }
        );
    });

    // filterForm.find('input[name="bussiness_id"]').tokenInput(
    // 	adminUrl+"/Apis/token_search_bussiness",
    // 	{
	   //      theme : "facebook",
	   //      tokenDelimiter: ",",
	   //      tokenLimit:1,
	   //      preventDuplicates: true,
	   //      <?php if(isset($tokenBussiness)) : ?>
	   //      prePopulate:<?php echo $tokenBussiness;?>,
	   //      <?php endif; ?>
    // 	}
    // );
    $('.is-datepicker').datepicker({
    	dateFormat: 'dd/mm/yy',
    	changeMonth: true,
      	changeYear: true
    });
});
</script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/product-list.js');?>" defer></script>