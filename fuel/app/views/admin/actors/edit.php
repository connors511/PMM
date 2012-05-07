<h2>Editing Actor</h2>
<br>

<?php echo render('admin/actors/_form'); ?>
<p>
	<?php echo Html::anchor('admin/actors/view/'.$actor->id, 'View'); ?> |
	<?php echo Html::anchor('admin/actors', 'Back'); ?></p>
