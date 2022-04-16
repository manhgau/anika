<div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header">
					<h4 class="box-title">Thông tin</h4>
				</div>
				<div class="box-body">
					<?php echo form_open('', 'post') ?>
					<div class="form-group">
						<label>Mentor</label>
						<?php
							$opMentors = json_decode(json_encode($mentors), true);
							$opPortfolios = json_decode(json_encode($portfolios), true);
							$options = array_combine(array_column($opMentors, 'id'), array_column($opMentors, 'name'));
							echo form_dropdown('mentor_id', $options, $feedback->mentor_id, 'class="form-control"'); 
						?>
					</div>
					<div class="form-group">
						<label>Portfolio</label>
						<?php
							$options = array_combine(array_column($opPortfolios, 'id'), array_column($opPortfolios, 'name'));
							echo form_dropdown('portfolio_id', $options, $feedback->portfolio_id, 'class="form-control"'); 
						?>
					</div>
					<div class="form-group">
						<label>Tiêu đề</label>
						<?php echo form_input('title', set_value('title', $feedback->title, false), 'class="form-control" required');  ?>
					</div>
					<div class="form-group">
						<label>Nội dung</label>
						<?php echo form_textarea('feedback', set_value('feedback', $feedback->feedback, false), 'class="form-control" id="tinymce" rows="3"');  ?>
					</div>
					<div class="form-group">
						<label>Thứ tự hiển thị</label>
						<?php echo form_input('order', set_value('order', $feedback->order, false), 'class="form-control"'); ?>
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-sm" type="submit">Save</button>
					</div>
					<?php echo form_close() ?>

				</div>
			</div>
		</div>
	</div>
</div>