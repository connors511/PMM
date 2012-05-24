<h2>Listing Movie scrapergroups</h2>
<br>
<?php if ($scrapergroup_movies): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Title</th>
			<th>Plot</th>
			<th>Plotsummary</th>
			<th>Tagline</th>
			<th>Rating</th>
			<th>Votes</th>
			<th>Released</th>
			<th>Runtime</th>
			<th>Contentrating</th>
			<th>Originaltitle</th>
			<th>Trailer url</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($scrapergroup_movies as $scrapergroup_movie): ?>		<tr>

			<td><?php echo $scrapergroup_movie->name; ?></td>
			<td><?php echo $scrapergroup_movie->title; ?></td>
			<td><?php echo $scrapergroup_movie->plot; ?></td>
			<td><?php echo $scrapergroup_movie->plotsummary; ?></td>
			<td><?php echo $scrapergroup_movie->tagline; ?></td>
			<td><?php echo $scrapergroup_movie->rating; ?></td>
			<td><?php echo $scrapergroup_movie->votes; ?></td>
			<td><?php echo $scrapergroup_movie->released; ?></td>
			<td><?php echo $scrapergroup_movie->runtime; ?></td>
			<td><?php echo $scrapergroup_movie->contentrating; ?></td>
			<td><?php echo $scrapergroup_movie->originaltitle; ?></td>
			<td><?php echo $scrapergroup_movie->trailer_url; ?></td>
			<td>
				<?php echo Html::anchor('admin/scrapergroup/movie/view/'.$scrapergroup_movie->id, 'View'); ?> |
				<?php echo Html::anchor('admin/scrapergroup/movie/edit/'.$scrapergroup_movie->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/scrapergroup/movie/delete/'.$scrapergroup_movie->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Movie scrapergroups.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/scrapergroup/movie/create', 'Add new Movie scrapergroup', array('class' => 'btn btn-success')); ?>

</p>
