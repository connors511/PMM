<h2>Listing scraper types</h2>
<br>
<?php if ($scraper_types): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Type</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($scraper_types as $scraper_type): ?>		<tr>

			<td><?php echo $scraper_type->type; ?></td>
			<td>
				<?php echo Html::anchor('admin/scraper/types/view/'.$scraper_type->id, 'View'); ?> |
				<?php echo Html::anchor('admin/scraper/types/edit/'.$scraper_type->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/scraper/types/delete/'.$scraper_type->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No scraper types.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/scraper/types/create', 'Add new scraper type', array('class' => 'btn btn-success')); ?>
<?php echo \Fuel\Core\Pagination::create_links(); ?>
</p>
