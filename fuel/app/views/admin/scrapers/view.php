<h2>Viewing #<?php echo $scraper->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $scraper->name; ?></p>
<p>
	<strong>Author:</strong>
	<?php echo $scraper->author; ?></p>
<p>
	<strong>Type:</strong>
	<?php echo $scraper->type; ?></p>
<p>
	<strong>Version:</strong>
	<?php echo $scraper->version; ?></p>
<p>
	<strong>Fields:</strong>
	<?php echo $scraper->fields; ?></p>

<?php echo Html::anchor('admin/scrapers/edit/'.$scraper->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/scrapers', 'Back'); ?>