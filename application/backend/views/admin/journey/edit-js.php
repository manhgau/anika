<script type="text/javascript">
	var btnAddMile = $('#addmore-milestone'),
	    journeyId = parseInt($('input[name="journey_id"]').val()),
	    milestone = $('tr#defined-milestone'),
	    mileTable = $('table.table'),
	    e_btnsave = '.btn-save-milestone',
	    e_cancel = '.btn-cancel',
	    e_remove = '.btn-remove-milestone',
	    e_activities = 'textarea[name="activities"]',
	    e_output = 'textarea[name="output"]',
	    e_milestone = 'input[name="milestone"]',
	    e_position = 'input[name="position"]';

	btnAddMile.on('click', function(e) {
		e.preventDefault();
		addMilestoneRow();
	});

	$(e_btnsave).on('click', function(e){
		e.preventDefault();
		let row = $(this).parent().parent();
		saveMilestone(row);
	});

	$(e_remove).on('click', function(e){
		e.preventDefault();
		let row = $(this).parent().parent();
		removeMilestone(row);
	});

	function removeMilestone(row) {
		let rowId = (row.attr('id')) ? parseInt(row.attr('id')) : null;
		let data = {};
		data.id = rowId;
		$.ajax({
			url: baseUrl + 'apis/removeJourneyMilestone',
			type : 'post',
			dataType: 'json',
			data:data,
			success: function(response) {
				showMessage(response.msg);
				if (rowId == null) {
					row.find(e_btnsave).attr("disabled", 'disabled');
				}
			}
		});
	}

	function addMilestoneRow() {
		let row = milestone.clone();
		row.removeClass('hidden').attr({'id':''});
		row.find(e_btnsave).bind('click', function(e){ 
			e.preventDefault();
			saveMilestone(row); 
		});
		mileTable.find('tbody').append(row);
	}

	function saveMilestone(row) {
		let rowId = (row.attr('id')) ? parseInt(row.attr('id')) : null;
		let data = {};
		data.id = rowId;
		data.milestone = row.find(e_milestone).val();
		data.activities = row.find(e_activities).val();
		data.output = row.find(e_output).val();
		data.position = row.find(e_position).val();
		data.journey_id = journeyId;
		$.ajax({
			url: baseUrl + 'apis/saveJourneyMilestone',
			type : 'post',
			dataType: 'json',
			data:data,
			success: function(response) {
				showMessage(response.msg);
				if (rowId == null) {
					row.find(e_btnsave).attr("disabled", 'disabled');
				}
			}
		});
	}

</script>