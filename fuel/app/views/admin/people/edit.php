<h2>Editing Person</h2>
<br>

<?php echo render('admin/people/_form'); ?>
<p>
	<?php echo Html::anchor('admin/people/view/'.$person->id, 'View'); ?> |
	<?php echo Html::anchor('admin/people', 'Back'); ?></p>
