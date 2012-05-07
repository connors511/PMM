<h2>Viewing #<?php echo $producer->id; ?></h2>

<p>
	<strong>People:</strong>
	<?php echo $producer->person->name; ?></p>
<p>
	<strong>Movie:</strong>
	<?php echo $producer->movie->title; ?></p>

<?php echo Html::anchor('admin/producers/edit/'.$producer->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/producers', 'Back'); ?>