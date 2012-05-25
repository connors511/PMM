<h2>Editing scraper field</h2>
<br>

<?php echo render('admin/scraper/fields/_form'); ?>
<p>
	<?php echo Html::anchor('admin/scraper/fields/view/'.$scraper_field->id, 'View'); ?> |
	<?php echo Html::anchor('admin/scraper/fields', 'Back'); ?></p>
