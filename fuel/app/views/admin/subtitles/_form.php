<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('File', 'file_id'); ?>

			<div class="input">
				<?php echo Form::input('file_id', Input::post('file_id', isset($subtitle) ? $subtitle->file_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Language', 'language'); ?>

			<div class="input">
				<?php echo Form::input('language', Input::post('language', isset($subtitle) ? $subtitle->language : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Movie', 'movie_id'); ?>

			<div class="input">
				<?php echo Form::input('movie_id', Input::post('movie_id', isset($subtitle) ? $subtitle->movie_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>