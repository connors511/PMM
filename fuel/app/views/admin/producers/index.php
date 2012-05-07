<h2>Listing Producers</h2>
<br>
<?php if ($producers): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Person</th>
			<th>Movie</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($producers as $producer): ?>		<tr>

			<td><?php echo $producer->person->name; ?></td>
			<td><?php echo $producer->movie->title; ?></td>
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
	<?php echo Html::anchor('admin/producers/create', 'Add new Producer', array('class' => 'btn success')); ?>

</p>
