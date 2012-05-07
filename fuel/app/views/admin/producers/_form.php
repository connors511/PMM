<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Person', 'person_id'); ?>

			<div class="input">
				<?php echo Form::select('person_id', Input::post('person_id', isset($producer) ? $producer->person_id : ''), empty($people)?array():$people, array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Movie', 'movie_id'); ?>

			<div class="input">
				<?php echo Form::select('movie_id', Input::post('movie_id', isset($producer) ? $producer->movie_id : ''), empty($movies)?array():$movies, array('class' => 'span6')); ?>
                                
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>