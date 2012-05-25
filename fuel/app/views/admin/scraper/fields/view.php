<h2>Viewing #<?php echo $scraper_field->id; ?></h2>

<p>
	<strong>Field:</strong>
	<?php echo $scraper_field->field; ?></p>

<?php echo Html::anchor('admin/scraper/fields/edit/'.$scraper_field->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/scraper/fields', 'Back'); ?>