<h2>Listing Sources</h2>
<br>
<?php if ($sources): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Path</th>
			<th>Scraper group</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($sources as $source): ?>		<tr>

			<td><?php echo $source->path; ?></td>
			<td><?php echo $source->scraper_group->name; ?></td>
			<td>
				<?php echo Html::anchor('admin/sources/view/'.$source->id, 'View'); ?> |
				<?php echo Html::anchor('admin/sources/edit/'.$source->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/sources/delete/'.$source->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Paths.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/sources/create', 'Add new Path', array('class' => 'btn btn-success')); ?>

<?php echo \Fuel\Core\Pagination::create_links(); ?>
</p>
