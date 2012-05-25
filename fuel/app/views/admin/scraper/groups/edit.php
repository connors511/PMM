<h2>Editing scraper group</h2>
<br>

<?php echo render('admin/scraper/groups/_form'); ?>
<p>
	<?php echo Html::anchor('admin/scraper/groups/view/'.$scraper_group->id, 'View'); ?> |
	<?php echo Html::anchor('admin/scraper/groups', 'Back'); ?></p>
