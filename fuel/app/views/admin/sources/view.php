<h2>Viewing #<?php echo $source->id; ?></h2>

<p>
	<strong>Path:</strong>
	<?php echo $source->path; ?></p>
<p>
	<strong>Scraper group:</strong>
	<?php echo $source->scraper_group->name; ?></p>

<?php echo Html::anchor('admin/sources/edit/'.$source->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/sources', 'Back'); ?>