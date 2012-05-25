<h2>Listing scraper fields</h2>
<br>
<?php if ($scraper_fields): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Field</th>
			<th>Type</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($scraper_fields as $scraper_field): ?>		<tr>

			<td><?php echo $scraper_field->field; ?></td>
			<td><?php echo $scraper_field->scraper_type->type; ?></td>
			<td>
				<?php echo Html::anchor('admin/scraper/fields/view/'.$scraper_field->id, 'View'); ?> |
				<?php echo Html::anchor('admin/scraper/fields/edit/'.$scraper_field->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/scraper/fields/delete/'.$scraper_field->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No scraper fields.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/scraper/fields/create', 'Add new scraper field', array('class' => 'btn btn-success')); ?>

</p>
