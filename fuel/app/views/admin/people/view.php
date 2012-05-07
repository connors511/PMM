<h2>Viewing #<?php echo $person->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $person->name; ?></p>
<p>
	<strong>Biography:</strong>
	<?php echo $person->biography; ?></p>
<p>
	<strong>Birthname:</strong>
	<?php echo $person->birthname; ?></p>
<p>
	<strong>Birthday:</strong>
	<?php echo $person->birthday; ?></p>
<p>
	<strong>Birthlocation:</strong>
	<?php echo $person->birthlocation; ?></p>
<p>
	<strong>Height:</strong>
	<?php echo $person->height; ?></p>

<?php echo Html::anchor('admin/people/edit/'.$person->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/people', 'Back'); ?>