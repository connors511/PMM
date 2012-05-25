<h2>Editing Source</h2>
<br>

<?php echo render('admin/sources/_form'); ?>
<p>
	<?php echo Html::anchor('admin/sources/view/'.$source->id, 'View'); ?> |
	<?php echo Html::anchor('admin/sources', 'Back'); ?></p>
