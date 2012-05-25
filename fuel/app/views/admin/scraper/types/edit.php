<h2>Editing scraper type</h2>
<br>

<?php echo render('admin/scraper/types/_form'); ?>
<p>
	<?php echo Html::anchor('admin/scraper/types/view/'.$scraper_type->id, 'View'); ?> |
	<?php echo Html::anchor('admin/scraper/types', 'Back'); ?></p>
