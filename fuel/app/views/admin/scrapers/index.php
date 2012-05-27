<h2>Listing Scrapers</h2>
<br>
<?php if ($scrapers): ?>
<table class="table table-striped table-bordered">
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
			<td><?php echo $scraper->scraper_type->type; ?></td>
			<td><?php echo $scraper->version; ?></td>
			<td>
				<?php 
				if (empty($scraper->scraper_fields)) 
				{
					echo 'None';
				} 
				else 
				{
					$links = array();
					foreach(Arr::assoc_to_keyval($scraper->scraper_fields,'id','field') as $id=>$f) 
					{
						$links[] = Html::anchor('admin/scraper/fields/view/'.$id,$f);
					}
					echo implode(', ',$links);
				}
				?>
			</td>
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
	<?php echo Html::anchor('admin/scrapers/create', 'Add new Scraper', array('class' => 'btn btn-success')); ?>
	<?php echo Html::anchor('admin/scrapers/scanscrapers', 'Scan for Scrapers', array('class' => 'btn btn-primary')); ?>

<?php echo \Fuel\Core\Pagination::create_links(); ?>
</p>
