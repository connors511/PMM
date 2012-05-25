<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Path', 'path'); ?>

			<div class="input">
				<?php echo Form::textarea('path', Input::post('path', isset($source) ? $source->path : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Scraper group', 'scraper_group_id'); ?>

			<div class="input">
				<?php echo Form::select('scraper_group_id', Input::post('scraper_group_id', isset($source) ? $source->scraper_group_id : ''), $groups, array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>