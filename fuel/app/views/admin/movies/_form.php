<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($movie) ? $movie->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Plot', 'plot'); ?>

			<div class="input">
				<?php echo Form::textarea('plot', Input::post('plot', isset($movie) ? $movie->plot : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Plotsummary', 'plotsummary'); ?>

			<div class="input">
				<?php echo Form::input('plotsummary', Input::post('plotsummary', isset($movie) ? $movie->plotsummary : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tagline', 'tagline'); ?>

			<div class="input">
				<?php echo Form::input('tagline', Input::post('tagline', isset($movie) ? $movie->tagline : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Rating', 'rating'); ?>

			<div class="input">
				<?php echo Form::input('rating', Input::post('rating', isset($movie) ? $movie->rating : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Votes', 'votes'); ?>

			<div class="input">
				<?php echo Form::input('votes', Input::post('votes', isset($movie) ? $movie->votes : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Released', 'released'); ?>

			<div class="input">
				<?php echo Form::input('released', Input::post('released', isset($movie) ? $movie->released : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Runtime', 'runtime'); ?>

			<div class="input">
				<?php echo Form::input('runtime', Input::post('runtime', isset($movie) ? $movie->runtime : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Runtime file', 'runtime_file'); ?>

			<div class="input">
				<?php echo Form::input('runtime_file', Input::post('runtime_file', isset($movie) ? $movie->runtime_file : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Contentrating', 'contentrating'); ?>

			<div class="input">
				<?php echo Form::input('contentrating', Input::post('contentrating', isset($movie) ? $movie->contentrating : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Originaltitle', 'originaltitle'); ?>

			<div class="input">
				<?php echo Form::input('originaltitle', Input::post('originaltitle', isset($movie) ? $movie->originaltitle : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Trailer url', 'trailer_url'); ?>

			<div class="input">
				<?php echo Form::textarea('trailer_url', Input::post('trailer_url', isset($movie) ? $movie->trailer_url : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Poster url', 'poster'); ?>

			<div class="input">
				<?php echo Form::textarea('poster', Input::post('poster', isset($movie) ? $movie->poster : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>

			<?php if ($movie->web_images): ?>
			<div class="input">
				<?php foreach($movie->web_images as $wi): ?>
					<img src="data:image/jpeg;base64,<?php echo $wi->data; ?>" class="wi" />
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

		</div>
		<div class="clearfix">
			<?php echo Form::label('File', 'file_id'); ?>

			<div class="input">
				<?php echo Form::textarea('file_id', Input::post('file_id', isset($movie) ? $movie->file_id : ''), array('class' => 'span9')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>

<style>
.chosen {
	border: 5px solid blue;
}
.wi {
	margin: 5px
}
</style>
<script>
$(document).ready(function() {
	$('.wi:first').addClass('chosen');
});
</script>