<script type="text/javascript" src="<?php echo base_url();?>/admin/assets/js/ajaxUpload/single-upload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/admin/assets/js/me/banner-editor.js"></script>
<script type="text/javascript">
	$('input[name="expired_date"]').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate:1
	});

	var btnInsertImg = $('#addmore-image');
	btnInsertImg.on('click', function(evt){
		evt.preventDefault();
		var img = $('#singleUploaded').find('img').attr('src');
		if (img == undefined || img=='') {
			alert('vui lòng upload ảnh.');
			return false;
		}
		var title = $('#input-name').val();
		var url = $('input#url').val();
		var expired = $('input[name="expired_date"]').val();
		var expiredTime = null;
		if (expired != '') {
			var dt = new Date(expired);
			expiredTime = dt.getTime()/1000;
		}
		var ads = $('<img/>').attr('src', img);
		var is_blank = $('input[name="is_blank"]');
		var c = '';
		if (is_blank.is(':checked')) {
			c = 'target="_blank"';
		}

		if (url == '') 
			ads = '<img src=\"'+img+'\" alt=\"'+title+'\"/>';
		else
			ads = '<a href="'+url+'" '+c+' title=\"'+title+'\"><img src=\"'+img+'\" alt=\"'+title+'\" /></a>';

		if (expiredTime != null)
        	tinyMCE.execCommand('mceInsertContent', false, '<p data-expired="'+expiredTime+'">'+ads+'</p>');
		else
			tinyMCE.execCommand('mceInsertContent', false, '<p>'+ads+'</p>');
	});
</script>