<h2>Editing Genre</h2>
<br>

<?php echo render('admin/genres/_form'); ?>
<p>
	<?php echo Html::anchor('admin/genres/view/'.$genre->id, 'View'); ?> |
	<?php echo Html::anchor('admin/genres', 'Back'); ?></p>
