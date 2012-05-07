<h2>Editing Director</h2>
<br>

<?php echo render('admin/directors/_form'); ?>
<p>
	<?php echo Html::anchor('admin/directors/view/'.$director->id, 'View'); ?> |
	<?php echo Html::anchor('admin/directors', 'Back'); ?></p>
