<h2>Viewing #<?php echo $stream_video->id; ?></h2>

<p>
	<strong>Movie:</strong>
	<?php echo $stream_video->movie->title; ?></p>
<p>
	<strong>Duration:</strong>
	<?php echo $stream_video->duration; ?></p>
<p>
	<strong>Frames:</strong>
	<?php echo $stream_video->frames; ?></p>
<p>
	<strong>Fps:</strong>
	<?php echo $stream_video->fps; ?></p>
<p>
	<strong>Height:</strong>
	<?php echo $stream_video->height; ?></p>
<p>
	<strong>Width:</strong>
	<?php echo $stream_video->width; ?></p>
<p>
	<strong>Pixelformat:</strong>
	<?php echo $stream_video->pixelformat; ?></p>
<p>
	<strong>Bitrate:</strong>
	<?php echo $stream_video->bitrate; ?></p>
<p>
	<strong>Codec:</strong>
	<?php echo $stream_video->codec; ?></p>

<?php echo Html::anchor('admin/stream/video/edit/'.$stream_video->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/stream/video', 'Back'); ?>