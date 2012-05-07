<h2>Editing Subtitle</h2>
<br>

<?php echo render('admin/subtitles/_form'); ?>
<p>
	<?php echo Html::anchor('admin/subtitles/view/'.$subtitle->id, 'View'); ?> |
	<?php echo Html::anchor('admin/subtitles', 'Back'); ?></p>
