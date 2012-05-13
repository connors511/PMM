<h2>Listing Subtitles</h2>
<br>
<?php if ($subtitles): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>File</th>
			<th>Language</th>
			<th>Movie</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($subtitles as $subtitle): ?>		<tr>

			<td><?php echo $subtitle->file->path; ?></td>
			<td><?php echo $subtitle->language; ?></td>
			<td><?php echo Html::anchor('admin/movies/view/'.$subtitle->movie->id,$subtitle->movie->title); ?></td>
			<td>
				<?php echo Html::anchor('admin/subtitles/view/'.$subtitle->id, 'View'); ?> |
				<?php echo Html::anchor('admin/subtitles/edit/'.$subtitle->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/subtitles/delete/'.$subtitle->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Subtitles.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/subtitles/create', 'Add new Subtitle', array('class' => 'btn btn-success')); ?>

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
