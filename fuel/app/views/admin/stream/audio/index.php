<h2>Listing audio streams</h2>
<br>
<?php if ($stream_audios): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Movie</th>
			<th>Bitrate</th>
			<th>Samplerate</th>
			<th>Codec</th>
			<th>Channels</th>
			<th>Language</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($stream_audios as $stream_audio): ?>		<tr>

			<td><?php echo $stream_audio->movie->title; ?></td>
			<td><?php echo $stream_audio->bitrate; ?></td>
			<td><?php echo $stream_audio->samplerate; ?></td>
			<td><?php echo $stream_audio->codec; ?></td>
			<td><?php echo $stream_audio->channels; ?></td>
			<td><?php echo $stream_audio->language; ?></td>
			<td>
				<?php echo Html::anchor('admin/stream/audio/view/'.$stream_audio->id, 'View'); ?> |
				<?php echo Html::anchor('admin/stream/audio/edit/'.$stream_audio->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/stream/audio/delete/'.$stream_audio->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No audio streams.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/stream/audio/create', 'Add new Stream audio', array('class' => 'btn btn-success')); ?>

</p>
