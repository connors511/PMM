<h2>Listing Movies</h2>
<br>
<?php if ($movies): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Poster</th>
			<th>Title</th>
			<th>Tagline</th>
			<th>Genres</th>
			<th>Rating</th>
			<th>Votes</th>
			<th>Released</th>
			<th>Runtime</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($movies as $movie): ?>		<tr>

			<td>
				<?php if (!empty($movie->poster)) {
					echo Html::img($movie->poster, array('width' => '90', 'height' => '120'));
				} ?>
			</td>
			<td><?php echo $movie->title; ?></td>
			<td><?php echo $movie->tagline; ?></td>
			<td>
				<?php 
				if (empty($movie->genres)) 
				{
					echo 'None';
				} 
				else 
				{
					echo '<ul>';
					foreach(Arr::assoc_to_keyval($movie->genres,'id','name') as $id=>$g) 
					{
						echo '<li>'.Html::anchor('admin/genres/view/'.$id,$g).'</li>';
					}
					echo '</ul>';
				}
				?>
			</td>
			<td><?php echo $movie->rating; ?></td>
			<td><?php echo number_format($movie->votes); ?></td>
			<td><?php echo $movie->released; ?></td>
			<td><?php echo Time::time_elapsed_min($movie->runtime); ?></td>
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

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
