<h2>Listing Directors</h2>
<br>
<?php if ($directors): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Person</th>
			<th>Movie</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($directors as $director): ?>		<tr>

			<td><?php echo Html::anchor('admin/people/view/'.$director->person->id,$director->person->name); ?></td>
			<td><?php echo Html::anchor('admin/movies/view/'.$director->movie->id,$director->movie->title); ?></td>
			<td>
				<?php echo Html::anchor('admin/directors/view/'.$director->id, 'View'); ?> |
				<?php echo Html::anchor('admin/directors/edit/'.$director->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/directors/delete/'.$director->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Directors.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/directors/create', 'Add new Director', array('class' => 'btn btn-success')); ?>

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
