<h2>Editing Image</h2>
<br>

<?php echo render('admin/images/_form'); ?>
<p>
	<?php echo Html::anchor('admin/images/view/'.$image->id, 'View'); ?> |
	<?php echo Html::anchor('admin/images', 'Back'); ?></p>
