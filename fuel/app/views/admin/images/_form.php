<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('File', 'file_id'); ?>

			<div class="input">
				<?php echo Form::input('file_id', Input::post('file_id', isset($image) ? $image->file_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Height', 'height'); ?>

			<div class="input">
				<?php echo Form::input('height', Input::post('height', isset($image) ? $image->height : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Width', 'width'); ?>

			<div class="input">
				<?php echo Form::input('width', Input::post('width', isset($image) ? $image->width : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Movie', 'movie_id'); ?>

			<div class="input">
				<?php echo Form::select('movie_id', Input::post('movie_id', isset($image) ? $image->movie_id : ''), empty($movies)?array():$movies, array('class' => 'span6')); ?>
                             
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>