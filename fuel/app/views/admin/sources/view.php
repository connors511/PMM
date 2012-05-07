<h2>Viewing #<?php echo $source->id; ?></h2>

<p>
	<strong>Path:</strong>
	<?php echo $source->path; ?></p>
<p>
	<strong>Scrapergroup:</strong>
	<?php echo $source->scrapergroup; ?></p>

<?php echo Html::anchor('admin/sources/edit/'.$source->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/sources', 'Back'); ?>