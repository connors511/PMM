<div class="row">
	<div class="span6">
		<h2>Re-scrape missing fields</h2>
		<?php
		foreach($sources as $s):
		?>
			<p><?php echo Html::anchor('admin/tools/scrape/missing/'.$s->id, $s->path); ?></p>
		<?php
		endforeach;
		?>
	</div>
	<div class="span6">
		<h2>Re-scrape all fields</h2>
		<?php
		foreach($sources as $s):
		?>
			<p><?php echo Html::anchor('admin/tools/scrape/all/'.$s->id, $s->path); ?></p>
		<?php
		endforeach;
		?>
	</div>
</div>