<h2>Viewing #<?php echo $file->id; ?></h2>

<p>
	<strong>Path:</strong>
	<?php echo $file->path; ?></p>
<p>
	<strong>Source:</strong>
	<?php echo $file->source->path; ?></p>

<?php echo Html::anchor('admin/files/edit/'.$file->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/files', 'Back'); ?>