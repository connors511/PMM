<h2>Viewing #<?php echo $scraper->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $scraper->name; ?></p>
<p>
	<strong>Author:</strong>
	<?php echo $scraper->author; ?></p>
<p>
	<strong>Type:</strong>
	<?php echo $scraper->scraper_type->type; ?></p>
<p>
	<strong>Version:</strong>
	<?php echo $scraper->version; ?></p>
<p>
	<strong>Fields:</strong>
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

<?php echo Html::anchor('admin/scrapers/edit/'.$scraper->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/scrapers', 'Back'); ?>