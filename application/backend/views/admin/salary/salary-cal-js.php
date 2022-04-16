<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script type="text/javascript">
	$(function(){
		loadReportNumber();
		var saveButton = $('.save-salary-btn');
		saveButton.on('click', function() {
			var newsId = $(this).data('id');
			saveNewsSalary(newsId);
		});

		$('#table-report').find('input[name="money"]').on('change', function(){
			reloadReportData();
		});

		$('select[name="news_type"]').on('change', function(){
			var row = $(this).parent('td').parent('tr');
			changeSalaryQuota(row);
		});

		//tu dong tinh tien neu chua duoc tinh toan
		$(document).find('select[name="news_type"]').each( function(){
			if ($(this).find('option:selected').val() != undefined && $(this).find('option:selected').val()!='') {
				console.log($(this).find('option:selected').val());
				//check money
				var row = $(this).parent('td').parent('tr');
				var money = parseInt(row.find('input[name="money"]').val());
				if (money == 0) {
					changeSalaryQuota(row);
				}
			}
		} );
	});

	$('a.btn-change-mode').on('click', function(){
		var row = $(this).parent('td').parent('tr');
		row.toggleClass('edit-mode');
		row.toggleClass('view-mode');
	});

	function changeSalaryQuota(element) {
		var news_id = element.attr('id');
		var view = parseInt(element.find('td:nth-child(3)').text().replace(',', ''));
		var news_type = element.find('select[name="news_type"] option:selected').val();
		$.ajax({
			url: baseUrl + 'apis/getMoneyQuotaByNewsType',
			type: 'post',
			dataType: 'json',
			data: {type:news_type, view:view},
			success: function(r) {
				if (r.code == 0) {
					element.find('small#money-step').text(r.data.money_hint);
					element.find('input[name="money"]').val(r.data.money_auto);
					if ( ! element.find('input[name="allow_payment"]').is(':checked')) {
						element.find('input[name="allow_payment"]').prop({checked:true});
					}
				}
				else {
					showMessage(r.msg);
				}
			}
		});
	}

	function saveNewsSalary(news_id) {
		var tr = $('tr#' + news_id);
		var news_type = tr.find('select[name="news_type"] option:selected').val();
		var view = parseInt(tr.find('td:nth-child(3)').text().replace(',', ''));
		var money = tr.find('input[name="money"]').val(),
			note = tr.find('input[name="note"]').val(),
			allowPayment = 0;
		if (tr.find('input[name="allow_payment"]').is(':checked')) {
			allowPayment = 1;
		}

		$.ajax({
			url: baseUrl + 'apis/updateNewsSalary',
			type: 'post',
			dataType: 'json',
			data: {news_id:news_id, news_type:news_type, money:money, note:note, allowPayment:allowPayment, view:view},
			success: function(r) {
				updateViewData(tr);
				viewMode(tr);
				// showMessage(r.msg);
			}
		});
	}

	function loadReportNumber() {
		var view = $('#table-view').text();
		var money = $('#table-money').text();
		$('#report-view-number').text(view);
		$('#report-money-number').text(money);
	}

	function reloadReportData() {
		var table = $('#table-report');
		var view = 0, money=0;
		table.find('input[name="money"]').each(function(){
			money += parseInt($(this).val());
		});
		$('#report-money-number').text(numeral(money).format('0,0'));
		$('#table-money').text(numeral(money).format('0,0'));
	}

	//change author
	$(function(){
		var reportForm = $('#form-create-report');
		reportForm.find('select').each(function(){
			$(this).bind('change', function(){
				reportForm.find('button').trigger('click');
			});
		});
	});
</script>
<script src="<?php echo base_url('admin/assets/js/me/salary-calculator.js');?>" defer></script>