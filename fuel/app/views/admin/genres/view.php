<h2>Viewing #<?php echo $genre->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $genre->name; ?></p>

<?php echo Html::anchor('admin/genres/edit/'.$genre->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/genres', 'Back'); ?>