<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Path', 'path'); ?>

			<div class="input">
				<?php echo Form::textarea('path', Input::post('path', isset($file) ? $file->path : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Source', 'source_id'); ?>

			<div class="input">
				<?php echo Form::select('source_id', Input::post('source_id', isset($file) ? $file->source_id : ''), empty($sources)?array():$sources, array('class' => 'span6')); ?>
                             
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>