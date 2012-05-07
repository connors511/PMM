<h2>Viewing #<?php echo $image->id; ?></h2>

<p>
	<strong>File:</strong>
	<?php echo $image->file->path; ?></p>
<p>
	<strong>Height:</strong>
	<?php echo $image->height; ?></p>
<p>
	<strong>Width:</strong>
	<?php echo $image->width; ?></p>
<p>
	<strong>Movie:</strong>
	<?php echo $image->movie->title; ?></p>

<?php echo Html::anchor('admin/images/edit/'.$image->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/images', 'Back'); ?>