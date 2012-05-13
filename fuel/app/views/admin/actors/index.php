<h2>Listing Actors</h2>
<br>
<?php if ($actors): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Person</th>
			<th>Movie</th>
			<th>Role</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($actors as $actor): ?>		<tr>

			<td><?php echo Html::anchor('admin/people/view/'.$actor->person->id,$actor->person->name); ?></td>
			<td><?php echo Html::anchor('admin/movies/view/'.$actor->movie->id,$actor->movie->title); ?></td>
			<td><?php echo $actor->role; ?></td>
			<td>
				<?php echo Html::anchor('admin/actors/view/'.$actor->id, 'View'); ?> |
				<?php echo Html::anchor('admin/actors/edit/'.$actor->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/actors/delete/'.$actor->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Actors.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/actors/create', 'Add new Actor', array('class' => 'btn success')); ?>

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>