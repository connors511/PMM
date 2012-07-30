<h2>Editing video stream</h2>
<br>

<?php echo render('admin/stream/video/_form'); ?>
<p>
	<?php echo Html::anchor('admin/stream/video/view/'.$stream_video->id, 'View'); ?> |
	<?php echo Html::anchor('admin/stream/video', 'Back'); ?></p>
