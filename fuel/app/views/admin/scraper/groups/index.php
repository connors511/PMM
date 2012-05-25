<h2>Listing scraper groups</h2>
<br>
<?php if ($scraper_groups): ?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Scraper type</th>
			<th>Comment</th>
			<th>Fields</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($scraper_groups as $scraper_group): ?>		<tr>

			<td><?php echo $scraper_group->name; ?></td>
			<td><?php echo $scraper_group->scraper_type->type; ?></td>
			<td><?php echo $scraper_group->comment; ?></td>
			<td>
				<?php 
				if (empty($scraper_group->scraper_group_fields)) 
				{
					echo 'None';
				} 
				else 
				{
					echo '<ul>';
					foreach($scraper_group->scraper_group_fields as $sgf) 
					{
						echo '<li>'.Html::anchor('admin/scraper/fields/view/'.$sgf->scraper_field->id, ucwords($sgf->scraper_field->field)).': '.$sgf->scraper->name.' (v'.$sgf->scraper->version.')</li>';
					}
					echo '</ul>';
				}
				?>
			</td>
			<td>
				<?php echo Html::anchor('admin/scraper/groups/view/'.$scraper_group->id, 'View'); ?> |
				<?php echo Html::anchor('admin/scraper/groups/edit/'.$scraper_group->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/scraper/groups/delete/'.$scraper_group->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Scraper_groups.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/scraper/groups/create', 'Add new scraper group', array('class' => 'btn btn-success')); ?>

</p>
