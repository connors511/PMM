<h2>Listing Producers</h2>
<br>
<?php if ($producers): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Person</th>
			<th>Movie</th>
			<th>Role</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($producers as $producer): ?>		<tr>

			<td><?php echo Html::anchor('admin/people/view/'.$producer->person->id,$producer->person->name); ?></td>
			<td><?php echo Html::anchor('admin/movies/view/'.$producer->movie->id,$producer->movie->title); ?></td>
			<td><?php echo $producer->role; ?></td>
			<td>
				<?php echo Html::anchor('admin/producers/view/'.$producer->id, 'View'); ?> |
				<?php echo Html::anchor('admin/producers/edit/'.$producer->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/producers/delete/'.$producer->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Producers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/producers/create', 'Add new Producer', array('class' => 'btn btn-success')); ?>

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
