<h2>Listing video streams</h2>
<br>
<?php if ($stream_videos): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Movie</th>
			<th>Duration</th>
			<th>Frames</th>
			<th>Fps</th>
			<th>Height</th>
			<th>Width</th>
			<th>Pixelformat</th>
			<th>Bitrate</th>
			<th>Codec</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($stream_videos as $stream_video): ?>		<tr>

			<td><?php echo $stream_video->movie->title; ?></td>
			<td><?php echo $stream_video->duration; ?></td>
			<td><?php echo number_format($stream_video->frames); ?></td>
			<td><?php echo $stream_video->fps; ?></td>
			<td><?php echo $stream_video->height; ?></td>
			<td><?php echo $stream_video->width; ?></td>
			<td><?php echo $stream_video->pixelformat; ?></td>
			<td><?php echo $stream_video->bitrate; ?></td>
			<td><?php echo $stream_video->codec; ?></td>
			<td>
				<?php echo Html::anchor('admin/stream/video/view/'.$stream_video->id, 'View'); ?> |
				<?php echo Html::anchor('admin/stream/video/edit/'.$stream_video->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/stream/video/delete/'.$stream_video->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No video streams.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/stream/video/create', 'Add new Stream video', array('class' => 'btn btn-success')); ?>

</p>
