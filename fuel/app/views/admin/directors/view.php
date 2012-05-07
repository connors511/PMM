<h2>Viewing #<?php echo $director->id; ?></h2>

<p>
	<strong>People:</strong>
	<?php echo $director->person->name; ?></p>
<p>
	<strong>Movie:</strong>
	<?php echo $director->movie->title; ?></p>

<?php echo Html::anchor('admin/directors/edit/'.$director->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/directors', 'Back'); ?>