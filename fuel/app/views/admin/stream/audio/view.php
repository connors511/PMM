<h2>Viewing #<?php echo $stream_audio->id; ?></h2>

<p>
	<strong>Movie:</strong>
	<?php echo $stream_audio->movie->title; ?></p>
<p>
	<strong>Bitrate:</strong>
	<?php echo $stream_audio->bitrate; ?></p>
<p>
	<strong>Samplerate:</strong>
	<?php echo $stream_audio->samplerate; ?></p>
<p>
	<strong>Codec:</strong>
	<?php echo $stream_audio->codec; ?></p>
<p>
	<strong>Channels:</strong>
	<?php echo $stream_audio->channels; ?></p>
<p>
	<strong>Language:</strong>
	<?php echo $stream_audio->language; ?></p>

<?php echo Html::anchor('admin/stream/audio/edit/'.$stream_audio->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/stream/audio', 'Back'); ?>