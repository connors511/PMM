<h2>Editing File</h2>
<br>

<?php echo render('admin/files/_form'); ?>
<p>
	<?php echo Html::anchor('admin/files/view/'.$file->id, 'View'); ?> |
	<?php echo Html::anchor('admin/files', 'Back'); ?></p>
