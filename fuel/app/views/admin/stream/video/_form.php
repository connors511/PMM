<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Duration', 'duration'); ?>

			<div class="input">
				<?php echo Form::input('duration', Input::post('duration', isset($stream_video) ? $stream_video->duration : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Frames', 'frames'); ?>

			<div class="input">
				<?php echo Form::input('frames', Input::post('frames', isset($stream_video) ? $stream_video->frames : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Fps', 'fps'); ?>

			<div class="input">
				<?php echo Form::input('fps', Input::post('fps', isset($stream_video) ? $stream_video->fps : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Height', 'height'); ?>

			<div class="input">
				<?php echo Form::input('height', Input::post('height', isset($stream_video) ? $stream_video->height : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Width', 'width'); ?>

			<div class="input">
				<?php echo Form::input('width', Input::post('width', isset($stream_video) ? $stream_video->width : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Pixelformat', 'pixelformat'); ?>

			<div class="input">
				<?php echo Form::input('pixelformat', Input::post('pixelformat', isset($stream_video) ? $stream_video->pixelformat : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Bitrate', 'bitrate'); ?>

			<div class="input">
				<?php echo Form::input('bitrate', Input::post('bitrate', isset($stream_video) ? $stream_video->bitrate : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Codec', 'codec'); ?>

			<div class="input">
				<?php echo Form::input('codec', Input::post('codec', isset($stream_video) ? $stream_video->codec : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Movie', 'movie_id'); ?>

			<div class="input">
				<?php echo Form::select('movie_id', Input::post('movie_id', isset($stream_audio) ? $stream_audio->movie_id : ''), $movies, array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>