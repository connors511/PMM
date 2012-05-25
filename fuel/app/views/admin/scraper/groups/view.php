<h2>Viewing #<?php echo $scraper_group->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $scraper_group->name; ?></p>
<p>
	<strong>Scraper type:</strong>
	<?php echo $scraper_group->scraper_type->type; ?></p>
<p>
	<strong>Comment:</strong>
	<?php echo $scraper_group->comment; ?></p>
<p>
	<strong>Fields:</strong>
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
			echo '<li>'.Html::anchor('admin/scraper/fields/view/'.$sgf->scraper_field->id,ucwords($sgf->scraper_field->field)).': '.$sgf->scraper->name.' (v'.$sgf->scraper->version.')</li>';
		}
		echo '</ul>';
	}
	?></p>

<?php echo Html::anchor('admin/scraper/groups/edit/'.$scraper_group->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/scraper/groups', 'Back'); ?>