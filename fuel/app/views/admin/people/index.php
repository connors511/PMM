<h2>Listing People</h2>
<br>
<?php if ($people): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Biography</th>
			<th>Birthname</th>
			<th>Birthday</th>
			<th>Birthlocation</th>
			<th>Height</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($people as $person): ?>		<tr>

			<td><?php echo $person->name; ?></td>
			<td><?php echo $person->biography; ?></td>
			<td><?php echo $person->birthname; ?></td>
			<td><?php echo $person->birthday; ?></td>
			<td><?php echo $person->birthlocation; ?></td>
			<td><?php echo $person->height; ?></td>
			<td>
				<?php echo Html::anchor('admin/people/view/'.$person->id, 'View'); ?> |
				<?php echo Html::anchor('admin/people/edit/'.$person->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/people/delete/'.$person->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No People.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/people/create', 'Add new Person', array('class' => 'btn success')); ?>

</p>
