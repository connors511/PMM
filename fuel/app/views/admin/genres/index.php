<h2>Listing Genres</h2>
<br>
<?php if ($genres): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($genres as $genre): ?>		<tr>

			<td><?php echo $genre->name; ?></td>
			<td>
				<?php echo Html::anchor('admin/genres/view/'.$genre->id, 'View'); ?> |
				<?php echo Html::anchor('admin/genres/edit/'.$genre->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/genres/delete/'.$genre->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Genres.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/genres/create', 'Add new Genre', array('class' => 'btn success')); ?>

</p>
