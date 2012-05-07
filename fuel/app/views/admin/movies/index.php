<h2>Listing Movies</h2>
<br>
<?php if ($movies): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Plot</th>
			<th>Plotsummary</th>
			<th>Tagline</th>
			<th>Rating</th>
			<th>Votes</th>
			<th>Released</th>
			<th>Runtime</th>
			<th>Runtime file</th>
			<th>Contentrating</th>
			<th>Originaltitle</th>
			<th>Thumb</th>
			<th>Fanart</th>
			<th>Trailer url</th>
			<th>File</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($movies as $movie): ?>		<tr>

			<td><?php echo $movie->title; ?></td>
			<td><?php echo $movie->plot; ?></td>
			<td><?php echo $movie->plotsummary; ?></td>
			<td><?php echo $movie->tagline; ?></td>
			<td><?php echo $movie->rating; ?></td>
			<td><?php echo $movie->votes; ?></td>
			<td><?php echo $movie->released; ?></td>
			<td><?php echo $movie->runtime; ?></td>
			<td><?php echo $movie->runtime_file; ?></td>
			<td><?php echo $movie->contentrating; ?></td>
			<td><?php echo $movie->originaltitle; ?></td>
			<td><?php echo $movie->thumb; ?></td>
			<td><?php echo $movie->fanart; ?></td>
			<td><?php echo $movie->trailer_url; ?></td>
			<td><?php echo $movie->file_id; ?></td>
			<td>
				<?php echo Html::anchor('admin/movies/view/'.$movie->id, 'View'); ?> |
				<?php echo Html::anchor('admin/movies/edit/'.$movie->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/movies/delete/'.$movie->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Movies.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/movies/create', 'Add new Movie', array('class' => 'btn success')); ?>

</p>
