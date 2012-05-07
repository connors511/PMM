<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($person) ? $person->name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Biography', 'biography'); ?>

			<div class="input">
				<?php echo Form::textarea('biography', Input::post('biography', isset($person) ? $person->biography : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Birthname', 'birthname'); ?>

			<div class="input">
				<?php echo Form::input('birthname', Input::post('birthname', isset($person) ? $person->birthname : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Birthday', 'birthday'); ?>

			<div class="input">
				<?php echo Form::input('birthday', Input::post('birthday', isset($person) ? $person->birthday : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Birthlocation', 'birthlocation'); ?>

			<div class="input">
				<?php echo Form::input('birthlocation', Input::post('birthlocation', isset($person) ? $person->birthlocation : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Height', 'height'); ?>

			<div class="input">
				<?php echo Form::input('height', Input::post('height', isset($person) ? $person->height : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>
		</div>
	</fieldset>
<?php echo Form::close(); ?>
<script>
	
</script>