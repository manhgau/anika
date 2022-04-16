<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#token-input-parent").tokenInput(adminUrl+"/Apis/token_search_location",{
        theme : "facebook",
        tokenDelimiter: ",",
        tokenLimit: 1,
        preventDuplicates: true,
        <?php if(isset($tokenParent)) : ?>
        prePopulate:<?php echo $tokenParent;?>,
        <?php endif; ?>
    });

    $("#token-group-location").tokenInput(adminUrl+"/Apis/token_search_location_group",{
        theme : "facebook",
        tokenDelimiter: ",",
        tokenLimit: 1,
        preventDuplicates: true,
        <?php if(isset($tokenGroup)) : ?>
        prePopulate:<?php echo $tokenGroup;?>,
        <?php endif; ?>
    });
});

$(function(){
	formLocationName();

	var selectType = $('select[name="location_type"]');
	selectType.on('change', function(){
		formLocationName();
	});
});

function formLocationName() {
	var selectType = $('select[name="location_type"]');
	var divParent = $('.form-group.parent-location');
	var divGroup = $('.form-group.group-location');
	var divLocation = $('.form-group.location');
	var type = selectType.find('option:selected').val();
	console.log(type);

	if (type == 'is_country') {
		divParent.addClass('hidden');
		divGroup.removeClass('hidden');
		divLocation.removeClass('hidden');
		divGroup.find('label').text('Khu vực');
		divLocation.find('label').text('Tên quốc gia');
	}
	if (type == 'is_province') {
		divParent.removeClass('hidden');
		divParent.find('label').text('Quốc gia');
		divGroup.removeClass('hidden');
		divGroup.find('label').text('Vùng miền');
		divLocation.removeClass('hidden');
		divLocation.find('label').text('Tên tỉnh/thành');
	}
	if (type == 'is_location') {
		divParent.removeClass('hidden');
		divParent.find('label').text('Tỉnh/thành');
		divGroup.addClass('hidden');
		divLocation.removeClass('hidden');
		divLocation.find('label').text('Tên địa danh');
	}
}

</script>

