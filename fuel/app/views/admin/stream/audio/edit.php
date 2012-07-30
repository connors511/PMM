<h2>Editing audio stream</h2>
<br>

<?php echo render('admin/stream/audio/_form'); ?>
<p>
	<?php echo Html::anchor('admin/stream/audio/view/'.$stream_audio->id, 'View'); ?> |
	<?php echo Html::anchor('admin/stream/audio', 'Back'); ?></p>
