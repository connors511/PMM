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
					echo '<ul>';
					foreach(Arr::assoc_to_keyval($scraper->scraper_fields,'id','field') as $id=>$f) 
					{
						echo '<li>'.Html::anchor('admin/scraper/fields/view/'.$id,$f).'</li>';
					}
					echo '</ul>';
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

<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>
