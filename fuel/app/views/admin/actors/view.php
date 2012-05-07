<h2>Viewing #<?php echo $actor->id; ?></h2>

<p>
	<strong>Person:</strong>
	<?php echo $actor->person->name; ?></p>
<p>
	<strong>Movie:</strong>
	<?php echo $actor->movie->title; ?></p>
<p>
	<strong>Role:</strong>
	<?php echo $actor->role; ?></p>

<?php echo Html::anchor('admin/actors/edit/'.$actor->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/actors', 'Back'); ?>