<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($scraper_group) ? $scraper_group->name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Scraper type', 'scraper_type_id'); ?>

			<div class="input">
				<?php echo Form::select('scraper_type_id', Input::post('scraper_type_id', isset($scraper_group) ? $scraper_group->scraper_type_id : ''), Arr::assoc_to_keyval($types, 'id', 'type'),array('class' => 'span6')); ?>

			</div>
		</div>
		<?php
		foreach($types as $type):
		?>
		<div id="type_<?php echo $type->id; ?>" class="hidden">
			<?php
			foreach($type->scraper_fields as $field):
			?>
			<div class="clearfix">
				<?php echo Form::label(ucwords($field->field), $field->field); ?>

				<div class="input">
					<?php 
						$values = Arr::assoc_to_keyval($field->scrapers, 'id', 'name');
						$values[0] = 'Skip';
						$default = 0;
						if (isset($scraper_group->scraper_group_fields))
						{
							// Arr::to_assoc, why you no work?!
							$selected = array();
							foreach($scraper_group->scraper_group_fields as $f)
							{
								$selected[$f->scraper_field_id] = $f->scraper_id;
							}
							// If a scraper is already assigned to the field, set it as default
							if (isset($selected[$field->id]))
							{
								$default = $selected[$field->id];
							}
						}
						echo Form::select($type->type.'['.$field->field.']', Input::post($field->field, $default), $values,array('class' => 'span6'));
					?>
				</div>
			</div>
			<?php
			endforeach;
			?>
		</div>
		<?php
		endforeach;
		?>
		<div class="clearfix">
			<?php echo Form::label('Comment', 'comment'); ?>

			<div class="input">
				<?php echo Form::textarea('comment', Input::post('comment', isset($scraper_group) ? $scraper_group->comment : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>
<script>
$(document).ready(function(){
	$('.hidden').hide();
	$('#type_' + $('#form_scraper_type_id').val()).show();
});
$('#form_scraper_type_id').change(function(){
	$('.hidden').hide();
	$('#type_' + $(this).val()).show();
});
</script>