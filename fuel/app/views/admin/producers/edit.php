<h2>Editing Producer</h2>
<br>

<?php echo render('admin/producers/_form'); ?>
<p>
	<?php echo Html::anchor('admin/producers/view/'.$producer->id, 'View'); ?> |
	<?php echo Html::anchor('admin/producers', 'Back'); ?></p>
