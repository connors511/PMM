<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Path', 'path'); ?>

			<div class="input">
				<?php echo Form::textarea('path', Input::post('path', isset($path) ? $path->path : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Scrapergroup', 'scrapergroup'); ?>

			<div class="input">
				<?php echo Form::input('scrapergroup', Input::post('scrapergroup', isset($path) ? $path->scrapergroup : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>