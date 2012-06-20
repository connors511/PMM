<div class="row">
	<div class="span8">
		<h2>Scan</h2>
		<?php
		foreach($sources as $s):
		?>
			<p><?php echo Html::anchor('admin/tools/import/scan/'.$s->id, $s->path); ?></p>
		<?php
		endforeach;
		?>
	</div>
	<div class="span4">
		<h2>Stats</h2>
		<p>Files: <?php echo $files; ?></p>
		<p>Images: <?php echo $images; ?></p>
		<p>Movies: <?php echo $movies; ?></p>
		<p>Subtitles: <?php echo $subtitles; ?></p>
		<p>People: <?php echo $people; ?></p>
		<p>Directors: <?php echo $directors; ?></p>
		<p>Actors: <?php echo $actors; ?></p>
		<p>Producers: <?php echo $producers; ?></p>
	</div>
</div>