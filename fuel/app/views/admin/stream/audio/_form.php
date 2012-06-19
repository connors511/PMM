<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Bitrate', 'bitrate'); ?>

			<div class="input">
				<?php echo Form::input('bitrate', Input::post('bitrate', isset($stream_audio) ? $stream_audio->bitrate : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Samplerate', 'samplerate'); ?>

			<div class="input">
				<?php echo Form::input('samplerate', Input::post('samplerate', isset($stream_audio) ? $stream_audio->samplerate : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Codec', 'codec'); ?>

			<div class="input">
				<?php echo Form::input('codec', Input::post('codec', isset($stream_audio) ? $stream_audio->codec : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Channels', 'channels'); ?>

			<div class="input">
				<?php echo Form::input('channels', Input::post('channels', isset($stream_audio) ? $stream_audio->channels : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Language', 'language'); ?>

			<div class="input">
				<?php echo Form::input('language', Input::post('language', isset($stream_audio) ? $stream_audio->language : ''), array('class' => 'span6')); ?>

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