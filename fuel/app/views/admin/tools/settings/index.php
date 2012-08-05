<div class="row">
	<div class="span6">
		<?php echo Form::open(); ?>
		<h2>Jobs</h2>
		<div class="well">
			<?php 
				//echo Form::label('Use jobs','jobs[use]');
				//echo Form::checkbox('jobs[use]', 'Enable jobs', \Config::get('settings.jobs.use'));
				//echo Form::input('jobs[use]', \Config::get('settings.jobs.use'), array('class' => 'span3'));
			?>
			<label class="checkbox" for="jobs[use]">
				<input type="checkbox" name="jobs[use]" <?php if(\Config::get('settings.jobs.use', false)) echo 'checked="checked"'; ?>> Enable jobs
			</label>
			<span class="help-block">
				Enable to use background workers for heavy tasks.<br />
				<span class="label label-info">Note!</span> This will decrease loading time of some pages,
				but certain actions will not be reflected immediately.
			</span>
		</div>
		<h2>Scanner</h2>
		<div class="well">
			<?php 
				//echo Form::label('Use jobs','jobs[use]');
				//echo Form::checkbox('jobs[use]', 'Enable jobs', \Config::get('settings.jobs.use'));
				//echo Form::input('jobs[use]', \Config::get('settings.jobs.use'), array('class' => 'span3'));
			?>
			<span class="help-block">
				What action should be taken when an NFO is found and valid?.<br />
			</span>
		</div>
		<h2>Export</h2>
		<div class="well">
			<?php 
			foreach(\Config::get('settings.export.save_locations') as $type => $loc)
			{
				?>
			<label>
				Path to <?php echo $type; ?>
				<a href="#" class="icon-plus pull-right add-path" data-type="<?php echo $type; ?>"></a>
			</label>
				<?php
				if (is_array($loc))
				{
					foreach($loc as $l)
					{
						echo Form::input("export[save_locations][{$type}][]", $l, array('class' => 'span5'));
					}
				}
				else
				{
					echo Form::input("export[save_locations][{$type}][]", $loc, array('class' => 'span5'));
				}
			}
			?>
			
		</div>
		<h2>Binaries</h2>
		<div class="well">
			<?php 
				echo Form::label('Path to FFmpeg','binaries[ffmpeg]');
				echo Form::input('binaries[ffmpeg]', \Config::get('settings.binaries.ffmpeg'), array('class' => 'span3'));
			?>
		</div>
		<?php 
		echo Form::submit('subtmit', 'Save', array('class' => 'btn btn-primary'));
		echo Form::close();
		?>
	</div>
</div>
<script>
$(document).ready(function() {
	$('.add-path').click(function(e) {
		e.preventDefault();
		var type = $(this).attr('data-type');
		var html = '<input class="span5" name="export[save_locations]['+type+'][]" type="text" id="form_export[save_locations]['+type+'][]" />';
		$(this).parent().append(html);
	});
});
</script>