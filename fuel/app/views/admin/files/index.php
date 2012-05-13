<h2>Listing Files</h2>
<br>
<?php if ($files): ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Path</th>
				<th>Source</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($files as $file): ?>		<tr>

					<td><?php echo str_replace($file->source->path,'',$file->path); ?></td>
					<td><?php echo $file->source->path; ?></td>
					<td>
						<?php echo Html::anchor('admin/files/view/' . $file->id, 'View'); ?> |
						<?php echo Html::anchor('admin/files/edit/' . $file->id, 'Edit'); ?> |
						<?php echo Html::anchor('admin/files/delete/' . $file->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

					</td>
				</tr>
			<?php endforeach; ?>	</tbody>
	</table>
<?php else: ?>
	<p>No Files.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/files/create', 'Add new File', array('class' => 'btn btn-success')); ?>

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
