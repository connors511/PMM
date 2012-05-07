<h2>Editing Scraper</h2>
<br>

<?php echo render('admin/scrapers/_form'); ?>
<p>
	<?php echo Html::anchor('admin/scrapers/view/'.$scraper->id, 'View'); ?> |
	<?php echo Html::anchor('admin/scrapers', 'Back'); ?></p>
