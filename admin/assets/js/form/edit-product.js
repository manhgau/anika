$(function() {
	$('form#product-intro-form').productIntroModule();
	$('form#product-setting-form').productSettingModule();
	$('form#product-detail-form').productDetailModule();
	$('form#product-price-form').productPriceModule();
});

$.fn.productPriceModule = function(options) {
	var form = $(this),
		rowData = {},
		formId = form.attr('id'),
		e_name = 'input[name="name"]',
		e_person_min = 'input[name="person_min"]',
		e_person_max = 'input[name="person_max"]',
		e_price = 'input[name="price"]',
		e_price_child = 'input[name="price_child"]',
		e_price_baby = 'input[name="price_baby"]',
		e_note = 'input[name="note"]',
		e_note_child = 'input[name="note_child"]',
		e_note_baby = 'input[name="note_baby"]',
		btnAddNew = form.find('.well').find('button#add-new-price'),
		btnRemovePrice = form.find('.btn-remove-price'),
		btnSave = form.find('.btn-save-price');
	var product_id = form.find('input[name="product_id"]').val();

	btnAddNew.on('click', function(e) {
		e.preventDefault();
		var newRow = form.find('tr#price-defined').clone().show();
		newRow.attr({'data-id':'', 'id':''});
		newRow.find('input').val('');
		newRow.find('.btn-save-price').bind('click', function(e) {
			e.preventDefault();
			getRowData(newRow);
			submitPrice();
			$(this).attr('disabled', 'disabled');
		});
		newRow.find('.btn-remove-price').bind('click', function(e) {
			newRow.remove();
		});
		form.find('table').find('tbody').prepend(newRow);
	});

	btnSave.on('click', function(e) {
		e.preventDefault();
		var row = $(this).parent().parent();
		getRowData(row);
		submitPrice();
	});

	btnRemovePrice.on('click', function(e){
		e.preventDefault();
		var row = $(this).parent().parent();
		var priceId = row.data('id');
		var cfrButtons = {
			'Xóa' : function() {
				removePrice(priceId, row);
				$(this).dialog('close');
			},
			'Hủy' : function() {
				$(this).dialog('close');
			}
		};
		confirm_dialog('Bạn muốn xóa mức giá này?', cfrButtons);
	});

	function removePrice(id, row) {
		if (id!='' && id!=null) 
		{
			$.ajax({
				url: baseUrl + 'apis/removeProductPrice',
				type:'post',
				dataType: 'json',
				data: {id:id},
				success: function(res) {
					(res.code == 0) ? row.remove() : showMessage(res.msg);
				}
			});

		}
		else
		{
			row.remove();
		}
	}

	function getRowData(row) {
		rowData.name = row.find(e_name).val();
		rowData.note = row.find(e_note).val();
		rowData.note_child = row.find(e_note_child).val();
		rowData.note_baby = row.find(e_note_baby).val();
		rowData.person_min = parseInt(row.find(e_person_min).val());
		rowData.person_max = parseInt(row.find(e_person_max).val());
		rowData.price = parseInt(row.find(e_price).val());
		rowData.price_child = parseInt(row.find(e_price_child).val());
		rowData.price_baby = parseInt(row.find(e_price_baby).val());
		rowData.price_id = parseInt(row.data('id'));
		rowData.product_id = product_id;
		// console.log(rowData);
	}

	function submitPrice() {
		if (product_id == '')
		{
			showMessage('Sản phẩm không tồn tại');
			return false;
		}
		$.ajax({
			type:'post',
			url : baseUrl + 'apis/saveProductPrice',
    		dataType: 'json',
    		data : rowData,
    		success : function(res) {
    			// var data = $.parseJSON(res);
    			showMessage(res.msg);
    		}
		});
	}
}

$.fn.productDetailModule = function(options) {
	var form = $(this),
		formData = null,
		formId = form.attr('id'),
		btnSave = form.find('button[type="submit"]');
	var e_start_time = 'input[name="start_time"]';

	init();

	function init() {
		if(form.find(e_start_time).offset())
		{
			$(e_start_time).datepicker({
				minDate:0,
				dateFormat:'yy-mm-dd'
			}).prop('readonly', 'readonly');
		}
	}

	form.on('submit', function(e){
		e.preventDefault();
		formData = new FormData(document.getElementById(formId));
		formData.set('content', tinymce.get("tinymce1").getContent());
		submitForm();
	});

	function submitForm() {
		$.ajax({
			type:'post',
			url : baseUrl + 'apis/saveProductDetail',
    		processData: false,
    		contentType:false,
    		data : formData,
    		success : function(res) {
    			var data = $.parseJSON(res);
    			showMessage(data.msg);
    		}
		});
	}
}

$.fn.productSettingModule = function(options) {
	var form = $(this),
		formData = null,
		formId = form.attr('id'),
		btnSave = form.find('button[type="submit"]');

	form.on('submit', function(e){
		e.preventDefault();
		formData = new FormData(document.getElementById(formId));
		submitForm();
	});

	function submitForm() {
		$.ajax({
			type:'post',
			url : baseUrl + 'apis/saveProductSetting',
    		processData: false,
    		contentType:false,
    		data : formData,
    		success : function(res) {
    			var data = $.parseJSON(res);
    			showMessage(data.msg);
    		}
		});
	}
}

$.fn.productIntroModule = function(options)
{
	var form = $(this),
		formData = null,
		formId = form.attr('id'),
		productId = form.find('input[name="product_id"]').val(),
		btnSave = form.find('button[type="submit"]');

	form.on('submit', function(e){
		e.preventDefault();
		formData = new FormData(document.getElementById(formId));
		formData.set('description', tinymce.get("editor-2").getContent());
		submitForm();
	});

	function submitForm() {
		$.ajax({
			type:'post',
			url : baseUrl + 'apis/saveProductIntro',
    		processData: false,
    		contentType:false,
    		data : formData,
    		success : function(res) {
    			var jData = $.parseJSON(res);
    			if (jData.code==0) {
    				if (productId == '')
    					location.href = baseUrl + 'product/edit/' + jData.data;
    				else
    					showMessage(jData.msg);
    			}
    			else
    				showMessage(jData.msg);
    			
    		}
		});
	}
}