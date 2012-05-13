<h2>Listing Sources</h2>
<br>
<?php if ($sources): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Path</th>
			<th>Scrapergroup</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($sources as $source): ?>		<tr>

			<td><?php echo $source->path; ?></td>
			<td><?php echo $source->scrapergroup; ?></td>
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
	<?php echo Html::anchor('admin/sources/create', 'Add new Path', array('class' => 'btn success')); ?>

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
