<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($scrapergroup_movie) ? $scrapergroup_movie->name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($scrapergroup_movie) ? $scrapergroup_movie->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Plot', 'plot'); ?>

			<div class="input">
				<?php echo Form::input('plot', Input::post('plot', isset($scrapergroup_movie) ? $scrapergroup_movie->plot : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Plotsummary', 'plotsummary'); ?>

			<div class="input">
				<?php echo Form::input('plotsummary', Input::post('plotsummary', isset($scrapergroup_movie) ? $scrapergroup_movie->plotsummary : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tagline', 'tagline'); ?>

			<div class="input">
				<?php echo Form::input('tagline', Input::post('tagline', isset($scrapergroup_movie) ? $scrapergroup_movie->tagline : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Rating', 'rating'); ?>

			<div class="input">
				<?php echo Form::input('rating', Input::post('rating', isset($scrapergroup_movie) ? $scrapergroup_movie->rating : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Votes', 'votes'); ?>

			<div class="input">
				<?php echo Form::input('votes', Input::post('votes', isset($scrapergroup_movie) ? $scrapergroup_movie->votes : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Released', 'released'); ?>

			<div class="input">
				<?php echo Form::input('released', Input::post('released', isset($scrapergroup_movie) ? $scrapergroup_movie->released : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Runtime', 'runtime'); ?>

			<div class="input">
				<?php echo Form::input('runtime', Input::post('runtime', isset($scrapergroup_movie) ? $scrapergroup_movie->runtime : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Contentrating', 'contentrating'); ?>

			<div class="input">
				<?php echo Form::input('contentrating', Input::post('contentrating', isset($scrapergroup_movie) ? $scrapergroup_movie->contentrating : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Originaltitle', 'originaltitle'); ?>

			<div class="input">
				<?php echo Form::input('originaltitle', Input::post('originaltitle', isset($scrapergroup_movie) ? $scrapergroup_movie->originaltitle : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Trailer url', 'trailer_url'); ?>

			<div class="input">
				<?php echo Form::input('trailer_url', Input::post('trailer_url', isset($scrapergroup_movie) ? $scrapergroup_movie->trailer_url : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>