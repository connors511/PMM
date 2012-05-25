<h2>Viewing #<?php echo $scraper_type->id; ?></h2>

<p>
	<strong>Type:</strong>
	<?php echo $scraper_type->type; ?></p>

<?php echo Html::anchor('admin/scraper/types/edit/'.$scraper_type->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/scraper/types', 'Back'); ?>