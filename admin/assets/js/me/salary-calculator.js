var salaryTable = $('#table-report');
var trData = {};
var eMoney = 'input[name="money"]', eAP = 'input[name="allow_payment"]', eNewsType = 'select[name="news_type"]';
var eNewsTypeSelected = 'select[name="news_type"] option:selected';
var btnAutoConfirm = salaryTable.find('#auto-check-salary');
const AUTO_CONFIRM_SALARY = baseUrl + 'apis/saveBatchNewSalary';

$(function(){

	salaryTable.find('tbody').find('tr').each(function(){
		var tr = $(this);
		var trMode = tr.data('mode');
		if(trMode=='edit-mode') {
			editMode(tr);
		}
		else {
			updateViewData(tr);
			viewMode(tr);
		}
	});

	salaryTable.on('click', '.btn-change-mode', function() {
		var tr = $(this).parent('td').parent('tr');
		var mode = tr.data('mode');
		getTrData(tr);
		editMode(tr);
		return false;
	});

	salaryTable.on('click', '.btn-cancel', function(){
		var tr = $(this).parent('td').parent('tr');
		if( trData.element_id != tr.attr('id') || $.isEmptyObject(trData) ) {
			tr.find(eNewsType).val('');
			tr.find(eMoney).val('');
			tr.find(eAP).prop({checked:false});
		}
		else {
			resetEditData(tr);
			viewMode(tr);
		}
		return false;
	});

	btnAutoConfirm.on('click', function(e) {
		e.preventDefault();
		var author_id = parseInt($(this).data('author'));
		var month = parseInt($(this).data('month'));
		var year = parseInt($(this).data('year'));
		$.ajax({
			url: AUTO_CONFIRM_SALARY,
			type: 'post',
			dataType: 'json',
			data: {author:author_id, month:month, year:year},
			success: function(r) {
				if (r.code == 0) {
					var btns = {
						'ok': {
							'text' :'OK',
							'class': 'btn btn-xs btn-success',
							click: function() {
								window.location.reload();
							}
						}
					};
					confirm_dialog(r.msg, btns);
				}
				else
					showMessage(r.msg);
			}
		});
	});
});

function getTrData(element) {
	var type = {};
	type.id = element.find(eNewsTypeSelected).val();
	type.name = element.find(eNewsTypeSelected).text();
	trData.type = type;
	trData.element_id = element.attr('id');
	trData.money = element.find(eMoney).val();
	trData.allow_payment = (element.find(eAP).is(':checked')) ? true : false;
	// console.log(trData);
}

function resetEditData(element) {
	element.find(eMoney).val(trData.money);
	element.find(eNewsType).val(trData.type.id);
	if (trData.allow_payment == true)
		element.find(eAP).prop({'checked':true});
	else
		element.find(eAP).prop({'checked':false});
}

function editMode(elements) {
	elements.attr('data-mode', 'edit-mode');
	elements.find('.view-mode').addClass('hidden');
	elements.find('.edit-mode').removeClass('hidden');
}

function viewMode(elements) {
	elements.attr('data-mode', 'edit-mode');
	elements.find('.edit-mode').addClass('hidden');
	elements.find('.view-mode').removeClass('hidden');
}

function updateViewData(elements) {
	var newsType = elements.find('select[name="news_type"] option:selected').text();
	elements.find('.view-mode.news_type').text(newsType);
	
	var money = elements.find('input[name="money"]').val();
	elements.find('.view-mode.money').text(numeral(money).format('0,0'));

	var allow_payment = elements.find('input[name="allow_payment"]');
	if (allow_payment.is(':checked')) 
		elements.find('.view-mode.allow_payment').html($('<i/>').attr({'class':'fa fa-check green'}));
	else
		elements.find('.view-mode.allow_payment').html($('<i/>').attr({'class':'fa fa-times red'}));
	
}