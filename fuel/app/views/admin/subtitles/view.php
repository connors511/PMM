<h2>Viewing #<?php echo $subtitle->id; ?></h2>

<p>
	<strong>File:</strong>
	<?php echo $subtitle->file->path; ?></p>
<p>
	<strong>Language:</strong>
	<?php echo $subtitle->language; ?></p>
<p>
	<strong>Movie:</strong>
	<?php echo $subtitle->movie->title; ?></p>

<?php echo Html::anchor('admin/subtitles/edit/'.$subtitle->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/subtitles', 'Back'); ?>