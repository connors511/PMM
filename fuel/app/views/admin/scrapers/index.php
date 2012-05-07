<h2>Listing Scrapers</h2>
<br>
<?php if ($scrapers): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Author</th>
			<th>Type</th>
			<th>Version</th>
			<th>Fields</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($scrapers as $scraper): ?>		<tr>

			<td><?php echo $scraper->name; ?></td>
			<td><?php echo $scraper->author; ?></td>
			<td><?php echo str_replace(':',', ',$scraper->type); ?></td>
			<td><?php echo $scraper->version; ?></td>
			<td><?php echo $scraper->fields; ?></td>
			<td>
				<?php echo Html::anchor('admin/scrapers/view/'.$scraper->id, 'View'); ?> |
				<?php echo Html::anchor('admin/scrapers/edit/'.$scraper->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/scrapers/delete/'.$scraper->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Scrapers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/scrapers/create', 'Add new Scraper', array('class' => 'btn success')); ?>
	<?php echo Html::anchor('admin/scrapers/scanscrapers', 'Scan for Scrapers', array('class' => 'btn primary')); ?>

</p>
